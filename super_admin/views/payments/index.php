<?php

require_once "../layouts/header.php";
require_once "../layouts/navbar.php";
require_once "../layouts/sidebar.php";

require_once "../../controllers/PaymentController.php";

$controller = new PaymentController();
$payments = $controller->index();

?>

<div class="content-wrapper">

<section class="content-header">

<div class="container-fluid">

<div class="d-flex justify-content-between align-items-center">

<h1>Payments</h1>

</div>

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
placeholder="Search Society or User"
value="<?= htmlspecialchars($_GET['search'] ?? '') ?>">

</div>

<div class="col-md-3">

<select
name="status"
class="form-select">

<option value="">All Status</option>

<option value="CREATED"
<?= (($_GET['status'] ?? '')=='CREATED')?'selected':''; ?>>

Created

</option>

<option value="SUCCESS"
<?= (($_GET['status'] ?? '')=='SUCCESS')?'selected':''; ?>>

Success

</option>

<option value="FAILED"
<?= (($_GET['status'] ?? '')=='FAILED')?'selected':''; ?>>

Failed

</option>

<option value="REFUNDED"
<?= (($_GET['status'] ?? '')=='REFUNDED')?'selected':''; ?>>

Refunded

</option>

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
<th>Paid By</th>
<th>Plan</th>
<th>Amount</th>
<th>Method</th>
<th>Payment ID</th>
<th>Status</th>
<th>Paid At</th>
<th width="120">Action</th>

</tr>

</thead>

<tbody>

<?php if(empty($payments)): ?>

<tr>

<td colspan="10" class="text-center">

No payments found.

</td>

</tr>

<?php else: ?>

<?php foreach($payments as $payment): ?>

<tr>

<td><?= $payment['id']; ?></td>

<td><?= htmlspecialchars($payment['society_name']); ?></td>

<td><?= htmlspecialchars($payment['paid_by']); ?></td>

<td><?= htmlspecialchars($payment['plan_name']); ?></td>

<td>

₹<?= number_format($payment['amount'],2); ?>

</td>

<td>

<?= htmlspecialchars($payment['payment_method'] ?: '-'); ?>

</td>

<td>

<?= htmlspecialchars($payment['razorpay_payment_id'] ?: '-'); ?>

</td>

<td>

<?php

$status = strtoupper($payment['status']);

switch($status){

case 'SUCCESS':
echo '<span class="badge bg-success">Success</span>';
break;

case 'FAILED':
echo '<span class="badge bg-danger">Failed</span>';
break;

case 'REFUNDED':
echo '<span class="badge bg-warning text-dark">Refunded</span>';
break;

default:
echo '<span class="badge bg-secondary">Created</span>';

}

?>

</td>

<td>

<?= $payment['paid_at'] ?? '-'; ?>

</td>

<td>

<a href="#"
class="btn btn-info btn-sm">

<i class="fas fa-eye"></i>

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

<?php

require_once "../layouts/footer.php";

?>