<?php
require_once __DIR__ . '/../../config.php';
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
let selectedSeats = []; 
let basePrice = 0; // Giá cơ bản của event

async function loadSeats() {
  const params = new URLSearchParams(window.location.search);
  const eventId = params.get('event_id');
  if (!eventId) return alert("Không có ID sự kiện.");

  try {
    // Lấy layout ghế
    const resSeat = await fetch(`/PR_RESERVATION_FnB_FOR_LIVEMUSIC/api_gateway/index.php?service=reservation&action=get_seat_layout&event_id=${eventId}`);
    const seatJson = await resSeat.json();
    if (!seatJson.success) {
      seatMap.innerHTML = `<div style="padding:20px;text-align:center;">${seatJson.message || 'Chưa có dữ liệu ghế'}</div>`;
      return;
    }

    // Lấy thông tin event để có giá cơ bản
    const resEvent = await fetch(`/PR_RESERVATION_FnB_FOR_LIVEMUSIC/api_gateway/index.php?service=admin&action=get_events`);
    const eventJson = await resEvent.json();
    if(eventJson.success){
        const event = eventJson.data.find(ev => ev.id === eventId);
        if(event) basePrice = Number(event.price);
    }

    renderSeats(seatJson.data);
    renderSummary();
    updateEventPrice();

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
              class="seat ${seat.type === 'VIP' ? 'vip' : 'standard'} ${seat.status} ${isSelected ? 'selected' : ''}"
              onclick="toggleSeat('${seat.id}', ${seat.price}, '${row.row}', '${seat.number}', '${seat.type}')"
              title="${row.row}${seat.number} - ${seat.type} - ${seat.price.toLocaleString()} đ"
              ${seat.status === 'reserved' ? 'disabled' : ''}
            >${seat.number}</button>
          `;
        }).join('')}
      </div>
    `;
  }).join('');
}

function toggleSeat(id, price, rowLetter, number, type){
  const seatBtn = event.target;
  const existingIndex = selectedSeats.findIndex(s => s.id === id);

  if(seatBtn.disabled) return;

  if(existingIndex !== -1){
    selectedSeats.splice(existingIndex, 1);
    seatBtn.classList.remove('selected');
  } else {
    selectedSeats.push({ 
      id, 
      price, 
      number: `${rowLetter}${number}`,  // Ghép row + number
      type: type                        // Lưu loại ghế
    });
    seatBtn.classList.add('selected');
  }

  localStorage.setItem('selectedSeats', JSON.stringify(selectedSeats));
  renderSummary();
  updateEventPrice();
}

function renderSummary(){
  if(selectedSeats.length === 0){
    seatSummary.innerHTML = `
      <p style="text-align:center;color:var(--muted);">Không có chỗ ngồi nào được chọn</p>
      <p style="text-align:center;font-size:0.9rem;color:var(--muted);">Nhấp vào chỗ ngồi còn trống để chọn</p>
    `;
    return;
  }

  const totalPrice = selectedSeats.reduce((sum,s)=> sum + s.price, 0);

  seatSummary.innerHTML = `
    <div class="seat-list">
      ${selectedSeats.map(s=>`
        <div class="seat-item">
          <div> ${s.number} (${s.type})</div>
          <div>${s.price.toLocaleString()} đ</div>
        </div>
      `).join('')}
    </div>
    <div style="margin-top:0.5rem; display:flex; justify-content:space-between; font-size:0.9rem; color:var(--muted);">
      <span>Vị trí (${selectedSeats.length})</span>
      <span>${totalPrice.toLocaleString()} đ</span>
    </div>
    <div class="total"><span>Tổng</span><span>${totalPrice.toLocaleString()} đ</span></div>
    <button class="btn" onclick="goToOrder()">Tiếp tục</button>
  `;
}

// Cập nhật giá tổng lên event detail nếu có
function updateEventPrice(){
  const priceEl = document.getElementById('eventPrice');
  if(!priceEl) return;
  const totalPrice = selectedSeats.reduce((sum,s)=> sum + s.price, 0);
  priceEl.textContent = `${totalPrice.toLocaleString()} đ`;
}

// Khi click "Tiếp tục"
function goToOrder(){
  if(selectedSeats.length === 0){
      alert("Vui lòng chọn ít nhất 1 ghế.");
      return;
  }

  fetch('/PR_RESERVATION_FnB_FOR_LIVEMUSIC/api_gateway/index.php?service=order&action=save_selected_seats', {
      method: 'POST',
      headers: {'Content-Type': 'application/json'},
      body: JSON.stringify({ seats: selectedSeats })
  })
  .then(res => res.json())
  .then(data => {
      if(data.success){
          window.location.href = 'index.php?page=order';
      } else {
          alert("Lỗi lưu ghế: " + (data.message || 'Không xác định'));
      }
  })
  .catch(err => {
      console.error(err);
      alert("Lỗi kết nối server khi lưu ghế");
  });
}

// Load ghế khi mở trang
loadSeats();
</script>

