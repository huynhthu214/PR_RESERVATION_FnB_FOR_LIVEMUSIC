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

<script>
const notificationList = document.getElementById('notification-list');
const customer_id = "<?php echo $_SESSION['CUSTOMER_ID']; ?>";
let notifications = [];
let currentTab = 'all';
let deleteNotifId = null;

// =================== Load notifications ===================
async function loadNotifications() {
    try {
        const res = await fetch(`/PR_RESERVATION_FnB_FOR_LIVEMUSIC/api_gateway/index.php?service=notification&action=get_noti`, {
            credentials: 'include'
        });
        const data = await res.json();
        if (!data.success) throw new Error(data.message || 'Lỗi API');
        notifications = data.data;
        renderNotifications(currentTab);
    } catch(err) {
        notificationList.innerHTML = '<p style="text-align:center;color:red;">Lỗi tải dữ liệu</p>';
        console.error(err);
    }
}

// =================== Render notifications ===================
function renderNotifications(tab) {
    currentTab = tab;
    notificationList.innerHTML = '';

    const list = tab === 'unread'
        ? notifications.filter(n => !n.is_read)
        : notifications;

    if (!list.length) {
        notificationList.innerHTML = '<p style="text-align:center;">Không có thông báo</p>';
        return;
    }

    list.forEach(notif => {
        const div = document.createElement('div');
        div.className = 'notification' + (notif.is_read ? ' read' : ' unread');
        div.dataset.id = notif.id;
        div.innerHTML = `
            <div class="notification-title">${notif.title}</div>
            <div class="notification-message">${notif.message}</div>
            <div class="notification-time">${new Date(notif.sent_at).toLocaleString("vi-VN")}</div>
            ${notif.id ? `<a href="index.php?page=noti_details&id=${notif.id}" class="action-link">Xem chi tiết</a>` : ''}
            <button class="close-btn">&times;</button>
        `;
        notificationList.appendChild(div);

        const linkEl = div.querySelector('.action-link');

        // Click vào thông báo → đánh dấu đã đọc
        div.addEventListener('click', async e => {
            if (e.target.classList.contains('close-btn') || e.target === linkEl) return;
            if (!notif.is_read) await markAsRead(notif, div);
        });

        // Click vào link “Xem chi tiết” → đánh dấu đã đọc trước khi chuyển trang
        if (linkEl) {
            linkEl.addEventListener('click', async e => {
                e.preventDefault();
                if (!notif.is_read) await markAsRead(notif, div);
                window.location.href = linkEl.href;
            });
        }

        // Click nút xóa → mở modal
        div.querySelector('.close-btn').addEventListener('click', e => {
            e.stopPropagation();
            deleteNotifId = notif.id;
            document.getElementById('deleteModal').classList.remove('hidden');
        });
    });
}

// =================== Mark as read ===================
async function markAsRead(notif, div) {
    try {
        const res = await fetch(`/PR_RESERVATION_FnB_FOR_LIVEMUSIC/api_gateway/index.php?service=notification&action=mark_as_read&id=${notif.id}&receiver_id=${customer_id}&receiver_type=CUSTOMER`, {
            method: 'POST',
            credentials: 'include'
        });
        const data = await res.json();
        if (data.success) {
            notif.is_read = true;
            div.classList.remove('unread');
            div.classList.add('read');
            if (currentTab === 'unread') renderNotifications(currentTab);
        }
    } catch(err) {
        console.error('Lỗi đánh dấu đã đọc:', err);
    }
}

// =================== Modal & Delete ===================
document.querySelector('.modal-close').onclick = () => document.getElementById('deleteModal').classList.add('hidden');
document.getElementById('cancelDelete').onclick = () => document.getElementById('deleteModal').classList.add('hidden');

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
    } catch(err) {
        console.error(err);
    }
    document.getElementById('deleteModal').classList.add('hidden');
};

// =================== Mark all read ===================
document.getElementById('mark-all-read').onclick = async () => {
    try {
        const res = await fetch(`/PR_RESERVATION_FnB_FOR_LIVEMUSIC/api_gateway/index.php?service=notification&action=mark_all_read&receiver_id=${customer_id}&receiver_type=CUSTOMER`, {
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

// =================== Delete all ===================
document.getElementById('delete-all').onclick = async () => {
    if (!confirm('Bạn có chắc muốn xóa tất cả thông báo?')) return;
    try {
        const res = await fetch(`/PR_RESERVATION_FnB_FOR_LIVEMUSIC/api_gateway/index.php?service=notification&action=delete_all_noti&receiver_id=${customer_id}&receiver_type=CUSTOMER`, {
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

// =================== Tabs ===================
document.querySelectorAll('.tab-btn').forEach(btn => {
    btn.addEventListener('click', e => {
        document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
        e.target.classList.add('active');
        renderNotifications(e.target.dataset.tab);
    });
});

document.addEventListener('DOMContentLoaded', loadNotifications);
</script>
