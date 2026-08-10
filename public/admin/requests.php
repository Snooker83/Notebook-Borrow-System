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
transactions.status,
transactions.notebook_id,

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

WHERE transactions.status='pending'

ORDER BY transactions.id ASC
");

$stmt->execute();

$requests = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<?php

$pageTitle = "Notebook Borrow System (Admin)";

include "includes/header.php";

include "includes/navbar.php"; ?>

<h2>Borrow Requests</h2>

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

<th>#</th>

<th>Student</th>

<th>Student ID</th>

<th>Notebook</th>

<th>Asset Number</th>

<th>Status</th>

<th>Action</th>

</tr>

</thead>

<tbody>

<?php foreach($requests as $r): ?>

<tr>

<td><?= $r['id'] ?></td>

<td>

<?= htmlspecialchars($r['first_name']) ?>

<?= htmlspecialchars($r['last_name']) ?>

</td>

<td><?= htmlspecialchars($r['student_id']) ?></td>

<td><?= htmlspecialchars($r['name']) ?></td>

<td><?= htmlspecialchars($r['asset_num']) ?></td>

<td>

<span class="badge bg-warning">

Pending

</span>

</td>

<td>

<div class="d-flex gap-2">

<a
href="process/approve.php?id=<?= $r['id'] ?>"
class="btn btn-success btn-sm">

Approve

</a>

<a
href="process/reject.php?id=<?= $r['id'] ?>"
class="btn btn-danger btn-sm">

Reject

</a>
</div>
</td>

</tr>

<?php endforeach; ?>

</tbody>

</table>
</div>
</div>

<?php include "includes/footer.php"; ?>