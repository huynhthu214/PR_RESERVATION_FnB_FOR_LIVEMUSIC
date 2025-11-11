<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

?>
<link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/menu.css">

<main class="main-content add-menu-page">
  <section class="section-header">
    <h2>Thêm món mới</h2>
    <button class="btn-back" onclick="window.location.href='index.php?page=menu'">
        ← Quay lại danh sách
    </button>
  </section>

  <section class="form-section">
    <form id="addMenuForm" class="add-form">
      <label for="name">Tên món:</label>
      <input type="text" id="name" required>

      <label for="category">Danh mục:</label>
      <input type="text" id="category" placeholder="Drink, food,...">

      <label for="description">Mô tả:</label>
      <textarea id="description" rows="3" placeholder="Nhập mô tả món..."></textarea>

      <label for="price">Giá:</label>
      <div class="price-input">
        <input type="text" id="price" required>
        <span class="currency-label">VNĐ</span>
      </div>

      <label for="quantity">Số lượng tồn:</label>
      <input type="number" id="quantity" min="0" value="0">

      <label for="available">Trạng thái:</label>
      <select id="available">
        <option value="1" selected>Còn bán</option>
        <option value="0">Ngừng bán</option>
      </select>

      <div class="form-actions">
        <button type="submit" class="btn-add">Lưu</button>
        <button type="button" class="btn-cancel" onclick="window.location.href='index.php?page=menu'">Hủy</button>
      </div>
    </form>
  </section>
</main>

<!-- Toast container -->
<div id="toast-container"></div>

<script>
// Format tiền khi nhập
// document.getElementById("price").addEventListener("input", e => {
//   let value = e.target.value.replace(/\D/g, "");
//   if (value) e.target.value = Number(value).toLocaleString("vi-VN");
// });

// Gửi form
document.getElementById("addMenuForm").addEventListener("submit", e => {
  e.preventDefault();

  const data = {
    NAME: document.getElementById("name").value.trim(),
    CATEGORY: document.getElementById("category").value.trim(),
    DESCRIPTION: document.getElementById("description").value.trim(),
    PRICE: parseInt(document.getElementById("price").value.replace(/\./g, "")),
    STOCK_QUANTITY: parseInt(document.getElementById("quantity").value),
    IS_AVAILABLE: parseInt(document.getElementById("available").value),
    ADMIN_ID: "AD001"
  };

  fetch("http://localhost/PR_RESERVATION_FnB_FOR_LIVEMUSIC/api_gateway/index.php?service=admin&action=add_menu_item", {
    method: "POST",
    headers: {"Content-Type": "application/json"},
    body: JSON.stringify(data)
  })
  .then(res => res.json())
  .then(result => {
    if(result.message){
      showToast(result.message, "success");
      setTimeout(() => window.location.href = "index.php?page=menu", 1500);
    } else {
      showToast(result.error || "Không thể thêm món.", "error");
    }
  })
  .catch(err => {
    console.error("Lỗi khi thêm món:", err);
    showToast("Không thể kết nối tới server.", "error");
  });
});

// ---------------- Toast ----------------
function showToast(message, type = 'info', duration = 3000){
  const container = document.getElementById('toast-container');
  const toast = document.createElement('div');
  toast.className = 'toast ' + type;
  toast.textContent = message;
  const closeBtn = document.createElement('span');
  closeBtn.className = 'close-toast';
  closeBtn.innerHTML = '&times;';
  closeBtn.onclick = () => {
    toast.classList.remove('show');
    setTimeout(() => container.removeChild(toast), 300);
  };
  toast.appendChild(closeBtn);
  container.appendChild(toast);
  setTimeout(() => toast.classList.add('show'), 50);
  setTimeout(() => {
    toast.classList.remove('show');
    setTimeout(() => {
      if(container.contains(toast)) container.removeChild(toast);
    }, 300);
  }, duration);
}
</script>