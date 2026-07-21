<?php

require_once "../config/config.php";
require_once "../config/database.php";

// ==========================================
// รับข้อมูลจากฟอร์ม
// ==========================================

$username = trim($_POST['username'] ?? '');
$password = $_POST['password'] ?? '';

// ==========================================
// ตรวจสอบข้อมูล
// ==========================================

if ($username === '' || $password === '') {

    $_SESSION['error'] = "Please enter username and password.";

    header("Location: ../admin/login.php");
    exit;
}

// ==========================================
// ค้นหา Admin
// ==========================================

$stmt = $conn->prepare("
    SELECT *
    FROM admin
    WHERE username = ?
    LIMIT 1
");

$stmt->execute([
    $username
]);

$admin = $stmt->fetch(PDO::FETCH_ASSOC);

// ==========================================
// ตรวจสอบรหัสผ่าน
// ==========================================

if (!$admin || !password_verify($password, $admin['password'])) {

    $_SESSION['error'] = "Invalid username or password.";

    header("Location: ../admin/login.php");
    exit;
}

// ==========================================
// Login Success
// ==========================================

$_SESSION['admin_login'] = true;
$_SESSION['admin_id'] = $admin['id'];
$_SESSION['admin_username'] = $admin['username'];

header("Location: ../admin/dashboard.php");
exit;