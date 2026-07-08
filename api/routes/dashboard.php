<?php

require_once "../middleware/auth.php";
require_once "../config/database.php";
require_once "../controllers/DashboardController.php";

$db = (new Database())->connect();

$controller =
new DashboardController($db);

$controller->stats();