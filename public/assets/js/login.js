// ==========================================
// Notebook Borrow System
// Modern Login
// ==========================================

document.addEventListener("DOMContentLoaded", function () {

    const form = document.getElementById("loginForm");

    if (!form) return;

    const email = document.getElementById("email");
    const password = document.getElementById("password");

    form.addEventListener("submit", function (e) {

        const emailValue = email.value.trim();

        // ==========================================
        // Validate Email
        // ==========================================

        if (emailValue === "") {

            e.preventDefault();

            Swal.fire({
                icon: "warning",
                title: "CMU Email Required",
                text: "Please enter your CMU Email.",
                confirmButtonColor: "#6C5CE7"
            });

            email.focus();

            return;
        }

        // ==========================================
        // Validate Password
        // ==========================================

        if (password.value.trim() === "") {

            e.preventDefault();

            Swal.fire({
                icon: "warning",
                title: "Password Required",
                text: "Please enter your password.",
                confirmButtonColor: "#6C5CE7"
            });

            password.focus();

            return;
        }

        // ==========================================
        // Loading Dialog
        // ==========================================

        if (typeof showLoading === "function") {

            showLoading(
                "Signing In...",
                "Checking your account"
            );

        }

    });

});