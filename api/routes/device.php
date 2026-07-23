<?php

require_once __DIR__ . "/../config/database.php";
require_once __DIR__ . "/../helpers/response.php";

// Authenticate user
require_once __DIR__ . "/../middleware/auth.php";

$db = (new Database())->connect();

$action = $_GET['action'] ?? '';

/*
|--------------------------------------------------------------------------
| REGISTER / UPDATE FCM DEVICE TOKEN
|--------------------------------------------------------------------------
*/

if ($action === "register") {

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {

        http_response_code(405);

        response(
            false,
            "Method not allowed"
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Get authenticated user
    |--------------------------------------------------------------------------
    */

    $user = $GLOBALS['auth_user'];

    $userId = $user['id'];
    $societyId = $user['society_id'];

    /*
    |--------------------------------------------------------------------------
    | Read JSON body
    |--------------------------------------------------------------------------
    */

    $input = json_decode(
        file_get_contents("php://input"),
        true
    );

    $fcmToken = trim(
        $input['fcm_token'] ?? ''
    );

    if (empty($fcmToken)) {

        http_response_code(400);

        response(
            false,
            "FCM token is required"
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Check if this exact token already exists
    |--------------------------------------------------------------------------
    */

    $check = $db->prepare(
        "SELECT id
         FROM user_devices
         WHERE fcm_token = ?
         LIMIT 1"
    );

    $check->execute([
        $fcmToken
    ]);

    $existingDevice =
        $check->fetch(PDO::FETCH_ASSOC);

    if ($existingDevice) {

        /*
         * Token already exists.
         *
         * Update ownership in case the same app installation
         * is now logged in using another account.
         */

        $update = $db->prepare(
            "UPDATE user_devices
             SET user_id = ?,
                 society_id = ?,
                 device_type = 'ANDROID',
                 updated_at = CURRENT_TIMESTAMP
             WHERE id = ?"
        );

        $update->execute([
            $userId,
            $societyId,
            $existingDevice['id']
        ]);

        response(
            true,
            "Device token updated successfully"
        );
    }

    /*
    |--------------------------------------------------------------------------
    | New device/token
    |--------------------------------------------------------------------------
    */

    $insert = $db->prepare(
        "INSERT INTO user_devices
            (
                user_id,
                society_id,
                fcm_token,
                device_type
            )
         VALUES (?, ?, ?, 'ANDROID')"
    );

    $insert->execute([
        $userId,
        $societyId,
        $fcmToken
    ]);

    response(
        true,
        "Device registered successfully"
    );
}


/*
|--------------------------------------------------------------------------
| INVALID ACTION
|--------------------------------------------------------------------------
*/

http_response_code(404);

response(
    false,
    "Invalid device action"
);
