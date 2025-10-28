<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

//Sửa lại đường dẫn config cho đúng
require_once __DIR__ . '/../frontend/config.php';

//Kiểm tra loại người dùng + tên hiển thị
$userName = '';

if (!empty($_SESSION['ADMIN_NAME'])) {
    $userName = $_SESSION['ADMIN_NAME']; // Tên admin đăng nhập
} elseif (!empty($_SESSION['STAFF_NAME'])) {
    $userName = $_SESSION['STAFF_NAME']; // Nếu là staff đăng nhập
} else {
    $userName = 'Khách'; // Fallback
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LYZY - <?php echo isset($namePage) ? $namePage : ''; ?></title>
    <link rel="icon" type="image/png" href="<?php echo BASE_URL; ?>assets/images/logo_L.png">

    <!-- CSS CHUNG -->
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/base.css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/remixicon@4.2.0/fonts/remixicon.css">
    <script src="https://unpkg.com/lucide@latest"></script>

    <!-- CSS RIÊNG CHO MỖI TRANG -->
    <?php
    $pageCssPath = __DIR__ . "/../../assets/css/{$page}.css";
    if (!empty($page) && file_exists($pageCssPath)) {
        echo '<link rel="stylesheet" href="' . BASE_URL . 'assets/css/' . $page . '.css">';
    }
    ?>
</head>
<body>

<header class="admin-header">
  <div class="header-left">
      <div class="logo">
        <img src="<?php echo BASE_URL; ?>assets/images/logo_L.png" alt="Logo" width="60" height="60">
        <div>
            <h2>LYZY Admin</h2>
        </div>
      </div>
  </div>

  <div class="header-right">
    <div class="notification">
      <a href="index.php?page=notification" class="notification-link" title="Thông báo">
        <i data-lucide="bell"></i>
        <span class="badge">3</span>
      </a>
    </div>

    <div class="user-info">
      <img src="<?php echo BASE_URL; ?>assets/images/logo_login(1).jpg" alt="User Avatar" class="user-avatar">
      <span class="username"><?php echo htmlspecialchars($userName); ?></span>
    </div>

    <button class="logout-btn" onclick="window.location.href='pages/logout.php'">Đăng xuất</button>
  </div>
</header>
