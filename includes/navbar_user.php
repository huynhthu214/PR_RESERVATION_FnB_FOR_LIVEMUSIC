<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>LYZY</title>
  <link rel="stylesheet" href="../frontend/assets/css/user_style.css">
  <link rel="stylesheet" href="https://unpkg.com/lucide-static@latest/font/lucide.css">
</head>
<body>
  <!-- Sidebar -->
  <aside class="sidebar compact" id="sidebar">
    <ul>
      <li>
        <div class="sb-icon"></div>
        <span>Trang chủ</span>
      </li>
      <li>
        <div class="sb-icon"></div>
        <span>Sự kiện</span>
      </li>
      <li>
        <div class="sb-icon"></div>
        <span>Giới thiệu</span>
      </li>
      <li>
        <div class="sb-icon"></div>
        <span>Liên hệ</span>
      </li>
    </ul>
  </aside>

  <!-- Navbar -->
  <nav class="navbar" id="navbar">
    <div class="navbar-inner">
      <div class="logo" id="logo">
        <div class="logo-icon"></div>
        <span>LYZY</span>
      </div>

      <div class="nav-links">
        <a href="#">Home</a>
        <a href="#">Event</a>
        <a href="#">About</a>
        <a href="#">Contact</a>
      </div>

      <div class="Notification">
        <div class="logo-icon"></div>
      </div>
      
      <div class="search-box" id="searchBox">
        <input type="text" placeholder="Tìm kiếm..." />
      </div>

      <div class="user">
        <a href="my-tickets.php" class="user-btn" title="Vé của tôi">
          <svg xmlns="http://www.w3.org/2000/svg"
            width="22" height="22"
            fill="none" stroke="currentColor"
            stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
            class="lucide lucide-user">
            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
            <circle cx="12" cy="7" r="4"/>
          </svg>
          <span>User</span>
        </a>
      </div>
    </div>
  </nav>

  <!-- Script -->
  <script>
    const navbar = document.getElementById("navbar");
    const logo = document.getElementById("logo");
    const sidebar = document.getElementById("sidebar");

    if (logo && sidebar) {
      let lastScrollY = 0;

      // Hàm thu gọn sidebar
      const collapseSidebar = () => {
        sidebar.classList.remove("active");
        sidebar.classList.add("compact");
      };

      // Cuộn trang
      window.addEventListener("scroll", () => {
        const currentScrollY = window.scrollY;

        if (currentScrollY > 60) {
          navbar.classList.add("scrolled");
          sidebar.classList.add("hidden"); // ẩn khi cuộn
        } else {
          navbar.classList.remove("scrolled");
          sidebar.classList.remove("hidden");

          // Nếu đang ở đầu trang → sidebar tự thu gọn
          collapseSidebar();
        }

        lastScrollY = currentScrollY;
      });

      // Click logo
      logo.addEventListener("click", () => {
        const isActive = sidebar.classList.contains("active");
        const isScrolled = navbar.classList.contains("scrolled");

        if (isScrolled) {
          // Khi đang giữa trang → bật lại full sidebar + full navbar
          navbar.classList.remove("scrolled");
          sidebar.classList.remove("hidden", "compact");
          sidebar.classList.add("active");
        } else {
          // Khi ở đầu trang → toggle mở/đóng
          sidebar.classList.toggle("active", !isActive);
          sidebar.classList.toggle("compact", isActive);
        }
      });
    } else {
      console.warn('Thiếu logo hoặc sidebar (id="logo" hoặc id="sidebar").');
    }
  </script>
</body>
</html>
