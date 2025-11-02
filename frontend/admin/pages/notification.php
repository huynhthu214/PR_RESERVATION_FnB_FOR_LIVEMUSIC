<?php

// Xác định loại người dùng (admin hoặc customer)
if (isset($_SESSION['ADMIN_ID'])) {
    $receiver_id = $_SESSION['ADMIN_ID'];
    $receiver_type = 'ADMIN';
} elseif (isset($_SESSION['CUSTOMER_ID'])) {
    $receiver_id = $_SESSION['CUSTOMER_ID'];
    $receiver_type = 'CUSTOMER';
} else {
    // Nếu chưa đăng nhập → chuyển hướng login
    header("Location: login.php");
    exit();
}
?>


<link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/notification.css">

<main class="main-content notification-page">
  <section class="section-header">
    <h2>Thông báo của bạn</h2>
    <button class="btn-refresh" onclick="loadNotifications()">⟳ Làm mới</button>
  </section>

  <section class="notification-list" id="notification-list">
    <p class="loading-text">Đang tải...</p>
  </section>
</main>

<script>
const receiver_id = "<?php echo htmlspecialchars($receiver_id); ?>";
const receiver_type = "<?php echo htmlspecialchars($receiver_type); ?>";
document.addEventListener("DOMContentLoaded", loadNotifications);

function loadNotifications() {
  const list = document.getElementById("notification-list");
  list.innerHTML = `<p class="loading-text">Đang tải...</p>`;

  if (!receiver_id) {
    list.innerHTML = `<p class="loading-text" style="color:red;">Không xác định người nhận!</p>`;
    return;
  }

  fetch(`http://localhost/PR_RESERVATION_FnB_FOR_LIVEMUSIC/api_gateway/index.php?service=notification&action=get_notifications&receiver_id=${receiver_id}&receiver_type=${receiver_type}`)
    .then(res => res.json())
    .then(data => {
      console.log("Dữ liệu API nhận được:", data);

      if (!data.success) {
        list.innerHTML = `<p class="loading-text" style="color:red;">Không thể tải dữ liệu</p>`;
        return;
      }

      const notifications = data.data;
      if (!notifications || notifications.length === 0) {
        list.innerHTML = `<p class="loading-text">Không có thông báo nào.</p>`;
        return;
      }

      list.innerHTML = notifications.map(n => `
        <div class="notification-item ${n.IS_READ ? '' : 'unread'}"
            onclick="viewNotification('${n.NOTIFICATION_ID}')">
          <div class="notification-message">${n.MESSAGE}</div>
          <div class="notification-meta">
            <span class="time">${formatDateTime(n.SENT_AT)}</span>
            <span class="status ${n.IS_READ ? 'active' : 'pending'}">
              ${n.IS_READ ? 'Đã đọc' : 'Chưa đọc'}
            </span>
          </div>
        </div>
      `).join('');
    })
    .catch(error => {
      console.error("Lỗi khi tải thông báo:", error);
      list.innerHTML = `<p class="loading-text" style="color:red;">Lỗi khi tải dữ liệu</p>`;
    });
}


function viewNotification(id) {
  window.location.href = `index.php?page=notification_detail&id=${id}`;
}

function formatDateTime(datetime) {
  if (!datetime) return '';
  const d = new Date(datetime);
  return `${String(d.getDate()).padStart(2, '0')}/${String(d.getMonth() + 1).padStart(2, '0')}/${d.getFullYear()} - ${String(d.getHours()).padStart(2, '0')}:${String(d.getMinutes()).padStart(2, '0')}`;
}
</script>
