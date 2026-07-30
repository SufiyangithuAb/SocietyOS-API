<?php

require_once "../../middleware/auth.php";

$user = $_SESSION['super_admin'];

?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Dashboard | SocietyOS</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" rel="stylesheet">

</head>

<body class="bg-light">

<nav class="navbar navbar-dark bg-primary">

<div class="container-fluid">

<span class="navbar-brand">

🏢 SocietyOS Super Admin

</span>

<div class="text-white">

Welcome,

<strong><?= htmlspecialchars($user['name']) ?></strong>

|

<a
href="../../controllers/AuthController.php?action=logout"
class="text-white text-decoration-none">

Logout

</a>

</div>

</div>

</nav>

<div class="container mt-5">

<div class="row">

<div class="col-md-3">

<div class="card shadow-sm">

<div class="card-body text-center">

<h2>0</h2>

<p>Total Societies</p>

</div>

</div>

</div>

<div class="col-md-3">

<div class="card shadow-sm">

<div class="card-body text-center">

<h2>0</h2>

<p>Total Residents</p>

</div>

</div>

</div>

<div class="col-md-3">

<div class="card shadow-sm">

<div class="card-body text-center">

<h2>₹0</h2>

<p>Total Revenue</p>

</div>

</div>

</div>

<div class="col-md-3">

<div class="card shadow-sm">

<div class="card-body text-center">

<h2>0</h2>

<p>Premium Plans</p>

</div>

</div>

</div>

</div>

</div>

</body>

</html>