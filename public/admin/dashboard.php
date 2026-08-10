<?php

require_once __DIR__ . "/../../config/config.php";
require_once __DIR__ . "/../../config/database.php";

if (
    !isset($_SESSION['admin_login']) ||
    $_SESSION['admin_login'] !== true
) {
    header("Location: login.php");
    exit;
}

// จำนวน User
$totalUsers = $conn->query("SELECT COUNT(*) FROM users")->fetchColumn();

// จำนวน Notebook
$totalNotebook = $conn->query("SELECT COUNT(*) FROM notebook")->fetchColumn();

// Notebook ที่พร้อมให้ยืม
$availableNotebook = $conn->query("
SELECT COUNT(*)
FROM notebook
WHERE status='available'
")->fetchColumn();

// Notebook ที่กำลังถูกยืม
$borrowedNotebook = $conn->query("
SELECT COUNT(*)
FROM notebook
WHERE status='borrowed'
")->fetchColumn();

// จำนวนคำขอที่รออนุมัติ
$pendingRequests = $conn->query("
SELECT COUNT(*)
FROM transactions
WHERE status='pending'
")->fetchColumn();

// จำนวน Pending
$totalPending = $conn->query("
SELECT COUNT(*)
FROM transactions
WHERE status='pending'
")->fetchColumn();

// จำนวน Borrowed
$totalBorrowed = $conn->query("
SELECT COUNT(*)
FROM transactions
WHERE status='approved'
")->fetchColumn();

// ==========================================
// Recent Borrow Requests
// ==========================================

$recent = $conn->prepare("
SELECT

transactions.id,
transactions.status,
transactions.borrow_time,

users.student_id,
users.first_name,
users.last_name,

notebook.name,
notebook.asset_num

FROM transactions

INNER JOIN users
ON users.id = transactions.user_id

INNER JOIN notebook
ON notebook.id = transactions.notebook_id

ORDER BY transactions.id DESC

LIMIT 5
");

$recent->execute();

$recentRequests = $recent->fetchAll(PDO::FETCH_ASSOC);

?>

<?php

$pageTitle = "Notebook Borrow System (Admin)";

include "includes/header.php";

include "includes/navbar.php"; ?>

<!-- <nav class="navbar navbar-dark bg-dark">
    <div class="container">

        <span class="navbar-brand">
            Notebook Borrow System (Admin)
        </span>

        <div class="text-white">

            <?= htmlspecialchars($_SESSION['admin_username']) ?>

            <a
            href="logout.php"
            class="btn btn-danger btn-sm ms-3">

            Logout

            </a>

        </div>

    </div>
</nav> -->

<div class="container py-5">

<h2 class="mb-4">

Admin Dashboard

</h2>

<div class="row mb-4">
  

    <div class="col-12 col-sm-6 col-xl-3 mb-4">

        <div class="card shadow border-0 bg-primary text-white">

            <div class="card-body">

                <div class="d-flex justify-content-between align-items-center">

                    <div>

                        <h6>Total Users</h6>

                        <h2><?= $totalUsers ?></h2>

                    </div>

                    <i class="bi bi-people-fill fs-1"></i>

                </div>

            </div>

        </div>

    </div>

    <div class="col-12 col-sm-6 col-xl-3 mb-4">

        <div class="card shadow border-0 bg-success text-white">

            <div class="card-body">

                <div class="d-flex justify-content-between align-items-center">

                    <div>

                        <h6>Total Notebook</h6>

                        <h2><?= $totalNotebook ?></h2>

                    </div>

                    <i class="bi bi-laptop fs-1"></i>

                </div>

            </div>

        </div>

    </div>


    <div class="col-12 col-sm-6 col-xl-3 mb-4">

        <div class="card shadow border-0 bg-warning text-dark">

            <div class="card-body">

                <div class="d-flex justify-content-between align-items-center">

                    <div>

                        <h6>Pending Requests</h6>

                        <h2><?= $totalPending ?></h2>

                    </div>

                    <i class="bi bi-hourglass-split fs-1"></i>

                </div>

            </div>

        </div>

    </div>


    <div class="col-12 col-sm-6 col-xl-3 mb-4">

        <div class="card shadow border-0 bg-danger text-white">

            <div class="card-body">

                <div class="d-flex justify-content-between align-items-center">

                    <div>

                        <h6>Borrowed</h6>

                        <h2><?= $totalBorrowed ?></h2>

                    </div>

                    <i class="bi bi-box-seam fs-1"></i>

                </div>

            </div>

        </div>

    </div>

</div>

<h3 class="mb-4">

Quick Actions

</h3>

<div class="row">

        <div class="col-12 col-xl-6 mb-4">

        <a href="requests.php"
           class="text-decoration-none">

            <div class="card shadow h-100 text-center">

                <div class="card-body">

                    <i class="bi bi-list-check display-4 text-danger"></i>

                    <h5 class="mt-3">

                        Borrow Requests

                    </h5>

                    <p class="text-muted">

                        อนุมัติหรือปฏิเสธคำขอยืม

                    </p>

                </div>

            </div>

        </a>

    </div>


    <div class="col-12 col-xl-6 mb-4">

        <a href="borrowed.php"
           class="text-decoration-none">

            <div class="card shadow h-100 text-center">

                <div class="card-body">

                    <i class="bi bi-box-seam display-4 text-info"></i>

                    <h5 class="mt-3">

                        Borrowed Notebook

                    </h5>

                    <p class="text-muted">

                        รายการ Notebook ที่กำลังถูกยืม

                    </p>

                </div>

            </div>

        </a>

    </div>

    <div class="col-12 col-md-6 col-xl-4 mb-4">

        <a href="notebook_add.php"
           class="text-decoration-none">

            <div class="card shadow h-100 text-center">

                <div class="card-body">

                    <i class="bi bi-plus-circle display-4 text-primary"></i>

                    <h5 class="mt-3">

                        Add Notebook

                    </h5>

                    <p class="text-muted">

                        เพิ่ม Notebook ใหม่เข้าสู่ระบบ

                    </p>

                </div>

            </div>

        </a>

    </div>


    <div class="col-12 col-md-6 col-xl-4 mb-4">

        <a href="notebooks.php"
           class="text-decoration-none">

            <div class="card shadow h-100 text-center">

                <div class="card-body">

                    <i class="bi bi-laptop display-4 text-success"></i>

                    <h5 class="mt-3">

                        Manage Notebook

                    </h5>

                    <p class="text-muted">

                        จัดการข้อมูล Notebook

                    </p>

                </div>

            </div>

        </a>

    </div>


    <div class="col-12 col-md-6 col-xl-4 mb-4">

        <a href="users.php"
           class="text-decoration-none">

            <div class="card shadow h-100 text-center">

                <div class="card-body">

                    <i class="bi bi-people-fill display-4 text-warning"></i>

                    <h5 class="mt-3">

                        Manage Users

                    </h5>

                    <p class="text-muted">

                        จัดการบัญชีผู้ใช้งาน

                    </p>

                </div>

            </div>

        </a>

    </div>

</div>

<div class="card shadow mt-4">

    <div class="card-header d-flex justify-content-between align-items-center">

        <h4 class="mb-0">

            Recent Borrow Requests

        </h4>

        <a
        href="history.php"
        class="btn btn-primary btn-sm">

            View All

        </a>

    </div>

    <div class="card-body">

        <div class="table-responsive">

            <table class="table table-hover align-middle">

                <thead>

                <tr>

                    <th>Student</th>

                    <th>Name</th>

                    <th>Notebook</th>

                    <th>Asset No.</th>

                    <th>Borrow Time</th>

                    <th>Status</th>

                </tr>

                </thead>

                <tbody>
                <?php if(empty($recentRequests)): ?>

<tr>

    <td colspan="6" class="text-center text-muted">

        No borrow requests found.

    </td>

</tr>

<?php endif; ?>

                <?php foreach($recentRequests as $r): ?>

                <tr>

                    <td>

                        <?= htmlspecialchars($r['student_id']) ?>

                    </td>

                    <td>

                        <?= htmlspecialchars($r['first_name']) ?>

                        <?= htmlspecialchars($r['last_name']) ?>

                    </td>

                    <td>

                        <?= htmlspecialchars($r['name']) ?>

                    </td>

                    <td>

                        <?= htmlspecialchars($r['asset_num']) ?>

                    </td>

                    <td>

                        <?= $r['borrow_time'] ?? "-" ?>

                    </td>

                    <td>

                        <?php

                        switch($r['status']){

                            case "pending":
                                echo '<span class="badge bg-warning text-dark">Pending</span>';
                                break;

                            case "approved":
                                echo '<span class="badge bg-success">Approved</span>';
                                break;

                            case "returned":
                                echo '<span class="badge bg-primary">Returned</span>';
                                break;

                            case "rejected":
                                echo '<span class="badge bg-danger">Rejected</span>';
                                break;

                            default:
                                echo htmlspecialchars($r['status']);

                        }

                        ?>

                    </td>

                </tr>

                <?php endforeach; ?>

                </tbody>

            </table>

        </div>

    </div>

</div>
<!--  
<div class="row g-4">

<div class="col-md-3">

<div class="card text-center shadow">

<div class="card-body">

<h5>Total Users</h5>

<h2><?= $totalUsers ?></h2>

</div>

</div>

</div>

<div class="col-md-3">

<div class="card text-center shadow">

<div class="card-body">

<h5>Total Notebook</h5>

<h2><?= $totalNotebook ?></h2>

</div>

</div>

</div>

<div class="col-md-3">

<div class="card text-center shadow">

<div class="card-body">

<h5>Available</h5>

<h2><?= $availableNotebook ?></h2>

</div>

</div>

</div>

<div class="col-md-3">

<div class="card text-center shadow">

<div class="card-body">

<h5>Borrowed</h5>

<h2><?= $borrowedNotebook ?></h2>

</div>

</div>

</div>

<div class="col-md-3">

<div class="card text-center shadow border-warning">

<div class="card-body">

<h5>Pending Requests</h5>

<h2><?= $pendingRequests ?></h2>

</div>

</div>

</div>

</div>

<hr class="my-5">

<div class="d-grid gap-3">

<a
href="requests.php"
class="btn btn-warning">

📥 Borrow Requests

</a>

<a
href="borrowed.php"
class="btn btn-info">

📦 Borrowed Notebook

</a>

<a
href="notebooks.php"
class="btn btn-primary">

💻 Manage Notebook

</a>

<a
href="users.php"
class="btn btn-dark">

👤 Manage Users

</a>

<a
href="transactions.php"
class="btn btn-dark">

📄 Transactions

</a>

</div>

</div>

</div>
-->

<?php include "includes/footer.php"; ?>