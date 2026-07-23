<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, Content-Type, Accept, Authorization");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

header("Content-Type: application/json");

$route = $_GET['route'] ?? '';

switch($route)
{
    case "auth":
        require_once "../routes/auth.php";
        break;

    case "profile":
        require_once "../routes/profile.php";
        break;

    case "residents":
        require_once "../routes/residents.php";
        break;

    case "notices":
        require_once "../routes/notices.php";
        break;

    case "complaints":
        require_once "../routes/complaints.php";
        break;
    
    case "maintenance":
        require_once "../routes/maintenance.php";
        break;
    
    case "dashboard":
        require_once "../routes/dashboard.php";
        break;

    case "society_profile":
        require_once "../routes/society_profile.php";
        break;

    case "resident_search":
        require_once "../routes/resident_search.php";
        break;

    case "resident_statistics":
        require_once "../routes/resident_statistics.php";
        break;

    case "resident_app":
        require_once "../routes/resident_app.php";
        break;

    case "device":
        require_once "../routes/device.php";
        break;

    default:
        echo json_encode([
            "success" => false,
            "message" => "Route Not Found"
        ]);
}
