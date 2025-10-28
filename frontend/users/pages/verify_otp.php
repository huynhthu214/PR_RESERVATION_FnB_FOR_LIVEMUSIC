<?php
session_start();
require_once __DIR__ . '/../../config.php';
$error = '';  
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $otp = trim($_POST['otp']);
    if (empty($otp)) {
        $error = "Vui lòng nhập mã xác nhận!";
    } else {
        header("Location: reset_password.php");
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <title>Xác minh mã OTP - LYZY</title>
  <link rel="icon" href="<?php echo BASE_URL; ?>assets/images/logo_L.png">
  <link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/login_user.css">
</head>
<body>
  <div class="user-login-container">
    <div class="left-side">
      <img src="<?php echo BASE_URL; ?>assets/images/verify.jpg" alt="Xác minh mã" class="illustration" width="400" height="400">
    </div>

    <div class="right-side">
      <div class="login-card">
        <h2>Xác minh mã OTP</h2>
        <p>Nhập mã 6 chữ số được gửi đến email của bạn.</p>
        <?php if ($error): ?><p class="error-msg"><?php echo $error; ?></p><?php endif; ?>
        <form method="POST">
          <label>Mã xác nhận</label>
          <input type="text" name="otp" placeholder="Nhập mã OTP..." required maxlength="6">
          <button type="submit" class="btn-submit">Xác nhận</button>
        </form>
        <p class="signup-note"><a href="reset_pass.php">← Quay lại</a></p>
      </div>
    </div>
  </div>
</body>
</html>
