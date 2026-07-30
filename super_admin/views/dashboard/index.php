<?php

require_once "../layouts/header.php";
require_once "../layouts/navbar.php";
require_once "../layouts/sidebar.php";
require_once "../../controllers/DashboardController.php";

$dashboard = new DashboardController();

$stats = $dashboard->index();
?>

<div class="content-wrapper">

<section class="content-header">

<div class="container-fluid">

<div class="row mb-2">

<div class="col-sm-6">

<h1>Dashboard</h1>

</div>

<div class="col-sm-6 text-end">

<small class="text-muted">

Welcome back,

<strong><?= htmlspecialchars($user['name']) ?></strong>

</small>

</div>

</div>

</div>

</section>

<section class="content">

<div class="container-fluid">

<div class="row">

<div class="col-lg-3 col-6">

<div class="small-box bg-primary">

<div class="inner">

<h3>0</h3>

<p>Societies</p>

</div>

<div class="icon">

<i class="fas fa-building"></i>

</div>

</div>

</div>

<div class="col-lg-3 col-6">

<div class="small-box bg-success">

<div class="inner">

<h3>0</h3>

<p>Residents</p>

</div>

<div class="icon">

<i class="fas fa-users"></i>

</div>

</div>

</div>

<div class="col-lg-3 col-6">

<div class="small-box bg-warning">

<div class="inner">

<h3>₹0</h3>

<p>Revenue</p>

</div>

<div class="icon">

<i class="fas fa-wallet"></i>

</div>

</div>

</div>

<div class="col-lg-3 col-6">

<div class="small-box bg-danger">

<div class="inner">

<h3>0</h3>

<p>Premium Plans</p>

</div>

<div class="icon">

<i class="fas fa-crown"></i>

</div>

</div>

</div>

</div>

<div class="row">

<div class="col-lg-8">

<div class="card">

<div class="card-header">

<h3 class="card-title">

Recent Activities

</h3>

</div>

<div class="card-body">

<p class="text-muted">

No recent activities found.

</p>

</div>

</div>

</div>

<div class="col-lg-4">

<div class="card">

<div class="card-header">

<h3 class="card-title">

Quick Actions

</h3>

</div>

<div class="card-body d-grid gap-2">

<button class="btn btn-primary">

Add Society

</button>

<button class="btn btn-success">

Create Subscription

</button>

<button class="btn btn-warning">

Generate Report

</button>

</div>

</div>

</div>

</div>

</div>

</section>

</div>

<?php

require_once "../layouts/footer.php";

?>