// ==========================================
// OTP INPUT
// ==========================================

const otpInputs = document.querySelectorAll(".otp-input");
const hiddenOtp = document.getElementById("otp");

function updateHiddenOTP() {
  hiddenOtp.value = [...otpInputs].map((input) => input.value).join("");
}

otpInputs.forEach((input, index) => {
  input.addEventListener("input", function () {
    this.value = this.value.replace(/[^0-9]/g, "");

    if (this.value.length === 1 && index < otpInputs.length - 1) {
      otpInputs[index + 1].focus();
    }

    updateHiddenOTP();
  });

  input.addEventListener("keydown", function (e) {
    if (e.key === "Backspace" && this.value === "" && index > 0) {
      otpInputs[index - 1].focus();
    }
  });
});

// ==========================================
// PASTE OTP
// ==========================================

document.addEventListener("paste", function (e) {
  const paste = (e.clipboardData || window.clipboardData)
    .getData("text")
    .replace(/\D/g, "")
    .substring(0, 6);

  if (paste.length === 6) {
    otpInputs.forEach((input, i) => {
      input.value = paste[i];
    });

    updateHiddenOTP();

    otpInputs[5].focus();

    e.preventDefault();
  }
});

// ==========================================
// VERIFY FORM LOADING
// ==========================================

const verifyForm = document.querySelector("form");

if (verifyForm) {

    verifyForm.addEventListener("submit", function () {

        // ตรวจสอบว่ากรอก OTP ครบ 6 หลักหรือไม่
        if (hiddenOtp.value.length !== 6) {
            return;
        }

        showLoading(
            "Verifying OTP...",
            "Checking your verification code"
        );

    });

}

// ==========================================
// COUNTDOWN
// ==========================================

let timeLeft = 300;

const countdown = document.getElementById("countdown");
const resendBtn = document.getElementById("resendBtn");

let timer;

function updateCountdown() {
  const minutes = String(Math.floor(timeLeft / 60)).padStart(2, "0");

  const seconds = String(timeLeft % 60).padStart(2, "0");

  countdown.textContent = `${minutes}:${seconds}`;

  if (timeLeft <= 0) {
    clearInterval(timer);

    countdown.innerHTML = "Available";

    resendBtn.disabled = false;

    return;
  }

  timeLeft--;
}

function startCountdown(seconds = 300) {
  clearInterval(timer);

  timeLeft = seconds;

  resendBtn.disabled = true;

  updateCountdown();

  timer = setInterval(updateCountdown, 1000);
}

startCountdown();

// ==========================================
// RESEND OTP
// ==========================================

resendBtn.addEventListener("click", function () {
  fetch("../../process/resend_reset_otp.php", {
    method: "POST",
  })
    .then(async (response) => {
      const text = await response.text();

      console.log("HTTP Status:", response.status);
      console.log("Response:", text);

      if (!response.ok) {
        throw new Error(text);
      }

      return JSON.parse(text);
    })

    .then((data) => {
      if (data.success) {
        Swal.fire({
          icon: "success",

          title: "OTP Sent",

          text: data.message,

          timer: 2000,

          showConfirmButton: false,
        });

        startCountdown(data.expires_in ?? 300);

        otpInputs.forEach((input) => (input.value = ""));

        updateHiddenOTP();

        otpInputs[0].focus();
      } else {
        Swal.fire({
          icon: "error",

          title: "Error",

          text: data.message,
        });
      }
    })

    .catch((error) => {
      console.error(error);

      Swal.fire({
        icon: "error",
        title: "Network Error",
        html: "<pre style='text-align:left'>" + error + "</pre>",
      });
    });
});
