<?php

require_once "../config/database.php";

require_once "../mail/Mail.php";


// ==========================================
// รับ User ID
// ==========================================

$user_id = $_POST['user_id'] ?? null;


if(!$user_id){

    echo json_encode([

        "status" => false,

        "message" => "User ID missing"

    ]);

    exit;

}



// ==========================================
// ดึงข้อมูล User
// ==========================================

$stmt = $conn->prepare(

    "SELECT email 
     FROM users 
     WHERE id = ?"

);


$stmt->execute([$user_id]);


$user = $stmt->fetch(PDO::FETCH_ASSOC);



if(!$user){


    echo json_encode([

        "status" => false,

        "message" => "User not found"

    ]);

    exit;

}



$email = $user['email'];



// ==========================================
// สร้าง OTP 6 หลัก
// ==========================================

$otp = random_int(100000,999999);



// ==========================================
// ลบ OTP เก่าที่ยังไม่ได้ใช้
// ==========================================

$delete = $conn->prepare(

    "DELETE FROM email_otp
     WHERE user_id = ?
     AND is_used = 0"

);


$delete->execute([$user_id]);




// ==========================================
// กำหนดเวลา OTP
// ==========================================

$created_at = date("Y-m-d H:i:s");


$expires_at = date(

    "Y-m-d H:i:s",

    strtotime("+5 minutes")

);




// ==========================================
// บันทึก OTP
// ==========================================

$insert = $conn->prepare(

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


$insert->execute([

    $user_id,

    $otp,

    $created_at,

    $expires_at

]);




// ==========================================
// ส่ง Email
// ==========================================

$mail = new MailSender();


$result = $mail->sendOTP(

    $email,

    $otp

);




if($result){


    echo json_encode([

        "status" => true,

        "message" => "OTP sent successfully"

    ]);



}else{


    echo json_encode([

        "status" => false,

        "message" => "Cannot send email"

    ]);



}
