<?php

require_once __DIR__ . "/../../config/config.php";

if(isset($_SESSION['admin_login'])){

    header("Location: dashboard.php");
    exit;

}

?>
<!DOCTYPE html>

<html lang="en">

<head>

<meta charset="UTF-8">

<title>

Admin Login

</title>

<link
href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
rel="stylesheet">

</head>

<body class="bg-light">

<div class="container">

<div
class="row justify-content-center mt-5">

<div class="col-md-5">

<div class="card shadow">

<div class="card-header bg-dark text-white">

<h3 class="mb-0">

Administrator Login

</h3>

</div>

<div class="card-body">

<?php if(isset($_SESSION['error'])): ?>

<div class="alert alert-danger">

    <?= $_SESSION['error']; ?>

</div>

<?php unset($_SESSION['error']); ?>

<?php endif; ?>

<form
action="process/login_process.php"
method="POST">

<div class="mb-3">

<label>

Username

</label>

<input
type="text"
name="username"
class="form-control"
required>

</div>

<div class="mb-3">

<label>

Password

</label>

<input
type="password"
name="password"
class="form-control"
required>

</div>

<button
class="btn btn-dark w-100">

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