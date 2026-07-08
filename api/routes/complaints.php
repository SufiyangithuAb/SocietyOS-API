<?php

require_once "../middleware/auth.php";
require_once "../config/database.php";
require_once "../controllers/ComplaintController.php";

$db = (new Database())->connect();

$controller = new ComplaintController($db);

$action = $_GET['action'] ?? '';

switch($action)
{
    case "create":
        $controller->create();
        break;

    case "list":
        $controller->list();
        break;

    case "details":
        $controller->details();
        break;

    case "update_status":
        $controller->updateStatus();
        break;

    case "delete":
        $controller->delete();
        break;

    default:
        response(false, "Invalid Action");
}