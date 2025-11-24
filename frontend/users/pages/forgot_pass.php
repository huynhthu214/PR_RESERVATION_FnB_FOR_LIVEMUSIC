<?php
session_start();
require_once __DIR__ . '/../../config.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');

    if (empty($email)) {
        $error = "Vui lòng nhập email!";
    } else {

      $url = "http://localhost/PR_RESERVATION_FnB_FOR_LIVEMUSIC/api_gateway/index.php?service=customer&action=send_otp";

        $payload = [
            "email" => $email
        ];

        $options = [
            "http" => [
                "header"  => "Content-Type: application/json",
                "method"  => "POST",
                "content" => json_encode($payload)
            ]
        ];

        $context  = stream_context_create($options);
        $result = file_get_contents($url, false, $context);

        $res = json_decode($result, true);

        if ($res && isset($res['success']) && $res['success'] == true) {

            // Lưu email + thời gian gửi OTP để verify
            $_SESSION['email_reset'] = $email;
            $_SESSION['otp_sent_time'] = $res['otp_sent_time'] ?? time();

            header("Location: verify_otp.php");
            exit();

        } else {
            $error = $res['message'] ?? "Gửi mã OTP thất bại, vui lòng thử lại!";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <title>LYZY - Quên mật khẩu</title>
  <link rel="icon" href="<?php echo BASE_URL; ?>assets/images/logo_L.png">
  <link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/login_user.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <style>
    /* Thêm nhẹ phần ảnh minh họa cho forgot password */
    .forgot-illustration {
      width: 100%;
      height: 100%;
      display: flex;
      align-items: center;
      justify-content: center;
      background: linear-gradient(160deg, #fff3d4, #ffe6b3, #ffd580);
    }
    .forgot-illustration img {
      width: 100%;
      max-width: 420px;
      filter: drop-shadow(0 5px 10px rgba(0,0,0,0.1));
      animation: float 3s ease-in-out infinite;
      margin-top: -120px;
    }
    @keyframes float {
      0%, 100% { transform: translateY(0); }
      50% { transform: translateY(-10px); }
    }
  </style>
</head>
<body>
  <div class="user-login-container">

    <!-- Bên trái là hình minh họa -->
    <div class="left-side forgot-illustration">
      <img src="<?php echo BASE_URL; ?>assets/images/forgot.jpg" alt="Forgot Password Illustration">
    </div>

    <!-- Bên phải là form -->
    <div class="right-side">
      <div class="login-card">
        <h2>Quên mật khẩu</h2>
        <?php if ($error): ?><p class="error-msg"><?php echo $error; ?></p><?php endif; ?>

        <form method="POST">
          <label>Email</label>
          <input type="email" name="email" placeholder="Nhập email của bạn..." required>
          <button type="submit" class="btn-submit">Gửi mã</button>
          <p class="signup-note"><a href="login_user.php">← Quay lại</a></p>
        </form>
      </div>
    </div>

  </div>
</body>
</html>
