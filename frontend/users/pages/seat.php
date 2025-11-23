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
const seatMap = document.getElementById("seatMap");
const seatSummary = document.getElementById("seatSummary");
let selectedSeats = JSON.parse(localStorage.getItem('selectedSeats') || '[]');

async function loadSeats() {
  const params = new URLSearchParams(window.location.search);
  const eventId = params.get('event_id');
  
  if (!eventId) return alert("Không có ID sự kiện.");

  try {
    const res = await fetch(`/PR_RESERVATION_FnB_FOR_LIVEMUSIC/api_gateway/index.php?service=reservation&action=get_seat_layout&event_id=${eventId}`);
    const json = await res.json();

    if (!json.success) {
        seatMap.innerHTML = `<div style="padding:20px; text-align:center;">${json.message || 'Chưa có dữ liệu ghế'}</div>`;
        return;
    }

    renderSeats(json.data);
    renderSummary();

  } catch (error) {
    console.error(error);
    alert("Lỗi kết nối server.");
  }
}

function renderSeats(layout) {
  seatMap.innerHTML = layout.map(row => {
    return `
      <div class="seat-row">
        <span class="row-label">${row.row}</span>
        ${row.seats.map(seat => {
          const isSelected = selectedSeats.some(s => s.id === seat.id);
          return `
            <button
              class="seat ${seat.type === 'VIP' ? 'vip' : ''} ${seat.status} ${isSelected ? 'selected' : ''}"
              onclick="toggleSeat('${seat.id}', ${seat.price}, '${seat.number}')" 
              title="Ghế ${seat.number} - ${seat.type} - ${seat.price.toLocaleString()} đ"
              ${seat.status === 'reserved' ? 'disabled' : ''}
            >${seat.number}</button>
          `;
        }).join('')}
      </div>
    `}).join('');
}

function toggleSeat(id, price, number) {
  const seatBtn = event.target; 
  const existingIndex = selectedSeats.findIndex(s => s.id === id);

  if (seatBtn.disabled) return;

  if (existingIndex !== -1) {
    selectedSeats.splice(existingIndex, 1);
    seatBtn.classList.remove('selected');
  } else {
    selectedSeats.push({ id, price, number });
    seatBtn.classList.add('selected');
  }

  // Lưu vào localStorage để giữ dữ liệu khi reload
  localStorage.setItem('selectedSeats', JSON.stringify(selectedSeats));
  renderSummary();
}

function renderSummary() {
  if (selectedSeats.length === 0) {
    seatSummary.innerHTML = `
      <p style="text-align:center;color:var(--muted);">Không có chỗ ngồi nào được chọn</p>
      <p style="text-align:center;font-size:0.9rem;color:var(--muted);">Nhấp vào chỗ ngồi còn trống để chọn</p>
    `;
    return;
  }

  const totalPrice = selectedSeats.reduce((sum, s) => sum + s.price, 0);
  
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
    <div class="total"><span>Tổng</span><span>${totalPrice.toLocaleString()} đ</span></div>
    <button class="btn" onclick="goToPayment()">
      Tiếp tục
    </button>

  `;
}

// Khi load trang, render lại ghế dựa trên localStorage
loadSeats();

function goToPayment(){
  if(selectedSeats.length === 0){
      alert("Vui lòng chọn ít nhất 1 ghế.");
      return;
  }

  fetch('save_selected_seats.php', {
      method:'POST',
      headers:{'Content-Type':'application/json'},
      body: JSON.stringify(selectedSeats)
  })
  .then(res=>res.json())
  .then(data=>{
      console.log("DEBUG save_selected_seats:", data);
      if(data.success) window.location.href = 'index.php?page=payment';
      else alert("Lỗi lưu ghế");
  })
  .catch(err=>{
      console.error(err);
      alert("Lỗi server khi lưu ghế");
  });
}


</script>
