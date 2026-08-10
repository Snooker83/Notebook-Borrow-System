<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/**
 * ตรวจสอบการ Login ของ User
 */
function isLoggedIn(): bool
{
    return isset($_SESSION['user_id']);
}

/**
 * บังคับให้ Login ก่อนเข้าใช้งาน
 */
function requireLogin(): void
{
    if (!isLoggedIn()) {
        header("Location: login.php");
        exit;
    }
}

/**
 * Logout
 */
function logout(): void
{
    session_unset();
    session_destroy();
}
