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
        <span class="badge">1</span>
      </a>
    </div>

    <div class="user-info">
      <img src="<?php echo BASE_URL; ?>assets/images/logo_login(1).jpg" alt="User Avatar" class="user-avatar">
      <span class="username"><?php echo htmlspecialchars($userName); ?></span>
    </div>

    <button class="logout-btn" onclick="window.location.href='pages/logout.php'">Đăng xuất</button>
  </div>
</header>

<script>
document.addEventListener("DOMContentLoaded", loadNotificationCount);

function loadNotificationCount() {
    const badge = document.querySelector(".notification .badge");

    // --- Lấy thông tin người đăng nhập ---
    // (ở backend PHP, ta có thể in sẵn SESSION ra JS)
    const receiverId = "<?php echo isset($_SESSION['ADMIN_ID']) ? $_SESSION['ADMIN_ID'] : (isset($_SESSION['CUSTOMER_ID']) ? $_SESSION['CUSTOMER_ID'] : ''); ?>";
    const receiverType = "<?php echo isset($_SESSION['ADMIN_ID']) ? 'ADMIN' : (isset($_SESSION['CUSTOMER_ID']) ? 'CUSTOMER' : ''); ?>";

    if (!receiverId || !receiverType) {
        badge.style.display = "none";
        return;
    }

    // --- Gọi API qua API Gateway ---
    fetch(`http://localhost/PR_RESERVATION_FnB_FOR_LIVEMUSIC/api_gateway/index.php?service=notification&action=get_notifications&receiver_id=${receiverId}&receiver_type=${receiverType}`)
        .then(res => res.json())
        .then(data => {
            if (!data.success) {
                badge.style.display = "none";
                return;
            }

            const notifications = data.data || [];
            const unreadCount = notifications.filter(n => !n.IS_READ).length;

            if (unreadCount > 0) {
                badge.textContent = unreadCount;
                badge.style.display = "inline-block";
            } else {
                badge.style.display = "none";
            }
        })
        .catch(err => {
            console.error("Lỗi khi tải số lượng thông báo:", err);
            badge.style.display = "none";
        });
}
</script>
