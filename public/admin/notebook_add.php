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

<div class="card-header bg-primary text-white">

<h3 class="mb-0">

Add Notebook

</h3>

</div>

<div class="card-body">

<form
action="process/add_notebook_process.php"
method="POST"
enctype="multipart/form-data">

<div class="mb-3">

<label class="form-label">

Asset Number

</label>

<input
type="text"
name="asset_num"
class="form-control"
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
required></textarea>

</div>

<div class="mb-3">

<label class="form-label">

Notebook Image

</label>

<input
type="file"
name="image"
class="form-control"
accept=".jpg,.jpeg,.png,.webp">

<div class="form-text">

Allowed: JPG, JPEG, PNG, WEBP

</div>

</div>

<div class="mb-3">

<label class="form-label">

Status

</label>

<select
name="status"
class="form-select">

<option value="available">

Available

</option>

<option value="borrowed">

Borrowed

</option>

</select>

</div>

<div class="d-flex justify-content-between">

<button
type="submit"
class="btn btn-success">

Save Notebook

</button>

</div>

</form>

</div>

</div>

</div>

</div>

</div>

<?php include "includes/footer.php"; ?>