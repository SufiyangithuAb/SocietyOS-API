<?php

require_once "../layouts/header.php";
require_once "../layouts/navbar.php";
require_once "../layouts/sidebar.php";

require_once "../../controllers/SettingsController.php";

$controller = new SettingsController();

$controller->save();

$settings = $controller->get();

?>

<div class="content-wrapper">

<section class="content-header">

<div class="container-fluid">

<div class="d-flex justify-content-between align-items-center">

<h1>Settings</h1>

</div>

</div>

</section>

<section class="content">

<div class="container-fluid">

<?php if(isset($_GET['success'])): ?>

<div class="alert alert-success">

Settings updated successfully.

</div>

<?php endif; ?>

<div class="card">

<div class="card-header">

<h3 class="card-title">

Platform Settings

</h3>

</div>

<form method="POST">

<div class="card-body">

<div class="row">

<div class="col-md-6">

<div class="mb-3">

<label>Site Name</label>

<input
type="text"
name="site_name"
class="form-control"
value="<?= htmlspecialchars($settings['site_name']); ?>">

</div>

</div>

<div class="col-md-6">

<div class="mb-3">

<label>Company Name</label>

<input
type="text"
name="company_name"
class="form-control"
value="<?= htmlspecialchars($settings['company_name']); ?>">

</div>

</div>

<div class="col-md-6">

<div class="mb-3">

<label>Support Email</label>

<input
type="email"
name="support_email"
class="form-control"
value="<?= htmlspecialchars($settings['support_email']); ?>">

</div>

</div>

<div class="col-md-6">

<div class="mb-3">

<label>Support Phone</label>

<input
type="text"
name="support_phone"
class="form-control"
value="<?= htmlspecialchars($settings['support_phone']); ?>">

</div>

</div>

<div class="col-md-6">

<div class="mb-3">

<label>Currency</label>

<select
name="currency"
class="form-select">

<option
value="INR"
<?= $settings['currency']=="INR"?"selected":""; ?>>

INR

</option>

<option
value="USD"
<?= $settings['currency']=="USD"?"selected":""; ?>>

USD

</option>

<option
value="EUR"
<?= $settings['currency']=="EUR"?"selected":""; ?>>

EUR

</option>

</select>

</div>

</div>

<div class="col-md-6">

<div class="mb-3">

<label>Timezone</label>

<input
type="text"
name="timezone"
class="form-control"
value="<?= htmlspecialchars($settings['timezone']); ?>">

</div>

</div>

<div class="col-md-6">

<div class="mb-3">

<label>Maintenance Mode</label>

<select
name="maintenance_mode"
class="form-select">

<option
value="0"
<?= $settings['maintenance_mode']==0?"selected":""; ?>>

OFF

</option>

<option
value="1"
<?= $settings['maintenance_mode']==1?"selected":""; ?>>

ON

</option>

</select>

</div>

</div>

<div class="col-md-12">

<div class="mb-3">

<label>Company Address</label>

<textarea
name="address"
class="form-control"
rows="4"><?= htmlspecialchars($settings['address']); ?></textarea>

</div>

</div>

</div>

</div>

<div class="card-footer">

<button
class="btn btn-primary">

<i class="fas fa-save"></i>

Save Settings

</button>

</div>

</form>

</div>

</div>

</section>

</div>

<?php

require_once "../layouts/footer.php";

?>