<?php
require_once __DIR__ . '/../../config.php'; // session đã được start trong config.php

// Lấy dữ liệu ghế và menu từ session, mặc định array rỗng nếu chưa có
$selectedSeats = $_SESSION['selectedSeats'] ?? [];
$orderMenu     = $_SESSION['order_menu'] ?? [];

// Tính tổng tiền
$totalSeatPrice = array_sum(array_column($selectedSeats, 'price'));
$totalMenuPrice = array_sum(array_map(fn($m)=>$m['price']*$m['quantity'], $orderMenu));
$total          = $totalSeatPrice + $totalMenuPrice;

// Thông tin user login
$userName   = $_SESSION['USERNAME'] ?? '';
$customerId = $_SESSION['CUSTOMER_ID'] ?? '';
$email      = $_SESSION['USER_EMAIL'] ?? '';
?>

<link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/payment_user.css">

<div class="container">

  <!-- Order Summary -->
  <div class="card summary">
    <h2>Tóm tắt đơn hàng</h2>

    <div id="order-items">
      <!-- Seat Items -->
      <?php if(!empty($selectedSeats)): ?>
        <h3>Ghế</h3>
        <?php foreach($selectedSeats as $seat): ?>
          <div class="order-item seat-item" 
               data-id="<?php echo $seat['id']; ?>" 
               data-price="<?php echo $seat['price']; ?>" 
               data-quantity="1">
            <span class="item-name">Ghế <?php echo $seat['number']; ?> (<?php echo $seat['type'] ?? 'Standard'; ?>)</span>
            <span class="item-price"><?php echo number_format($seat['price']); ?>đ</span>
          </div>
        <?php endforeach; ?>
      <?php else: ?>
        <p>Chưa chọn ghế.</p>
      <?php endif; ?>

      <!-- Menu Items -->
      <h3>Đồ uống / Food</h3>
      <?php if(!empty($orderMenu)): ?>
        <?php foreach($orderMenu as $item): ?>
        <div class="order-item menu-item" 
             data-id="<?php echo $item['item_id']; ?>" 
             data-price="<?php echo $item['price']; ?>" 
             data-quantity="<?php echo $item['quantity']; ?>">
          <span class="item-name"><?php echo $item['name']; ?> x <?php echo $item['quantity']; ?></span>
          <span class="item-price"><?php echo number_format($item['price'] * $item['quantity']); ?>đ</span>
        </div>
        <?php endforeach; ?>
      <?php else: ?>
        <p>Chưa chọn đồ uống.</p>
      <?php endif; ?>
    </div>

    <div class="total row">
      <span>Tổng cộng</span>
      <span id="total-price"><?php echo number_format($total); ?>đ</span>
    </div>
  </div>

  <!-- Payment Section -->
  <div class="card">
    <h2>Thông tin thanh toán</h2>
    <form id="payment-form">
      <div class="grid-2">
        <div>
          <label>Họ và tên</label>
          <input type="text" name="name" value="<?php echo htmlspecialchars($userName); ?>" required>
        </div>
        <div>
          <label>Email</label>
          <input type="email" name="email" value="<?php echo htmlspecialchars($email); ?>" required>
        </div>
      </div>

      <h3>Phương thức thanh toán</h3>
      <div class="payment-methods">
        <button type="button" class="method active">💳 Thẻ ngân hàng</button>
        <button type="button" class="method">🏦 Chuyển khoản</button>
        <button type="button" class="method">📱 Ví MoMo</button>
        <button type="button" class="method">🔳 Mã QR</button>
      </div>

      <div class="checkbox">
        <input type="checkbox" id="agree" required>
        <label for="agree">
          Tôi đồng ý với <a href="#" style="color:gold;">Điều khoản dịch vụ</a> và <a href="#" style="color:gold;">Chính sách bảo mật</a>.
        </label>
      </div>

      <button type="submit" class="btn" id="confirm-btn">Xác nhận thanh toán</button>
    </form>
  </div>
</div>

<script>
// Debug dữ liệu từ PHP
console.log("DEBUG selectedSeats:", <?php echo json_encode($selectedSeats); ?>);
console.log("DEBUG orderMenu:", <?php echo json_encode($orderMenu); ?>);

// Cập nhật tổng tiền
function updateTotal() {
  const items = document.querySelectorAll('.order-item');
  let total = 0;
  items.forEach(item=>{
    const price = parseInt(item.dataset.price);
    const quantity = parseInt(item.dataset.quantity ?? 1);
    total += price * quantity;
  });
  document.getElementById('total-price').textContent = total.toLocaleString() + 'đ';
}
updateTotal();

// Chọn phương thức thanh toán
document.querySelectorAll('.payment-methods .method').forEach(btn=>{
  btn.addEventListener('click', ()=>{
    document.querySelector('.payment-methods .method.active').classList.remove('active');
    btn.classList.add('active');
  });
});

// Gửi đơn hàng
document.getElementById('payment-form').addEventListener('submit', async e=>{
  e.preventDefault();

  const name = e.target.name.value.trim();
  const email = e.target.email.value.trim();
  const paymentMethod = document.querySelector('.payment-methods .method.active').textContent;

  const seats = Array.from(document.querySelectorAll('.seat-item')).map(s=>({
    id: s.dataset.id,
    price: parseInt(s.dataset.price)
  }));

  const menu = Array.from(document.querySelectorAll('.menu-item')).map(m=>({
    item_id: m.dataset.id,
    quantity: parseInt(m.dataset.quantity),
    unit_price: parseInt(m.dataset.price)
  }));

  console.log("DEBUG submitting seats:", seats);
  console.log("DEBUG submitting menu:", menu);

  const total = seats.reduce((sum,s)=>sum+s.price,0) + menu.reduce((sum,m)=>sum+m.unit_price*m.quantity,0);

  try{
    const res = await fetch('/PR_RESERVATION_FnB_FOR_LIVEMUSIC/api_gateway/index.php?service=order&action=add_order', {
      method:'POST',
      headers:{'Content-Type':'application/json'},
      body: JSON.stringify({name,email,paymentMethod,seats,menu,total})
    });

    const data = await res.json();
    console.log("DEBUG add_order response:", data);

    if(data.success){
      alert('Thanh toán thành công! Mã đơn: ' + data.order_id);
      window.location.href='index.php?page=receipt&order_id='+data.order_id;
    } else {
      alert(data.message || 'Lỗi thanh toán');
    }
  } catch(err){
    console.error(err);
    alert('Lỗi server, vui lòng thử lại.');
  }
});
</script>
