<link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/events.css">

<main class="main-content notification-page">
    <section class="section-header">
        <h2>Email Logs</h2>
    </section>

    <section class="table-section">
        <table class="data-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Người nhận</th>
                    <th>Tiêu đề</th>
                    <th>Thời gian gửi</th>
                    <th>Trạng thái</th>
                    <th>Lỗi</th>
                </tr>
            </thead>
            <tbody id="email-body">
                <tr><td colspan="6" style="text-align:center;">Đang tải dữ liệu...</td></tr>
            </tbody>
        </table>
    </section>
</main>

<!-- Toast container -->
<div id="toast-container"></div>

<script>
document.addEventListener("DOMContentLoaded", function() {
    loadEmailLogs();
});

// ---------------- Toast ----------------
function showToast(message, type = 'info', duration = 3000) {
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

// ---------------- Load Email Logs ----------------
function loadEmailLogs() {
    fetch('http://localhost/PR_RESERVATION_FnB_FOR_LIVEMUSIC/api_gateway/index.php?service=notification&action=get_admin_logs')
        .then(res => res.json())
        .then(data => {
            if(!data.success){
                throw new Error("Không lấy được dữ liệu từ API");
            }

            // Email Logs
            const emailBody = document.getElementById('email-body');
            emailBody.innerHTML = '';
            if(data.email_logs.length === 0){
                emailBody.innerHTML = '<tr><td colspan="6" style="text-align:center;">Chưa có email nào</td></tr>';
            } else {
                data.email_logs.forEach(email => {
                    emailBody.innerHTML += `<tr>
                        <td>${email.EMAILLOG_ID}</td>
                        <td>${email.RECIPIENT_EMAIL}</td>
                        <td>${email.SUBJECT}</td>
                        <td>${email.SENT_TIME}</td>
                        <td>${email.STATUS}</td>
                        <td>${email.ERRORMESSAGE || '-'}</td>
                    </tr>`;
                });
            }
        })
        .catch(error => {
            console.error('Lỗi tải dữ liệu email:', error);
            document.getElementById('email-body').innerHTML = 
                '<tr><td colspan="6" style="text-align:center;">Lỗi tải dữ liệu</td></tr>';
            showToast('Không thể tải dữ liệu email.', 'error', 4000);
        });
}
</script>
