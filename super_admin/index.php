<?php

require_once "config/config.php";

if (isset($_SESSION['super_admin'])) {

    header("Location: views/dashboard/index.php");
    exit;

}

header("Location: views/auth/login.php");
exit;