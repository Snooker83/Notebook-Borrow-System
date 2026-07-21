<?php

require_once "../config/config.php";

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>
        Forgot Password | Notebook Borrow System
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

                <h2>Forgot Password</h2>

                <p>Enter your CMU Email</p>

                <form
                    id="forgotForm"
                    action="../process/forgot_password_process.php"
                    method="POST">

                    <label class="form-label">

                        <i class="bi bi-envelope-fill me-2"></i>

                        CMU Email

                    </label>

                    <div class="input-group mb-4">

                        <input

                            type="text"

                            id="email_prefix"

                            class="form-control"

                            placeholder="CMU Email"

                            required>

                        <span class="input-group-text">

                            @cmu.ac.th

                        </span>

                    </div>

                    <input

                        type="hidden"

                        id="email"

                        name="email">

                    <button

                        class="btn-login"

                        type="submit">

                        <i class="bi bi-send-fill me-2"></i>

                        Send OTP

                    </button>

                </form>

                <div class="register-link mt-4">

                Remember your password?

                <a href="login.php">

                    Back to Login

                </a>

            </div>

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

    <script src="assets/js/forgot_password.js"></script>

</body>

</html>