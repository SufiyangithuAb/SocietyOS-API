<?php

class FirebaseNotification
{
    private $db;

    private $projectId;
    private $clientEmail;
    private $privateKey;

    public function __construct($db)
    {
        $this->db = $db;

        $this->projectId =
            getenv("FIREBASE_PROJECT_ID");

        $this->clientEmail =
            getenv("FIREBASE_CLIENT_EMAIL");

        $this->privateKey =
            getenv("FIREBASE_PRIVATE_KEY");

        // Railway may store \n as literal characters
        if ($this->privateKey) {
            $this->privateKey = str_replace(
                "\\n",
                "\n",
                $this->privateKey
            );
        }
    }

    /*
    |--------------------------------------------------------------------------
    | Base64 URL Encode
    |--------------------------------------------------------------------------
    */

    private function base64UrlEncode($data)
    {
        return rtrim(
            strtr(
                base64_encode($data),
                '+/',
                '-_'
            ),
            '='
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Generate Google OAuth Access Token
    |--------------------------------------------------------------------------
    */

    private function getAccessToken()
    {
        if (
            empty($this->projectId) ||
            empty($this->clientEmail) ||
            empty($this->privateKey)
        ) {
            error_log(
                "FCM ERROR: Firebase environment variables are missing"
            );

            return false;
        }

        $now = time();

        $header = [
            "alg" => "RS256",
            "typ" => "JWT"
        ];

        $claimSet = [

            "iss" => $this->clientEmail,

            "scope" =>
                "https://www.googleapis.com/auth/firebase.messaging",

            "aud" =>
                "https://oauth2.googleapis.com/token",

            "iat" => $now,

            "exp" => $now + 3600
        ];

        $encodedHeader =
            $this->base64UrlEncode(
                json_encode($header)
            );

        $encodedClaims =
            $this->base64UrlEncode(
                json_encode($claimSet)
            );

        $unsignedJwt =
            $encodedHeader .
            "." .
            $encodedClaims;

        $signature = "";

        $signed = openssl_sign(
            $unsignedJwt,
            $signature,
            $this->privateKey,
            OPENSSL_ALGO_SHA256
        );

        if (!$signed) {

            error_log(
                "FCM ERROR: Unable to sign Google JWT"
            );

            return false;
        }

        $jwt =
            $unsignedJwt .
            "." .
            $this->base64UrlEncode(
                $signature
            );

        /*
        |--------------------------------------------------------------------------
        | Exchange JWT for Google OAuth token
        |--------------------------------------------------------------------------
        */

        $ch = curl_init();

        curl_setopt_array($ch, [

            CURLOPT_URL =>
                "https://oauth2.googleapis.com/token",

            CURLOPT_POST => true,

            CURLOPT_RETURNTRANSFER => true,

            CURLOPT_HTTPHEADER => [
                "Content-Type: application/x-www-form-urlencoded"
            ],

            CURLOPT_POSTFIELDS =>
                http_build_query([

                    "grant_type" =>
                        "urn:ietf:params:oauth:grant-type:jwt-bearer",

                    "assertion" =>
                        $jwt

                ]),

            CURLOPT_TIMEOUT => 20
        ]);

        $response =
            curl_exec($ch);

        $httpCode =
            curl_getinfo(
                $ch,
                CURLINFO_HTTP_CODE
            );

        if (curl_errno($ch)) {

            error_log(
                "FCM OAUTH CURL ERROR: " .
                curl_error($ch)
            );

            curl_close($ch);

            return false;
        }

        curl_close($ch);

        $result =
            json_decode(
                $response,
                true
            );

        if (
            $httpCode !== 200 ||
            empty($result['access_token'])
        ) {

            error_log(
                "FCM OAUTH ERROR: " .
                $response
            );

            return false;
        }

        return $result['access_token'];
    }

    /*
    |--------------------------------------------------------------------------
    | Send Notification to One FCM Token
    |--------------------------------------------------------------------------
    */

    private function sendToToken(
        $accessToken,
        $fcmToken,
        $title,
        $body,
        $data = []
    ) {

        $url =
            "https://fcm.googleapis.com/v1/projects/" .
            $this->projectId .
            "/messages:send";

        /*
        | FCM data values must be strings.
        */

        $stringData = [];

        foreach ($data as $key => $value) {

            $stringData[$key] =
                (string) $value;
        }

        $message = [

            "message" => [

                "token" =>
                    $fcmToken,

                "notification" => [

                    "title" =>
                        $title,

                    "body" =>
                        $body
                ],

                "data" =>
                    $stringData,

                "android" => [

                    "priority" =>
                        "high"
                ]
            ]
        ];

        $ch = curl_init();

        curl_setopt_array($ch, [

            CURLOPT_URL =>
                $url,

            CURLOPT_POST =>
                true,

            CURLOPT_RETURNTRANSFER =>
                true,

            CURLOPT_HTTPHEADER => [

                "Authorization: Bearer " .
                $accessToken,

                "Content-Type: application/json"
            ],

            CURLOPT_POSTFIELDS =>
                json_encode($message),

            CURLOPT_TIMEOUT =>
                20
        ]);

        $response =
            curl_exec($ch);

        $httpCode =
            curl_getinfo(
                $ch,
                CURLINFO_HTTP_CODE
            );

        if (curl_errno($ch)) {

            error_log(
                "FCM SEND CURL ERROR: " .
                curl_error($ch)
            );

            curl_close($ch);

            return false;
        }

        curl_close($ch);

        if (
            $httpCode >= 200 &&
            $httpCode < 300
        ) {

            error_log(
                "FCM SUCCESS: " .
                $response
            );

            return true;
        }

        error_log(
            "FCM SEND ERROR [" .
            $httpCode .
            "]: " .
            $response
        );

        return false;
    }

    /*
    |--------------------------------------------------------------------------
    | Notify Residents of One Society
    |--------------------------------------------------------------------------
    */

    public function notifyResidents(
        $societyId,
        $title,
        $body,
        $data = []
    ) {

        /*
        | Get devices belonging only to RESIDENT users
        | from the specified society.
        */

        $query = $this->db->prepare(
            "SELECT DISTINCT ud.fcm_token
             FROM user_devices ud
             INNER JOIN users u
                ON u.id = ud.user_id
             WHERE u.society_id = ?
             AND u.role = 'RESIDENT'
             AND u.is_active = 1
             AND ud.fcm_token IS NOT NULL
             AND ud.fcm_token != ''"
        );

        $query->execute([
            $societyId
        ]);

        $devices =
            $query->fetchAll(
                PDO::FETCH_ASSOC
            );

        if (!$devices) {

            error_log(
                "FCM: No resident devices found for society " .
                $societyId
            );

            return [
                "sent" => 0,
                "failed" => 0
            ];
        }

        /*
        | Generate OAuth token only once.
        */

        $accessToken =
            $this->getAccessToken();

        if (!$accessToken) {

            return [
                "sent" => 0,
                "failed" => count($devices)
            ];
        }

        $sent = 0;
        $failed = 0;

        foreach ($devices as $device) {

            $success =
                $this->sendToToken(

                    $accessToken,

                    $device['fcm_token'],

                    $title,

                    $body,

                    $data
                );

            if ($success) {

                $sent++;

            } else {

                $failed++;
            }
        }

        error_log(
            "FCM RESULT: Society=" .
            $societyId .
            " Sent=" .
            $sent .
            " Failed=" .
            $failed
        );

        return [

            "sent" =>
                $sent,

            "failed" =>
                $failed
        ];
    }
}
