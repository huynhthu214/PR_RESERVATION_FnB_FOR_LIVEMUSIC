<?php
session_start();
require_once __DIR__ . '/../../config.php'; // Chứa BASE_URL, API_GATEWAY_URL,...

// Nếu đã đăng nhập → chuyển về dashboard
if (isset($_SESSION['ADMIN_ID'])) {
    header("Location: ../index.php?page=dashboard");
    exit();
}

$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    if ($email === 'admin@lyzy.com' && $password === '123456') {
        $_SESSION['ADMIN_ID'] = 1;
        $_SESSION['ADMIN_NAME'] = 'Admin LYZY';
        header("Location: ../index.php?page=dashboard");
        exit();
    } else {
        $api_url = "http://localhost/PR_RESERVATION_FnB_FOR_LIVEMUSIC/api_gateway/index.php?service=admin&action=login";
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
                $_SESSION['ADMIN_ID'] = $result['data']['ADMIN_ID'];
                $_SESSION['ADMIN_NAME'] = $result['data']['USERNAME'];
                header("Location: ../index.php?page=dashboard");
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

        <form method="POST">
          <label>Email</label>
          <input type="email" name="email" placeholder="Nhập email..." required>

          <label>Mật khẩu</label>
          <input type="password" name="password" placeholder="••••••••" required>

          <!---Hiển thị lỗi NGAY DƯỚI ô mật khẩu -->
          <?php if (!empty($error)): ?>
            <p class="error-msg"><i class="fa fa-exclamation-circle"></i> <?php echo htmlspecialchars($error); ?></p>
          <?php endif; ?>

          <button type="submit" class="btn-submit">Đăng nhập</button>
          <p class="footer-note">© <?php echo date('Y'); ?> LYZY Music. All rights reserved.</p>
        </form>
      </div>
    </div>
  </div>
</body>
</html>
