<?php
header('Content-Type: application/json');
require_once "../config/config.php";
require_once "../config/database.php";
require_once "../mail/Mail.php";

// ==========================================
// ตรวจสอบ Session
// ==========================================

if (!isset($_SESSION['verify_user_id'])) {

    echo json_encode([
        "success" => false,
        "message" => "Session expired."
    ]);

    exit;
}

$user_id = $_SESSION['verify_user_id'];

// ==========================================
// ดึงข้อมูล User
// ==========================================

$stmt = $conn->prepare("
    SELECT
        first_name,
        email
    FROM users
    WHERE id = ?
    LIMIT 1
");

$stmt->execute([$user_id]);

$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {

    echo json_encode([
        "success" => false,
        "message" => "User not found."
    ]);

    exit;
}

// ==========================================
// ยกเลิก OTP เก่าที่ยังไม่ใช้
// ==========================================

$disable = $conn->prepare("
    UPDATE email_otp
    SET is_used = 1
    WHERE user_id = ?
      AND is_used = 0
");

$disable->execute([$user_id]);

// ==========================================
// สร้าง OTP ใหม่
// ==========================================

$otp = random_int(100000, 999999);

$expires_at = date(
    "Y-m-d H:i:s",
    strtotime("+5 minutes")
);

// ==========================================
// บันทึก OTP ใหม่
// ==========================================

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
    $user_id,
    $otp,
    $expires_at
]);

// ==========================================
// ส่ง Email
// ==========================================
$mail = new MailSender();

$mailSent = $mail->sendOTP(
    $user['email'],
    $otp
);

// ==========================================
// ส่งผลลัพธ์
// ==========================================

if ($mailSent) {

    echo json_encode([
        "success" => true,
        "message" => "OTP has been sent again.",
        "expires_in" => 300
    ]);

} else {

    echo json_encode([
        "success" => false,
        "message" => "Unable to send OTP."
    ]);

}