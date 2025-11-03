<link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/notification.css">

<main class="main-content notification-detail-page">
  <section class="section-header">
    <h2>Chi tiết thông báo</h2>
    <button class="btn-back" onclick="window.location.href='index.php?page=notification'">← Quay lại</button>
  </section>

  <section class="notification-detail">
    <div id="loading" class="loading">Đang tải chi tiết thông báo...</div>
    <div id="detail-container" class="detail-container" style="display:none;">
      <div class="detail-row"><strong>Mã thông báo:</strong> <span id="notif-id"></span></div>
      <div class="detail-row"><strong>Người gửi:</strong> <span id="notif-sender"></span></div>
      <div class="detail-row"><strong>Loại:</strong> <span id="notif-type"></span></div>
      <div class="detail-row"><strong>Ngày gửi:</strong> <span id="notif-date"></span></div>
      <div class="detail-row"><strong>Nội dung:</strong></div>
      <div id="notif-message" class="notif-message"></div>
    </div>
  </section>
</main>

<script>
document.addEventListener("DOMContentLoaded", async () => {
  const params = new URLSearchParams(window.location.search);
  const id = params.get("id");

  if (!id) {
    document.getElementById("loading").innerText = "Thiếu ID thông báo.";
    return;
  }

  try {
    // Gọi API lấy chi tiết
    const res = await fetch(`http://localhost/PR_RESERVATION_FnB_FOR_LIVEMUSIC/api_gateway/index.php?service=notification&action=get_notification_detail&notification_id=${id}`);
    const data = await res.json();
    console.log("Chi tiết thông báo:", data);

    if (!data.success) {
      document.getElementById("loading").innerText = "Không tìm thấy thông báo.";
      return;
    }

    const n = data.data;
    document.getElementById("notif-id").innerText = n.NOTIFICATION_ID;
    document.getElementById("notif-sender").innerText = n.SENDER_ID || "Hệ thống";
    document.getElementById("notif-type").innerText = n.TYPE;
    document.getElementById("notif-date").innerText = formatDateTime(n.SENT_AT);
    document.getElementById("notif-message").innerText = n.MESSAGE;

    document.getElementById("loading").style.display = "none";
    document.getElementById("detail-container").style.display = "block";

    // Gọi API mark_as_read (chỉ khi chưa đọc)
    if (!n.IS_READ) {
      await fetch(`http://localhost/PR_RESERVATION_FnB_FOR_LIVEMUSIC/api_gateway/index.php?service=notification&action=mark_as_read`, {
        method: "POST",
        headers: { "Content-Type": "application/x-www-form-urlencoded" },
        body: new URLSearchParams({ notification_id: id })
      })
      .then(res => res.json())
      .then(r => console.log("mark_as_read:", r))
      .catch(e => console.error("Lỗi mark_as_read:", e));
    }

  } catch (err) {
    console.error("Lỗi khi tải chi tiết:", err);
    document.getElementById("loading").innerText = "Lỗi khi tải dữ liệu.";
  }
});

function formatDateTime(datetime) {
  if (!datetime) return '';
  const d = new Date(datetime);
  return `${String(d.getDate()).padStart(2, '0')}/${String(d.getMonth() + 1).padStart(2, '0')}/${d.getFullYear()} - ${String(d.getHours()).padStart(2, '0')}:${String(d.getMinutes()).padStart(2, '0')}`;
}
</script>
