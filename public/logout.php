<?php

session_start();

// ลบ Session ของ User
unset($_SESSION['user_login']);
unset($_SESSION['user_id']);
unset($_SESSION['user_email']);
unset($_SESSION['user_name']);

// ล้าง Session ทั้งหมด
session_unset();
session_destroy();

// กลับไปหน้า Login
header("Location: login.php");
exit;

?>