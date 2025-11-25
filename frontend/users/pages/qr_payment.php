<?php
require_once __DIR__ . '/../../config.php'; 

$orderId = $_GET['order_id'] ?? null;

if (!$orderId) {
    echo "Order ID không hợp lệ";
    exit;
}

// Gọi API backend để lấy order
$order = null;
$apiUrl = "http://localhost/PR_RESERVATION_FnB_FOR_LIVEMUSIC/api_gateway/index.php?service=order&action=get_order_bank&order_id=$orderId";

$response = file_get_contents($apiUrl);
if ($response) {
    $data = json_decode($response, true);
    if ($data['success'] ?? false) {
        $order = $data['order'];
    }
}

if (!$order) {
    echo "Đơn hàng không tồn tại";
    exit;
}

$total = $order['TOTAL_AMOUNT'] ?? 0;
// Tạo QR tạm (giả lập link thanh toán)
$qrUrl = "https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=" . urlencode("ORDER:$orderId|TOTAL:$total");

?>
<link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/payment_user.css">
<style>
    /*==============================================================*/
/* Payment Page Styles                                         */
/*==============================================================*/
body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background-color: #f5f5f5;
    margin: 0;
    padding: 0;
}

/* Container */
.container {
    max-width: 900px;
    margin: 40px auto;
    padding: 0 15px;
}

/* Card */
.card {
    background-color: #fff;
    border-radius: 12px;
    padding: 25px 20px;
    margin-bottom: 25px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
}

/* Card Titles */
.card h2 {
    margin-top: 0;
    margin-bottom: 15px;
    font-size: 1.6rem;
    color: #222;
}

/* Order Items */
.order-item {
    display: flex;
    justify-content: space-between;
    margin-bottom: 10px;
    padding: 6px 0;
    border-bottom: 1px solid #eee;
}

.order-item span {
    font-size: 1rem;
    color: #333;
}

/* Total Row */
.total {
    display: flex;
    justify-content: space-between;
    font-weight: bold;
    font-size: 1.2rem;
    margin-top: 15px;
}

/* Form Inputs */
input[type="text"], input[type="email"], textarea {
    width: 100%;
    padding: 10px 12px;
    margin-bottom: 15px;
    border-radius: 8px;
    border: 1px solid #ccc;
    font-size: 1rem;
    box-sizing: border-box;
}

textarea {
    resize: vertical;
    min-height: 100px;
}

/* Grid Layout */
.grid-2 {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 15px;
}

.grid-lg-2 {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 25px;
}

/* Buttons */
.btn, .submit-btn, .btn-paid, .btn-resend {
    display: inline-block;
    padding: 10px 22px;
    font-size: 1rem;
    border-radius: 8px;
    text-decoration: none;
    cursor: pointer;
    transition: background-color 0.3s;
    border: none;
    font-weight: 600;
}

/* Confirm / Submit */
.btn, .submit-btn {
    background-color: #007BFF;
    color: #fff;
    width: 100%;
}

.btn:hover, .submit-btn:hover {
    background-color: #0056b3;
}

/* Payment Methods */
.payment-methods {
    display: flex;
    gap: 12px;
    margin-bottom: 15px;
}

.payment-methods .method {
    flex: 1;
    padding: 10px 0;
    text-align: center;
    background-color: #eee;
    border-radius: 8px;
    cursor: pointer;
    font-weight: 600;
    transition: all 0.3s;
}

.payment-methods .method.active {
    background-color: #007BFF;
    color: #fff;
}

/* Checkbox */
.checkbox {
    display: flex;
    align-items: center;
    margin-bottom: 15px;
}

.checkbox input[type="checkbox"] {
    margin-right: 10px;
}

/* QR Container */
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

/* Timer */
#timer {
    font-weight: bold;
    margin-top: 10px;
    color: #ffdd57;
}

/* Responsive */
@media (max-width: 768px) {
    .grid-2, .grid-lg-2 {
        grid-template-columns: 1fr;
    }
    #qr-container {
        width: 90%;
        padding: 20px;
    }
}

</style>
<div id="qr-container">
    <p>Mã đơn hàng: <b><?= $orderId ?></b></p>
    <p>Số tiền: <b><?= number_format($total) ?> VND</b></p>
    <p>Quét QR bên dưới bằng ứng dụng ngân hàng hoặc ví điện tử:</p>
    <img src="<?= $qrUrl ?>" alt="QR Payment">
    <div id="timer"></div>
    <a class="btn-paid" id="btn-paid">Đã thanh toán</a>
    <div id="resend-container" style="display:none;">
        <p>Mã QR hết hạn.</p>
        <a class="btn-resend" id="btn-resend">Gửi lại QR</a>
    </div>
</div>

<script>
const orderId = "<?= $orderId ?>";
let remainingSeconds = 300; // 5 phút

function startTimer() {
    const timerElem = document.getElementById('timer');
    const interval = setInterval(() => {
        if (remainingSeconds <= 0) {
            clearInterval(interval);
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
startTimer();

// Xử lý "Đã thanh toán"
document.getElementById('btn-paid').addEventListener('click', async () => {
    try {
        const res = await fetch(`http://localhost/PR_RESERVATION_FnB_FOR_LIVEMUSIC/api_gateway/index.php?service=order&action=confirm_transfer&order_id=${orderId}`);
        const data = await res.json();
        if (data.success) {
            alert('Đơn hàng đã được xác nhận và email thông báo đã gửi!');
            window.location.href = `index.php?page=user_orders`;
        } else {
            alert(data.message || 'Có lỗi xảy ra');
        }
    } catch(e) {
        alert('Lỗi server, vui lòng thử lại');
    }
});

// Gửi lại QR
document.getElementById('btn-resend').addEventListener('click', () => {
    window.location.reload();
});
</script>
