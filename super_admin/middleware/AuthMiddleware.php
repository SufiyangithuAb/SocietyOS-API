<?php

if (!isset($_SESSION["super_admin"])) {

    header("Location: ../../index.php");
    exit;

}