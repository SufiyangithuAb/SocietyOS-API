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

$client = $google->getClient();

$client->setAccessToken($token);

$oauth = new Google\Service\Oauth2($client);

$user = $oauth->userinfo->get();

$email = $user->email;

require_once __DIR__ . "/../config/database.php";

$db = (new Database())->connect();

/*
Remove previous token
*/

$db->exec("DELETE FROM google_tokens");

$stmt = $db->prepare("
INSERT INTO google_tokens
(
email,
refresh_token
)
VALUES
(
?,
?
)
");

if (!isset($token['refresh_token'])) {
    die("Refresh token not received. Please revoke the app from your Google Account and authorize again.");
}

$stmt->execute([
    $email,
    $token['refresh_token']
]);

echo "<h2>Google Drive Connected Successfully ✅</h2>";

echo "Connected Account : <b>{$email}</b>";

} catch (Exception $e) {

    die($e->getMessage());

}