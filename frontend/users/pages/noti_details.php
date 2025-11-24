<?php
require_once __DIR__ . '/../../config.php';

$customer_id = $_SESSION['CUSTOMER_ID'] ?? null;
if (!$customer_id) {
    header("Location: login.php");
    exit;
}

$notif_id = $_GET['id'] ?? null;
if (!$notif_id) {
    header("Location: index.php?page=notification");
    exit;
}
?>

<link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/noti_details.css">

<div class="container">
    <a href="index.php?page=notification" class="back-btn">⬅ Back to Notifications</a>

    <div id="notification-card" class="card">
        <div class="header">
            <div class="icon">🔔</div>
            <div>
                <h1 class="title"></h1>
                <p class="time"></p>
            </div>
        </div>

        <div class="content"></div>
    </div>

    <div class="settings">
        <h3>🔔 Notification Settings</h3>
        <p>You can manage your notification preferences in your account settings.</p>
    </div>
</div>

<script>
async function loadNotificationDetail() {
    const notifId = '<?php echo $notif_id; ?>';
    try {
        const res = await fetch(`/PR_RESERVATION_FnB_FOR_LIVEMUSIC/api_gateway/index.php?service=notification&action=get_noti`, {
            credentials: 'include'
        });
        const data = await res.json();

        if (!data.success) throw new Error(data.message || 'Không thể tải thông báo');

        // Tìm thông báo theo ID
        const notif = data.data.find(n => String(n.id) === String(notifId));
        if (!notif) throw new Error('Không tìm thấy thông báo');

        // Render dữ liệu
        document.querySelector('#notification-card .title').textContent = notif.title;
        document.querySelector('#notification-card .time').textContent = new Date(notif.sent_at).toLocaleString("vi-VN");
        document.querySelector('#notification-card .content').innerHTML = notif.message;

        // Đánh dấu đã đọc
        const formData = new FormData();
        formData.append("notification_id", notifId);

        await fetch(`/PR_RESERVATION_FnB_FOR_LIVEMUSIC/api_gateway/index.php?service=notification&action=mark_as_read`, {
        method: 'POST',
        body: formData,
        credentials: 'include'
        });


    } catch(err) {
        console.error(err);
        document.getElementById('notification-card').innerHTML = '<p style="text-align:center;">Không thể tải thông báo</p>';
    }
}

document.addEventListener('DOMContentLoaded', loadNotificationDetail);
</script>
