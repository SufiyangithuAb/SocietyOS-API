<?php

require_once "../middleware/auth.php";
require_once "../config/database.php";
require_once "../controllers/ResidentAppController.php";

$db =
        (new Database())->connect();

$controller =
        new ResidentAppController($db);

$action =
        $_GET['action'] ?? '';

switch($action)
{

    case "dashboard":

        $controller->dashboard();

        break;

    case "profile":

        $controller->profile();

        break;

    case "bills":

        $controller->bills();

        break;

    case "notices":

        $controller->notices();

        break;

    case "complaints":

        $controller->complaints();

        break;

    case "create_complaint":

        $controller->createComplaint();

        break;

    default:

        response(
            false,
            "Invalid Action"
        );
}
