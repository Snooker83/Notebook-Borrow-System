<?php

require_once __DIR__ . "/../config/config.php";
require_once __DIR__ . "/../config/database.php";

// ==========================================
// Session Protection
// ==========================================

if (
    !isset($_SESSION['login']) ||
    $_SESSION['login'] !== true
) {

    header("Location: login.php");
    exit;

}

// ==========================================
// User
// ==========================================

$user_id    = $_SESSION['user_id'];
$user_name  = $_SESSION['user_name'];
$user_email = $_SESSION['user_email'];

// ==========================================
// Notebook List
// current_status
// ==========================================

$stmt = $conn->prepare("

SELECT

    n.*,

    CASE

        WHEN EXISTS(

            SELECT 1

            FROM transactions t

            WHERE t.notebook_id = n.id

            AND t.status = 'approved'

        )

        THEN 'borrowed'

        WHEN EXISTS(

            SELECT 1

            FROM transactions t

            WHERE t.notebook_id = n.id

            AND t.status = 'pending'

        )

        THEN 'pending'

        ELSE 'available'

    END AS current_status

FROM notebook n

ORDER BY n.id ASC

");

$stmt->execute();

$notebooks = $stmt->fetchAll(PDO::FETCH_ASSOC);

// ==========================================
// My Borrow History
// ==========================================

$history = $conn->prepare("

SELECT

    t.*,

    n.name,

    n.asset_num

FROM transactions t

INNER JOIN notebook n

ON n.id = t.notebook_id

WHERE t.user_id = ?

ORDER BY t.id DESC

");

$history->execute([
    $user_id
]);

$transactions = $history->fetchAll(PDO::FETCH_ASSOC);

// ==========================================
// My Pending / Approved
// ==========================================

$requestStatus = [];

$request = $conn->prepare("

SELECT

    notebook_id,

    status

FROM transactions

WHERE user_id = ?

AND status IN ('pending','approved')

ORDER BY id DESC

");

$request->execute([
    $user_id
]);

while($row = $request->fetch(PDO::FETCH_ASSOC)){

    $requestStatus[$row['notebook_id']] = $row['status'];

}

// ==========================================
// Statistics
// ==========================================

$totalNotebook = count($notebooks);

$availableNotebook = 0;
$borrowedNotebook  = 0;

foreach($notebooks as $nb){

    if($nb['current_status'] == "available"){

        $availableNotebook++;

    }
    else{

        $borrowedNotebook++;

    }

}

$userBorrowCount = count($requestStatus);

// ==========================================
// User Current Borrow
// ==========================================

$myBorrow = $conn->prepare("

SELECT COUNT(*) total

FROM transactions

WHERE user_id = ?

AND status IN ('pending','approved')

");

$myBorrow->execute([
    $user_id
]);

$myBorrowCount = $myBorrow
    ->fetch(PDO::FETCH_ASSOC)['total'];

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>
        Dashboard | Notebook Borrow System
    </title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet">

    <link rel="stylesheet"
          href="assets/css/theme.css">

    <link rel="stylesheet"
          href="assets/css/dashboard.css">

    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

</head>

<body>

<!-- ==========================================
Navbar
========================================== -->

<nav class="navbar navbar-expand-lg">

    <div class="container">

        <a
            class="navbar-brand fw-bold"
            href="dashboard.php">

            <i class="bi bi-laptop me-2"></i>

            Notebook Borrow System

        </a>

        <div class="d-flex align-items-center">

            <span class="text-white me-3">

                <i class="bi bi-person-circle me-2"></i>

                <?= htmlspecialchars($user_name) ?>

            </span>

            <a

                href="logout.php"

                class="btn btn-light"

                data-title="Logout?"

                data-text="Do you really want to logout?"

                data-confirm="Logout"

                data-icon="question">

                <i class="bi bi-box-arrow-right"></i>

            </a>

        </div>

    </div>

</nav>

<!-- ==========================================
Dashboard
========================================== -->

<div class="container-fluid py-4">

<div class="row">

<!-- ==========================================
Left Sidebar
========================================== -->

<div class="col-lg-3 mb-4">

<div class="dashboard-sidebar">

<!-- User -->

<div class="dashboard-card mb-4">

    <div class="text-center">

        <i class="bi bi-person-circle"

           style="font-size:70px;color:#6C5CE7"></i>

        <h5 class="mt-3">

            <?= htmlspecialchars($user_name) ?>

        </h5>

        <small class="text-muted">

            <?= htmlspecialchars($user_email) ?>

        </small>

    </div>

</div>

<!-- Statistics -->

<div class="dashboard-card mb-4">

    <h5 class="mb-3">

        <i class="bi bi-bar-chart-fill me-2"></i>

        Statistics

    </h5>

    <div class="stat-item">

        <span>Total Notebook</span>

        <strong>

            <?= $totalNotebook ?>

        </strong>

    </div>

    <div class="stat-item">

        <span>Available</span>

        <strong class="text-success">

            <?= $availableNotebook ?>

        </strong>

    </div>

    <div class="stat-item">

        <span>Unavailable</span>

        <strong class="text-danger">

            <?= $borrowedNotebook ?>

        </strong>

    </div>

    <div class="stat-item">

        <span>My Requests</span>

        <strong class="text-primary">

            <?= $myBorrowCount ?>

            / 2

        </strong>

    </div>

</div>

<!-- Quick Menu -->

<div class="dashboard-card">

    <h5 class="mb-3">

        <i class="bi bi-lightning-charge-fill me-2"></i>

        Quick Actions

    </h5>

    <div class="d-grid gap-2">

        <a
            href="#borrow"
            class="btn btn-primary">

            <i class="bi bi-laptop me-2"></i>

            Borrow Notebook

        </a>

        <a
            href="#history"
            class="btn btn-outline-primary">

            <i class="bi bi-clock-history me-2"></i>

            Borrow History

        </a>
        <br>
        <a
        href="logout.php"
        class="btn btn-outline-danger"

        data-title="Logout?"

        data-text="Do you want to logout now?"

        data-confirm="Logout"

        data-icon="question">

        <i class="bi bi-box-arrow-right me-2"></i>

        Logout

    </a>

    </div>

</div>

</div>

</div>

<!-- ==========================================
Right Content
========================================== -->

<div class="col-lg-9">

<div class="dashboard-card">

<h2 id="borrow">

    Borrow Notebook

</h2>

<p class="text-muted">

    Select a notebook to borrow.

</p>

<div class="notebook-grid">

<?php 

$badgeim = 01;

foreach($notebooks as $nb): 

?>

<?php

$status = $requestStatus[$nb['id']] ?? null;

$disabled =
    $nb['current_status'] != "available"
    || $userBorrowCount >= 2;

$overlayText = "";

switch($nb['current_status']){

    case "pending":

        $overlayText = "Pending Approval";

        break;

    case "borrowed":

        $overlayText = "Borrowed";

        break;

    default:

        if($userBorrowCount >= 2){

            $overlayText = "Borrow Limit";

        }

}

?>

<div

class="card notebook-card"

id="card-<?= $nb['id'] ?>">

    <!-- Image -->

    <div

    class="notebook-image
    <?= $disabled ? 'disabled' : '' ?>"

    id="image-<?= $nb['id'] ?>">

        <?php if(!empty($nb['image'])): ?>
        
       <div class="badge-number"><?php echo $badgeim; $badgeim++; ?></div>

        <img

        src="uploads/notebook/<?= htmlspecialchars($nb['image']) ?>"

        alt="<?= htmlspecialchars($nb['name']) ?>"

        id="image-img-<?= $nb['id'] ?>"  > 

        

        <?php else: ?>

        <img

        src="https://via.placeholder.com/300x180?text=Notebook"

        id="image-img-<?= $nb['id'] ?>">


        <?php endif; ?>

        <!-- Status Badge -->

        <?php

        switch($nb['current_status']){

            case "available":

                echo '<span class="status-badge available">
                        Available
                      </span>';

                break;

            case "pending":

                echo '<span class="status-badge pending">
                        Pending
                      </span>';

                break;

            case "borrowed":

                echo '<span class="status-badge borrowed">
                        Borrowed
                      </span>';

                break;

        }

        ?>

        <!-- Overlay -->

        <div class="notebook-overlay">

            <i class="bi bi-slash-circle-fill"></i>

            <span>

                <?= $overlayText ?>

            </span>

        </div>

    </div>

    <!-- Body -->

    <div class="card-body">

        <h5>

            <?= htmlspecialchars($nb['name']) ?>

        </h5>

        <p class="mb-1">

            <strong>

                Asset

            </strong>

            <?= htmlspecialchars($nb['asset_num']) ?>

        </p>

        <!-- <?php if(!empty($nb['spec'])): ?>

        <small class="text-muted d-block mb-3">

            <?= htmlspecialchars($nb['spec']) ?>

        </small>

        <?php endif; ?> -->

        <!-- Action -->

        <div id="action-<?= $nb['id'] ?>">

        <?php

        if($status == "pending"){

        ?>

            <div class="d-grid gap-2">

                <button

                class="btn btn-warning"

                disabled>

                    Pending Approval

                </button>

                <a

                href="process/cancel_request.php?notebook_id=<?= $nb['id'] ?>"

                class="btn btn-outline-danger"

                data-title="Cancel Request?"

                data-text="Do you want to cancel this request?"

                data-confirm="Yes"

                data-icon="warning">

                    <i class="bi bi-x-circle"></i>

                    Cancel Request

                </a>

            </div>

        <?php

        }

        elseif($status == "approved"){

        ?>

            <button

            class="btn btn-success w-100"

            disabled>

                Borrowed

            </button>

        <?php

        }

        elseif($nb['current_status'] == "pending"){

        ?>

            <button

            class="btn btn-warning w-100"

            disabled>

                Pending Approval

            </button>

        <?php

        }

        elseif($nb['current_status'] == "borrowed"){

        ?>

            <button

            class="btn btn-danger w-100"

            disabled>

                Borrowed

            </button>

        <?php

        }

        elseif($userBorrowCount >= 2){

        ?>

            <button

            class="btn btn-secondary w-100"

            disabled>

                Maximum 2 Notebooks

            </button>

        <?php

        }

        else{

        ?>

            <form

            action="process/request_borrow.php"

            method="POST">

                <input

                type="hidden"

                name="notebook_id"

                value="<?= $nb['id'] ?>">

                <button

                class="btn btn-primary w-100">

                    Request Borrow

                </button>

            </form>

        <?php

        }

        ?>

        </div>

    </div>

</div>

<?php endforeach; ?>

</div>

</div>
<!-- End Dashboard Card -->


<!-- ==========================================
My Borrow Requests
========================================== -->

<div class="dashboard-card mt-4">

    <h2 id="history">

        My Borrow Requests

    </h2>

    <div class="table-responsive">

        <table class="table table-hover align-middle">

            <thead>

                <tr>

                    <th>Notebook</th>

                    <th>Asset Number</th>

                    <th>Borrow Time</th>

                    <th>Return Time</th>

                    <th>Status</th>

                </tr>

            </thead>

            <tbody id="historyTable">

                <?php foreach($transactions as $t): ?>

                <tr>

                    <td>

                        <?= htmlspecialchars($t['name']) ?>

                    </td>

                    <td>

                        <?= htmlspecialchars($t['asset_num']) ?>

                    </td>

                    <td>

                        <?= $t['borrow_time'] ?? "-" ?>

                    </td>

                    <td>

                        <?= $t['return_time'] ?? "-" ?>

                    </td>

                    <td>

                        <?php

                        switch($t['status']){

                            case "pending":

                                echo '<span class="badge bg-warning text-dark">
                                        Pending
                                      </span>';

                                break;

                            case "approved":

                                echo '<span class="badge bg-success">
                                        Borrowed
                                      </span>';

                                break;

                            case "returned":

                                echo '<span class="badge bg-primary">
                                        Returned
                                      </span>';

                                break;

                            case "rejected":

                                echo '<span class="badge bg-danger">
                                        Rejected
                                      </span>';

                                break;

                            default:

                                echo htmlspecialchars($t['status']);

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
<!-- End Right -->

</div>
<!-- End Row -->

</div>
<!-- End Container -->

<script>

const flashSuccess =
<?= json_encode($_SESSION['success'] ?? null); ?>;

const flashError =
<?= json_encode($_SESSION['error'] ?? null); ?>;

</script>

<?php

unset($_SESSION['success']);
unset($_SESSION['error']);

?>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script src="assets/js/alert.js"></script>

<script src="assets/js/loading.js"></script>

<script src="assets/js/confirm.js"></script>

<script src="assets/js/dashboard.js"></script>

</body>

</html>

