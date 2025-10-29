<main class="main-content notification-page">
  <section class="section-header">
      <h2>Thông báo của bạn</h2>
      <button class="btn-refresh" onclick="loadNotifications()">⟳ Làm mới</button>
  </section>

  <section class="table-section">
      <table class="data-table">
          <thead>
              <tr>
                  <th>ID</th>
                  <th>Nội dung</th>
                  <th>Loại</th>
                  <th>Ngày gửi</th>
                  <th>Trạng thái</th>
              </tr>
          </thead>
          <tbody id="notification-body">
              <tr><td colspan="5" style="text-align:center;">Đang tải...</td></tr>
          </tbody>
      </table>
  </section>
</main>

<script>
document.addEventListener("DOMContentLoaded", loadNotifications);

function loadNotifications() {
    const tbody = document.getElementById("notification-body");
    tbody.innerHTML = `<tr><td colspan="5" style="text-align:center;">Đang tải...</td></tr>`;

    fetch("http://localhost/PR_RESERVATION_FnB_FOR_LIVEMUSIC/api_gateway/index.php?service=notification&action=get_notifications")
        .then(res => res.json())
        .then(data => {
            console.log("📩 Dữ liệu API nhận được:", data);

            if (!data.success) {
                tbody.innerHTML = `<tr><td colspan="5" style="text-align:center;color:red;">Không thể tải dữ liệu</td></tr>`;
                return;
            }

            const notifications = data.data;

            if (notifications.length === 0) {
                tbody.innerHTML = `<tr><td colspan="5" style="text-align:center;">Không có thông báo nào.</td></tr>`;
                return;
            }

            let html = '';
            notifications.forEach(n => {
                html += `
                    <tr>
                        <td>${n.NOTIFICATION_ID}</td>
                        <td>${n.MESSAGE}</td>
                        <td>${n.TYPE}</td>
                        <td>${formatDateTime(n.SENT_AT)}</td>
                        <td>
                            <span class="status ${n.IS_READ ? 'active' : 'pending'}">
                                ${n.IS_READ ? 'Đã đọc' : 'Chưa đọc'}
                            </span>
                        </td>
                    </tr>
                `;
            });

            tbody.innerHTML = html;
        })
        .catch(error => {
            console.error("⚠️ Lỗi khi tải thông báo:", error);
            tbody.innerHTML = `<tr><td colspan="5" style="text-align:center;color:red;">Lỗi khi tải dữ liệu</td></tr>`;
        });
}

function formatDateTime(datetime) {
    if (!datetime) return '';
    const d = new Date(datetime);
    return `${String(d.getDate()).padStart(2, '0')}/${String(d.getMonth() + 1).padStart(2, '0')}/${d.getFullYear()} - ${String(d.getHours()).padStart(2, '0')}:${String(d.getMinutes()).padStart(2, '0')}`;
}
</script>

<?php include __DIR__ . '/../../includes/footer_admin.php'; ?>
