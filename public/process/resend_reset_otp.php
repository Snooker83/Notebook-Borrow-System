<?php

require_once __DIR__ . "/../../config/config.php";
require_once __DIR__ . "/../../config/database.php";
require_once __DIR__ . "/../../mail/Mail.php";

// ==========================================
// Check Session
// ==========================================

if (!isset($_SESSION['reset_user_id'])) {

    header("Location: " . BASE_URL . "/forgot_password.php");
    exit;
}

$user_id = $_SESSION['reset_user_id'];

// ==========================================
// Get User
// ==========================================

$stmt = $conn->prepare("
    SELECT email
    FROM users
    WHERE id = ?
    LIMIT 1
");

$stmt->execute([$user_id]);

$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {

    $_SESSION['error'] = "User not found.";

    header("Location: " . BASE_URL . "/forgot_password.php");
    exit;
}

// ==========================================
// Generate OTP
// ==========================================

$otp = random_int(100000, 999999);

$expires_at = date(
    "Y-m-d H:i:s",
    strtotime("+" . OTP_EXPIRE_MINUTES . " minutes")
);

// ==========================================
// Save OTP
// ==========================================

$insert = $conn->prepare("
    INSERT INTO email_otp
    (
        user_id,
        otp,
        expires_at,
        is_used
    )
    VALUES
    (
        ?,
        ?,
        ?,
        0
    )
");

$insert->execute([
    $user_id,
    $otp,
    $expires_at
]);

// ==========================================
// Send Email
// ==========================================

sendOTP(
    $user['email'],
    $otp
);

// ==========================================
// Success
// ==========================================

$_SESSION['success'] = "A new OTP has been sent to your email.";

header("Location: " . BASE_URL . "/verify_reset.php");
exit;