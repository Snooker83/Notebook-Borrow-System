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

$id = $_GET['id'] ?? null;

if (!$id) {
    header("Location: notebooks.php");
    exit;
}

$stmt = $conn->prepare("
SELECT *
FROM notebook
WHERE id = ?
LIMIT 1
");

$stmt->execute([$id]);

$notebook = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$notebook) {
    $_SESSION['error'] = "Notebook not found.";
    header("Location: notebooks.php");
    exit;
}

?>

<?php

$pageTitle = "Notebook Borrow System (Admin)";

include "includes/header.php";

include "includes/navbar.php"; ?>

<a
href="notebooks.php"
class="btn btn-secondary mb-3">

← Back

</a>

<div class="card shadow">

<div class="card-header bg-warning">

<h3 class="mb-0">Edit Notebook</h3>  

</div>

<div class="card-body">

<form
action="process/update_notebook_process.php"
method="POST"
enctype="multipart/form-data">

<input
type="hidden"
name="id"
value="<?= $notebook['id'] ?>">

<input
type="hidden"
name="old_image"
value="<?= htmlspecialchars($notebook['image']) ?>">

<div class="mb-3">

<label class="form-label">

Asset Number

</label>

<input
type="text"
name="asset_num"
class="form-control"
value="<?= htmlspecialchars($notebook['asset_num']) ?>"
required>

</div>

<div class="mb-3">

<label class="form-label">

Notebook Name

</label>

<input
type="text"
name="name"
class="form-control"
value="<?= htmlspecialchars($notebook['name']) ?>"
required>

</div>

<div class="mb-3">

<label class="form-label">

Specification

</label>

<textarea
name="spec"
rows="5"
class="form-control"
required><?= htmlspecialchars($notebook['spec']) ?></textarea>

</div>

<div class="mb-3">

<label class="form-label">

Current Image

</label>

<br>

<?php if(!empty($notebook['image'])): ?>

<img
src="../uploads/notebook/<?= htmlspecialchars($notebook['image']) ?>"
width="180"
class="img-thumbnail">

<?php else: ?>

<p>No image</p>

<?php endif; ?>

</div>

<div class="mb-3">

<label class="form-label">

Replace Image (optional)

</label>

<input
type="file"
name="image"
class="form-control"
accept=".jpg,.jpeg,.png,.webp">

</div>

<div class="mb-3">

<label class="form-label">

Status

</label>

<select
name="status"
class="form-select">

<option
value="available"
<?= $notebook['status']=="available" ? "selected" : "" ?>>

Available

</option>

<option
value="borrowed"
<?= $notebook['status']=="borrowed" ? "selected" : "" ?>>

Borrowed

</option>

</select>

</div>

<div class="d-flex justify-content-between">

<button
type="submit"
class="btn btn-warning">

Update Notebook

</button>

</div>

</form>

</div>

</div>

</div>

</div>

</div>

<?php include "includes/footer.php"; ?>