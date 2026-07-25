<?php

require_once "../middleware/auth.php";
require_once "../controllers/PlanController.php";

$db = (new Database())->connect();

$controller = new PlanController($db);

$action = $_GET["action"] ?? "";

switch ($action) {

    case "list":

        $controller->list();
        break;

    case "details":

        $controller->details();
        break;

    default:

        response(
            false,
            "Invalid Action"
        );
}