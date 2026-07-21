<?php

require_once "../config/config.php";

if (
    !isset($_SESSION['reset_password_user_id'])
) {

    header("Location: forgot_password.php");

    exit;
}

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

                <h2>Reset Password</h2>

                <p>Create your new password</p>

                <form
                    id="resetForm"
                    action="../process/reset_password_process.php"
                    method="POST">

                    <div class="mb-3">

                        <label class="form-label">

                            <i class="bi bi-lock-fill me-2"></i>

                            New Password

                        </label>

                        <input

                            type="password"

                            id="password"

                            name="password"

                            class="form-control"

                            placeholder="Enter new password"

                            required>

                    </div>

                    <div class="mb-4">

                        <label class="form-label">

                            <i class="bi bi-shield-lock-fill me-2"></i>

                            Confirm Password

                        </label>

                        <input

                            type="password"

                            id="confirm_password"

                            name="confirm_password"

                            class="form-control"

                            placeholder="Confirm new password"

                            required>

                    </div>

                    <button
                        class="btn-login"
                        type="submit">

                        <i class="bi bi-arrow-repeat me-2"></i>

                        Reset Password

                    </button>

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

    <script src="assets/js/reset_password.js"></script>

</body>

</html>