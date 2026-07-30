<?php
require_once "config/config.php";

if (isset($_SESSION["super_admin"])) {
    header("Location: views/dashboard/index.php");
    exit;
}
?>

<!DOCTYPE html>
<html>

<head>

    <title>SocietyOS Super Admin</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet">

</head>

<body class="bg-light">

<div class="container mt-5">

<div class="row justify-content-center">

<div class="col-md-4">

<div class="card shadow">

<div class="card-header text-center">

<h3>Super Admin Login</h3>

</div>

<div class="card-body">

<form action="login.php" method="POST">

<input
type="email"
name="email"
class="form-control mb-3"
placeholder="Email"
required>

<input
type="password"
name="password"
class="form-control mb-3"
placeholder="Password"
required>

<button
class="btn btn-primary w-100">

Login

</button>

</form>

</div>

</div>

</div>

</div>

</div>

</body>

</html>