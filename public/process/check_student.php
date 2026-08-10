<?php

require_once __DIR__ . "/../../config/database.php";

header('Content-Type: application/json');


$student_id = trim($_POST['student_id'] ?? "");


if(empty($student_id)){


    echo json_encode([

        "status" => false,

        "message" => "Student ID is empty"

    ]);


    exit;

}



$stmt = $conn->prepare(

    "SELECT id FROM users WHERE student_id = ?"

);


$stmt->execute([$student_id]);



if($stmt->rowCount() > 0){


    echo json_encode([

        "status" => false,

        "message" => "Student ID already exists"

    ]);


}else{


    echo json_encode([

        "status" => true,

        "message" => "Student ID available"

    ]);

}


exit;