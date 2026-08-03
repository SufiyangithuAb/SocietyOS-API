<?php

session_start();

require_once __DIR__ . "/GoogleOAuthService.php";

if (!isset($_GET['code'])) {

    exit("Authorization code not received.");

}

try {

    $google = new GoogleOAuthService();

    $token = $google->fetchAccessToken($_GET['code']);

    if (isset($token['error'])) {

        die($token['error']);

    }

    $_SESSION['google_token'] = $token;

    echo "<h2>✅ Google Drive Connected Successfully</h2>";

    echo "<pre>";

    print_r($token);

    echo "</pre>";

} catch (Exception $e) {

    die($e->getMessage());

}