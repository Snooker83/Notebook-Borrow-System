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

$transaction_id = $_GET['id'] ?? null;

if (!$transaction_id) {
    $_SESSION['error'] = "Invalid Transaction ID.";
    header("Location: ../requests.php");
    exit;
}

// ดึงข้อมูล Transaction
$stmt = $conn->prepare("
SELECT *
FROM transactions
WHERE id = ?
LIMIT 1
");

$stmt->execute([$transaction_id]);

$transaction = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$transaction) {
    $_SESSION['error'] = "Transaction not found.";
    header("Location: ../requests.php");
    exit;
}

if ($transaction['status'] != 'pending') {
    $_SESSION['error'] = "This request has already been processed.";
    header("Location: ../requests.php");
    exit;
}

// Reject
$update = $conn->prepare("
UPDATE transactions
SET status = 'rejected'
WHERE id = ?
");

$update->execute([$transaction_id]);

$_SESSION['success'] = "Borrow request rejected successfully.";

header("Location: ../requests.php");
exit;