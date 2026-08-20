<?php

require_once __DIR__ . "/../../config/database.php";

$username = "adminwk";

$password = $_ENV['ADMIN_INITIAL_PASSWORD'] ?? '';

if ($password === '') {
    die("ADMIN_INITIAL_PASSWORD is not configured");
}

$password = password_hash($password, PASSWORD_DEFAULT);

$stmt = $conn->prepare("
    INSERT INTO admin
    (
        username,
        password
    )
    VALUES
    (
        ?,
        ?
    )
");

$stmt->execute([
    $username,
    $password
]);

echo "Admin Created";