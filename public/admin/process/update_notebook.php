<?php

require_once __DIR__ . "/../../../config/config.php";
require_once __DIR__ . "/../../../config/database.php";

// ==========================================
// ตรวจสอบ Admin Login
// ==========================================

if (
    !isset($_SESSION['admin_login']) ||
    $_SESSION['admin_login'] !== true
) {
    header("Location: ../login.php");
    exit;
}

// ==========================================
// รับข้อมูล
// ==========================================

$id        = $_POST['id'] ?? null;
$asset_num = trim($_POST['asset_num'] ?? '');
$name      = trim($_POST['name'] ?? '');
$spec      = trim($_POST['spec'] ?? '');
$status    = $_POST['status'] ?? 'available';
$old_image = $_POST['old_image'] ?? '';

if (
    !$id ||
    $asset_num == "" ||
    $name == "" ||
    $spec == ""
) {
    $_SESSION['error'] = "Please complete all required fields.";
    header("Location: ../notebook_edit.php?id=".$id);
    exit;
}

// ==========================================
// ตรวจสอบ Asset Number ซ้ำ
// ==========================================

$check = $conn->prepare("
SELECT id
FROM notebook
WHERE asset_num = ?
AND id != ?
LIMIT 1
");

$check->execute([
    $asset_num,
    $id
]);

if($check->fetch()){

    $_SESSION['error'] = "Asset Number already exists.";

    header("Location: ../notebook_edit.php?id=".$id);
    exit;

}

// ==========================================
// Upload รูปใหม่ (ถ้ามี)
// ==========================================

$imageName = $old_image;

if(
    isset($_FILES['image']) &&
    $_FILES['image']['error'] == 0
){

    $allowed = [
        "jpg",
        "jpeg",
        "png",
        "webp"
    ];

    $extension = strtolower(
        pathinfo(
            $_FILES['image']['name'],
            PATHINFO_EXTENSION
        )
    );

    if(!in_array($extension,$allowed)){

        $_SESSION['error']="Invalid image format.";

        header("Location: ../notebook_edit.php?id=".$id);
        exit;

    }

    $imageName =
    uniqid("notebook_").".".$extension;

    $uploadPath =
    "../../uploads/notebook/".$imageName;

    if(
        move_uploaded_file(
            $_FILES['image']['tmp_name'],
            $uploadPath
        )
    ){

        // ลบรูปเก่า

        if(
            !empty($old_image) &&
            file_exists("../../uploads/notebook/".$old_image)
        ){

            unlink("../../uploads/notebook/".$old_image);

        }

    }

}

// ==========================================
// UPDATE
// ==========================================

$update = $conn->prepare("
UPDATE notebook
SET

asset_num = ?,
name = ?,
spec = ?,
image = ?,
status = ?

WHERE id = ?
");

$update->execute([

    $asset_num,
    $name,
    $spec,
    $imageName,
    $status,
    $id

]);

$_SESSION['success']="Notebook updated successfully.";

header("Location: ../notebooks.php");
exit;