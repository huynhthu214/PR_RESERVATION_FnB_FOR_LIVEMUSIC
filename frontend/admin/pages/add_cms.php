<link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/cms.css">

<main class="main-content add-cms-page">
  <section class="section-header">
    <h2>Thêm CMS</h2>
    <button class="btn-back" onclick="window.location.href='index.php?page=cms'">
        ← Quay lại danh sách
    </button>
  </section>

  <section class="form-section">
    <form id="add-cms-form" class="cms-form">
    <div class="form-group">
        <label for="type">Loại nội dung:</label>
        <select id="type" name="type" required>
            <option value="policy">Chính sách và điều khoản</option>
            <option value="about">Giới thiệu</option>
        </select>
    </div>

      <div class="form-group">
        <label for="title">Tiêu đề trang:</label>
        <input type="text" id="title" name="title" placeholder="Nhập tiêu đề..." required>
      </div>

      <div class="form-group file-group">
        <label for="content_file">Nội dung:</label>
        <div class="file-input-wrapper">
          <input type="text" id="content_file_text" placeholder="Chọn tệp..." readonly>
          <button type="button" id="content_file_btn">Chọn tệp</button>
          <input type="file" id="content_file" name="content_file" accept=".txt,.html" hidden>
        </div>
      <div class="form-actions">
        <button type="submit" class="btn-save">Lưu</button>
        <button type="button" class="btn-cancel" onclick="window.location.href='index.php?page=add_cms'">Hủy</button>
      </div>
    </form>
  </section>

  <div id="toast-container"></div>
</main>

<script>
// ===== xử lý nút chọn file =====
const fileInput = document.getElementById('content_file');
const fileBtn = document.getElementById('content_file_btn');
const fileText = document.getElementById('content_file_text');

fileBtn.addEventListener('click', () => fileInput.click());
fileInput.addEventListener('change', () => {
    fileText.value = fileInput.files[0] ? fileInput.files[0].name : '';
});

// ===== xử lý submit form =====
document.getElementById("add-cms-form").addEventListener("submit", async function(e) {
  e.preventDefault();

  const type = document.getElementById("type").value.trim();
  const title = document.getElementById("title").value.trim();

  // Nếu có file, đọc nội dung file
  if (fileInput.files.length > 0) {
    const file = fileInput.files[0];
    content = await file.text();
  }

  if (!type || !title || !content) {
    showToast("Vui lòng nhập đầy đủ thông tin!", "error");
    return;
  }

  const data = { type, title, content };

  try {
    const res = await fetch('http://localhost/PR_RESERVATION_FnB_FOR_LIVEMUSIC/api_gateway/index.php?service=admin&action=add_cms', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify(data)
    });

    const result = await res.json();

    if (result.success) {
      showToast("Thêm CMS thành công!", "success");
      setTimeout(() => window.location.href = "index.php?page=cms", 1500);
    } else {
      showToast(result.message || "Thêm CMS thất bại!", "error");
    }
  } catch (error) {
    console.error("Lỗi:", error);
    showToast("Lỗi khi gửi yêu cầu!", "error");
  }
});

// ===== toast =====
function showToast(message, type = "info", duration = 3000) {
  const container = document.getElementById("toast-container");
  const toast = document.createElement("div");
  toast.className = `toast show ${type}`;
  toast.innerHTML = `
    <span>${message}</span>
    <span class="close-toast">&times;</span>
  `;
  container.appendChild(toast);
  toast.querySelector(".close-toast").addEventListener("click", () => {
    toast.classList.remove("show");
    setTimeout(() => toast.remove(), 300);
  });
  setTimeout(() => {
    toast.classList.remove("show");
    setTimeout(() => toast.remove(), 300);
  }, duration);
}
</script>
