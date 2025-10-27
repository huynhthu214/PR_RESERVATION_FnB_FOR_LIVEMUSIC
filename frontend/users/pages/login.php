<?php
session_start();
require_once __DIR__ . '/../../config.php';

// Nếu user đã đăng nhập thì chuyển hướng
if (isset($_SESSION['USER_ID'])) {
    header("Location: index.php?page=home");
    exit();
}

// Xử lý đăng nhập
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    if ($email === 'user@lyzy.com' && $password === '123456') {
        $_SESSION['USER_ID'] = 1001;
        $_SESSION['USER_NAME'] = 'LYZY User';
        header("Location: index.php?page=home");
        exit();
    } else {
        $error = "Email hoặc mật khẩu không đúng!";
    }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Đăng nhập - LYZY</title>
  <link rel="icon" type="image/png" href="<?php echo BASE_URL; ?>assets/images/logo_L.png">
  <link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/login_user.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
  <div class="user-login-container">
    <div class="left-side">
      <h1>Chào mừng bạn đến với LYZY!</h1>
      <p>Đăng nhập để không bỏ lỡ các sự kiện âm nhạc đang chờ bạn, khám phá thế giới cảm xúc và kết nối cùng cộng đồng yêu nhạc!</p>
    </div>

    <div class="right-side">
      <div class="login-card">
        <h2>Đăng nhập</h2>

        <?php if (!empty($error)): ?>
          <p class="error-msg"><i class="fa fa-exclamation-circle"></i> <?php echo htmlspecialchars($error); ?></p>
        <?php endif; ?>

        <form method="POST">
          <label>Email</label>
          <input type="email" name="email" placeholder="Nhập email..." required>

          <label>Mật khẩu</label>
          <input type="password" name="password" placeholder="••••••••" required>

          <a href="forgot_pass.php" class="forgot-link">Quên mật khẩu?</a>

          <button type="submit" class="btn-submit">Đăng nhập</button>
        </form>
      </div>
    </div>
  </div>
</body>
</html>
