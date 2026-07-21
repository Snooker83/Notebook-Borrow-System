<?php

require_once "../config/config.php";


// ตรวจสอบว่ามี user_id ใน session หรือไม่

if (!isset($_SESSION['verify_user_id'])) {

    header(
        "Location: login.php"
    );

    exit;
}



?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">


    <title>
        Verify OTP | Notebook Borrow System
    </title>


    <link rel="stylesheet" href="assets/css/theme.css">

    <link rel="stylesheet" href="assets/css/auth.css">

    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">


</head>


<body>

    <div class="auth-wrapper">

        <!-- Left -->

        <div class="auth-left">

            <div class="brand">

                <img
                    src="assets/img/logo-white.svg"
                    class="brand-logo">

                <h1>

                    Notebook Borrow System

                </h1>

                <p>

                    Faculty of Engineering

                    <br>

                    Chiang Mai University

                </p>

            </div>

            <div class="brand-footer">

                Verify your email
                to activate your account.

            </div>

        </div>

        <!-- Right -->

        <div class="auth-right">

            <div class="login-card fade-up">

                <!-- Progress -->

                <h2>

                    Verify Email

                </h2>

                <p>

                    Enter the verification code
                    sent to your CMU Email.

                </p>

                <p class="text-secondary">

                    กรุณากรอกรหัส OTP 6 หลักที่ส่งไปยัง Email

                </p>



                <form
                    action="../process/verify_process.php"
                    method="POST">


                    <div class="otp-group">

                        <input maxlength="1" class="otp-input">

                        <input maxlength="1" class="otp-input">

                        <input maxlength="1" class="otp-input">

                        <input maxlength="1" class="otp-input">

                        <input maxlength="1" class="otp-input">

                        <input maxlength="1" class="otp-input">

                    </div>

                    <input
                        type="hidden"
                        name="otp"
                        id="otp">

                    <button
                        type="submit"
                        class="btn-login">

                        Verify Account
                    </button>

                </form>


                <div class="register-link">

                <div class="text-center mt-4">

                        <p class="text-secondary mb-2">

                            Didn't receive the code?

                        </p>

                        <p>

                            Resend available in

                            <span id="countdown" class="fw-bold text-purple">

                                05:00

                            </span>

                        </p>

                        <button
                            type="button"
                            id="resendBtn"
                            class="btn btn-outline-primary"
                            disabled>

                            <i class="bi bi-arrow-clockwise"></i>

                            Resend OTP

                        </button>

                    </div>
                    <br>
                    <a href="login.php">

                        Back to Login

                    </a>

                </div>




            </div>

        </div>

    </div>



    <!-- 
    <div class="container py-5">


        <div class="row justify-content-center">


            <div class="col-md-5">


                <div class="card shadow">


                    <div class="card-body p-5 text-center">


                        <h2 class="text-purple fw-bold">

                            Email Verification

                        </h2>


                        <p class="text-secondary">

                            กรุณากรอกรหัส OTP 6 หลักที่ส่งไปยัง Email

                        </p>



                        <form
                            action="../process/verify_process.php"
                            method="POST">


                            <div class="mb-4">


                                <input

                                    type="text"

                                    name="otp"

                                    maxlength="6"

                                    class="form-control text-center"

                                    style="font-size:30px;letter-spacing:10px"

                                    placeholder="000000"

                                    required>


                            </div>



                            <button

                                class="btn btn-primary w-100">

                                Verify OTP

                            </button>



                        </form>



                        <div class="mt-3">


                            <a href="login.php">

                                Back to Login

                            </a>


                        </div>



                    </div>


                </div>


            </div>


        </div>


    </div> -->

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script src="assets/js/alert.js"></script>

    <script src="assets/js/loading.js"></script>

    <script src="assets/js/verify.js"></script>

    <script>

        const inputs = document.querySelectorAll(".otp-input");

        const hidden = document.getElementById("otp");

        inputs.forEach((input, index) => {

            input.addEventListener("input", () => {

                if (input.value.length === 1 && index < 5) {

                    inputs[index + 1].focus();

                }

                hidden.value = [...inputs]

                    .map(i => i.value)

                    .join("");

            });

        });
    </script>

</body>

</html>