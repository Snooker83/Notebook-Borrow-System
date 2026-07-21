// ==========================================
// Notebook Borrow System
// Register Validation + AJAX Check
// ==========================================

document.addEventListener("DOMContentLoaded", function () {
  const form = document.getElementById("registerForm");

  const studentID = document.getElementById("student_id");

  const email = document.getElementById("email");

  const password = document.getElementById("password");

  const confirmPassword = document.getElementById("confirm_password");

  const studentMessage = document.getElementById("studentMessage");

  const emailMessage = document.getElementById("emailMessage");

  const passwordMessage = document.getElementById("passwordMessage");

  let emailAvailable = false;

  let studentAvailable = false;

  // =====================================
  // Student ID Format
  // =====================================

  studentID.addEventListener("input", function () {
    this.value = this.value.replace(/\D/g, "");

    if (this.value.length > 10) {
      this.value = this.value.substring(0, 10);
    }

    if (this.value.length === 10) {
      checkStudentID(this.value);
    } else {
      studentMessage.innerHTML = "Student ID must be 10 digits";

      studentMessage.className = "invalid";

      studentAvailable = false;
    }
  });

  // =====================================
  // Email
  // =====================================

  email.addEventListener("input", function () {
    this.value = this.value.replace(/[^a-zA-Z0-9._-]/g, "");

    if (this.value.length > 0) {
      checkEmail(this.value);
    } else {
      emailMessage.innerHTML = "";

      emailAvailable = false;
    }
  });

  // =====================================
  // Password Check
  // =====================================

  function checkPassword() {
    if (password.value.length < 8) {
      passwordMessage.innerHTML = "Password must be at least 8 characters";

      passwordMessage.className = "invalid";

      return false;
    }

    if (password.value !== confirmPassword.value) {
      passwordMessage.innerHTML = "Passwords do not match";

      passwordMessage.className = "invalid";

      return false;
    }

    passwordMessage.innerHTML = "✓ Password matched";

    passwordMessage.className = "valid";

    return true;
  }

  password.addEventListener("keyup", checkPassword);

  confirmPassword.addEventListener("keyup", checkPassword);

  // =====================================
  // AJAX Check Email
  // =====================================

  function checkEmail(value) {
    fetch("../process/check_email.php", {
      method: "POST",

      headers: {
        "Content-Type": "application/x-www-form-urlencoded",
      },

      body: "email=" + encodeURIComponent(value),
    })
      .then((response) => response.json())

      .then((data) => {
        emailMessage.innerHTML = data.message;

        if (data.status) {
          emailMessage.className = "valid";

          emailAvailable = true;
        } else {
          emailMessage.className = "invalid";

          emailAvailable = false;
        }
      });
  }

  // =====================================
  // AJAX Check Student ID
  // =====================================

  function checkStudentID(value) {
    fetch("../process/check_student.php", {
      method: "POST",

      headers: {
        "Content-Type": "application/x-www-form-urlencoded",
      },

      body: "student_id=" + encodeURIComponent(value),
    })
      .then((response) => response.json())

      .then((data) => {
        studentMessage.innerHTML = data.message;

        if (data.status) {
          studentMessage.className = "valid";

          studentAvailable = true;
        } else {
          studentMessage.className = "invalid";

          studentAvailable = false;
        }
      });
  }

  // =====================================
  // Submit
  // =====================================
  registerForm.addEventListener("submit", function () {
    showLoading(
      "Creating Account...",

      "Please wait",
    );
  });

  form.addEventListener("submit", function (e) {
    if (!studentAvailable) {
      alert("Please check Student ID");

      e.preventDefault();

      return;
    }

    if (!emailAvailable) {
      alert("Please check Email");

      e.preventDefault();

      return;
    }

    if (!checkPassword()) {
      e.preventDefault();

      return;
    }

    // เพิ่ม @cmu.ac.th ก่อนส่ง

    if (!email.value.includes("@cmu.ac.th")) {
      email.value = email.value + "@cmu.ac.th";
    }
  });
});
