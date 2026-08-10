<?php

$adminName = $_SESSION['admin_name'] ?? "Administrator";

?>

<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm rounded mb-4">

    <div class="container-fluid">
        <button
    class="btn btn-outline-secondary d-lg-none me-3"
    type="button"
    data-bs-toggle="offcanvas"
    data-bs-target="#mobileSidebar">

    <i class="bi bi-list"></i>

</button>

        <h4 class="mb-0">

            <?= htmlspecialchars($pageTitle ?? "Dashboard") ?>

        </h4>

        <div class="d-flex align-items-center">

            <span class="me-4 text-secondary">

                <i class="bi bi-clock"></i>

                <span id="live-clock"></span>

            </span>

            <span class="me-3">

                <i class="bi bi-person-circle"></i>

                <?= htmlspecialchars($adminName) ?>

            </span>

            <a
                href="logout.php"
                class="btn btn-outline-danger btn-sm">

                <i class="bi bi-box-arrow-right"></i>

                Logout

            </a>

        </div>

    </div>

</nav>