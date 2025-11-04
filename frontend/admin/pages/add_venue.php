<link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/venues.css">

<main class="main-content add-venue-page">
  <section class="section-header">
    <h2>Thêm địa điểm mới</h2>
    <button class="btn-back" onclick="window.location.href='index.php?page=venues'">
        ← Quay lại danh sách
    </button>
  </section>

  <section class="form-section">
    <form id="add-venue-form" class="venue-form">
      <div class="form-group">
        <label for="venue_id">Mã địa điểm:</label>
        <input type="text" id="venue_id" name="venue_id" placeholder="VD: V001" required>
      </div>

      <div class="form-group">
        <label for="venue_name">Tên địa điểm:</label>
        <input type="text" id="venue_name" name="venue_name" placeholder="Nhập tên địa điểm..." required>
      </div>

      <div class="form-group">
        <label for="address">Địa chỉ:</label>
        <input type="text" id="address" name="address" placeholder="Nhập địa chỉ..." required>
      </div>

      <div class="form-group">
        <label for="capacity">Sức chứa:</label>
        <input type="number" id="capacity" name="capacity" placeholder="Nhập sức chứa..." required>
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
        <button type="button" class="btn-cancel" onclick="window.location.href='index.php?page=venues'">Hủy</button>
      </div>
    </form>
  </section>

  <!-- Toast -->
  <div id="toast" class="toast"></div>
</main>

<script>
document.getElementById("add-venue-form").addEventListener("submit", async function(e) {
  e.preventDefault();

  const venue_id = document.getElementById("venue_id").value.trim();
  const venue_name = document.getElementById("venue_name").value.trim();
  const address = document.getElementById("address").value.trim();
  const capacity = document.getElementById("capacity").value.trim();
  const status = document.getElementById("status").value;

  if (!venue_id || !venue_name || !address || !capacity) {
    showToast("Vui lòng nhập đầy đủ thông tin!", "error");
    return;
  }

  const data = { venue_id, venue_name, address, capacity, status };

  try {
    const res = await fetch('http://localhost/PR_RESERVATION_FnB_FOR_LIVEMUSIC/api_gateway/index.php?service=admin&action=add_venue', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify(data)
    });

    const result = await res.json();

    if (result.success) {
      showToast("Thêm địa điểm thành công!", "success");
      setTimeout(() => window.location.href = "index.php?page=venues", 1500);
    } else {
      showToast(result.message || "Thêm địa điểm thất bại!", "error");
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
