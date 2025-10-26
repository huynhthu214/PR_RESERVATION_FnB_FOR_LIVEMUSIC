<?php
session_start();
require_once __DIR__ . '/../../config.php';

if (isset($_SESSION['ADMIN_ID'])) {
    header("Location: index.php?page=dashboard");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    if ($email === 'admin@lyzy.com' && $password === '123456') {
        $_SESSION['ADMIN_ID'] = 1;
        $_SESSION['ADMIN_NAME'] = 'Admin LYZY';
        header("Location: index.php?page=dashboard");
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
  <title>Đăng nhập Admin - LYZY</title>
  <link rel="icon" type="image/png" href="<?php echo BASE_URL; ?>assets/images/logo_L.png">
  <link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/login.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
  <div class="login-container">
    <div class="welcome-side">
      <h1>LYZY ADMIN</h1>
      <p>Bước vào không gian quản trị của LYZY.<br>Hãy cùng tạo nên trải nghiệm tốt nhất cho người dùng.</p>
    </div>

    <div class="form-side">
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

          <button type="submit" class="btn-submit">Đăng nhập</button>
          <p class="footer-note">© <?php echo date('Y'); ?> LYZY Music. All rights reserved.</p>
        </form>
      </div>
    </div>
  </div>
</body>
</html>
