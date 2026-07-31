<?php

require_once "../layouts/header.php";
require_once "../layouts/navbar.php";
require_once "../layouts/sidebar.php";

require_once "../../controllers/ResidentController.php";

$controller = new ResidentController();
$residents = $controller->index();

?>

<div class="content-wrapper">

<section class="content-header">

<div class="container-fluid">

<div class="d-flex justify-content-between align-items-center">

<h1>Residents</h1>

</div>

</div>

</section>

<section class="content">

<div class="container-fluid">

<div class="card">

<div class="card-body">

<table class="table table-bordered table-hover">

<thead>

<tr>

<th>ID</th>
<th>Name</th>
<th>Email</th>
<th>Phone</th>
<th>Society</th>
<th>Status</th>
<th width="120">Action</th>

</tr>

</thead>

<tbody>

<?php if(empty($residents)): ?>

<tr>

<td colspan="7" class="text-center">

No residents found

</td>

</tr>

<?php else: ?>

<?php foreach($residents as $resident): ?>

<tr>

<td><?= $resident['id'] ?></td>

<td><?= htmlspecialchars($resident['name']) ?></td>

<td><?= htmlspecialchars($resident['email']) ?></td>

<td><?= htmlspecialchars($resident['phone']) ?></td>

<td><?= htmlspecialchars($resident['society_name']) ?></td>

<td>

<?php if($resident['status']=='ACTIVE'): ?>

<span class="badge bg-success">

Active

</span>

<?php else: ?>

<span class="badge bg-danger">

Inactive

</span>

<?php endif; ?>

</td>

<td>

<button class="btn btn-primary btn-sm">

View

</button>

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