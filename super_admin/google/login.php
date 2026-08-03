<?php

session_start();

require_once __DIR__ . "/GoogleOAuthService.php";

try {

    $google = new GoogleOAuthService();

    header("Location: " . $google->getAuthUrl());

    exit;

} catch (Exception $e) {

    die("Google Login Error : " . $e->getMessage());

}