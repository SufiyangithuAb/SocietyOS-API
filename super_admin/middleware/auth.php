<?php

require_once __DIR__ . "/../config/config.php";

if (!isset($_SESSION['super_admin'])) {

    setFlash("danger", "Please login first.");

    header("Location: " . BASE_URL . "login.php");

    exit;
}