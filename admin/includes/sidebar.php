<?php

$currentPage = basename($_SERVER['PHP_SELF']);

?>

<div class="sidebar d-none d-lg-block">

    <div class="sidebar-header">

        <h4 class="text-center mb-0">
            Notebook Borrow
        </h4>

        <small class="text-center d-block">
            Admin Panel
        </small>

    </div>

    <ul class="nav flex-column mt-4">

        <li class="nav-item">

            <a
                href="dashboard.php"
                class="nav-link <?= $currentPage == 'dashboard.php' ? 'active' : '' ?>">

                🏠 Dashboard

                <small class="d-block">
                    หน้าต่างสรุปผล
                </small>

            </a>

        </li>

        <li class="nav-item">

            <a
                href="requests.php"
                class="nav-link <?= $currentPage == 'requests.php' ? 'active' : '' ?>">

                📋 Borrow Requests
                <small class="d-block">
                    อนุมัติหรือปฏิเสธคำขอยืม
                </small>


            </a>

        </li>


        <li class="nav-item">

            <a
                href="borrowed.php"
                class="nav-link <?= $currentPage == 'borrowed.php' ? 'active' : '' ?>">

                📦 Borrowed Notebook 
                 <small class="d-block">
                รายการ Notebook ที่กำลังถูกยืม
                 </small>


            </a>

        </li>

        <li class="nav-item">

            <a
                href="history.php"
                class="nav-link <?= $currentPage == 'history.php' ? 'active' : '' ?>">

                📋 History Borrow List
                <small class="d-block">
                    ประวัติรายการคำขอ
                </small>


            </a>

        </li>

        <li class="nav-item">

            <a
                href="notebooks.php"
                class="nav-link <?= in_array($currentPage, ['notebooks.php', 'notebook_add.php', 'notebook_edit.php']) ? 'active' : '' ?>">

                💻 Manage Notebook
                <small class="d-block">
                จัดการข้อมูล Notebook
                 </small>


            </a>

        </li>

        <li class="nav-item">

            <a
                href="users.php"
                class="nav-link <?= in_array($currentPage, ['users.php', 'user_detail.php']) ? 'active' : '' ?>">

                👤 Manage Users

                <small class="d-block">
                จัดการข้อมูลผู้ใช้งาน
                 </small>


            </a>

        </li>


        <hr>

        <li class="nav-item">

            <a
                href="logout.php"
                class="nav-link text-danger">

                🚪 Logout

            </a>

        </li>

    </ul>

</div>

<div
class="offcanvas offcanvas-start"
tabindex="-1"
id="mobileSidebar">

    <div class="offcanvas-header">

        <h5>

            Notebook Borrow

        </h5>

        <button
            type="button"
            class="btn-close"
            data-bs-dismiss="offcanvas">
        </button>

    </div>

    <div class="offcanvas-body">

        <ul class="nav flex-column">

            <li class="nav-item">
                <a href="dashboard.php" class="nav-link">
                    🏠 Dashboard
                </a>
            </li>

            <li class="nav-item">
                <a href="notebooks.php" class="nav-link">
                    💻 Manage Notebook
                </a>
            </li>

            <li class="nav-item">
                <a href="users.php" class="nav-link">
                    👤 Manage Users
                </a>
            </li>

            <li class="nav-item">
                <a href="requests.php" class="nav-link">
                    📋 Borrow Requests
                </a>
            </li>

            <li class="nav-item">
                <a href="borrowed.php" class="nav-link">
                    📦 Borrowed Notebook
                </a>
            </li>

            <hr>

            <li class="nav-item">
                <a
                href="../logout.php"
                class="nav-link text-danger">

                    🚪 Logout

                </a>
            </li>

        </ul>

    </div>

</div>