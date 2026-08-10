<?php

require_once __DIR__ . "/../../config/database.php";


// ==========================================
// ตรวจสอบ Method
// ==========================================

if ($_SERVER["REQUEST_METHOD"] !== "POST") {

    header("Location: ../register.php");
    exit;

}


// ==========================================
// รับค่าจาก Form
// ==========================================

$first_name = trim($_POST['first_name'] ?? '');

$last_name = trim($_POST['last_name'] ?? '');

$student_id = trim($_POST['student_id'] ?? '');

$phone = trim($_POST['phone'] ?? '');

$email = trim($_POST['email'] ?? '');

$password = $_POST['password'] ?? '';

$confirm_password = $_POST['confirm_password'] ?? '';



// ==========================================
// Validate เบื้องต้น
// ==========================================

if (
    empty($first_name) ||
    empty($last_name) ||
    empty($student_id) ||
    empty($phone) ||
    empty($email) ||
    empty($password)
) {

    $_SESSION['error'] = "Please fill all required fields.";

    header("Location: ../register.php");

    exit;

}



// ==========================================
// ตรวจสอบ Student ID
// ==========================================

if (!preg_match('/^[0-9]{10}$/', $student_id)) {

    $_SESSION['error'] =
        "Student ID must contain 10 digits.";

    header("Location: ../register.php");

    exit;

}



// ==========================================
// ตรวจสอบ Password
// ==========================================

if ($password !== $confirm_password) {

    $_SESSION['error'] =
        "Password does not match.";

    header("Location: ../register.php");

    exit;

}



if (strlen($password) < 8) {


    $_SESSION['error'] =
        "Password must be at least 8 characters.";

    header("Location: ../register.php");

    exit;

}



// ==========================================
// สร้าง CMU Email
// ==========================================

if (!str_ends_with($email, '@cmu.ac.th')) {

    $email .= "@cmu.ac.th";

}



// ==========================================
// ตรวจสอบ Email ซ้ำ
// ==========================================

$checkEmail = $conn->prepare(
    "SELECT id FROM users WHERE email = ?"
);


$checkEmail->execute([$email]);


if ($checkEmail->rowCount() > 0) {


    $_SESSION['error'] =
        "Email already exists.";

    header("Location: ../register.php");

    exit;

}



// ==========================================
// ตรวจสอบ Student ID ซ้ำ
// ==========================================

$checkStudent = $conn->prepare(
    "SELECT id FROM users WHERE student_id = ?"
);


$checkStudent->execute([$student_id]);


if ($checkStudent->rowCount() > 0) {


    $_SESSION['error'] =
        "Student ID already exists.";

    header("Location: ../register.php");

    exit;

}



// ==========================================
// Hash Password
// ==========================================

$password_hash =
    password_hash(
        $password,
        PASSWORD_DEFAULT
    );



// ==========================================
// Insert User
// ==========================================

try {


    $sql = "
        INSERT INTO users
        (
            first_name,
            last_name,
            student_id,
            phone,
            email,
            password,
            is_verified,
            created_at
        )

        VALUES
        (
            ?,
            ?,
            ?,
            ?,
            ?,
            ?,
            0,
            NOW()
        )
    ";


    $stmt = $conn->prepare($sql);


    $stmt->execute([

        $first_name,

        $last_name,

        $student_id,

        $phone,

        $email,

        $password_hash

    ]);



$user_id = $conn->lastInsertId();

$_SESSION['verify_user_id'] = $user_id;


require_once __DIR__ . "/../../mail/Mail.php";


$otp = random_int(100000,999999);


$created_at = date("Y-m-d H:i:s");


$expires_at = date(
    "Y-m-d H:i:s",
    strtotime("+5 minutes")
);



$stmtOTP = $conn->prepare(

"
INSERT INTO email_otp
(
user_id,
otp,
is_used,
created_at,
expires_at
)

VALUES
(
?,
?,
0,
?,
?
)

"

);



$stmtOTP->execute([

    $user_id,

    $otp,

    $created_at,

    $expires_at

]);



$mail = new MailSender();


$result = $mail->sendOTP(

    $email,

    $otp

);


header(
    "Location: ../verify.php"
);

exit;



}

catch(PDOException $e){


    $_SESSION['error'] =
        "Register failed.";

    header(
        "Location: ../register.php"
    );

    exit;


}