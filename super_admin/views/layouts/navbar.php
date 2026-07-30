<nav class="main-header navbar navbar-expand navbar-white navbar-light">

<ul class="navbar-nav">

<li class="nav-item">

<a
class="nav-link"
data-widget="pushmenu"
href="#">

<i class="fas fa-bars"></i>

</a>

</li>

</ul>

<ul class="navbar-nav ms-auto">

<li class="nav-item">

<span class="nav-link">

Welcome,

<strong>

<?= htmlspecialchars($user['name']) ?>

</strong>

</span>

</li>

<li class="nav-item">

<a
class="nav-link text-danger"
href="<?= BASE_URL ?>controllers/AuthController.php?action=logout">

Logout

</a>

</li>

</ul>

</nav>