<?php

require_once "config/config.php";
require_once "config/database.php";
require_once "controllers/AuthController.php";

$db = (new Database())->connect();

$controller = new AuthController($db);

$controller->login();