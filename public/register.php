<?php
require_once '../config/config.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Register | <?= APP_NAME ?></title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="assets/css/theme.css">

    <link rel="stylesheet" href="assets/css/auth.css">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

</head>

<body>

    <div class="auth-wrapper">

        <div class="auth-left">

            <div class="brand">

                <img
                    src="assets/img/logo-white.svg"
                    class="brand-logo">

                <h1>

                    Create Account

                </h1>

                <p>

                    Join Notebook Borrow System

                </p>

                <p>

                    Faculty of Engineering
                    <br>
                    Chiang Mai University

                </p>

            </div>

            <div class="brand-footer">

                Create your CMU account
                to borrow notebooks securely.

            </div>

        </div>

        <div class="auth-right">

            <div class="register-card">
                <h2>Create Account</h2>
                <p class="text-secondary">
                    Register Account
                    <br>
                    <small>สมัครสมาชิกเพื่อเข้าใช้งานระบบ</small>
                </p>

                <form
                    id="registerForm"
                    action="../process/register_process.php"
                    method="POST">

                    <div class="row">

                        <!-- Left -->

                        <div class="col-md-6">

                            <div class="row">

                                <div class="col-md-6 mb-3">

                                    <label class="form-label">

                                        First Name

                                        <br>

                                        <small class="text-secondary">
                                            ชื่อ
                                        </small>

                                    </label>

                                    <input
                                        type="text"
                                        class="form-control"
                                        name="first_name"
                                        required>

                                </div>

                                <div class="col-md-6 mb-3">

                                    <label class="form-label">

                                        Last Name

                                        <br>

                                        <small class="text-secondary">
                                            นามสกุล
                                        </small>

                                    </label>

                                    <input
                                        type="text"
                                        class="form-control"
                                        name="last_name"
                                        required>

                                </div>

                            </div>

                            <div class="mb-3">

                                <label class="form-label">

                                    Student ID

                                    <br>

                                    <small class="text-secondary">
                                        รหัสนักศึกษา
                                    </small>

                                </label>

                                <input
                                    type="text"
                                    maxlength="10"
                                    class="form-control"
                                    name="student_id"
                                    id="student_id"
                                    required>

                                <small id="studentMessage"></small>

                            </div>

                            <div class="mb-3">

                                <label class="form-label">

                                    Phone Number

                                    <br>

                                    <small class="text-secondary">
                                        เบอร์โทรศัพท์
                                    </small>

                                </label>

                                <input
                                    type="text"
                                    maxlength="10"
                                    class="form-control"
                                    name="phone"
                                    required>

                            </div>

                            <div class="mb-3">

                                <label class="form-label">

                                    CMU Email

                                    <br>

                                    <small class="text-secondary">
                                        กรอกเฉพาะชื่ออีเมล
                                    </small>

                                </label>

                                <div class="input-group">

                                    <input
                                        type="text"
                                        class="form-control"
                                        id="email"
                                        name="email"
                                        placeholder="example"
                                        required>

                                    <span class="input-group-text">
                                        @cmu.ac.th
                                    </span>

                                </div>

                                <small id="emailMessage"></small>

                            </div>
                            <label class="form-label">

                                Password

                            </label>
                            <div class="input-group mb-3">

                                <input
                                    type="password"
                                    class="form-control"
                                    name="password"
                                    id="password"
                                    required>

                                <button
                                    type="button"
                                    class="btn btn-ouline-secodary"
                                    id="togglePassword">
                                    <i class="bi bi-eye"></i>
                                </button>

                            </div>

                            <label class="form-label">

                                Confirm Password

                            </label>

                            <div class="input-group mb-3">

                                <input
                                    type="password"
                                    class="form-control"
                                    name="confirm_password"
                                    id="confirm_password"
                                    required>
                                <button
                                    type="button"
                                    class="btn btn-ouline-secodary"
                                    id="togglePassword">
                                    <i class="bi bi-eye"></i>
                                </button>



                            </div>
                            <small id="passwordMessage"></small>

                        </div>

                        <!-- Right -->

                        <div class="col-md-6">

                            <div class="terms-box">

                                <h5 class="text-purple">
                                    <i class="bi bi-file-earmark-text-fill text-primary"></i>

                                    Terms & Conditions

                                </h5>

                                <small class="text-secondary">

                                    เงื่อนไขการใช้งาน

                                </small>

                                <hr>

                                <ol>

                                    <li>Use only your own CMU account.<br>ใช้บัญชี CMU ของตนเองเท่านั้น</li>
                                    <li>All information provided must be truthful and accurate.<br>ข้อมูลที่กรอกต้องเป็นความจริง</li>
                                    <li>Do not disclose your password to others.<br>ห้ามเปิดเผยรหัสผ่านแก่ผู้อื่น</li>
                                    <li>The notebook is for educational purposes only.<br>Notebook ใช้เพื่อการศึกษาเท่านั้น</li>
                                    <li>The borrower is responsible for any damages under all circumstances.<br>ผู้ยืมรับผิดชอบความเสียหายทุกกรณี</li>
                                    <li>The device must be returned on time.<br>ต้องคืนตรงเวลาที่กำหนด</li>
                                    <li>Do not install illegal or unauthorized software.<br>ห้ามติดตั้งโปรแกรมผิดกฎหมาย</li>
                                    <li>Do not alter or modify the hardware.<br>ห้ามเปลี่ยนแปลงอุปกรณ์</li>
                                    <li>Staff may inspect or audit borrowing history.<br>เจ้าหน้าที่สามารถตรวจสอบประวัติการยืมได้</li>
                                    <li>Submitting the application constitutes full acceptance of all terms and conditions.<br>การสมัครถือว่ายอมรับเงื่อนไขทั้งหมด</li>

                                </ol>

                            </div>
                            <div class="form-check">

                                <input
                                    class="form-check-input"
                                    type="checkbox"
                                    id="accept"
                                    required>

                                <label
                                    class="form-check-label"
                                    for="accept">

                                    I have read and accept the Terms & Conditions.

                                </label>
                            </div>

                        </div>

                    </div>

                    <div class="d-grid mt-4">

                        <button
                            class="btn btn-primary btn-lg">

                            Register

                        </button>

                    </div>
                    <div class="text-center mt-3">
                        Already have an account?
                        <a
                            href="login.php">

                            Back to Login

                        </a>

                    </div>

                </form>
            </div>

        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script src="../assets/js/register.js"></script>

    <script src="assets/js/alert.js"></script>

    <script src="assets/js/loading.js"></script>

    <script>
        function togglePassword(inputId, buttonId) {

            const input = document.getElementById(inputId);

            const icon = document.querySelector("#" + buttonId + " i");

            if (input.type === "password") {

                input.type = "text";

                icon.classList.remove("bi-eye");

                icon.classList.add("bi-eye-slash");

            } else {

                input.type = "password";

                icon.classList.remove("bi-eye-slash");

                icon.classList.add("bi-eye");

            }

        }

        document.getElementById("togglePassword")
            .addEventListener("click", function() {

                togglePassword("password", "togglePassword");

            });

        document.getElementById("toggleConfirm")
            .addEventListener("click", function() {

                togglePassword("confirm_password", "toggleConfirm");

            });
    </script>

</body>

</html>