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
// รับ ID
// ==========================================

$id = $_GET['id'] ?? null;

if (!$id) {

    $_SESSION['error'] = "Invalid Notebook ID.";

    header("Location: ../notebooks.php");
    exit;
}

// ==========================================
// ค้นหา Notebook
// ==========================================

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

    header("Location: ../notebooks.php");
    exit;
}

// ==========================================
// ห้ามลบถ้ากำลังถูกยืม
// ==========================================

if ($notebook['status'] === 'borrowed') {

    $_SESSION['error'] = "Cannot delete a notebook that is currently borrowed.";

    header("Location: ../notebooks.php");
    exit;
}

// ==========================================
// เริ่ม Transaction
// ==========================================

try {

    $conn->beginTransaction();

    // ลบข้อมูล
    $delete = $conn->prepare("
    DELETE FROM notebook
    WHERE id = ?
    ");

    $delete->execute([$id]);

    // ลบรูป (หลังจากลบข้อมูลสำเร็จ)
    if (
        !empty($notebook['image']) &&
        file_exists("../../uploads/notebook/" . $notebook['image'])
    ) {
        unlink("../../uploads/notebook/" . $notebook['image']);
    }

    $conn->commit();

    $_SESSION['success'] = "Notebook deleted successfully.";

} catch (PDOException $e) {

    $conn->rollBack();

    $_SESSION['error'] = $e->getMessage();
}

header("Location: ../notebooks.php");
exit;