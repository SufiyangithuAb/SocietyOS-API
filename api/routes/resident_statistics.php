<?php

require_once "../middleware/auth.php";
require_once "../config/database.php";
require_once "../controllers/ResidentStatisticsController.php";

$db =
        (new Database())->connect();

$controller =
        new ResidentStatisticsController($db);

$action =
        $_GET['action'] ?? '';

switch($action)
{

    case "get":

        $controller->get();

        break;

    default:

        response(
                false,
                "Invalid Action"
        );
}