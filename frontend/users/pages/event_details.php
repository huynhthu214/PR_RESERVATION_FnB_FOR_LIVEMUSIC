<?php
// event_details.php
?>
<link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/event_details.css">

<div class="hero">
  <img src="https://images.unsplash.com/photo-1470229722913-7c0e2dbbafd3?q=80&w=2070" alt="Sự kiện trực tiếp">
</div>

<div class="container">
  <div class="grid">
    <div>
      <div class="card">
        <div class="card-content">

          <h1>...</h1>

          <div class="details-grid">
            <div class="detail-item">
              <div>
                <p class="detail-label">Ngày</p>
                <p>...</p>
              </div>
            </div>

            <div class="detail-item">
              <div>
                <p class="detail-label">Thời gian</p>
                <p>...</p>
              </div>
            </div>

            <div class="detail-item">
              <div>
                <p class="detail-label">Địa điểm</p>
                <p>...</p>
                <p class="detail-label">Địa chỉ</p>
              </div>
            </div>

            <div class="detail-item">
              <div>
                <p class="detail-label">Sức chứa</p>
                <p>...</p>
              </div>
            </div>
          </div>

          <div>
            <h2>Giới thiệu về sự kiện</h2>
            <p>...</p>
          </div>
        </div>
      </div>

      <div class="card" style="margin-top:1.5rem;">
        <div class="card-content">
          <h2>Nghệ sĩ và ban nhạc</h2>
          <p>...</p>
        </div>
      </div>
    </div>

    <div>
      <div class="booking-card">
        <div class="price">
          <p style="color:var(--muted);font-size: 20px; font-weight: bold;">Chỉ từ</p>
          <h3>...</h3>
          <p style="color:var(--muted);font-size: 20px; font-weight: bold;">mỗi vé</p>
        </div>

        <button class="button button-primary">
          Chọn chỗ ngồi
        </button>

        <div class="booking-info">
          ✓ Xác nhận vé ngay<br>
          ✓ Xử lý thanh toán an toàn<br>
          ✓ Truy cập vé trên thiết bị di động<br>
          ✓ Hỗ trợ khách hàng 24/7
        </div>
      </div>
    </div>
  </div>
</div>

<script>
async function loadEventDetail() {
    const params = new URLSearchParams(window.location.search);
    const eventId = params.get('id');

    if (!eventId) {
        document.body.innerHTML = `
            <div style="text-align:center;margin-top:50px;">
                <h2>Không có ID sự kiện</h2>
                <p>Vui lòng truy cập trang từ danh sách sự kiện.</p>
                <a href="event_user.php" style="text-decoration:none;color:blue;">Quay lại danh sách sự kiện</a>
            </div>
        `;
        return;
    }

    try {
        const res = await fetch('/PR_RESERVATION_FnB_FOR_LIVEMUSIC/api_gateway/index.php?service=admin&action=get_events');
        const json = await res.json();

        if (!json.success) {
            document.body.innerHTML = `
                <div style="text-align:center;margin-top:50px;">
                    <h2>Lỗi khi tải dữ liệu sự kiện</h2>
                    <p>${json.error || ''}</p>
                </div>
            `;
            return;
        }

        const event = json.data.find(ev => ev.id === eventId);
        if (!event) {
            document.body.innerHTML = `
                <div style="text-align:center;margin-top:50px;">
                    <h2>Event không tồn tại</h2>
                    <p>ID: ${eventId} không tìm thấy trong hệ thống.</p>
                    <a href="event.php" style="text-decoration:none;color:blue;">Quay lại danh sách sự kiện</a>
                </div>
            `;
            return;
        }

        // Hero image
        document.querySelector('.hero img').src = event.image_url;
        document.querySelector('.hero img').alt = event.band;

        // Event Info
        document.querySelector('.card h1').textContent = event.band;

        // Details Grid
        const detailItems = document.querySelectorAll('.details-grid .detail-item');

        // Date
        const eventDate = new Date(event.date);
        const dateStr = eventDate.toLocaleDateString('vi-VN', { weekday:'long', year:'numeric', month:'long', day:'numeric' });
        detailItems[0].querySelectorAll('p')[1].textContent = dateStr;

        // Time
        const startTime = new Date(event.start_time).toLocaleTimeString('vi-VN', { hour: '2-digit', minute: '2-digit' });
        const endTime = new Date(event.end_time).toLocaleTimeString('vi-VN', { hour: '2-digit', minute: '2-digit' });
        detailItems[1].querySelectorAll('p')[1].textContent = `${startTime} - ${endTime}`;

        // Venue
        detailItems[2].querySelectorAll('p')[1].textContent = event.venue_name || 'Unknown Venue';
        detailItems[2].querySelectorAll('p')[2].textContent = event.venue_address || '';

        // Capacity
        detailItems[3].querySelectorAll('p')[1].textContent = event.capacity ? `${event.capacity} people` : 'N/A';

        // About event
        document.querySelectorAll('.card h2')[0].nextElementSibling.textContent = event.description || "Không có mô tả chi tiết";

        // About artist (Đã dùng layout ngang như bạn yêu cầu)
        const artistCard = document.querySelectorAll('.card h2')[1].nextElementSibling;
        artistCard.outerHTML = `
            <div style="display: flex; gap: 20px; align-items: flex-start; margin-top: 1rem;">
                <img src="${event.img_artist}" alt="${event.artist_name}" 
                     style="width: 140px; height: 140px; object-fit: cover; border-radius: 8px; flex-shrink: 0;">
                
                <div>
                    <p style="margin-bottom: 8px; font-size: 1.1rem; color: var(--muted);">
                        <strong>Nghệ sĩ:</strong> ${event.artist_name}
                    </p>
                    <p style="margin: 0; color: var(--muted);">
                        <strong>Ban nhạc:</strong> ${event.band}
                    </p>
                </div>
            </div>
        `;

        // Booking price
        document.querySelector('.booking-card h3').textContent = `${Number(event.price).toLocaleString()} VND`;

    const bookingBtn = document.querySelector('.booking-card .button-primary');
        if(bookingBtn) {
          bookingBtn.onclick = function() {
              window.location.href = `index.php?page=seat&event_id=${encodeURIComponent(eventId)}`;
          }
        }

    } catch (err) {
        document.body.innerHTML = `
            <div style="text-align:center;margin-top:50px;">
                <h2>Lỗi khi tải dữ liệu</h2>
                <p>${err.message}</p>
            </div>
        `;
    }
}

loadEventDetail();
</script>