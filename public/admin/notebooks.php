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
SELECT *
FROM notebook
ORDER BY id ASC
");

$stmt->execute();

$notebooks = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<?php

$pageTitle = "Notebook Borrow System (Admin)";

include "includes/header.php";

include "includes/navbar.php"; ?>

<h2>

Manage Notebook

</h2>

<a
href="dashboard.php"
class="btn btn-secondary mb-3">

← Dashboard

</a>

<a
href="notebook_add.php"
class="btn btn-success mb-3 float-end">

+ Add Notebook

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

<th>ID</th>

<th>Image</th>

<th>Asset Number</th>

<th>Name</th>

<th>Specification</th>

<th>Status</th>

<th width="180">

Action

</th>

</tr>

</thead>

<tbody>

<?php foreach($notebooks as $nb): ?>

<tr>

<td>

<?= $nb['id'] ?>

</td>

<td>

<?php if(!empty($nb['image'])): ?>

<img
src="../uploads/notebook/<?= htmlspecialchars($nb['image']) ?>"
width="100">

<?php else: ?>

No Image

<?php endif; ?>

</td>

<td>

<?= htmlspecialchars($nb['asset_num']) ?>

</td>

<td>

<?= htmlspecialchars($nb['name']) ?>

</td>

<td>

<?= htmlspecialchars($nb['spec']) ?>

</td>

<td>

<?php

if($nb['status']=="available"){

    echo '<span class="badge bg-success">Available</span>';

}else{

    echo '<span class="badge bg-danger">Borrowed</span>';

}

?>

</td>

<td>

<a
href="notebook_edit.php?id=<?= $nb['id'] ?>"
class="btn btn-warning btn-sm">

Edit

</a>

<a
href="process/notebook_delete.php?id=<?= $nb['id'] ?>"
class="btn btn-danger btn-sm"
onclick="return confirm('Are you sure you want to delete this notebook?')">

Delete

</a>

</td>

</tr>

<?php endforeach; ?>

</tbody>
</table>
</div>
</div>

<?php include "includes/footer.php"; ?>