<?php
require_once __DIR__ . '/../../config.php';
?>

<main class="main-content add-event-page">
  <section class="section-header">
      <h2>Thêm sự kiện mới</h2>
      <a href="index.php?page=events" class="btn-back">← Quay lại</a>
  </section>

  <section class="form-section">
      <form id="addEventForm" class="event-form">
          <label>Ban nhạc:</label>
          <input type="text" name="band_name" required>

          <label>ID địa điểm:</label>
          <input type="text" name="venue_id" required>

          <label>Ngày diễn:</label>
          <input type="datetime-local" name="event_date" required>

          <label>Giá vé:</label>
          <input type="number" name="ticket_price" required>

          <label>Trạng thái:</label>
          <select name="status">
              <option value="ACTIVE">ACTIVE</option>
              <option value="INACTIVE">INACTIVE</option>
          </select>

          <button type="submit" class="btn-save">Lưu</button>
      </form>
  </section>

  <script>
  document.getElementById('addEventForm').addEventListener('submit', async (e) => {
      e.preventDefault();
      const formData = new FormData(e.target);
      const payload = Object.fromEntries(formData.entries());

      try {
          const res = await fetch(
              'http://localhost/PR_RESERVATION_FnB_FOR_LIVEMUSIC/api_gateway/index.php?service=admin&action=add_event',
              {
                  method: 'POST',
                  headers: { 'Content-Type': 'application/json' },
                  body: JSON.stringify(payload)
              }
          );
          const data = await res.json();
          if (data.success) {
              alert('Thêm sự kiện thành công!');
              window.location.href = "index.php?page=events";
          } else {
              alert('Thêm sự kiện thất bại: ' + (data.error || 'Lỗi không xác định.'));
          }
      } catch (err) {
          console.error(err);
          alert('Có lỗi xảy ra khi gửi dữ liệu.');
      }
  });
  </script>
</main>
