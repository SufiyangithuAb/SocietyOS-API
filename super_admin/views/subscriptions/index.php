<?php

require_once "../layouts/header.php";
require_once "../layouts/navbar.php";
require_once "../layouts/sidebar.php";

require_once "../../controllers/SubscriptionController.php";

$controller = new SubscriptionController();
$subscriptions = $controller->index();

?>

<div class="content-wrapper">

<section class="content-header">
    <div class="container-fluid">
        <h1>Subscriptions</h1>
    </div>
</section>

<section class="content">

<div class="container-fluid">

<div class="card">

<div class="card-header">

<form method="GET" class="row">

<div class="col-md-4">
<input
type="text"
name="search"
class="form-control"
placeholder="Search Society"
value="<?= htmlspecialchars($_GET['search'] ?? '') ?>">
</div>

<div class="col-md-3">

<select name="status" class="form-select">

<option value="">All Status</option>

<option value="ACTIVE">Active</option>
<option value="EXPIRED">Expired</option>
<option value="CANCELLED">Cancelled</option>

</select>

</div>

<div class="col-md-2">

<button class="btn btn-primary w-100">

<i class="fas fa-search"></i>

Search

</button>

</div>

</form>

</div>

<div class="card-body">

<table class="table table-bordered table-hover">

<thead>

<tr>

<th>ID</th>
<th>Society</th>
<th>Plan</th>
<th>Amount</th>
<th>Start Date</th>
<th>Expiry</th>
<th>Status</th>
<th width="140">Action</th>

</tr>

</thead>

<tbody>

<?php if(empty($subscriptions)): ?>

<tr>

<td colspan="8" class="text-center">

No subscriptions found

</td>

</tr>

<?php else: ?>

<?php foreach($subscriptions as $subscription): ?>

<tr>

<td><?= $subscription['id'] ?></td>

<td><?= htmlspecialchars($subscription['society_name']) ?></td>

<td><?= htmlspecialchars($subscription['plan_name']) ?></td>

<td>₹<?= number_format($subscription['amount'],2) ?></td>

<td><?= $subscription['start_date'] ?></td>

<td><?= $subscription['expiry_date'] ?></td>

<td>

<?php
$status = strtoupper($subscription['status']);

if($status=='ACTIVE')
    echo '<span class="badge bg-success">Active</span>';
elseif($status=='EXPIRED')
    echo '<span class="badge bg-warning text-dark">Expired</span>';
else
    echo '<span class="badge bg-danger">Cancelled</span>';
?>

</td>

<td>

<a href="#" class="btn btn-info btn-sm">
<i class="fas fa-eye"></i>
</a>

<a href="#" class="btn btn-success btn-sm">
<i class="fas fa-sync"></i>
</a>

</td>

</tr>

<?php endforeach; ?>

<?php endif; ?>

</tbody>

</table>

</div>

</div>

</div>

</section>

</div>

<?php require_once "../layouts/footer.php"; ?>