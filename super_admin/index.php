<?php

require_once "config/config.php";

if (!isset($_SESSION['super_admin'])) {
    header("Location: login.php");
    exit;
}

header("Location: views/dashboard/index.php");
exit;