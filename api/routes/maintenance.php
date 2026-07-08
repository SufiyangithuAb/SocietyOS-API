<?php

require_once "../middleware/auth.php";
require_once "../config/database.php";
require_once "../controllers/MaintenanceBillController.php";

$db = (new Database())->connect();

$controller =
new MaintenanceBillController($db);

$action = $_GET['action'] ?? '';

switch($action)
{
    case "create":
        $controller->create();
        break;

    case "list":
        $controller->list();
        break;

    case "mark_paid":
        $controller->markPaid();
        break;

    default:
        response(false, "Invalid Action");
}