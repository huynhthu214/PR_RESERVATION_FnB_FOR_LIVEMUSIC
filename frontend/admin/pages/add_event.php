<link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/events.css">

<main class="main-content add-event-page">
  <section class="section-header">
    <h2>Thêm sự kiện mới</h2>
    <button class="btn-back" onclick="window.location.href='index.php?page=events'">
        ← Quay lại danh sách
    </button>
  </section>

  <section class="form-section">
    <form id="add-event-form" class="event-form">
      <div class="form-group">
        <label for="band_name">Tên ban nhạc:</label>
        <input type="text" id="band_name" name="band_name" placeholder="Nhập tên ban nhạc..." required>
      </div>

      <div class="form-group">
        <label for="venue_name">Địa điểm</label>
        <input type="text" id="venue_name" name="venue_name" placeholder="Nhập địa điểm" required>
      </div>

      <div class="form-group">
        <label for="event_date">Ngày diễn:</label>
        <input type="datetime-local" id="event_date" name="event_date" required>
      </div>

      <div class="form-group">
        <label for="ticket_price">Giá vé:</label>
        <input type="number" id="ticket_price" name="ticket_price" placeholder="Nhập giá vé..." required step="5000" min="0">
      </div>

      <div class="form-group">
        <label for="status">Trạng thái:</label>
        <select id="status" name="status">
          <option value="ACTIVE">ACTIVE</option>
          <option value="INACTIVE">INACTIVE</option>
        </select>
      </div>

      <div class="form-actions">
        <button type="submit" class="btn-save">Lưu</button>
        <button type="button" class="btn-cancel" onclick="window.location.href='index.php?page=events'">Hủy</button>
      </div>
    </form>
  </section>

  <!-- Toast -->
  <div id="toast" class="toast"></div>
</main>

<script>
document.getElementById("add-event-form").addEventListener("submit", async function(e) {
  e.preventDefault();

  const band_name = document.getElementById("band_name").value.trim();
  const venue_name = document.getElementById("venue_name").value.trim();
  const event_date = document.getElementById("event_date").value.trim();
  const ticket_price = document.getElementById("ticket_price").value.trim();
  const status = document.getElementById("status").value;

  if (!band_name || !venue_name || !event_date || !ticket_price) {
    showToast("Vui lòng nhập đầy đủ thông tin!", "error");
    return;
  }

  const data = { band_name, venue_name, event_date, ticket_price, status };

  try {
    const res = await fetch('http://localhost/PR_RESERVATION_FnB_FOR_LIVEMUSIC/api_gateway/index.php?service=admin&action=add_event', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify(data)
    });

    const result = await res.json();

    if (result.success) {
      showToast("Thêm sự kiện thành công!", "success");
      setTimeout(() => window.location.href = "index.php?page=events", 1500);
    } else {
      showToast(result.message || "Thêm sự kiện thất bại!", "error");
    }
  } catch (error) {
    console.error("Lỗi:", error);
    showToast("Lỗi khi gửi yêu cầu!", "error");
  }
});

function showToast(message, type = "info") {
  const toast = document.getElementById("toast");
  toast.textContent = message;
  toast.className = `toast show ${type}`;
  setTimeout(() => { toast.className = "toast"; }, 2500);
}
</script>
