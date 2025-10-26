<?php
session_start();
require_once __DIR__ . '/../config.php';

// Nếu admin đã đăng nhập thì chuyển hướng luôn
if (isset($_SESSION['ADMIN_ID'])) {
    header("Location: index.php?page=dashboard");
    exit();
}

// Xử lý khi nhấn nút đăng nhập
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    // Giả lập xác thực (sau này thay bằng truy vấn DB)
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
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/remixicon@4.2.0/fonts/remixicon.css">
</head>
<body>
  <div class="login-container">
    <div class="login-card">
      <div class="logo">
        <img src="<?php echo BASE_URL; ?>assets/images/logo_L.png" alt="Logo" width="60" height="60">
        <h1>LYZY <span>ADMIN</span></h1>
      </div>

      <h2>ĐĂNG NHẬP</h2>
      <?php if (!empty($error)) echo "<p class='error'>$error</p>"; ?>

      <form method="POST" class="login-form">
        <div class="form-group">
          <label>Email</label>
          <input type="email" name="email" placeholder="Nhập email..." required>
        </div>

        <div class="form-group">
          <label>Mật khẩu</label>
          <input type="password" name="password" placeholder="••••••" required>
        </div>

        <button type="submit" class="btn-login">Đăng nhập</button>
      </form>

      <p class="note">© <?php echo date('Y'); ?> LYZY Music. All rights reserved.</p>
    </div>
  </div>
</body>
</html>
