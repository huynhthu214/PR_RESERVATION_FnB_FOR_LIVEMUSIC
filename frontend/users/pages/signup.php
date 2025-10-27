<?php
session_start();
require_once __DIR__ . '/../../config.php'; // Gọi file cấu hình chung (chứa BASE_URL, v.v.)

if (isset($_SESSION['USER_ID'])) {
    header("Location: index.php?page=dashboard");
    exit();
}

$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $username = trim($_POST['username']);

    if (empty($email) || empty($password) || empty($username)) {
        $error = "Vui lòng nhập đầy đủ thông tin!";
    } else {
        $_SESSION['USER_ID'] = 1001;
        $_SESSION['USER_NAME'] = $username;
        header("Location: index.php?page=dashboard");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Đăng ký - LYZY</title>

  <link rel="icon" type="image/png" href="<?php echo BASE_URL; ?>assets/images/logo_L.png">

  <link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/login_user.css">

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body>
  <div class="user-signup-container">
    <div class="left-side">
      <h1>Chào mừng bạn đến với LYZY!</h1>
      <p>Tạo tài khoản để không bỏ lỡ các sự kiện âm nhạc đang chờ bạn, khám phá thế giới cảm xúc và kết nối cùng cộng đồng yêu nhạc!</p>
    </div>

    <div class="right-side">
      <div class="signup-card">
        <h2>Đăng ký</h2>
        <?php if (!empty($error)): ?>
          <p class="error-msg">
            <i class="fa fa-exclamation-circle"></i> 
            <?php echo htmlspecialchars($error); ?>
          </p>
        <?php endif; ?>

        <form method="POST">
          <label>Họ và tên</label>
          <input type="text" name="username" placeholder="Nhập tên của bạn..." required>
          <label>Email</label>
          <input type="email" name="email" placeholder="Nhập email..." required>
          <label>Mật khẩu</label>
          <input type="password" name="password" placeholder="••••••••" required>
          <button type="submit" class="btn-submit">Đăng ký</button>
          <p class="signup-note">
            Đã có tài khoản? <a href="login.php">Đăng nhập ngay</a>
          </p>
        </form>
      </div>
    </div>
  </div>
</body>
</html>
