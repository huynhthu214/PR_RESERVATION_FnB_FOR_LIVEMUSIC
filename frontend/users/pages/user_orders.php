<link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/user_orders.css">

<!-- HERO -->
<section class="hero">
  <div class="hero-content">
    <h1>My Orders</h1>
    <p>Xem lại các món ăn & đồ uống bạn đã đặt</p>
  </div>
</section>

<!-- CONTAINER -->
<div class="container">

  <!-- ORDER 1 -->
  <div class="order-card">
    <div class="order-header">
      <span class="status ready">🔔 Ready to Pickup</span>
      <h3>Order #ORD001</h3>
      <p>Dec 15, 2024 - 2:30 PM</p>
    </div>
    <div class="order-body">
      <div class="order-items">
        <div class="item-row"><span>Popcorn x2</span><span>100.000đ</span></div>
        <div class="item-row"><span>Coca Cola x1</span><span>30.000đ</span></div>

        <div class="order-total">
          <span>Total</span><span>130.000đ</span>
        </div>

        <div class="pickup">
          <p style="margin-top:10px;color:#b87333;">📍 Pickup Location</p>
          <p style="font-weight:600;">Concession Stand A</p>
        </div>
      </div>

      <div class="order-side">
        <div class="qr-box">
          <div class="emoji"></div>
          <div>QR Code</div>
          <div style="font-family:monospace;">QR-ORD001</div>
        </div>
        <p style="font-size:0.8rem;color:#b87333;text-align:center;">
          Show this QR code at the pickup counter
        </p>
        <button class="btn-download">Download QR</button>
      </div>
    </div>
  </div>

  <!-- ORDER 2 -->
  <div class="order-card">
    <div class="order-header">
      <span class="status done">Completed</span>
      <h3>Order #ORD002</h3>
      <p>Dec 12, 2024 - 7:15 PM</p>
    </div>
    <div class="order-body">
      <div class="order-items">
        <div class="item-row"><span>Hot Dog x1</span><span>60.000đ</span></div>
        <div class="item-row"><span>Iced Coffee x1</span><span>50.000đ</span></div>

        <div class="order-total">
          <span>Total</span><span>110.000đ</span>
        </div>

        <div class="pickup">
          <p style="margin-top:10px;color:#b87333;">📍 Pickup Location</p>
          <p style="font-weight:600;">Concession Stand B</p>
        </div>
      </div>

      <div class="order-side">
        <div class="done-box">
          <div class="emoji"></div>
          <p class="text-green">Order Completed</p>
          <p style="color:#b87333;">Enjoy your meal!</p>
        </div>
      </div>
    </div>
  </div>

</div>

</body>
</html>
