<?php

require_once "../config/database.php";

if(
    !isset($_SESSION['login'])
){
    header("Location: ../public/login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

$notebook_id = intval($_GET['notebook_id'] ?? 0);

if($notebook_id <= 0){

    $_SESSION['error']="Invalid request.";

    header("Location: ../public/dashboard.php");

    exit;
}

try{

    $conn->beginTransaction();

    // ค้นหา Pending ของ User
    $stmt = $conn->prepare("
        SELECT id
        FROM transactions
        WHERE user_id = ?
        AND notebook_id = ?
        AND status='pending'
        LIMIT 1
    ");

    $stmt->execute([
        $user_id,
        $notebook_id
    ]);

    $transaction = $stmt->fetch(PDO::FETCH_ASSOC);

    if(!$transaction){

        throw new Exception("Request not found.");

    }

    // ลบ Request
    $delete = $conn->prepare("
        DELETE FROM transactions
        WHERE id=?
    ");

    $delete->execute([
        $transaction['id']
    ]);

    // คืนสถานะ Notebook
    $update = $conn->prepare("
        UPDATE notebook
        SET status='available'
        WHERE id=?
    ");

    $update->execute([
        $notebook_id
    ]);

    $conn->commit();

    $_SESSION['success'] =
        "Borrow request cancelled successfully.";

}
catch(Exception $e){

    $conn->rollBack();

    $_SESSION['error'] =
        $e->getMessage();

}

header("Location: ../public/dashboard.php");
exit;