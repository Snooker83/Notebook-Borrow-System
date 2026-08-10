<?php

require_once __DIR__ . "/../../config/config.php";

if (isset($_SESSION['admin_login'])) {

    header("Location: dashboard.php");
    exit;
}

header("Location: login.php");
exit;