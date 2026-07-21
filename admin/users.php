<?php

require_once "../config/config.php";
require_once "../config/database.php";

if (
    !isset($_SESSION['admin_login']) ||
    $_SESSION['admin_login'] !== true
) {
    header("Location: login.php");
    exit;
}

$stmt = $conn->prepare("
SELECT
    id,
    first_name,
    last_name,
    student_id,
    phone,
    email,
    is_verified,
    status,
    created_at
FROM users
ORDER BY id ASC
");

$stmt->execute();

$users = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<?php

$pageTitle = "Notebook Borrow System (Admin)";

include "includes/header.php";

include "includes/navbar.php"; ?>

<h2>Manage Users</h2>

<a
href="dashboard.php"
class="btn btn-secondary mb-3">

← Dashboard

</a>

<?php if(isset($_SESSION['success'])): ?>

<div class="alert alert-success">
    <?= htmlspecialchars($_SESSION['success']) ?>
</div>

<?php unset($_SESSION['success']); ?>
<?php endif; ?>


<?php if(isset($_SESSION['error'])): ?>

<div class="alert alert-danger">
    <?= htmlspecialchars($_SESSION['error']) ?>
</div>

<?php unset($_SESSION['error']); ?>
<?php endif; ?>

<div class="table-responsive">

<table class="table table-hover align-middle datatable">

<thead class="table-dark">

<tr>

<th>ID</th>

<th>Student ID</th>

<th>Name</th>

<th>Phone</th>

<th>Email</th>

<th>Verified</th>

<th>Status</th>

<th>Created</th>

<th width="220">Action</th>

</tr>

</thead>

<tbody>

<?php foreach($users as $u): ?>

<tr>

<td><?= $u['id'] ?></td>

<td><?= htmlspecialchars($u['student_id']) ?></td>

<td>
<?= htmlspecialchars($u['first_name']) ?>
<?= htmlspecialchars($u['last_name']) ?>
</td>

<td><?= htmlspecialchars($u['phone']) ?></td>

<td><?= htmlspecialchars($u['email']) ?></td>

<td>

<?php if($u['is_verified']) : ?>

<span class="badge bg-success">

Verified

</span>

<?php else: ?>

<span class="badge bg-danger">

Not Verified

</span>

<?php endif; ?>

</td>

<td>

<?php if($u['status']=="active"): ?>

<span class="badge bg-primary">

Active

</span>

<?php else: ?>

<span class="badge bg-secondary">

Disabled

</span>

<?php endif; ?>

</td>

<td><?= $u['created_at'] ?></td>

<td>

<a
href="user_detail.php?id=<?= $u['id'] ?>"
class="btn btn-info btn-sm">

View

</a>

<?php if($u['status']=="active"): ?>

<a
href="../process/disable_user.php?id=<?= $u['id'] ?>"
class="btn btn-warning btn-sm"
onclick="return confirm('Disable this user?')">

Disable

</a>

<?php else: ?>

<a
href="../process/enable_user.php?id=<?= $u['id'] ?>"
class="btn btn-success btn-sm"
onclick="return confirm('Enable this user?')">

Enable

</a>

<?php endif; ?>

</td>

</tr>

<?php endforeach; ?>

</tbody>

</table>
</div>

</div>

<?php include "includes/footer.php"; ?>