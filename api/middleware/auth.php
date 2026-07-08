<?php

require_once __DIR__ . "/../config/database.php";
require_once __DIR__ . "/../helpers/response.php";
require_once __DIR__ . "/../config/config.php";

$db = (new Database())->connect();

/*
|--------------------------------------------------------------------------
| DEVELOPMENT MODE
|--------------------------------------------------------------------------
| When DEV_MODE is true, authentication is skipped and the first user
| from the database is used automatically.
| Set DEV_MODE = false before production.
|--------------------------------------------------------------------------
*/

if (DEV_MODE) {

    $query = $db->query(
        "SELECT * FROM users LIMIT 1"
    );

    $user = $query->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        response(false, "No users found");
    }

    $GLOBALS['auth_user'] = $user;

    return;
}

/*
|--------------------------------------------------------------------------
| PRODUCTION MODE
|--------------------------------------------------------------------------
*/

$headers = getallheaders();

if (!isset($headers['Authorization'])) {
    response(false, "Token missing");
}

$token = str_replace(
    "Bearer ",
    "",
    $headers['Authorization']
);

$query = $db->prepare(
    "SELECT * FROM users
     WHERE api_token = ?"
);

$query->execute([$token]);

$user = $query->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    response(false, "Invalid token");
}

$GLOBALS['auth_user'] = $user;
