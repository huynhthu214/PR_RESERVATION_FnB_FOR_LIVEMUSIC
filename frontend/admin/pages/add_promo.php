<link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/promotion.css">

<main class="main-content add-promotion-page">
  <section class="section-header">
    <h2>Thêm khuyến mãi mới</h2>
    <button class="btn-back" onclick="window.location.href='index.php?page=promotion'">
        ← Quay lại danh sách
    </button>
  </section>

  <section class="form-section">
    <form id="add-promotion-form" class="promotion-form">
      <div class="form-group">
      <label for="promo_code">Mã khuyến mãi:</label>
      <input type="text" id="promo_code" name="promo_code" placeholder="VD: CHILL20" required>
    </div>
      <div class="form-group">
        <label for="description">Mô tả:</label>
        <input type="text" id="description" name="description" placeholder="Nhập mô tả khuyến mãi..." required>
      </div>

      <div class="form-group">
        <label for="discount_percent">Phần trăm giảm giá (%):</label>
        <input type="number" id="discount_percent" name="discount_percent" placeholder="VD: 20" required>
      </div>

      <div class="form-group">
        <label for="start_date">Ngày bắt đầu:</label>
        <input type="date" id="start_date" name="start_date" required>
      </div>

      <div class="form-group">
        <label for="end_date">Ngày kết thúc:</label>
        <input type="date" id="end_date" name="end_date" required>
      </div>

      <div class="form-group">
        <label for="status">Trạng thái:</label>
        <select id="status" name="status">
          <option value="ACTIVE">ACTIVE</option>
          <option value="INACTIVE">INACTIVE</option>
        </select>
      </div>

      <div class="form-group">
        <label for="apply_to">Áp dụng cho:</label>
        <input type="text" id="apply_to" name="apply_to" placeholder="Áp dụng cho..." required>
      </div>

      <div class="form-actions">
        <button type="submit" class="btn-save">Lưu</button>
        <button type="button" class="btn-cancel" onclick="window.location.href='index.php?page=promotion'">Hủy</button>
      </div>
    </form>
  </section>

  <!-- Toast -->
  <div id="toast-container"></div>
</main>

<script>
document.getElementById("add-promotion-form").addEventListener("submit", async function(e) {
  e.preventDefault();

  const promo_code = document.getElementById("promo_code").value.trim();
  const description = document.getElementById("description").value.trim();
  const discount_percent = document.getElementById("discount_percent").value.trim();
  const start_date = document.getElementById("start_date").value.trim();
  const end_date = document.getElementById("end_date").value.trim();
  const status = document.getElementById("status").value;
  const apply_to = document.getElementById("apply_to").value.trim();

  if (!promo_code || !description || !discount_percent || !start_date || !end_date || !apply_to) {
    showToast("Vui lòng nhập đầy đủ thông tin!", "error");
    return;
  }

 const data = { promo_code, description, discount_percent, start_date, end_date, status, apply_to };


  try {
    const res = await fetch('http://localhost/PR_RESERVATION_FnB_FOR_LIVEMUSIC/api_gateway/index.php?service=admin&action=add_promo', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify(data)
    });

    const result = await res.json();

    if (result.success) {
      showToast("Thêm khuyến mãi thành công!", "success");
      setTimeout(() => window.location.href = "index.php?page=promotion", 1500);
    } else {
      showToast(result.message || "Thêm khuyến mãi thất bại!", "error");
    }
  } catch (error) {
    console.error("Lỗi:", error);
    showToast("Lỗi khi gửi yêu cầu!", "error");
  }
});

function showToast(message, type = "info", duration = 2500) {
    const container = document.getElementById('toast-container');

    // Nếu chưa có container, tạo container
    if (!container) {
        const newContainer = document.createElement('div');
        newContainer.id = 'toast-container';
        document.body.appendChild(newContainer);
    }

    const toast = document.createElement('div');
    toast.className = `toast ${type}`;
    toast.textContent = message;

    // Nút đóng
    const closeBtn = document.createElement('span');
    closeBtn.className = 'close-toast';
    closeBtn.innerHTML = '&times;';
    closeBtn.onclick = () => {
        toast.classList.remove('show');
        setTimeout(() => {
            if (toast.parentNode) toast.parentNode.removeChild(toast);
        }, 300);
    };
    toast.appendChild(closeBtn);

    document.getElementById('toast-container').appendChild(toast);

    // Hiển thị toast
    setTimeout(() => toast.classList.add('show'), 50);

    // Ẩn toast sau thời gian duration
    setTimeout(() => {
        toast.classList.remove('show');
        setTimeout(() => {
            if (toast.parentNode) toast.parentNode.removeChild(toast);
        }, 300);
    }, duration);
}

</script>
