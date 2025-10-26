<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../frontend/config.php';
$user = ['full_name' => $_SESSION['ADMIN_NAME'] ?? 'Admin'];
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LYZY - <?php echo isset($namePage) ? $namePage : ''; ?></title>
    <link rel="icon" type="image/png" href="<?php echo BASE_URL; ?>assets/images/logo_L.png">

    <!-- CSS -->
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/remixicon@4.2.0/fonts/remixicon.css">
    <script src="https://unpkg.com/lucide@latest"></script>
</head>
<body>

<!-- Header -->
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
      <i data-lucide="bell"></i>
      <span class="badge">3</span>
    </div>

    <div class="user-info">
      <img src="<?php echo BASE_URL; ?>assets/images/logo_login(1).jpg" 
     alt="User Avatar" class="user-avatar">
      <span class="username"><?php echo htmlspecialchars($user['full_name']); ?></span>
    </div>

    <button class="logout-btn" onclick="window.location.href='?page=logout'">Đăng xuất
    </button>
  </div>
</header>
