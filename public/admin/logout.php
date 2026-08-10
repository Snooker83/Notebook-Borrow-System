<?php

require_once __DIR__ . "/../../config/config.php";

unset($_SESSION['admin_login']);
unset($_SESSION['admin_id']);
unset($_SESSION['admin_username']);

session_unset();
session_destroy();

header("Location: login.php");
exit;