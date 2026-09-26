<?php

require_once "../middleware/auth.php";
require_once "../config/database.php";
require_once "../controllers/ResidentExportController.php";

$db = (new Database())->connect();

$controller = new ResidentExportController($db);

$action = $_GET['action'] ?? '';

switch ($action) {

    case "monthly_pdf":

        $controller->monthlyPdf();

        break;


    default:

        http_response_code(400);

        echo json_encode([
            "success" => false,
            "message" => "Invalid export action"
        ]);
}
