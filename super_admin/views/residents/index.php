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

<div class="card-header">

<form method="GET" class="row">

    <div class="col-md-4">
        <input
            type="text"
            name="search"
            class="form-control"
            placeholder="Search Name, Email or Phone"
            value="<?= htmlspecialchars($_GET['search'] ?? '') ?>">
    </div>

    <div class="col-md-3">

        <select name="status" class="form-select">

            <option value="">All Status</option>

            <option value="ACTIVE"
                <?= (($_GET['status'] ?? '') == 'ACTIVE') ? 'selected' : '' ?>>
                Active
            </option>

            <option value="INACTIVE"
                <?= (($_GET['status'] ?? '') == 'INACTIVE') ? 'selected' : '' ?>>
                Inactive
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

<?php

$status = strtoupper($resident['status']);

if ($status == 'ACTIVE') {

    echo '<span class="badge bg-success">Active</span>';

} else {

    echo '<span class="badge bg-danger">Inactive</span>';

}

?>

</td>

<td>

<a href="#" class="btn btn-info btn-sm">

<i class="fas fa-eye"></i>

</a>

<a href="#" class="btn btn-warning btn-sm">

<i class="fas fa-edit"></i>

</a>

<a href="#"
class="btn btn-danger btn-sm"
onclick="return confirm('Delete this resident?')">

<i class="fas fa-trash"></i>

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