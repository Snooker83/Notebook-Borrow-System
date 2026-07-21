<?php

require_once "../config/config.php";

?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>
Login | Notebook Borrow System
</title>

<link 
href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
rel="stylesheet">

<link rel="stylesheet" href="assets/css/theme.css">

</head>

<body>

<div class="container py-5">

<div class="row justify-content-center">

<div class="col-md-5">

<div class="card shadow">

<div class="card-body p-5">

<h2 class="text-center fw-bold">

Notebook Borrow System

</h2>

<h5 class="text-center text-secondary mb-4">

Login เข้าสู่ระบบ

</h5>

<?php if(isset($_SESSION['error'])): ?>

<div class="alert alert-danger">

<?= $_SESSION['error']; ?>

</div>

<?php unset($_SESSION['error']); ?>

<?php endif; ?>

<?php if(isset($_SESSION['success'])): ?>

<div class="alert alert-success">

<?= $_SESSION['success']; ?>

</div>

<?php unset($_SESSION['success']); ?>

<?php endif; ?>

<form 
action="../process/login_process.php"
method="POST"
id="loginForm">

<div class="mb-3">


<label class="form-label">

CMU Email

<br>

อีเมล CMU

</label>

<div class="input-group">

<input

type="text"

name="email"

id="email"

class="form-control"

placeholder="username"

required

>

<span class="input-group-text">

@cmu.ac.th

</span>

</div>

</div>

<div class="mb-3">


<label class="form-label">

Password

<br>

รหัสผ่าน

</label>


<input

type="password"

name="password"

id="password"

class="form-control"

required

>

</div>

<button

type="submit"

class="btn btn-primary w-100"

>

Login

<br>

เข้าสู่ระบบ

</button>

</form>

<div class="text-center mt-3">

<p>

ยังไม่มีบัญชี?

<br>

<a href="register.php">

สมัครสมาชิก

</a>

</p>

</div>

</div>

</div>

</div>

</div>

</div>

<script src="assets/js/login.js"></script>

</body>

</html>