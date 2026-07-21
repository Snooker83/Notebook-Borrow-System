<?php

require_once "../config/config.php";

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>
        Login | Notebook Borrow System
    </title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="assets/css/theme.css">

    <link rel="stylesheet" href="assets/css/auth.css">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>

<body>

    <div class="auth-wrapper">

        <!-- Left Branding -->
        <div class="auth-left">

            <div class="brand">

                <img
                    src="assets/img/logo-white.svg"
                    class="brand-logo"
                    alt="NBS Logo">

                <h1>Notebook Borrow System</h1>

                <p>
                    Faculty of Engineering<br>
                    Chiang Mai University
                </p>

            </div>

            <div class="brand-footer">

                Borrow notebooks securely<br>
                and efficiently.

            </div>

        </div>

        <!-- Right Login -->
        <div class="auth-right">

            <div class="login-card fade-up">

                <h2>Welcome Back</h2>

                <p>Sign in to continue</p>

                <form id="loginForm" action="../process/login_process.php" method="POST">

                    <label class="form-label">
                        <i class="bi bi-envelope-fill me-2"></i>
                        CMU Email
                    </label>

                    <div class="input-group mb-3">

                        <input
                            type="text"
                            id="email"
                            name="email"
                            class="form-control"
                            placeholder="CMU Email"
                            autocomplete="username"
                            required>

                        <span class="input-group-text">
                            @cmu.ac.th
                        </span>

                    </div>

                    <div class="mb-3">

                        <label class="form-label">
                            <i class="bi bi-lock-fill me-2"></i>
                            Password
                        </label>

                        <input
                            type="password"
                            id="password"
                            name="password"
                            class="form-control"
                            placeholder="Enter your password"
                            required>
                    </div>
                    <div class="text-end mb-3">

                        <a
                            href="forgot_password.php"
                            class="forgot-link">

                            Forgot Password?

                        </a>

                    </div>

                    <button type="submit" class="btn-login">

                        <i class="bi bi-box-arrow-in-right me-2"></i>

                        Login

                    </button>

                    <div class="register-link">

                        Don't have an account?

                        <a href="register.php">

                            Register

                        </a>

                    </div>

                </form>

            </div>

        </div>

    </div>

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

    <script src="assets/js/login.js"></script>

</body>

</html>