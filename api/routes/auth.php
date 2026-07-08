<?php

require_once "../config/database.php";
require_once "../controllers/AuthController.php";

$db = (new Database())->connect();

$auth = new AuthController($db);

$action = $_GET['action'] ?? '';

switch($action)
{
    case "register":
        $auth->registerSociety();
        break;

    case "login":
        $auth->login();
        break;

    default:
        echo json_encode([
            "success" => false,
            "message" => "Invalid Route"
        ]);
}
