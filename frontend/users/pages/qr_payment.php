<?php
require_once __DIR__ . '/../../config.php'; 

$orderId = $_GET['order_id'] ?? null;

if (!$orderId) {
    echo "Order ID không hợp lệ";
    exit;
}
?>
<link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/payment_user.css">
<style>
body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background-color: #f5f5f5;
    margin: 0;
    padding: 0;
}

#qr-container {
    max-width: 400px;
    margin: 50px auto;
    background-color: #2c2626;
    padding: 30px 20px;
    border-radius: 12px;
    box-shadow: 0 6px 20px rgba(0,0,0,0.1);
    text-align: center;
}

#qr-container p {
    font-size: 16px;
    margin: 10px 0;
    color: #f1efeb;
}

#qr-container b {
    color: #eae1d5;
}

#qr-container img {
    margin: 20px 0;
    width: 200px;
    height: 200px;
    border: 4px solid #007BFF;
    border-radius: 12px;
}

#qr-container .btn-paid, #qr-container .btn-resend {
    display: inline-block;
    padding: 8px 18px;
    font-size: 1rem;
    border-radius: 6px;
    text-decoration: none;
    margin-top: 15px;
    width: auto;
    transition: background-color 0.3s;
    cursor: pointer;
}

#qr-container .btn-paid {
    background-color: #28a745;
    color: #fff;
}

#qr-container .btn-paid:hover {
    background-color: #218838;
}

#qr-container .btn-resend {
    background-color: #ffc107;
    color: #000;
}

#qr-container .btn-resend:hover {
    background-color: #e0a800;
}

#timer {
    font-weight: bold;
    margin-top: 10px;
    color: #ffdd57;
}
</style>

<div id="qr-container">
    <p>Đang tải thông tin thanh toán...</p>
</div>

<script>
const orderId = "<?= $orderId ?>";

let timerInterval;
let remainingSeconds = 20; // 5 phút = 300 giây

function startTimer() {
    const timerElem = document.getElementById('timer');
    timerInterval = setInterval(() => {
        if (remainingSeconds <= 0) {
            clearInterval(timerInterval);
            document.getElementById('btn-paid').style.display = 'none';
            document.getElementById('resend-container').style.display = 'block';
            timerElem.textContent = "Mã QR đã hết hạn";
            return;
        }
        const min = Math.floor(remainingSeconds / 60);
        const sec = remainingSeconds % 60;
        timerElem.textContent = `Mã QR khả dụng: ${min}:${sec < 10 ? '0'+sec : sec}`;
        remainingSeconds--;
    }, 1000);
}

async function loadQR() {
    try {
        const res = await fetch(`http://localhost/PR_RESERVATION_FnB_FOR_LIVEMUSIC/api_gateway/index.php?service=order&action=qr_api&order_id=${orderId}`);
        const data = await res.json();

        if(!data.success){
            document.getElementById('qr-container').innerHTML = `<p>${data.message}</p>`;
            return;
        }

        const container = document.getElementById('qr-container');
        container.innerHTML = `
            <p>Mã đơn hàng: <b>${data.order_id}</b></p>
            <p>Số tiền: <b>${data.total.toLocaleString()} VND</b></p>
            <p>Quét QR bên dưới bằng ứng dụng ngân hàng hoặc ví điện tử:</p>
            <img src="${data.qr_url}" alt="QR Payment">
            <div id="timer"></div>
            <a class="btn-paid" id="btn-paid">Đã thanh toán</a>
            <div id="resend-container" style="display:none;">
                <p>Mã QR hết hạn.</p>
                <a class="btn-resend" id="btn-resend">Gửi lại QR</a>
            </div>
        `;

        remainingSeconds = 20;
        startTimer();

        // Xử lý "Đã thanh toán"
        document.getElementById('btn-paid').addEventListener('click', async () => {
            const resConfirm = await fetch(`http://localhost/PR_RESERVATION_FnB_FOR_LIVEMUSIC/api_gateway/index.php?service=order&action=confirm_transfer&order_id=${orderId}`);
            const resp = await resConfirm.json();
            if(resp.success){
                alert('Đơn hàng đã được xác nhận và email thông báo đã gửi!');
                window.location.href = `index.php?page=user_orders`;
            } else {
                alert(resp.message || 'Có lỗi xảy ra');
            }
        });

        // Xử lý gửi lại QR
        document.getElementById('btn-resend').addEventListener('click', () => {
            loadQR();
        });

    } catch(e) {
        document.getElementById('qr-container').innerHTML = `<p>Không thể tải QR.</p>`;
    }
}

loadQR();
</script>
