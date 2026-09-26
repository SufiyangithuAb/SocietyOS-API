<?php

require_once "../middleware/auth.php";
require_once "../config/database.php";
require_once "../controllers/ResidentReportController.php";

$db =
    (new Database())
        ->connect();

$controller =
    new ResidentReportController($db);

$action =
    $_GET['action'] ?? '';

switch ($action)
{
    case "monthly":

        $controller->monthly();

        break;

    default:

        response(
            false,
            "Invalid Action"
        );
}
