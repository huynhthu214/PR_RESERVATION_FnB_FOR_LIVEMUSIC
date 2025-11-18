<?php
require_once __DIR__ . '/../../config.php'; // BASE_URL, DB
?>

<link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/seat.css">

<div class="container">
  <a href="#" class="back-link" onclick="history.back()">← Quay lại</a>

  <div class="grid">
    <!-- Seat Selection -->
    <div>
      <div class="card">
        <h2>Chọn chỗ ngồi</h2>

        <div class="legend">
          <div><div class="legend-box" style="background:var(--card);"></div> Trống</div>
          <div><div class="legend-box" style="background:rgba(212,175,55,0.1);border-color:var(--primary);"></div> VIP</div>
          <div><div class="legend-box" style="background:var(--primary);"></div> Đã chọn</div>
          <div><div class="legend-box" style="background:var(--border);"></div> Đã đặt</div>
        </div>

        <div class="stage">SÂN KHẤU</div>
        <div id="seatMap"></div>
      </div>
    </div>

    <!-- Summary -->
    <div>
      <div class="card summary">
        <h3>Tóm Tắt Đặt Vé</h3>
        <div id="seatSummary"></div>
        <div class="hint">
          ✓ Giữ chỗ trong 10 phút<br>
          ✓ Quy trình thanh toán an toàn<br>
          ✓ Xác nhận vé ngay
        </div>
      </div>
    </div>
  </div>
</div>

<script>
// Giữ nguyên tên biến toàn cục của bạn
const seatMap = document.getElementById("seatMap");
const seatSummary = document.getElementById("seatSummary");
let selectedSeats = [];

async function loadSeats() {
  const params = new URLSearchParams(window.location.search);
  // Hỗ trợ lấy cả id hoặc event_id từ URL
  const eventId = params.get('event_id') || params.get('id'); 
  
  if (!eventId) return alert("Không có ID sự kiện.");

  try {
    // GỌI API MỚI: API này trả về luôn cấu trúc 'layout' mà renderSeats cần
    // Đảm bảo đường dẫn trỏ đúng vào file PHP vừa tạo ở Bước 1
    const res = await fetch(`/PR_RESERVATION_FnB_FOR_LIVEMUSIC/api_gateway/index.php?service=admin&action=get_seat_layout?id=${eventId}`);
    const json = await res.json();

    if (!json.success) {
        // Xử lý nếu không có dữ liệu hoặc lỗi
        seatMap.innerHTML = `<div style="padding:20px; text-align:center;">${json.message || 'Chưa có dữ liệu ghế'}</div>`;
        return;
    }

    // json.data chính là biến 'layout' (mảng các row)
    renderSeats(json.data);
    renderSummary();

  } catch (error) {
    console.error(error);
    alert("Lỗi kết nối server.");
  }
}

// Hàm này GIỮ NGUYÊN logic và tên class của bạn
function renderSeats(layout) {
  seatMap.innerHTML = layout.map(row => {
    return `
      <div class="seat-row">
        <span class="row-label">${row.row}</span>
        ${row.seats.map(seat => `
          <button
            class="seat ${seat.type === 'VIP' ? 'vip' : ''} ${seat.status}"
            onclick="toggleSeat('${seat.id}', ${seat.price}, '${seat.number}')" 
            title="Ghế ${seat.number} - ${seat.type} - ${seat.price.toLocaleString()} đ"
            ${seat.status === 'reserved' ? 'disabled' : ''}
          >${seat.number}</button>
        `).join('')}
      </div>
    `}).join('');
}

// Cập nhật nhẹ hàm toggleSeat để nhận thêm giá (price) và số ghế (number) từ onclick
// Vì khi load từ API, ta truyền giá trị vào hàm này luôn cho tiện
function toggleSeat(id, price, number) {
  // Tìm button đang được click (dựa vào event) hoặc query lại DOM
  // Ở đây dùng cách đơn giản: tìm trong mảng selectedSeats xem có chưa
  
  // Logic này giữ nguyên style code của bạn
  // Tuy nhiên, để lấy đúng element button nhằm add class 'selected', ta cần cẩn thận:
  // Cách tốt nhất là truyền 'this' vào onclick, nhưng để giữ nguyên HTML string:
  // Ta sẽ tìm button dựa trên attribute title hoặc text content, hoặc dùng event.target
  
  // SỬA LẠI CÁCH TÌM ELEMENT CHO CHÍNH XÁC HƠN CODE CŨ:
  // Code cũ: seatMap.querySelector(`button[title^="${id}"]`) -> Có thể lỗi nếu title thay đổi
  // Code mới dùng event.target (đối tượng được click)
  const seatBtn = event.target; 

  const existingIndex = selectedSeats.findIndex(s => s.id === id);

  if (seatBtn.disabled) return;

  if (existingIndex !== -1) {
    // Nếu đã có -> Xóa
    selectedSeats.splice(existingIndex, 1);
    seatBtn.classList.remove('selected');
  } else {
    // Nếu chưa có -> Thêm
    selectedSeats.push({ id: id, price: price, number: number });
    seatBtn.classList.add('selected');
  }
  renderSummary();
}

// Hàm này GIỮ NGUYÊN logic
function renderSummary() {
  if (selectedSeats.length === 0) {
    seatSummary.innerHTML = `
      <p style="text-align:center;color:var(--muted);">Không có chỗ ngồi nào được chọn</p>
      <p style="text-align:center;font-size:0.9rem;color:var(--muted);">Nhấp vào chỗ ngồi còn trống để chọn</p>
    `;
    return;
  }

  const totalPrice = selectedSeats.reduce((sum, s) => sum + s.price, 0);
  
  // Format lại hiển thị tiền cho đẹp (toLocaleString)
  seatSummary.innerHTML = `
    <div class="seat-list">
      ${selectedSeats.map(s => `
        <div class="seat-item">
          <div>Ghế ${s.number} <small>(${s.id})</small></div>
          <div>${s.price.toLocaleString()} đ</div>
        </div>
      `).join('')}
    </div>
    <div style="margin-top:0.5rem;display:flex;justify-content:space-between;font-size:0.9rem;color:var(--muted);">
      <span>Vị trí (${selectedSeats.length})</span><span>${totalPrice.toLocaleString()} đ</span>
    </div>
    <div class="total"><span>Total</span><span>${totalPrice.toLocaleString()} đ</span></div>
    <button class="btn">Tiếp tục đến Đồ ăn & Đồ uống</button>
  `;
}

loadSeats();
</script>
