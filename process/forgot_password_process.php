<?php

require_once "../config/config.php";
require_once "../config/database.php";
require_once "../mail/Mail.php";

// Check Email

$email = trim($_POST['email'] ?? "");

if(empty($email)){

    $_SESSION['error'] =
    "Please enter your CMU Email.";

    header("Location: ../public/forgot_password.php");

    exit;

}

// Check User

$stmt = $conn->prepare("

SELECT *

FROM users

WHERE email = ?

LIMIT 1

");

$stmt->execute([$email]);

$user = $stmt->fetch(PDO::FETCH_ASSOC);

// Email Null

if(!$user){

    $_SESSION['error'] =
    "Email not found.";

    header("Location: ../public/forgot_password.php");

    exit;

}

// Check Verify

if($user['is_verified'] != 1){

    $_SESSION['error'] =
    "This account has not been verified.";

    header("Location: ../public/forgot_password.php");

    exit;

}


$disable = $conn->prepare("

UPDATE email_otp

SET is_used = 1

WHERE user_id = ?

AND is_used = 0

");

$disable->execute([

    $user['id']

]);

$otp = random_int(

    100000,

    999999

);

$expires_at = date(

    "Y-m-d H:i:s",

    strtotime("+5 minutes")

);

$insert = $conn->prepare("

INSERT INTO email_otp

(

user_id,

otp,

expires_at

)

VALUES

(

?,

?,

?

)

");

$insert->execute([

    $user['id'],

    $otp,

    $expires_at

]);

$mail = new MailSender();

$success = $mail->sendOTP(

    $user['email'],

    $otp

);

if($success){

    $_SESSION['reset_user_id'] =
    $user['id'];

    $_SESSION['success'] =
    "OTP has been sent to your email.";

    header(

        "Location: ../public/verify_reset.php"

    );

    exit;

}

$_SESSION['error'] =
"Unable to send OTP.";

header(

    "Location: ../public/forgot_password.php"

);

exit;

?>