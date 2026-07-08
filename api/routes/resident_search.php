<?php

require_once "../middleware/auth.php";
require_once "../config/database.php";
require_once "../controllers/ResidentSearchController.php";

$db =
        (new Database())->connect();

$controller =
        new ResidentSearchController($db);

$action =
        $_GET['action'] ?? '';

switch($action)
{

    case "search":

        $controller->search();

        break;

    default:

        response(
                false,
                "Invalid Action"
        );

}