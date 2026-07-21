<?php

require_once "../config/database.php";


header('Content-Type: application/json');


$email = trim($_POST['email'] ?? "");


if(empty($email)){

    echo json_encode([
        "status" => false,
        "message" => "Email is empty"
    ]);

    exit;

}


// เติมโดเมน CMU อัตโนมัติ
if(!str_ends_with($email, "@cmu.ac.th")){

    $email .= "@cmu.ac.th";

}


$stmt = $conn->prepare(
    "SELECT id FROM users WHERE email = ?"
);


$stmt->execute([$email]);


if($stmt->rowCount() > 0){


    echo json_encode([

        "status" => false,

        "message" => "Email already exists"

    ]);


}else{


    echo json_encode([

        "status" => true,

        "message" => "Email available"

    ]);


}

exit;