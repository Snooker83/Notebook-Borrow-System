<?php

header("Content-Type: application/json");

require_once "../config/config.php";
require_once "../config/database.php";

// ==========================================
// Login
// ==========================================

if (
    !isset($_SESSION['login']) ||
    $_SESSION['login'] !== true
){

    echo json_encode([
        "success"=>false
    ]);

    exit;

}

$user_id = $_SESSION['user_id'];

// ==========================================
// จำนวน Request ของ User
// ==========================================

$stmt = $conn->prepare("
SELECT COUNT(*) total
FROM transactions
WHERE user_id=?
AND status IN ('pending','approved')
");

$stmt->execute([$user_id]);

$myRequest =
$stmt->fetch(PDO::FETCH_ASSOC)['total'];

// ==========================================
// Notebook
// ==========================================

$stmt = $conn->prepare("

SELECT

n.*

FROM notebook n

ORDER BY n.id

");

$stmt->execute();

$list = [];

while($nb=$stmt->fetch(PDO::FETCH_ASSOC)){

    // -----------------------------
    // current status
    // -----------------------------

    $statusStmt=$conn->prepare("

    SELECT

    user_id,

    status

    FROM transactions

    WHERE notebook_id=?

    AND status IN('pending','approved')

    ORDER BY id DESC

    LIMIT 1

    ");

    $statusStmt->execute([
        $nb['id']
    ]);

    $tx=$statusStmt->fetch(PDO::FETCH_ASSOC);

    if(!$tx){

        $current="available";

    }

    else{

        if($tx['status']=="approved"){

            $current="borrowed";

        }

        else{

            $current="pending";

        }

    }

    // -----------------------------
    // action
    // -----------------------------

    if($current=="available"){

        if($myRequest>=2){

            $action="limit";

        }

        else{

            $action="request";

        }

    }

    elseif($current=="borrowed"){

        $action="borrowed";

    }

    else{

        if($tx['user_id']==$user_id){

            $action="pending_me";

        }

        else{

            $action="pending_other";

        }

    }

    $nb['current_status']=$current;

    $nb['action']=$action;

    $list[]=$nb;

}

// ==========================================
// Statistics
// ==========================================

$total=count($list);

$available=0;

$borrowed=0;

foreach($list as $nb){

    if($nb['current_status']=="available"){

        $available++;

    }

    else{

        $borrowed++;

    }

}

// ==========================================

echo json_encode([

    "success"=>true,

    "statistics"=>[

        "total"=>$total,

        "available"=>$available,

        "borrowed"=>$borrowed,

        "my_request"=>$myRequest

    ],

    "notebooks"=>$list

]);