<?php

require_once __DIR__ . "/../../middleware/auth.php";

$user = $_SESSION['super_admin'];

?>

<!DOCTYPE html>

<html lang="en">

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1">

<title><?= APP_NAME ?></title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" rel="stylesheet">

<link href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css" rel="stylesheet">

<style>

.brand-link{
    text-decoration:none;
}

.content-wrapper{
    min-height:100vh;
}

.small-box{
    border-radius:15px;
}

</style>

</head>

<body class="hold-transition sidebar-mini">

<div class="wrapper"></div>