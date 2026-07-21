<?php

require_once "../config/database.php";



// ==========================================
// รับข้อมูล
// ==========================================

$email = trim($_POST['email'] ?? "");

if (!str_contains($email, "@cmu.ac.th")) {

    $email .= "@cmu.ac.th";

}

$password = $_POST['password'] ?? "";




// ==========================================
// ตรวจสอบข้อมูล
// ==========================================

// echo "<pre>";
// print_r($_POST);
// exit;

if (empty($email) || empty($password)) {


    $_SESSION['error'] =
        "Please fill in all required fields.";


    header(
        "Location: ../public/login.php"
    );

    exit;
}




// ==========================================
// เติม CMU Domain
// ==========================================


if (!str_contains($email, "@cmu.ac.th")) {


    $email .= "@cmu.ac.th";
}




// ==========================================
// ค้นหา User
// ==========================================


$stmt = $conn->prepare(

    "
SELECT *

FROM users

WHERE email = ?

LIMIT 1

"

);


$stmt->execute([

    $email

]);



$user = $stmt->fetch(PDO::FETCH_ASSOC);




// ==========================================
// ตรวจสอบ Email
// ==========================================


if (!$user) {


    $_SESSION['error'] =
        "Invalid email or password.";


    header(
        "Location: ../public/login.php"
    );


    exit;
}





// ==========================================
// ตรวจสอบ Password
// ==========================================


if (
    !password_verify(
        $password,
        $user['password']
    )
) {


    $_SESSION['error'] =
        "Email or Password incorrect";


    header(
        "Location: ../public/login.php"
    );


    exit;
}





// ==========================================
// ตรวจสอบ Verification
// ==========================================


if (
    $user['is_verified'] != 1
) {


    $_SESSION['error'] =
        "Please verify your email before logging in.";


    $_SESSION['verify_user_id'] =
        $user['id'];



    header(
        "Location: ../public/verify.php"
    );


    exit;
}

if (
    isset($user['status']) &&
    $user['status'] === 'disabled'
) {

    $_SESSION['error'] = "Your account has been disabled. Please contact the administrator..";

    header("Location: ../public/login.php");
    exit;
}



// ==========================================
// Create Session
// ==========================================

$_SESSION['user_id'] =
    $user['id'];


$_SESSION['user_email'] =
    $user['email'];


$_SESSION['user_name'] =
    $user['first_name'] . " " . $user['last_name'];



$_SESSION['login'] =
    true;



// ==========================================
// Dashboard
// ==========================================

$_SESSION['success'] = "Welcome back, " . $user['first_name'] . "!";

header(

    "Location: ../public/dashboard.php"

);
exit;
