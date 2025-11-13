<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Thanh toán vé</title>
<style>
body {
  font-family: "Poppins", sans-serif;
  background: #0c0c0c;
  color: #f8f8f8;
  margin: 0;
  padding: 40px;
}

.container {
  display: grid;
  grid-template-columns: 1fr 2fr;
  gap: 2rem;
  max-width: 1100px;
  margin: auto;
}

/* Card layout */
.card {
  background: rgba(255,255,255,0.05);
  border: 1px solid rgba(218,165,32,0.2);
  border-radius: 15px;
  padding: 2rem;
  transition: all 0.3s ease;
}
.card:hover {
  border-color: gold;
  transform: scale(1.01);
  box-shadow: 0 0 15px rgba(255,215,0,0.15);
}

/* Titles */
h2 {
  color: gold;
  margin-bottom: 1rem;
}
h3 {
  color: #b87333;
  margin-bottom: 0.5rem;
}

/* Order Summary */
.summary .row {
  display: flex;
  justify-content: space-between;
  margin-bottom: 0.5rem;
  font-size: 0.95rem;
}
.summary .total {
  border-top: 1px solid rgba(218,165,32,0.3);
  padding-top: 1rem;
  font-weight: 600;
  color: gold;
  font-size: 1.1rem;
}

/* Form & Inputs */
form {
  display: grid;
  gap: 1.5rem;
}
.grid-2 {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 1rem;
}
label {
  display: block;
  font-size: 0.9rem;
  color: #b87333;
  margin-bottom: 0.3rem;
}
input, select {
  width: 100%;
  padding: 0.75rem;
  border-radius: 8px;
  border: 1px solid rgba(218,165,32,0.3);
  background: rgba(0,0,0,0.5);
  color: #fff;
  transition: all 0.3s;
}
input:focus {
  border-color: gold;
  outline: none;
  box-shadow: 0 0 10px rgba(255,215,0,0.3);
}

/* Payment Method buttons */
.payment-methods {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 1rem;
}
.method {
  padding: 1rem;
  border: 1px solid rgba(218,165,32,0.3);
  border-radius: 10px;
  background: transparent;
  color: #f8f8f8;
  font-weight: 500;
  transition: all 0.3s;
  cursor: pointer;
}
.method:hover {
  border-color: gold;
  color: gold;
  transform: scale(1.03);
}
.method.active {
  border-color: gold;
  background: linear-gradient(90deg, gold, #b87333);
  color: #000;
  font-weight: 600;
}

/* Card details */
.card-info {
  border: 1px solid rgba(218,165,32,0.3);
  border-radius: 10px;
  padding: 1rem;
  margin-top: 1rem;
  background: rgba(255,255,255,0.03);
}

/* Checkbox + Confirm */
.checkbox {
  display: flex;
  align-items: flex-start;
  gap: 0.5rem;
  font-size: 0.9rem;
}
.checkbox input {
  accent-color: gold;
  margin-top: 3px;
}
.btn {
  display: inline-block;
  width: 100%;
  padding: 1rem;
  background: linear-gradient(90deg, gold, #b87333);
  color: #000;
  font-weight: 700;
  border: none;
  border-radius: 8px;
  cursor: pointer;
  margin-top: 1rem;
  transition: all 0.3s;
}
.btn:hover {
  transform: scale(1.03);
  box-shadow: 0 0 15px rgba(255,215,0,0.3);
}

/* Responsive */
@media (max-width: 768px) {
  .container {
    grid-template-columns: 1fr;
  }
}
</style>
</head>
<body>

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
