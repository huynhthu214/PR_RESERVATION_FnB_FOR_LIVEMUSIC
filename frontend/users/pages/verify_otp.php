<?php
session_start();
require __DIR__ . '/../../config.php';

if (!isset($_SESSION['email_reset'])) {
    header("Location: forgot_pwd.php");
    exit;
}

$email = $_SESSION['email_reset'];
$error = '';
$success = '';
?>

<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8">
<title>LYZY - Xác minh OTP</title>
<link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/login_user.css">
<style>
.resend-btn {
    background: none;
    border: none;
    color: #333;
    cursor: pointer;
    text-decoration: none;
    padding: 0;
    transition: all 0.2s ease;
}
.resend-btn:hover {
    color: #0056b3;
    transform: scale(1.05);
}
.resend-btn:disabled {
    color: #6c757d;
    cursor: not-allowed;
    text-decoration: none;
    transform: none;
}
#countdown {
    font-weight: bold;
    margin-left: 10px;
}
.error-msg { color:red; margin-top:10px; }
</style>
</head>
<body>
<div class="user-login-container">
  <div class="left-side"><img src="<?php echo BASE_URL; ?>assets/images/verify.jpg" width="400"></div>
  <div class="right-side">
    <div class="login-card">
      <h2>Xác minh mã OTP</h2>
      <form id="otpForm">
        <label>Mã OTP</label>
        <input type="text" name="otp" placeholder="Nhập mã OTP..." maxlength="6" required>
        <button type="submit" class="btn-submit">Xác nhận</button>
      </form>

      <div style="margin-top:10px;">
        <button id="resendBtn" class="resend-btn">Gửi lại</button>
        <span id="countdown"></span>
      </div>

      <p class="error-msg" id="errorMsg"></p>
      <p class="signup-note"><a href="forgot_pwd.php">← Quay lại</a></p>
    </div>
  </div>
</div>

<script>
const otpForm = document.getElementById('otpForm');
const resendBtn = document.getElementById('resendBtn');
const countdownEl = document.getElementById('countdown');
const errorMsg = document.getElementById('errorMsg');
let otpDuration = 60;
let timer = null;

function startCountdown() {
    resendBtn.disabled = true;
    let timeLeft = otpDuration;
    countdownEl.textContent = timeLeft + "s";
    timer = setInterval(() => {
        timeLeft--;
        countdownEl.textContent = timeLeft + "s";
        if (timeLeft <= 0) {
            clearInterval(timer);
            resendBtn.disabled = false;
            countdownEl.textContent = "";
        }
    }, 1000);
}

// Xác nhận OTP
otpForm.addEventListener('submit', async function(e) {
    e.preventDefault();
    errorMsg.textContent = '';
    const otp = otpForm.otp.value.trim();
    if(!otp) { errorMsg.textContent = "Nhập mã OTP!"; return; }

    try {
        const res = await fetch("http://localhost/PR_RESERVATION_FnB_FOR_LIVEMUSIC/api_gateway/index.php?service=customer&action=verify_otp", {
            method: "POST",
            headers: {"Content-Type": "application/json"},
            body: JSON.stringify({ email: "<?php echo addslashes($email); ?>", otp })
        });
        const data = await res.json();
        if(data.success) {
            window.location.href = "reset_pass.php";
        } else {
            errorMsg.textContent = data.error || "OTP không hợp lệ!";
        }
    } catch (err) {
        errorMsg.textContent = "Không kết nối được server. Vui lòng thử lại.";
    }
});

// Gửi lại OTP
resendBtn.addEventListener('click', async function() {
    resendBtn.disabled = true;
    errorMsg.textContent = '';
    try {
        const res = await fetch("http://localhost/PR_RESERVATION_FnB_FOR_LIVEMUSIC/api_gateway/index.php?service=customer&action=send_otp", {
            method: "POST",
            headers: {"Content-Type": "application/json"},
            body: JSON.stringify({ email: "<?php echo addslashes($email); ?>" })
        });
        const data = await res.json();
        if(data.success) {
            startCountdown();
        } else {
            errorMsg.textContent = data.error || "Gửi OTP thất bại";
            resendBtn.disabled = false;
        }
    } catch(err) {
        errorMsg.textContent = "Có lỗi xảy ra khi gửi OTP";
        resendBtn.disabled = false;
    }
});
</script>
</body>
</html>
