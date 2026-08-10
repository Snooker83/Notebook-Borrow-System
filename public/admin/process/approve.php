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

    header("Location: ../requests.php");
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

    header("Location: ../requests.php");
    exit;
}

// ==========================================
// ตรวจสอบว่ายัง Pending อยู่หรือไม่
// ==========================================

if ($transaction['status'] != "pending") {

    $_SESSION['error'] = "This request has already been processed.";

    header("Location: ../requests.php");
    exit;
}

// ==========================================
// เริ่ม Transaction
// ==========================================

try {

    $conn->beginTransaction();

    // --------------------------------------
    // อนุมัติคำขอ
    // --------------------------------------

    $update = $conn->prepare("
    UPDATE transactions
    SET
        status = 'approved',
        borrow_time = NOW()
    WHERE id = ?
    ");

    $update->execute([
        $transaction_id
    ]);

    // --------------------------------------
    // เปลี่ยนสถานะ Notebook
    // --------------------------------------

    $updateNotebook = $conn->prepare("
    UPDATE notebook
    SET status = 'borrowed'
    WHERE id = ?
    ");

    $updateNotebook->execute([
        $transaction['notebook_id']
    ]);

    $conn->commit();

    $_SESSION['success'] = "Borrow request approved successfully.";

} catch (PDOException $e) {

    $conn->rollBack();

    $_SESSION['error'] = $e->getMessage();
}

header("Location: ../requests.php");
exit;