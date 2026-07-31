<?php

require_once "../layouts/header.php";
require_once "../layouts/navbar.php";
require_once "../layouts/sidebar.php";

require_once "../../controllers/ComplaintController.php";

$controller = new ComplaintController();
$complaints = $controller->index();

?>

<div class="content-wrapper">

<section class="content-header">

<div class="container-fluid">

<div class="d-flex justify-content-between align-items-center">

<h1>Complaints</h1>

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
placeholder="Search Complaint or Resident"
value="<?= htmlspecialchars($_GET['search'] ?? '') ?>">

</div>

<div class="col-md-3">

<select
name="status"
class="form-select">

<option value="">All Status</option>

<option value="OPEN"
<?= (($_GET['status'] ?? '')=='OPEN')?'selected':''; ?>>

Open

</option>

<option value="ASSIGNED"
<?= (($_GET['status'] ?? '')=='ASSIGNED')?'selected':''; ?>>

Assigned

</option>

<option value="IN_PROGRESS"
<?= (($_GET['status'] ?? '')=='IN_PROGRESS')?'selected':''; ?>>

In Progress

</option>

<option value="RESOLVED"
<?= (($_GET['status'] ?? '')=='RESOLVED')?'selected':''; ?>>

Resolved

</option>

<option value="CLOSED"
<?= (($_GET['status'] ?? '')=='CLOSED')?'selected':''; ?>>

Closed

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
<th>Resident</th>
<th>Title</th>
<th>Category</th>
<th>Status</th>
<th>Date</th>
<th width="120">Action</th>

</tr>

</thead>

<tbody>

<?php if(empty($complaints)): ?>

<tr>

<td colspan="8" class="text-center">

No complaints found.

</td>

</tr>

<?php else: ?>

<?php foreach($complaints as $complaint): ?>

<tr>

<td><?= $complaint['id']; ?></td>

<td><?= htmlspecialchars($complaint['society_name']); ?></td>

<td><?= htmlspecialchars($complaint['resident_name']); ?></td>

<td><?= htmlspecialchars($complaint['title']); ?></td>

<td><?= htmlspecialchars($complaint['category']); ?></td>

<td>

<?php

$status = strtoupper($complaint['status']);

switch($status){

case 'OPEN':
echo '<span class="badge bg-primary">Open</span>';
break;

case 'ASSIGNED':
echo '<span class="badge bg-info">Assigned</span>';
break;

case 'IN_PROGRESS':
echo '<span class="badge bg-warning text-dark">In Progress</span>';
break;

case 'RESOLVED':
echo '<span class="badge bg-success">Resolved</span>';
break;

default:
echo '<span class="badge bg-secondary">Closed</span>';

}

?>

</td>

<td>

<?= date("d M Y", strtotime($complaint['created_at'])); ?>

</td>

<td>

<a href="#"
class="btn btn-info btn-sm">

<i class="fas fa-eye"></i>

</a>

<a href="#"
class="btn btn-warning btn-sm">

<i class="fas fa-edit"></i>

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