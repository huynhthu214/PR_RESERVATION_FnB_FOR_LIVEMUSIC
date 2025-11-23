<link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/noti_user.css">

<h1>Thông báo</h1>

<div class="container">

    <!-- Filter Bar -->
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

    <!-- Notification List -->
    <div id="notification-list"></div>
</div>

<!-- Modal xác nhận xóa -->
<div id="deleteModal" class="modal hidden">
    <div class="modal-content">
        <h3>Xác nhận xóa</h3>
        <p>Bạn có chắc muốn xóa thông báo này?</p>
        <div class="modal-actions">
            <button id="cancelDelete" class="btn">Hủy</button>
            <button id="confirmDelete" class="btn btn-delete">Xóa</button>
        </div>
    </div>
</div>

<style>
/* Modal */
.modal {
    position: fixed;
    top: 0; left: 0; right: 0; bottom: 0;
    background: rgba(0,0,0,0.5);
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 9999;
}
.modal.hidden { display: none; }
.modal-content {
    background: #fff;
    padding: 20px;
    border-radius: 8px;
    width: 300px;
    text-align: center;
}
.modal-actions {
    margin-top: 15px;
    display: flex;
    justify-content: space-around;
}
.btn-delete { background: red; color: #fff; }
</style>

<script>
const notificationList = document.getElementById('notification-list');
let notifications = [];
let currentTab = 'all';
let deleteNotifId = null;

// Load notifications từ API
async function loadNotifications() {
    try {
        const res = await fetch('http://localhost/PR_RESERVATION_FnB_FOR_LIVEMUSIC/api_gateway/index.php?service=notification&action=get_noti');
        const data = await res.json();
        if (!data.success) throw new Error(data.message || 'Lỗi API');
        notifications = data.data;
        renderNotifications(currentTab);
    } catch(err) {
        notificationList.innerHTML = '<p style="text-align:center;">Lỗi tải dữ liệu</p>';
        console.error(err);
    }
}

// Render notifications theo tab
function renderNotifications(tab) {
    currentTab = tab;
    notificationList.innerHTML = '';
    const list = tab === 'unread' ? notifications.filter(n => !n.is_read) : notifications;

    if (list.length === 0) {
        notificationList.innerHTML = '<p style="text-align:center;">Không có thông báo</p>';
        return;
    }

    list.forEach(notif => {
        const div = document.createElement('div');
        div.className = 'notification' + (notif.is_read ? '' : ' unread');
        div.dataset.id = notif.id;
        div.id = `notif-${notif.id}`;
        div.innerHTML = `
            <div class="notification-title">${notif.title}</div>
            <div class="notification-message">${notif.message}</div>
            <div class="notification-time">${new Date(notif.sent_at).toLocaleString("vi-VN")}</div>
            ${notif.link ? `<a href="${notif.link}" class="action-link">Xem chi tiết</a>` : ''}
            <button class="close-btn">&times;</button>
        `;
        notificationList.appendChild(div);
    });

    // Xử lý nút xóa từng thông báo: mở modal
    document.querySelectorAll('.close-btn').forEach(btn => {
        btn.addEventListener('click', e => {
            const id = e.target.closest('.notification').dataset.id;
            openDeleteModal(id);
        });
    });
}

// Mở modal xóa
function openDeleteModal(notiId) {
    deleteNotifId = notiId;
    document.getElementById('deleteModal').classList.remove('hidden');
}

// Nút Hủy modal
document.getElementById('cancelDelete').onclick = () => {
    document.getElementById('deleteModal').classList.add('hidden');
};

// Nút Xóa modal
document.getElementById('confirmDelete').onclick = async () => {
    if (!deleteNotifId) return;
    try {
        const res = await fetch(`http://localhost/PR_RESERVATION_FnB_FOR_LIVEMUSIC/api_gateway/index.php?service=notification&action=delete_noti&id=${deleteNotifId}`, { method: 'DELETE' });
        const data = await res.json();
        if (data.success) {
            notifications = notifications.filter(n => n.id !== deleteNotifId);
            renderNotifications(currentTab);
        } else {
            alert(data.message || 'Xóa thất bại');
        }
    } catch(err){ console.error(err); }
    document.getElementById('deleteModal').classList.add('hidden');
};

// Nút đánh dấu tất cả đã đọc
document.getElementById('mark-all-read').addEventListener('click', async () => {
    try {
        const res = await fetch('http://localhost/PR_RESERVATION_FnB_FOR_LIVEMUSIC/api_gateway/index.php?service=notification&action=mark_all_read', { method: 'POST' });
        const data = await res.json();
        if (data.success) {
            notifications.forEach(n => n.is_read = true);
            renderNotifications(currentTab);
        } else {
            alert(data.message || 'Đánh dấu thất bại');
        }
    } catch(err) { console.error(err); }
});

// Nút xóa tất cả
document.getElementById('delete-all').addEventListener('click', async () => {
    if (!confirm('Bạn có chắc muốn xóa tất cả thông báo?')) return;
    try {
        const res = await fetch('http://localhost/PR_RESERVATION_FnB_FOR_LIVEMUSIC/api_gateway/index.php?service=notification&action=delete_all_noti', { method: 'DELETE' });
        const data = await res.json();
        if (data.success) {
            notifications = [];
            renderNotifications(currentTab);
        } else {
            alert(data.message || 'Xóa tất cả thất bại');
        }
    } catch(err) { console.error(err); }
});

// Chuyển tab
document.querySelectorAll('.tab-btn').forEach(btn => {
    btn.addEventListener('click', e => {
        document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
        e.target.classList.add('active');
        renderNotifications(e.target.dataset.tab);
    });
});

document.addEventListener('DOMContentLoaded', loadNotifications);
</script>
