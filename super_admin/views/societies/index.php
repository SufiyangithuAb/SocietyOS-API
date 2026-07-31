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

<form method="GET" class="row">

    <div class="col-md-4">
        <input
            type="text"
            name="search"
            class="form-control"
            placeholder="Search Society..."
            value="<?= htmlspecialchars($_GET['search'] ?? '') ?>">
    </div>

    <div class="col-md-3">
        <select name="status" class="form-select">

            <option value="">All Status</option>

            <option value="ACTIVE"
                <?= (($_GET['status'] ?? '') == 'ACTIVE') ? 'selected' : '' ?>>
                Active
            </option>

            <option value="EXPIRED"
                <?= (($_GET['status'] ?? '') == 'EXPIRED') ? 'selected' : '' ?>>
                Expired
            </option>

            <option value="CANCELLED"
                <?= (($_GET['status'] ?? '') == 'CANCELLED') ? 'selected' : '' ?>>
                Cancelled
            </option>

        </select>
    </div>

    <div class="col-md-2">
        <button type="submit" class="btn btn-primary w-100">
            <i class="fas fa-search"></i> Search
        </button>
    </div>

</form>

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