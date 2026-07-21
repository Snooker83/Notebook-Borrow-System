<?php

require_once "../config/config.php";
require_once "../config/database.php";


// ==========================================
// ตรวจสอบ Session
// ==========================================

if(!isset($_SESSION['reset_user_id'])){


    header(
        "Location: ../public/login.php"
    );

    exit;

}



$user_id = $_SESSION['reset_user_id'];

// ==========================================
// รับ OTP
// ==========================================


$otp = trim($_POST['otp'] ?? "");



if(empty($otp)){


    $_SESSION['error'] =
    "Please enter OTP";


    header(
        "Location: ../public/verify.php"
    );

    exit;

}




// ==========================================
// ค้นหา OTP
// ==========================================

$stmt = $conn->prepare(

"
SELECT *

FROM email_otp

WHERE user_id = ?

AND otp = ?

AND is_used = 0

ORDER BY id DESC

LIMIT 1

"

);



$stmt->execute([

    $user_id,

    $otp

]);



$data = $stmt->fetch(PDO::FETCH_ASSOC);





if(!$data){


    $_SESSION['error'] =
    "Invalid OTP";


    header(
        "Location: ../public/verify_reset.php"
    );

    exit;

}






// ==========================================
// ตรวจสอบ OTP หมดอายุ
// ==========================================


$current_time = date(
    "Y-m-d H:i:s"
);



if($current_time > $data['expires_at']){


    $_SESSION['error'] =
    "OTP expired. Please request new OTP";


    header(
        "Location: ../public/verify.php"
    );

    exit;

}


try {

    $conn->beginTransaction();

    // Update OTP

    $updateOTP = $conn->prepare(

        "
        UPDATE email_otp

        SET is_used = 1

        WHERE id = ?

        "

    );


    $updateOTP->execute([

        $data['id']

    ]);

    $conn->commit();

    unset($_SESSION['reset_user_id']);
    
    $_SESSION['reset_password_user_id'] = $user_id;

    header(

        "Location: ../public/reset_password.php"

    );


    exit;



}
catch(PDOException $e){

    $conn->rollBack();

    $_SESSION['error'] =
    "Verification failed.";

    header(
        "Location: ../public/verify_reset.php"
    );

    exit;

}

?>