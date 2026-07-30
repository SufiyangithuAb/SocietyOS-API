<?php

// Start Session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Base URL
define("BASE_URL", "/super_admin/");

// Timezone
date_default_timezone_set("Asia/Kolkata");

// Error Reporting (Turn OFF in production)
ini_set('display_errors', 1);
error_reporting(E_ALL);