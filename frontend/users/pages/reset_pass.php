<?php
session_start();
require_once __DIR__ . '/../../config.php';
if (!isset($_SESSION['email_reset'])) {
    header("Location: forgot_pwd.php");
    exit;
}

$email = $_SESSION['email_reset'];
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $password = trim($_POST['password']);
    $confirm  = trim($_POST['confirm']);

    if (empty($password) || empty($confirm)) {
        $error = "Vui lòng nhập đầy đủ thông tin!";
    } elseif ($password !== $confirm) {
        $error = "Mật khẩu xác nhận không khớp!";
    } else {

        // Gọi API reset password
        $url = "http://localhost/PR_RESERVATION_FnB_FOR_LIVEMUSIC/api_gateway/index.php?service=customer&action=reset_pwd";

        $data = [
            "email" => $email,
            "password" => $password
        ];

        $options = [
            "http" => [
                "header"  => "Content-Type: application/json",
                "method"  => "POST",
                "content" => json_encode($data)
            ]
        ];

        $context = stream_context_create($options);
        $result  = @file_get_contents($url, false, $context);

        if ($result === false) {
            $error = "Không thể kết nối server!";
        } else {
            $res = json_decode($result, true);

            if (isset($res["success"])) {
                unset($_SESSION['email_reset']);
                header("Location: login_user.php");
                exit;
            } else {
                $error = $res["error"] ?? "Có lỗi xảy ra!";
            }
        }
    }
}

?>
<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <title>LYZY - Đặt lại mật khẩu</title>
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
