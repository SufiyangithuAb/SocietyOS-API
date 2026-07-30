<?php

require_once "config/config.php";

if (isset($_SESSION['super_admin'])) {
    header("Location: index.php");
    exit;
}

$flash = getFlash();

?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title><?= APP_NAME ?> | Super Admin</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" rel="stylesheet">

<style>

body{
    background:#f4f7fb;
    font-family:'Segoe UI',sans-serif;
}

.login-container{
    min-height:100vh;
}

.login-card{

    border:none;
    border-radius:20px;

    box-shadow:
    0 15px 40px rgba(0,0,0,.08);

    overflow:hidden;
}

.left-side{

    background:linear-gradient(135deg,#2563EB,#10B981);

    color:white;

    padding:60px;

    display:flex;

    flex-direction:column;

    justify-content:center;

}

.right-side{

    padding:50px;

}

.logo{

    font-size:45px;

    margin-bottom:20px;

}

.form-control{

    height:50px;

    border-radius:10px;

}

.btn-login{

    height:50px;

    border-radius:10px;

    font-weight:600;

}

.footer{

    font-size:13px;

    color:#888;

    text-align:center;

    margin-top:25px;

}

</style>

</head>

<body>

<div class="container login-container d-flex align-items-center justify-content-center">

<div class="row w-100 justify-content-center">

<div class="col-lg-10">

<div class="card login-card">

<div class="row g-0">

<div class="col-lg-6 left-side">

<div class="logo">
<i class="fa-solid fa-building"></i>
</div>

<h2>SocietyOS</h2>

<h5 class="mt-3">
Super Admin Panel
</h5>

<p class="mt-4">

Manage societies, subscriptions,
payments, complaints,
analytics and system settings
from one centralized dashboard.

</p>

</div>

<div class="col-lg-6 right-side">

<h3 class="mb-4">

Welcome Back 👋

</h3>

<?php if($flash): ?>

<div class="alert alert-<?= $flash['type']; ?>">

<?= $flash['message']; ?>

</div>

<?php endif; ?>

<form
action="controllers/AuthController.php?action=login"
method="POST">

<div class="mb-3">

<label class="form-label">

Email Address

</label>

<input
type="email"
name="email"
class="form-control"
required>

</div>

<div class="mb-4">

<label class="form-label">

Password

</label>

<div class="input-group">

<input
type="password"
name="password"
id="password"
class="form-control"
required>

<button
type="button"
class="btn btn-outline-secondary"
onclick="togglePassword()">

<i
id="eye"
class="fa-solid fa-eye">
</i>

</button>

</div>

</div>

<div class="d-grid">

<button
class="btn btn-primary btn-login">

<i class="fa-solid fa-right-to-bracket"></i>

Login

</button>

</div>

</form>

<div class="footer">

<?= APP_NAME ?>

Version <?= APP_VERSION ?>

</div>

</div>

</div>

</div>

</div>

</div>

</div>

<script>

function togglePassword(){

let input=document.getElementById("password");

let eye=document.getElementById("eye");

if(input.type==="password"){

input.type="text";

eye.className="fa-solid fa-eye-slash";

}else{

input.type="password";

eye.className="fa-solid fa-eye";

}

}

</script>

</body>

</html>