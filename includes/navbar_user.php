<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../frontend/config.php';

$userName = '';

if (!empty($_SESSION['USERNAME'])) {
    $userName = $_SESSION['USERNAME']; // Tên customer đăng nhập
} else {
    $userName = 'Khách'; 
}

$page = $_GET['page'] ?? 'home';

// Tạo tiêu đề động theo từng trang
$title = match($page) {
    'home' => 'LYZY - Trang chủ',
    'event' => 'LYZY - Sự kiện',
    'about' => 'LYZY - Giới thiệu',
    'contact' => 'LYZY - Liên hệ',
    'event_details' => 'LYZY - Chi tiết sự kiện',
    'about' => 'LYZY - Giới thiệu',
    'cart' => 'LYZY - Giỏ hàng',
    'event' => 'LYZY - Sự kiện',
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
  <link rel="stylesheet" href="../../frontend/assets/css/user_style.css">
  <link rel="stylesheet" href="https://unpkg.com/lucide-static@latest/font/lucide.css">
  
 <?php if (!in_array($page, $hideSidebarPages)): ?>
  <!-- Sidebar -->
  <aside class="sidebar" id="sidebar">
    <ul>
      <li onclick="location.href='index.php?page=home'">
        <div class="sb-icon"></div>
        <span>Trang chủ</span>
      </li>

      <li onclick="location.href='index.php?page=event'">
        <div class="sb-icon"></div>
        <span>Sự kiện</span>
      </li>

      <li onclick="location.href='index.php?page=about'">
        <div class="sb-icon"></div>
        <span>Giới thiệu</span>
      </li>

      <li onclick="location.href='index.php?page=contact'">
        <div class="sb-icon"></div>
        <span>Liên hệ</span>
      </li>
    </ul>
  </aside>
<?php endif; ?>


  <!-- Navbar -->
  <nav class="navbar" id="navbar">
    <div class="navbar-inner">
      <div class="logo" id="logo">
        <div class="logo-icon"></div>
        <span>LYZY</span>
      </div>

      <div class="nav-links">
        <a href="index.php?page=home">Home</a>
        <a href="index.php?page=event">Event</a>
        <a href="index.php?page=about">About</a>
        <a href="index.php?page=contact">Contact</a>
      </div>


      <div class="Notification">
        <a href="index.php?page=notification">
          <div class="logo-icon"></div>
        </a>
      </div>

      
      <div class="search-box" id="searchBox">
        <input type="text" placeholder="Tìm kiếm..." />
      </div>

      <div class="user">
        <button class="user-btn" id="userBtn">
          <svg xmlns="http://www.w3.org/2000/svg"
            width="22" height="22"
            fill="none" stroke="currentColor"
            stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
            class="lucide lucide-user">
            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
            <circle cx="12" cy="7" r="4"/>
          </svg>
          <span class="username"><?php echo htmlspecialchars($userName); ?></span>
        </button>

        <div class="user-dropdown" id="userDropdown">
          <a href="index.php?page=user_details">Thông tin tài khoản</a>
          <a href="pages/logout_user.php" class="logout">Đăng xuất</a>
        </div>

      </div>
    </div>
  </nav>

  <!-- Script -->
  <script>
    document.addEventListener("DOMContentLoaded", () => {
  const navbar = document.getElementById("navbar");
  const logo = document.getElementById("logo");
  const sidebar = document.getElementById("sidebar");

  if (!logo || !sidebar || !navbar) {
    console.warn("Thiếu logo, sidebar hoặc navbar");
    return;
  }

  // Mặc định sidebar thu gọn
  sidebar.classList.add("compact");

  // Scroll event
  window.addEventListener("scroll", () => {
    const scrollY = window.scrollY;

    if (scrollY > 60) {
      // Khi scroll xuống → navbar scrolled + sidebar ẩn
      navbar.classList.add("scrolled");
      sidebar.classList.add("hidden");
    } else {
      // Khi ở đầu trang → navbar bình thường + sidebar hiện và thu gọn
      navbar.classList.remove("scrolled");
      sidebar.classList.remove("hidden");
      sidebar.classList.remove("active");
      sidebar.classList.add("compact");
    }
  });

  // Click logo → toggle sidebar
  logo.addEventListener("click", () => {
    const isActive = sidebar.classList.contains("active");
    const isScrolled = navbar.classList.contains("scrolled");

    if (isScrolled) {
      // Giữa trang → bật full sidebar + navbar
      navbar.classList.remove("scrolled");
      sidebar.classList.remove("hidden", "compact");
      sidebar.classList.add("active");
    } else {
      // Toggle mở/thu gọn khi ở đầu trang
      if (isActive) {
        sidebar.classList.remove("active");
        sidebar.classList.add("compact");
      } else {
        sidebar.classList.add("active");
        sidebar.classList.remove("compact");
      }
    }
  });
});

     // Dropdown User
      const userBtn = document.getElementById('userBtn');
      const userDropdown = document.getElementById('userDropdown');

      if (userBtn && userDropdown) {
        userBtn.addEventListener('click', (e) => {
          e.stopPropagation(); // chặn lan click ra ngoài
          userDropdown.classList.toggle('show');
        });

        // Click ra ngoài thì ẩn dropdown
        document.addEventListener('click', () => {
          userDropdown.classList.remove('show');
        });
      }

  </script>
</body>
</html>
