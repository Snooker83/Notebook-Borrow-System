<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once __DIR__ . "/../../config/config.php";
require_once __DIR__ . "/../../config/database.php";

// ==========================================
// ตรวจสอบ Login
// ==========================================

if(
    !isset($_SESSION['login']) ||
    $_SESSION['login'] !== true
){

    header(
        "Location: ../login.php"
    );

    exit;

}

$user_id = $_SESSION['user_id'];

// ==========================================
// จำกัดการยืมไม่เกิน 2 เครื่อง
// ==========================================

$countStmt = $conn->prepare("
    SELECT COUNT(*) AS total
    FROM transactions
    WHERE user_id = ?
      AND status IN ('pending','approved')
");

$countStmt->execute([
    $_SESSION['user_id']
]);

$totalBorrow = $countStmt->fetch(PDO::FETCH_ASSOC)['total'];

if($totalBorrow >= 2){

    $_SESSION['error'] = "You can request a maximum of 2 notebooks.";

    header("Location: ../dashboard.php");

    exit;
}

// ==========================================
// รับ Notebook ID
// ==========================================


$notebook_id =
$_POST['notebook_id'] ?? null;

// echo "User ID = ";
// var_dump($user_id);

// echo "<br>Notebook ID = ";
// var_dump($notebook_id);


if(!$notebook_id){


    $_SESSION['error'] =
    "Invalid Notebook";


    header(
        "Location: ../dashboard.php"
    );

    exit;

}

// ==========================================
// ตรวจสอบ Notebook
// ==========================================


$stmt = $conn->prepare(

"
SELECT *

FROM notebook

WHERE id = ?

LIMIT 1

"

);

$stmt->execute([

    $notebook_id

]);

$notebook =
$stmt->fetch(PDO::FETCH_ASSOC);

if(!$notebook){


    $_SESSION['error'] =
    "Notebook not found";


    header(
        "Location: ../dashboard.php"
    );


    exit;

}

// if($notebook['status'] != "available"){


//     $_SESSION['error'] =
//     "Notebook already borrowed";


//     header(
//         "Location: ../public/dashboard.php"
//     );

//     exit;

// }

// ตรวจสอบว่ามีคำขอ pending อยู่แล้วหรือไม่
$busy = $conn->prepare("
SELECT id
FROM transactions
WHERE notebook_id = ?
AND status IN ('pending','approved')
LIMIT 1
");

$busy->execute([
    $notebook_id
]);

if($busy->fetch()){

    $_SESSION['error']="Notebook is unavailable.";

    header("Location: ../dashboard.php");

    exit;

}


// สร้างคำขอยืม

$insert = $conn->prepare("
INSERT INTO transactions
(
    user_id,
    notebook_id,
    status
)
VALUES
(
    ?,
    ?,
    'pending'
)
");

$insert->execute([
    $user_id,
    $notebook_id
]);

$_SESSION['success'] = "Borrow request sent successfully.";

header("Location: ../dashboard.php");
exit;