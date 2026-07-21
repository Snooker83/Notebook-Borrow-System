<?php

require_once "../config/config.php";
require_once "../config/database.php";

if (
    !isset($_SESSION['admin_login']) ||
    $_SESSION['admin_login'] !== true
){
    header("Location: login.php");
    exit;
}

$id = $_GET['id'] ?? null;

if(!$id){

    header("Location: users.php");
    exit;

}

// --------------------------
// User
// --------------------------

$stmt = $conn->prepare("
SELECT *
FROM users
WHERE id=?
LIMIT 1
");

$stmt->execute([$id]);

$user = $stmt->fetch(PDO::FETCH_ASSOC);

if(!$user){

    $_SESSION['error']="User not found.";

    header("Location: users.php");
    exit;

}

// --------------------------
// Borrow History
// --------------------------

$history = $conn->prepare("
SELECT

transactions.*,

notebook.name,

notebook.asset_num

FROM transactions

INNER JOIN notebook

ON notebook.id = transactions.notebook_id

WHERE transactions.user_id = ?

ORDER BY transactions.id DESC
");

$history->execute([$id]);

$transactions =
$history->fetchAll(PDO::FETCH_ASSOC);

// --------------------------
// Statistics
// --------------------------

$totalBorrow =
count($transactions);

$pending = 0;
$approved = 0;
$returned = 0;
$rejected = 0;

foreach($transactions as $t){

    switch($t['status']){

        case "pending":
            $pending++;
            break;

        case "approved":
            $approved++;
            break;

        case "returned":
            $returned++;
            break;

        case "rejected":
            $rejected++;
            break;

    }

}

?>

<?php

$pageTitle = "Notebook Borrow System (Admin)";

include "includes/header.php";

include "includes/navbar.php"; ?>

<a
href="users.php"
class="btn btn-secondary mb-3">

← Back

</a>

<div class="card shadow mb-4">

<div class="card-header bg-dark text-white">

<h3>

User Detail

</h3>

</div>

<div class="card-body">

<div class="row">

<div class="col-md-6">

<p>

<strong>Name :</strong>

<?= htmlspecialchars($user['first_name']) ?>

<?= htmlspecialchars($user['last_name']) ?>

</p>

<p>

<strong>Student ID :</strong>

<?= htmlspecialchars($user['student_id']) ?>

</p>

<p>

<strong>Phone :</strong>

<?= htmlspecialchars($user['phone']) ?>

</p>

<p>

<strong>Email :</strong>

<?= htmlspecialchars($user['email']) ?>

</p>

</div>

<div class="col-md-6">

<p>

<strong>Verified :</strong>

<?= $user['is_verified'] ? "Yes" : "No" ?>

</p>

<p>

<strong>Status :</strong>

<?= htmlspecialchars($user['status']) ?>

</p>

<p>

<strong>Created :</strong>

<?= htmlspecialchars($user['created_at']) ?>

</p>

</div>

</div>

</div>

</div>

<div class="row mb-4">

<div class="col">

<div class="card border-primary">

<div class="card-body">

<h5>Total Requests</h5>

<h2><?= $totalBorrow ?></h2>

</div>

</div>

</div>

<div class="col">

<div class="card border-warning">

<div class="card-body">

<h5>Pending</h5>

<h2><?= $pending ?></h2>

</div>

</div>

</div>

<div class="col">

<div class="card border-success">

<div class="card-body">

<h5>Borrowed</h5>

<h2><?= $approved ?></h2>

</div>

</div>

</div>

<div class="col">

<div class="card border-info">

<div class="card-body">

<h5>Returned</h5>

<h2><?= $returned ?></h2>

</div>

</div>

</div>

<div class="col">

<div class="card border-danger">

<div class="card-body">

<h5>Rejected</h5>

<h2><?= $rejected ?></h2>

</div>

</div>

</div>

</div>

<h3>

Borrow History

</h3>

<table class="table table-bordered">

<thead class="table-dark">

<tr>

<th>Notebook</th>

<th>Asset</th>

<th>Borrow</th>

<th>Return</th>

<th>Status</th>

</tr>

</thead>

<tbody>

<?php foreach($transactions as $t): ?>

<tr>

<td>

<?= htmlspecialchars($t['name']) ?>

</td>

<td>

<?= htmlspecialchars($t['asset_num']) ?>

</td>

<td>

<?= $t['borrow_time'] ?: "-" ?>

</td>

<td>

<?= $t['return_time'] ?: "-" ?>

</td>

<td>

<?= ucfirst(htmlspecialchars($t['status'])) ?>

</td>

</tr>

<?php endforeach; ?>

</tbody>

</table>

</div>

<?php include "includes/footer.php"; ?>