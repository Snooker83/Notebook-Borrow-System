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

$stmt = $conn->prepare("
UPDATE users
SET status = 'active'
WHERE id = ?
");

$stmt->execute([$id]);

$_SESSION['success'] = "User enabled successfully.";

header("Location: ../users.php");
exit;