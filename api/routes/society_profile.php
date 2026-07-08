<?php

require_once "../middleware/auth.php";
require_once "../config/database.php";
require_once "../controllers/SocietyProfileController.php";

$db =
        (new Database())->connect();

$controller =
        new SocietyProfileController($db);

$action =
        $_GET['action'] ?? '';

switch($action)
{

    case "get":

        $controller->get();

        break;

    case "update":

        $controller->update();

        break;

    default:

        response(
                false,
                "Invalid Action"
        );

}