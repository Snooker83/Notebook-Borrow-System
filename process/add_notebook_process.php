<?php

require_once "../config/config.php";
require_once "../config/database.php";

// ==========================================
// ตรวจสอบ Admin Login
// ==========================================

if (
    !isset($_SESSION['admin_login']) ||
    $_SESSION['admin_login'] !== true
) {
    header("Location: ../admin/login.php");
    exit;
}

// ==========================================
// รับข้อมูลจากฟอร์ม
// ==========================================

$asset_num = trim($_POST['asset_num'] ?? '');
$name      = trim($_POST['name'] ?? '');
$spec      = trim($_POST['spec'] ?? '');
$status    = $_POST['status'] ?? 'available';

// ==========================================
// ตรวจสอบข้อมูล
// ==========================================

if (
    $asset_num == "" ||
    $name == "" ||
    $spec == ""
) {

    $_SESSION['error'] = "Please complete all required fields.";

    header("Location: ../admin/notebook_add.php");
    exit;
}

// ==========================================
// ตรวจสอบ Asset Number ซ้ำ
// ==========================================

$check = $conn->prepare("
SELECT id
FROM notebook
WHERE asset_num = ?
LIMIT 1
");

$check->execute([
    $asset_num
]);

if ($check->fetch()) {

    $_SESSION['error'] = "Asset Number already exists.";

    header("Location: ../admin/notebook_add.php");
    exit;
}

// ==========================================
// Upload Image
// ==========================================

$imageName = null;

if (
    isset($_FILES['image']) &&
    $_FILES['image']['error'] == 0
) {

    $allowed = [
        'jpg',
        'jpeg',
        'png',
        'webp'
    ];

    $extension = strtolower(
        pathinfo(
            $_FILES['image']['name'],
            PATHINFO_EXTENSION
        )
    );

    if (!in_array($extension, $allowed)) {

        $_SESSION['error'] = "Invalid image format.";

        header("Location: ../admin/notebook_add.php");
        exit;
    }

    // ตั้งชื่อไฟล์ใหม่
    $imageName = uniqid("notebook_") . "." . $extension;

    $uploadPath =
        "../uploads/notebook/" . $imageName;

    move_uploaded_file(
        $_FILES['image']['tmp_name'],
        $uploadPath
    );
}

// ==========================================
// INSERT
// ==========================================

$stmt = $conn->prepare("
INSERT INTO notebook
(
asset_num,
name,
spec,
image,
status
)
VALUES
(
?,
?,
?,
?,
?
)
");

$stmt->execute([
    $asset_num,
    $name,
    $spec,
    $imageName,
    $status
]);

$_SESSION['success'] = "Notebook added successfully.";

header("Location: ../admin/notebooks.php");
exit;