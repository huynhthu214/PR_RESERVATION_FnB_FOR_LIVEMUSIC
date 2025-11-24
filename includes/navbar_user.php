<?php
if (session_status() === PHP_SESSION_NONE) session_start();
require_once __DIR__ . '/../frontend/config.php';

$userName = !empty($_SESSION['USERNAME']) ? $_SESSION['USERNAME'] : 'Khách';
$page = $_GET['page'] ?? 'home';

$title = match($page) {
    'home' => 'LYZY - Trang chủ',
    'event' => 'LYZY - Sự kiện',
    'about' => 'LYZY - Giới thiệu',
    'contact' => 'LYZY - Liên hệ',
    'event_details' => 'LYZY - Chi tiết sự kiện',
    'cart' => 'LYZY - Giỏ hàng',
    'noti_details' => 'LYZY - Chi tiết thông báo',
    'notification' => 'LYZY - Thông báo',
    'order' => 'LYZY - Đặt hàng',
    'payment' => 'LYZY - Thanh toán',
    'seat' => 'LYZY - Chỗ ngồi',
    'tickets' => 'LYZY - Vé',
    'user_details' => 'LYZY - Thông tin tài khoản',
    'user_orders' => 'LYZY - Đơn hàng của tôi',
    default => 'LYZY | ' . ucfirst($page),
};

$hideSidebarPages = [
    'user_details', 'cart', 'event_details',
    'noti_details', 'notification', 'payment',
    'seat', 'tickets', 'user_orders'
];
?>

<title><?php echo htmlspecialchars($title); ?></title>
<link rel="stylesheet" href="../../frontend/assets/css/navbar.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" />

<?php if (!in_array($page, $hideSidebarPages)): ?>
<aside class="sidebar compact" id="sidebar">
  <ul>
    <li onclick="location.href='index.php?page=home'"><i class="fa-solid fa-home"></i><span>Trang chủ</span></li>
    <li onclick="location.href='index.php?page=user_orders'"><i class="fa-solid fa-cart-shopping"></i><span>Đơn hàng của tôi</span></li>
    <li onclick="location.href='index.php?page=contact'"><i class="fa-solid fa-phone"></i><span>Liên hệ</span></li>
    <li onclick="location.href='pages/logout_user.php'"><i class="fa-solid fa-right-from-bracket"></i></i><span>Đăng xuất</span></li>
  </ul>
</aside>
<?php endif; ?>

<nav class="navbar" id="navbar">
  <div class="navbar-inner">
    <div class="logo" id="logo">
      <a href="index.php?page=home" class="logo-icon">
        <img src="<?php echo BASE_URL; ?>assets/images/LogoLYZY.png" alt="LYZY Logo" style="height:40px;">
      </a>
    </div>

    <div class="nav-links">
      <a href="index.php?page=home">Trang chủ</a>
      <a href="index.php?page=event">Sự kiện</a>
      <a href="index.php?page=about">Giới thiệu</a>
      <a href="index.php?page=contact">Hỗ trợ</a>
    </div>

    <div class="Notification">
      <a href="index.php?page=notification"><i class="fa-solid fa-bell"></i></a>
    </div>

    <div class="search-box" id="searchBox">
      <input type="text" placeholder="Tìm kiếm..." />
    </div>

    <div class="user">
      <button class="user-btn" id="userBtn">
        <i class="fa-solid fa-user"></i>
        <span class="username"><?php echo htmlspecialchars($userName); ?></span>
      </button>
      <div class="user-dropdown" id="userDropdown">
        <a href="index.php?page=user_details">Thông tin tài khoản</a>
        <a href="pages/logout_user.php" class="logout">Đăng xuất</a>
      </div>
    </div>
  </div>
</nav>

<script>
document.addEventListener("DOMContentLoaded", () => {
  const sidebar = document.getElementById("sidebar");
  const logo = document.getElementById("logo");
  const navbar = document.getElementById("navbar");

  if (!sidebar || !logo || !navbar) return;

  logo.addEventListener("click", (e) => {
    e.preventDefault();
    if (sidebar.classList.contains("active")) {
      sidebar.classList.remove("active");
      sidebar.classList.add("compact");
    } else {
      sidebar.classList.add("active");
      sidebar.classList.remove("compact");
    }
  });

  window.addEventListener("scroll", () => {
    if (window.scrollY > 60) {
      navbar.classList.add("scrolled");
      sidebar.classList.add("hidden");
    } else {
      navbar.classList.remove("scrolled");
      sidebar.classList.remove("hidden");
      sidebar.classList.remove("active");
      sidebar.classList.add("compact");
    }
  });

  // Dropdown User
  const userBtn = document.getElementById('userBtn');
  const userDropdown = document.getElementById('userDropdown');
  if (userBtn && userDropdown) {
    userBtn.addEventListener('click', e => { e.stopPropagation(); userDropdown.classList.toggle('show'); });
    document.addEventListener('click', () => userDropdown.classList.remove('show'));
  }
});
</script>
