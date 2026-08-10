<?php

require_once __DIR__ . "/../../../config/config.php";
require_once __DIR__ . "/../../../config/database.php";

// ตรวจสอบ Admin Login
if (
    !isset($_SESSION['admin_login']) ||
    $_SESSION['admin_login'] !== true
) {
    header("Location: ../login.php");
    exit;
}

$id = $_GET['id'] ?? null;

if (!$id) {
    $_SESSION['error'] = "Invalid User ID.";
    header("Location: ../users.php");
    exit;
}

// ป้องกันไม่ให้ Admin ปิดบัญชีตัวเอง
if (isset($_SESSION['admin_id']) && $_SESSION['admin_id'] == $id) {
    $_SESSION['error'] = "You cannot disable your own account.";
    header("Location: ../users.php");
    exit;
}

$stmt = $conn->prepare("
UPDATE users
SET status = 'disabled'
WHERE id = ?
");

$stmt->execute([$id]);

$_SESSION['success'] = "User disabled successfully.";

header("Location: ../users.php");
exit;