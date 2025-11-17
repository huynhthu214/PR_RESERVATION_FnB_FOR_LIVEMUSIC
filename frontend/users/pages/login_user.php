<?php
session_start();
require_once __DIR__ . '/../../config.php'; // Gọi tới config chứa BASE_URL, API_GATEWAY_URL,...

// Nếu đã đăng nhập → chuyển về trang home
if (isset($_SESSION['CUSTOMER_ID'])) {
    header("Location: ../index.php?page=home");
    exit();
}

$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    if (empty($email) || empty($password)) {
        $error = "Vui lòng nhập đầy đủ thông tin!";
    } else {
        // Gọi API gateway (tương tự phần admin)
        $api_url = "http://localhost/PR_RESERVATION_FnB_FOR_LIVEMUSIC/api_gateway/index.php?service=customer&action=login";

        $payload = json_encode([
            "email" => $email,
            "password" => $password
        ]);

        $options = [
            "http" => [
                "header"  => "Content-Type: application/json",
                "method"  => "POST",
                "content" => $payload
            ]
        ];

        $context = stream_context_create($options);
        $response = file_get_contents($api_url, false, $context);

        if ($response === FALSE) {
            $error = "Không thể kết nối đến máy chủ!";
        } else {
            $result = json_decode($response, true);
          if (isset($result['success']) && $result['success'] === true) {
              $user = $result['user'];
              $_SESSION['CUSTOMER_ID'] = $user['CUSTOMER_ID'];
              $_SESSION['USERNAME'] = $user['USERNAME'];
              header("Location: ../index.php?page=home");
              exit();
          } else {
                          $error = $result['error'] ?? "Email hoặc mật khẩu không đúng!";
                      }
                  }
              }
          }
?>
<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>LYZY - Đăng nhập</title>
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
        <form method="POST">
          <label>Email</label>
          <input type="email" name="email" placeholder="Nhập email..." required>

          <label>Mật khẩu</label>
          <input type="password" name="password" placeholder="••••••••" required>

          <a href="forgot_pass.php" class="forgot-link">Quên mật khẩu?</a>

        <?php if (!empty($error)): ?>
          <p class="error-msg"><i class="fa fa-exclamation-circle"></i> <?php echo htmlspecialchars($error); ?></p>
        <?php endif; ?>

          <button type="submit" class="btn-submit">Đăng nhập</button>
        </form>
      </div>
    </div>
  </div>
</body>
</html>
