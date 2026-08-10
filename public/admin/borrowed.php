<?php

require_once __DIR__ . "/../../config/config.php";
require_once __DIR__ . "/../../config/database.php";

if (
    !isset($_SESSION['admin_login']) ||
    $_SESSION['admin_login'] !== true
) {
    header("Location: login.php");
    exit;
}

$stmt = $conn->prepare("
SELECT

transactions.id,
transactions.borrow_time,

users.first_name,
users.last_name,
users.student_id,

notebook.name,
notebook.asset_num

FROM transactions

INNER JOIN users
ON transactions.user_id = users.id

INNER JOIN notebook
ON transactions.notebook_id = notebook.id

WHERE transactions.status = 'approved'

ORDER BY transactions.borrow_time ASC
");

$stmt->execute();

$borrowed = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<?php

$pageTitle = "Notebook Borrow System (Admin)";

include "includes/header.php";

include "includes/navbar.php"; ?>

<h2>Borrowed Notebook</h2>

<a
href="dashboard.php"
class="btn btn-secondary mb-3">

← Dashboard

</a>

<?php if(isset($_SESSION['success'])): ?>

<div class="alert alert-success">

    <?= $_SESSION['success']; ?>

</div>

<?php unset($_SESSION['success']); ?>

<?php endif; ?>


<?php if(isset($_SESSION['error'])): ?>

<div class="alert alert-danger">

    <?= $_SESSION['error']; ?>

</div>

<?php unset($_SESSION['error']); ?>

<?php endif; ?>

<div class="table-responsive">

<table class="table table-hover align-middle datatable">

<thead class="table-dark">

<tr>

<th>Student</th>

<th>Student ID</th>

<th>Notebook</th>

<th>Asset Number</th>

<th>Borrow Time</th>

<th>Action</th>

</tr>

</thead>

<tbody>

<?php foreach($borrowed as $b): ?>

<tr>

<td>

<?= htmlspecialchars($b['first_name']) ?>
<?= htmlspecialchars($b['last_name']) ?>

</td>

<td>

<?= htmlspecialchars($b['student_id']) ?>

</td>

<td>

<?= htmlspecialchars($b['name']) ?>

</td>

<td>

<?= htmlspecialchars($b['asset_num']) ?>

</td>

<td>

<?= htmlspecialchars($b['borrow_time']) ?>

</td>

<td>

<a
href="process/return.php?id=<?= $b['id'] ?>"
class="btn btn-primary btn-sm"
onclick="return confirm('Confirm return notebook?');">

Return

</a>

</td>

</tr>

<?php endforeach; ?>

</tbody>

</table>

</div>

</div>

<?php include "includes/footer.php"; ?>