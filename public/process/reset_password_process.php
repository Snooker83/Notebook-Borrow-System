<?php

require_once __DIR__ . "/../../config/config.php";
require_once __DIR__ . "/../../config/database.php";

if(!isset($_SESSION['reset_password_user_id'])){

    header("Location: ../login.php");

    exit;

}

$user_id = $_SESSION['reset_password_user_id'];

$password = $_POST['password'] ?? "";
$confirm  = $_POST['confirm_password'] ?? "";

if(empty($password) || empty($confirm)){

    $_SESSION['error'] =
    "Please fill in all required fields.";

    header("Location: ../reset_password.php");

    exit;

}

if(strlen($password) < 8){

    $_SESSION['error'] =
    "Password must be at least 8 characters.";

    header("Location: ../reset_password.php");

    exit;

}

if($password !== $confirm){

    $_SESSION['error'] =
    "Passwords do not match.";

    header("Location: ../reset_password.php");

    exit;

}

$newPassword = password_hash(

    $password,

    PASSWORD_DEFAULT

);

$stmt = $conn->prepare("

UPDATE users

SET password = ?

WHERE id = ?

LIMIT 1

");

$stmt->execute([

    $newPassword,

    $user_id

]);

unset($_SESSION['reset_password_user_id']);

$_SESSION['success'] =
"Password reset successfully. Please login.";

header(

    "Location: ../login.php"

);

exit;

?>