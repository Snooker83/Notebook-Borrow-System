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

ORDER BY notebook.id DESC

");

$recent->execute();

$recentRequests = $recent->fetchAll(PDO::FETCH_ASSOC);

?>

<?php

$pageTitle = "Notebook Borrow System (Admin)";

include "includes/header.php";

include "includes/navbar.php"; ?>

<div class="card shadow mt-4">

    <div class="card-header d-flex justify-content-between align-items-center">

        <h4 class="mb-0">

            History Borrow

        </h4>

    </div>

    <div class="card-body">

        <div class="table-responsive">

            <table class="table table-hover align-middle datatable">

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

<?php include "includes/footer.php"; ?>