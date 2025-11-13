<link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/payment_user.css">
<div class="container">
  <!-- Order Summary -->
  <div class="card summary">
    <h2>Tóm tắt đơn hàng</h2>
    <h3>Electronic Night Vibes</h3>
    <p>DJ Pulse & The Synthwave</p>
    <p style="color:#aaa;">15/12/2024 - 20:00 | The Neon Arena, Downtown</p>

    <div class="row"><span>VIP Ticket x 2</span><span>$90.00</span></div>
    <div class="row"><span>Phí dịch vụ</span><span>$9.00</span></div>
    <div class="total row"><span>Tổng cộng</span><span>$99.00</span></div>
  </div>

  <!-- Payment Section -->
  <div class="card">
    <h2>Thông tin thanh toán</h2>

    <form>
      <div class="grid-2">
        <div>
          <label>Họ và tên</label>
          <input type="text" placeholder="Nguyễn Văn A">
        </div>
        <div>
          <label>Email</label>
          <input type="email" placeholder="nguyenvana@example.com">
        </div>
      </div>

      <div class="grid-2">
        <div>
          <label>Số điện thoại</label>
          <input type="tel" placeholder="+84 123 456 789">
        </div>
        <div>
          <label>CMND / CCCD</label>
          <input type="text" placeholder="0123456789">
        </div>
      </div>

      <h3>Phương thức thanh toán</h3>
      <div class="payment-methods">
        <button type="button" class="method active">💳 Thẻ ngân hàng</button>
        <button type="button" class="method">🏦 Chuyển khoản</button>
        <button type="button" class="method">📱 Ví MoMo</button>
        <button type="button" class="method">🔳 Mã QR</button>
      </div>

      <div class="card-info">
        <div class="grid-2">
          <div>
            <label>Số thẻ</label>
            <input type="text" placeholder="1234 5678 9012 3456">
          </div>
          <div>
            <label>Tên chủ thẻ</label>
            <input type="text" placeholder="NGUYEN VAN A">
          </div>
        </div>
        <div class="grid-2">
          <div>
            <label>Ngày hết hạn</label>
            <input type="text" placeholder="MM/YY">
          </div>
          <div>
            <label>CVV</label>
            <input type="text" placeholder="123">
          </div>
        </div>
      </div>

      <div class="checkbox">
        <input type="checkbox" id="agree">
        <label for="agree">
          Tôi đồng ý với <a href="#" style="color:gold;">Điều khoản dịch vụ</a> và <a href="#" style="color:gold;">Chính sách bảo mật</a>.
        </label>
      </div>

      <button class="btn">Xác nhận thanh toán - $99.00</button>
      <p style="text-align:center;color:#888;font-size:0.8rem;margin-top:0.5rem;">
        Thông tin thanh toán của bạn được mã hóa và bảo mật tuyệt đối.
      </p>
    </form>
  </div>
</div>

</body>
</html>
