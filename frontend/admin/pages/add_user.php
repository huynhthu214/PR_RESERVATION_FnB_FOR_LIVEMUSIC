<link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/user.css">

<main class="main-content add-user-page">
  <section class="section-header">
    <h2>Thêm người dùng</h2>
    <button class="btn-back" onclick="window.location.href='index.php?page=users'">
        ← Quay lại danh sách
    </button>
  </section>

  <section class="form-section">
    <form id="add-user-form" class="data-form">
      <div class="form-group">
        <label for="username">Tên người dùng:</label>
        <input type="text" id="username" name="username" placeholder="Nhập tên người dùng..." required>
      </div>

      <div class="form-group">
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" placeholder="Nhập email..." required>
      </div>

      <div class="form-group">
        <label for="password">Mật khẩu:</label>
        <div class="password-input">
            <input type="password" id="password" name="password" placeholder="Nhập mật khẩu..." required>
            <span class="toggle-password" onclick="togglePassword('password', this)">🔒</span>
        </div>
      </div>

      <div class="form-group">
        <label for="confirm_password">Nhập lại mật khẩu:</label>
        <div class="password-input">
            <input type="password" id="confirm_password" name="confirm_password" placeholder="Xác nhận mật khẩu..." required>
            <span class="toggle-password" onclick="togglePassword('confirm_password', this)">🔒</span>
        </div>
      </div>

      <div class="form-actions">
        <button type="submit" class="btn-save">Lưu</button>
        <button type="button" class="btn-cancel" onclick="window.location.href='index.php?page=add_user'">Hủy</button>
      </div>
    </form>
  </section>

  <!-- Toast -->
  <div id="toast" class="toast"></div>
</main>

<script>
document.getElementById("add-user-form").addEventListener("submit", function(e) {
  e.preventDefault();

  const username = document.getElementById("username").value.trim();
  const email = document.getElementById("email").value.trim();
  const password = document.getElementById("password").value.trim();
  const confirmPassword = document.getElementById("confirm_password").value.trim();

  if (!username || !email || !password || !confirmPassword) {
    showToast("Vui lòng nhập đầy đủ thông tin!", "error");
    return;
  }

  if (password !== confirmPassword) {
    showToast("Mật khẩu xác nhận không khớp!", "error");
    return;
  }

  const data = { username, email, password };

  fetch('http://localhost/PR_RESERVATION_FnB_FOR_LIVEMUSIC/api_gateway/index.php?service=customer&action=add_user', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify(data)
  })
    .then(res => res.json())
    .then(result => {
      if (result.success) {
        showToast("Thêm người dùng thành công!", "success");
        setTimeout(() => window.location.href = "index.php?page=users", 1500);
      } else {
        showToast(result.message || "Thêm thất bại!", "error");
      }
    })
    .catch(error => {
      console.error("Lỗi:", error);
      showToast("Lỗi khi gửi yêu cầu!", "error");
    });
});

// Toast hiển thị ở góc phải trên
function showToast(message, type = "info") {
  const toast = document.getElementById("toast");
  toast.textContent = message;
  toast.className = `toast show ${type}`;
  setTimeout(() => { toast.className = "toast"; }, 2500);
}

function togglePassword(inputId, icon) {
  const input = document.getElementById(inputId);
  if (input.type === "password") {
    input.type = "text";
    icon.textContent = "🔓";
  } else {
    input.type = "password";
    icon.textContent = "🔒";
  }
}

</script>
