<?php

require_once "../layouts/header.php";
require_once "../layouts/navbar.php";
require_once "../layouts/sidebar.php";

require_once "../../controllers/ReportController.php";

$controller = new ReportController();
$data = $controller->dashboard();

?>

<div class="content-wrapper">

<section class="content-header">

<div class="container-fluid">

<h1>Reports & Analytics</h1>

</div>

</section>

<section class="content">

<div class="container-fluid">

<div class="row">

<div class="col-lg-3 col-6">

<div class="small-box bg-primary">

<div class="inner">

<h3><?= $data['societies']; ?></h3>

<p>Total Societies</p>

</div>

<div class="icon">

<i class="fas fa-building"></i>

</div>

</div>

</div>

<div class="col-lg-3 col-6">

<div class="small-box bg-success">

<div class="inner">

<h3><?= $data['residents']; ?></h3>

<p>Total Residents</p>

</div>

<div class="icon">

<i class="fas fa-users"></i>

</div>

</div>

</div>

<div class="col-lg-3 col-6">

<div class="small-box bg-warning">

<div class="inner">

<h3>₹<?= number_format($data['revenue']); ?></h3>

<p>Total Revenue</p>

</div>

<div class="icon">

<i class="fas fa-wallet"></i>

</div>

</div>

</div>

<div class="col-lg-3 col-6">

<div class="small-box bg-danger">

<div class="inner">

<h3><?= $data['activePlans']; ?></h3>

<p>Active Plans</p>

</div>

<div class="icon">

<i class="fas fa-crown"></i>

</div>

</div>

</div>

</div>

<hr>

<div class="row">

<div class="col-md-4">

<div class="card">

<div class="card-header">

<b>Complaints</b>

</div>

<div class="card-body">

<h5>Total : <?= $data['complaints']; ?></h5>

<h5 class="text-success">

Resolved :

<?= $data['resolved']; ?>

</h5>

<h5 class="text-primary">

Open :

<?= $data['open']; ?>

</h5>

</div>

</div>

</div>

<div class="col-md-8">

<div class="card">

<div class="card-header">

Revenue Chart

</div>

<div class="card-body">

<canvas id="revenueChart" height="100"></canvas>

</div>

</div>

</div>

</div>

<div class="row">

<div class="col-md-6">

<div class="card">

<div class="card-header">

Subscription Distribution

</div>

<div class="card-body">

<canvas id="planChart"></canvas>

</div>

</div>

</div>

<div class="col-md-6">

<div class="card">

<div class="card-header">

Complaint Status

</div>

<div class="card-body">

<canvas id="complaintChart"></canvas>

</div>

</div>

</div>

</div>

</div>

</section>

</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>

new Chart(document.getElementById('revenueChart'),{

type:'bar',

data:{

labels:['Revenue'],

datasets:[{

label:'Amount',

data:[<?= $data['revenue']; ?>]

}]

}

});

new Chart(document.getElementById('planChart'),{

type:'pie',

data:{

labels:['Active'],

datasets:[{

data:[<?= $data['activePlans']; ?>]

}]

}

});

new Chart(document.getElementById('complaintChart'),{

type:'doughnut',

data:{

labels:['Open','Resolved'],

datasets:[{

data:[<?= $data['open']; ?>,<?= $data['resolved']; ?>]

}]

}

});

</script>

<?php

require_once "../layouts/footer.php";

?>