<?php

require_once "../middleware/auth.php";
require_once "../controllers/PaymentController.php";

$db = (new Database())->connect();

$controller = new PaymentController($db);

$action = $_GET["action"] ?? "";

switch ($action) {

    case "create-order":

        $controller->createOrder();

        break;

    case "verify":

        $controller->verify();

        break;

    default:

        response(
            false,
            "Invalid Action"
        );
}