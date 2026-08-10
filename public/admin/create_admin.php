<?php

require_once __DIR__ . "/../../config/database.php";

$username = "adminwk";

$password = password_hash("ieadmin", PASSWORD_DEFAULT);

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