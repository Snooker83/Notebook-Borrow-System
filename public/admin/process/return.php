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
// รับ Transaction ID
// ==========================================

$transaction_id = $_GET['id'] ?? null;

if (!$transaction_id) {

    $_SESSION['error'] = "Invalid Transaction ID.";

    header("Location: ../borrowed.php");
    exit;
}

// ==========================================
// ดึงข้อมูล Transaction
// ==========================================

$stmt = $conn->prepare("
SELECT *
FROM transactions
WHERE id = ?
LIMIT 1
");

$stmt->execute([
    $transaction_id
]);

$transaction = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$transaction) {

    $_SESSION['error'] = "Transaction not found.";

    header("Location: ../borrowed.php");
    exit;
}

// ==========================================
// ตรวจสอบสถานะ
// ==========================================

if ($transaction['status'] != "approved") {

    $_SESSION['error'] = "This notebook has already been returned.";

    header("Location: ../borrowed.php");
    exit;
}

// ==========================================
// เริ่ม Database Transaction
// ==========================================

try {

    $conn->beginTransaction();

    // --------------------------------------
    // คืน Notebook
    // --------------------------------------

    $updateTransaction = $conn->prepare("
    UPDATE transactions
    SET
        status = 'returned',
        return_time = NOW()
    WHERE id = ?
    ");

    $updateTransaction->execute([
        $transaction_id
    ]);

    // --------------------------------------
    // เปลี่ยนสถานะ Notebook
    // --------------------------------------

    $updateNotebook = $conn->prepare("
    UPDATE notebook
    SET status = 'available'
    WHERE id = ?
    ");

    $updateNotebook->execute([
        $transaction['notebook_id']
    ]);

    $conn->commit();

    $_SESSION['success'] = "Notebook returned successfully.";

} catch (PDOException $e) {

    $conn->rollBack();

    $_SESSION['error'] = $e->getMessage();
}

header("Location: ../borrowed.php");
exit;