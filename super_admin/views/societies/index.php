<?php

require_once "../layouts/header.php";
require_once "../layouts/navbar.php";
require_once "../layouts/sidebar.php";
require_once "../../controllers/SocietyController.php";

$controller = new SocietyController();

$societies = $controller->index();
?>

<div class="content-wrapper">

<section class="content-header">

<div class="container-fluid">

<div class="d-flex justify-content-between align-items-center">

<h1>Societies</h1>

<button class="btn btn-primary">

<i class="fas fa-plus"></i>

Add Society

</button>

</div>

</div>

</section>

<section class="content">

<div class="container-fluid">

<div class="card">

<div class="card-header">

<div class="row">

<div class="col-md-4">

<input
type="text"
class="form-control"
placeholder="Search Society">

</div>

<div class="col-md-3">

<select class="form-select">

<option>All Status</option>

<option>Active</option>

<option>Inactive</option>

</select>

</div>

</div>

</div>

<div class="card-body">

<table class="table table-bordered table-hover">

<thead>

<tr>

<th>ID</th>

<th>Society Name</th>

<th>City</th>

<th>Plan</th>

<th>Status</th>

<th width="180">

Action

</th>

</tr>

</thead>

<tbody>

<?php if(empty($societies)): ?>

<tr>

<td colspan="6" class="text-center">

No societies found

</td>

</tr>

<?php else: ?>

<?php foreach($societies as $society): ?>

<tr>

<td><?= $society['id']; ?></td>

<td><?= htmlspecialchars($society['name']); ?></td>

<td><?= htmlspecialchars($society['city']); ?></td>

<td><?= htmlspecialchars($society['plan_name'] ?? '-'); ?></td>

<td><?= htmlspecialchars($society['status'] ?? '-'); ?></td>

<td>

<button class="btn btn-sm btn-primary">

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