<?php

require_once "../layouts/header.php";
require_once "../layouts/navbar.php";
require_once "../layouts/sidebar.php";

require_once "../../controllers/NoticeController.php";

$controller = new NoticeController();
$notices = $controller->index();

?>

<div class="content-wrapper">

<section class="content-header">

<div class="container-fluid">

<div class="d-flex justify-content-between align-items-center">

<h1>Notices</h1>

<a href="#" class="btn btn-primary">

<i class="fas fa-plus"></i>

Add Notice

</a>

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
placeholder="Search Notice..."
value="<?= htmlspecialchars($_GET['search'] ?? '') ?>">

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
<th>Title</th>
<th>Created By</th>
<th>Date</th>
<th width="130">Action</th>

</tr>

</thead>

<tbody>

<?php if(empty($notices)): ?>

<tr>

<td colspan="6" class="text-center">

No notices found.

</td>

</tr>

<?php else: ?>

<?php foreach($notices as $notice): ?>

<tr>

<td><?= $notice['id']; ?></td>

<td><?= htmlspecialchars($notice['society_name'] ?? 'N/A'); ?></td>

<td><?= htmlspecialchars($notice['title']); ?></td>

<td><?= htmlspecialchars($notice['created_by'] ?? 'N/A'); ?></td>

<td><?= date("d M Y", strtotime($notice['created_at'])); ?></td>

<td>

<a href="#" class="btn btn-info btn-sm">

<i class="fas fa-eye"></i>

</a>

<a href="#" class="btn btn-warning btn-sm">

<i class="fas fa-edit"></i>

</a>

<a href="#" class="btn btn-danger btn-sm">

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