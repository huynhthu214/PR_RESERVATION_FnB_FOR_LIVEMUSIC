<?php
require_once __DIR__ . '/../frontend/config.php';
?>
  <link rel="stylesheet" href="../../frontend/assets/css/footer_style.css">
  <link href="https://cdn.jsdelivr.net/npm/remixicon@4.2.0/fonts/remixicon.css" rel="stylesheet">
</head>
<body>
  <footer class="user-footer">
    <div class="footer-container">
      <div class="footer-grid">
        <div class="footer-section">
          <a href="index.php?page=home" class="footer-brand">
            <div class="footer-logo">
              <img src="<?php echo BASE_URL; ?>assets/images/Logo_LYZY.png" alt="LYZY Logo" style="height:40px;">
            </div>
            <span class="footer-title">LYZY</span>
          </a>
          <p class="footer-desc">
            Nền tảng đặt vé và khám phá sự kiện âm nhạc trực tiếp hàng đầu - nơi kết nối bạn với những đêm nhạc đỉnh cao và trải nghiệm sống động nhất.
          </p>
          <div class="footer-social">
            <a href="#" class="social-btn"><i class="ri-facebook-fill"></i></a>
            <a href="#" class="social-btn"><i class="ri-instagram-line"></i></a>
            <a href="#" class="social-btn"><i class="ri-twitter-x-fill"></i></a>
            <a href="#" class="social-btn"><i class="ri-youtube-fill"></i></a>
          </div>
        </div>

        <div class="footer-section">
          <h3 class="footer-heading">Khám phá</h3>
          <ul class="footer-list">
            <li><a href="pages/event.php" class="footer-link">Sự kiện</a></li>
            <li><a href="pages/tickets.php" class="footer-link">Vé của tôi</a></li>
            <li><a href="#" class="footer-link">Nghệ sĩ & Ban nhạc</a></li>
            <li><a href="#" class="footer-link">Địa điểm biểu diễn</a></li>
          </ul>
        </div>

        <div class="footer-section">
          <h3 class="footer-heading">Hỗ trợ</h3>
          <ul class="footer-list">
            <li><a href="#" class="footer-link">Liên hệ</a></li>
            <li><a href="#" class="footer-link">Trung tâm trợ giúp</a></li>
            <li><a href="#" class="footer-link">Chính sách hoàn tiền</a></li>
            <li><a href="#" class="footer-link">Điều khoản & Chính sách</a></li>
          </ul>
        </div>
      </div>
    </div>

      <div class="footer-bottom">
        <p>&copy; <?php echo date('Y'); ?> LYZY Music. All rights reserved.</p>
      </div>
    </div>
  </footer>

</body>
</html>
