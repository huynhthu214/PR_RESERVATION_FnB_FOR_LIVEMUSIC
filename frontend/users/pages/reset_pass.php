<?php
session_start();
require_once __DIR__ . '/../../config.php';
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $password = trim($_POST['password']);
    $confirm  = trim($_POST['confirm']);
    if (empty($password) || empty($confirm)) {
        $error = "Vui lòng nhập đầy đủ thông tin!";
    } elseif ($password !== $confirm) {
        $error = "Mật khẩu xác nhận không khớp!";
    } else {
        // xử lý lưu mật khẩu mới ở đây...
        header("Location: login_user.php");
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <title>Đặt lại mật khẩu - LYZY</title>
  <link rel="icon" href="<?php echo BASE_URL; ?>assets/images/logo_L.png">
  <link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/login_user.css">
</head>
<body>
  <div class="user-login-container">
    <div class="left-side">
      <img src="<?php echo BASE_URL; ?>assets/images/reset.jpg" alt="Đặt lại mật khẩu" class="illustration" width="400" height="400">
    </div>

    <div class="right-side">
      <div class="login-card">
        <h2>Đặt lại mật khẩu</h2>
        <?php if ($error): ?><p class="error-msg"><?php echo $error; ?></p><?php endif; ?>
        <form method="POST">
          <label>Mật khẩu mới</label>
          <input type="password" name="password" placeholder="Nhập mật khẩu mới..." required>
          <label>Xác nhận mật khẩu</label>
          <input type="password" name="confirm" placeholder="Nhập lại mật khẩu..." required>
          <button type="submit" class="btn-submit">Đặt lại mật khẩu</button>
        </form>
        <p class="signup-note"><a href="login.php">← Quay lại đăng nhập</a></p>
      </div>
    </div>
  </div>
</body>
</html>
