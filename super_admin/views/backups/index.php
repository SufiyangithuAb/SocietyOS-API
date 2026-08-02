<?php

require_once "../layouts/header.php";
require_once "../layouts/navbar.php";
require_once "../layouts/sidebar.php";

require_once "../../controllers/BackupController.php";

$controller = new BackupController();

$message = "";

if(isset($_POST['backup']))
{
    $file = $controller->createBackup();

    $message = "Backup Created : ".$file;
}

?>

<div class="content-wrapper">

<section class="content-header">

<div class="container-fluid">

<h1>Backup Manager</h1>

</div>

</section>

<section class="content">

<div class="container-fluid">

<?php if($message): ?>

<div class="alert alert-success">

<?= $message ?>

</div>

<?php endif; ?>

<div class="card">

<div class="card-body">

<form method="POST">

<button
name="backup"
class="btn btn-success">

<i class="fas fa-database"></i>

Create Backup

</button>

</form>

</div>

</div>

</div>

</section>

</div>

<?php

require_once "../layouts/footer.php";

?>