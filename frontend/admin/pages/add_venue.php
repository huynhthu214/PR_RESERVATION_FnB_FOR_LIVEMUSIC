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
        <label for="venue_name">Tên địa điểm:</label>
        <input type="text" id="venue_name" name="venue_name" placeholder="Nhập tên địa điểm..." required>
      </div>

      <div class="form-group">
        <label for="address">Địa chỉ:</label>
        <input type="text" id="address" name="address" placeholder="Nhập địa chỉ..." required>
      </div>

      <div class="form-group">
        <label for="capacity">Sức chứa:</label>
        <input type="number" id="capacity" name="capacity" placeholder="Nhập sức chứa..." required step="1" min="0">
      </div>

    <div class="form-group file-group">
      <label for="seat_layout">Sơ đồ chỗ ngồi:</label>
      <div class="file-input-wrapper">
        <input type="text" id="seat_layout_text" placeholder="Chọn tệp..." readonly>
        <button type="button" id="seat_layout_btn">Chọn tệp</button>
        <input type="file" id="seat_layout" name="seat_layout" accept=".json" hidden>
      </div>
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

// ===== xử lý nút chọn file =====
const fileInput = document.getElementById('seat_layout');
const fileBtn = document.getElementById('seat_layout_btn');
const fileText = document.getElementById('seat_layout_text');

fileBtn.addEventListener('click', () => fileInput.click());
fileInput.addEventListener('change', () => {
    fileText.value = fileInput.files[0] ? fileInput.files[0].name : '';
});

// ===== xử lý submit form =====
document.getElementById("add-venue-form").addEventListener("submit", async function(e) {
  e.preventDefault();

  const formData = new FormData();
  formData.append("venue_name", document.getElementById("venue_name").value.trim());
  formData.append("address", document.getElementById("address").value.trim());
  formData.append("capacity", document.getElementById("capacity").value);

  const file = fileInput.files[0];
  if (file) formData.append("seat_layout", file);

  try {
    const res = await fetch("http://localhost/PR_RESERVATION_FnB_FOR_LIVEMUSIC/api_gateway/index.php?service=admin&action=add_venue", {
      method: "POST",
      body: formData
    });

    const result = await res.json();
    if (result.success) {
      showToast("Thêm địa điểm thành công!", "success");
      setTimeout(() => window.location.href = "index.php?page=venues", 1500);
    } else {
      showToast(result.message || "Thêm địa điểm thất bại!", "error");
    }
  } catch (err) {
    console.error(err);
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
