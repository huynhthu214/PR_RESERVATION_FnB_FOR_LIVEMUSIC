<?php
require_once __DIR__ . '/../../config.php';

$customer_id = $_SESSION['CUSTOMER_ID'] ?? null;
if (!$customer_id) {
    echo "<p>Chưa login</p>";
    exit;
}
?>

<link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/noti_user.css">

<h1>Thông báo</h1>

<div class="container">
    <div class="filter-bar">
        <div class="tabs">
            <button class="tab-btn active" data-tab="all">Tất cả</button>
            <button class="tab-btn" data-tab="unread">Chưa đọc</button>
        </div>
        <div class="actions">
            <button class="action-btn" id="mark-all-read">✔ Đánh dấu tất cả đã đọc</button>
            <button class="action-btn" id="delete-all">🗑 Xóa tất cả</button>
        </div>
    </div>

    <div id="notification-list"></div>
</div>

<!-- Modal xác nhận xóa -->
<div id="deleteModal" class="modal hidden">
    <div class="modal-content">
        <button class="modal-close">&times;</button>
        <h3>Xác nhận xóa</h3>
        <p>Bạn có chắc muốn xóa thông báo này?</p>
        <div class="modal-actions">
            <button id="cancelDelete" class="btn btn-cancel">Hủy</button>
            <button id="confirmDelete" class="btn btn-delete">Xóa</button>
        </div>
    </div>
</div>

<style>
/* Modal */
.modal {
    position: fixed;
    top: 0; left: 0; right: 0; bottom: 0;
    background: rgba(0,0,0,0.7);
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 9999;
}
.modal.hidden { display: none; }
.modal-content {
    background: linear-gradient(145deg, #ffcc66, #a97142, #ff4444, #1a1a1a);
    padding: 25px;
    border-radius: 12px;
    width: 320px;
    text-align: center;
    color: #fff;
    position: relative;
}
.modal-close {
    position: absolute;
    top: 8px;
    right: 12px;
    border: none;
    background: transparent;
    font-size: 22px;
    cursor: pointer;
    color: #fff;
}
.modal-actions { margin-top: 20px; display: flex; justify-content: space-around; }
.btn-cancel { background: #555; color: #fff; padding: 8px 18px; border-radius: 6px; border: none; cursor: pointer; }
.btn-delete { background: #ff4444; color: #fff; padding: 8px 18px; border-radius: 6px; border: none; cursor: pointer; }
.btn-cancel:hover { background: #777; }
.btn-delete:hover { background: #cc0000; }
</style>

<script>
const notificationList = document.getElementById('notification-list');
let notifications = [];
let currentTab = 'all';
let deleteNotifId = null;

// Load notifications
async function loadNotifications() {
    try {
        const res = await fetch(`/PR_RESERVATION_FnB_FOR_LIVEMUSIC/api_gateway/index.php?service=notification&action=get_noti`, {
            credentials: 'include' // gửi cookie PHP session
        });
        const data = await res.json();
        if (!data.success) throw new Error(data.message || 'Lỗi API');
        notifications = data.data;
        renderNotifications(currentTab);
    } catch(err) {
        notificationList.innerHTML = '<p style="text-align:center;">Lỗi tải dữ liệu</p>';
        console.error(err);
    }
}

// Render notifications
function renderNotifications(tab) {
    currentTab = tab;
    notificationList.innerHTML = '';
    const list = tab === 'unread' ? notifications.filter(n => !n.is_read) : notifications;

    if (!list.length) {
        notificationList.innerHTML = '<p style="text-align:center;">Không có thông báo</p>';
        return;
    }

    list.forEach(notif => {
        const div = document.createElement('div');
        div.className = 'notification' + (notif.is_read ? '' : ' unread');
        div.dataset.id = notif.id;
        div.innerHTML = `
            <div class="notification-title">${notif.title}</div>
            <div class="notification-message">${notif.message}</div>
            <div class="notification-time">${new Date(notif.sent_at).toLocaleString("vi-VN")}</div>
            ${notif.link ? `<a href="${notif.link}" class="action-link">Xem chi tiết</a>` : ''}
            <button class="close-btn">&times;</button>
        `;
        notificationList.appendChild(div);
    });

    // xóa từng thông báo → mở modal
    document.querySelectorAll('.close-btn').forEach(btn => {
        btn.onclick = e => {
            deleteNotifId = e.target.closest('.notification').dataset.id;
            document.getElementById('deleteModal').classList.remove('hidden');
        };
    });
}

// Modal close
document.querySelector('.modal-close').onclick = () => {
    document.getElementById('deleteModal').classList.add('hidden');
};
document.getElementById('cancelDelete').onclick = () => {
    document.getElementById('deleteModal').classList.add('hidden');
};

// Xóa 1 thông báo
document.getElementById('confirmDelete').onclick = async () => {
    if (!deleteNotifId) return;
    try {
        const res = await fetch(`/PR_RESERVATION_FnB_FOR_LIVEMUSIC/api_gateway/index.php?service=notification&action=delete_noti&id=${deleteNotifId}`, {
            method: 'DELETE',
            credentials: 'include'
        });
        const data = await res.json();
        if (data.success) {
            notifications = notifications.filter(n => n.id !== deleteNotifId);
            renderNotifications(currentTab);
        } else alert(data.message || 'Xóa thất bại');
    } catch(err){ console.error(err); }
    document.getElementById('deleteModal').classList.add('hidden');
};

// Đánh dấu tất cả đã đọc
document.getElementById('mark-all-read').onclick = async () => {
    try {
        const res = await fetch(`/PR_RESERVATION_FnB_FOR_LIVEMUSIC/api_gateway/index.php?service=notification&action=mark_all_read`, {
            method: 'POST',
            credentials: 'include'
        });
        const data = await res.json();
        if (data.success) {
            notifications.forEach(n => n.is_read = true);
            renderNotifications(currentTab);
        } else alert(data.message || 'Đánh dấu thất bại');
    } catch(err) { console.error(err); }
};

// Xóa tất cả
document.getElementById('delete-all').onclick = async () => {
    if (!confirm('Bạn có chắc muốn xóa tất cả thông báo?')) return;
    try {
        const res = await fetch(`/PR_RESERVATION_FnB_FOR_LIVEMUSIC/api_gateway/index.php?service=notification&action=delete_all_noti`, {
            method: 'DELETE',
            credentials: 'include'
        });
        const data = await res.json();
        if (data.success) {
            notifications = [];
            renderNotifications(currentTab);
        } else alert(data.message || 'Xóa tất cả thất bại');
    } catch(err) { console.error(err); }
};

// Chuyển tab
document.querySelectorAll('.tab-btn').forEach(btn => {
    btn.onclick = e => {
        document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
        e.target.classList.add('active');
        renderNotifications(e.target.dataset.tab);
    };
});

document.addEventListener('DOMContentLoaded', loadNotifications);
</script>
