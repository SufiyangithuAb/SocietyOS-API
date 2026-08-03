<?php

session_start();

require_once __DIR__ . "/GoogleOAuthService.php";
require_once __DIR__ . "/../config/database.php";

if (!isset($_GET['code'])) {
    exit("Authorization code not received.");
}

try {

    $google = new GoogleOAuthService();

    $token = $google->fetchAccessToken($_GET['code']);

    if (isset($token['error'])) {
        die($token['error']);
    }

    if (!isset($token['refresh_token'])) {
        die("Refresh token not received. Please revoke SocietyOS from your Google Account and authorize again.");
    }

    /*
    Decode ID Token
    */

    if (!isset($token['id_token'])) {
        die("ID Token not received.");
    }

    $parts = explode(".", $token['id_token']);

    $payload = json_decode(
        base64_decode(
            strtr($parts[1], "-_", "+/")
        ),
        true
    );

    $email = $payload['email'] ?? '';

    if (empty($email)) {
        die("Unable to retrieve Google account email.");
    }

    $db = (new Database())->connect();

    /*
    Keep only one connected account
    */

    $db->exec("DELETE FROM google_tokens");

    $stmt = $db->prepare("
        INSERT INTO google_tokens
        (
            email,
            refresh_token,
            access_token,
            expires_at,
            status
        )
        VALUES
        (
            ?,
            ?,
            ?,
            DATE_ADD(NOW(), INTERVAL ? SECOND),
            'CONNECTED'
        )
    ");

    $stmt->execute([
        $email,
        $token['refresh_token'],
        $token['access_token'],
        $token['expires_in']
    ]);

    $_SESSION['google_connected'] = true;

    header("Location: ../super_admin.php?google=connected");
    exit;

} catch (Exception $e) {

    die($e->getMessage());

}