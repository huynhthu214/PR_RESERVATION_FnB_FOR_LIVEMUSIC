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
?>

<link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/payment_user.css">

<style>
/* Container trung tâm và dịch lên */
.container {
    display: flex;
    justify-content: center; /* căn giữa ngang */
    align-items: flex-start; /* dịch lên trên một chút */
    min-height: 90vh;        /* chiếm gần hết chiều cao */
    padding-top: 40px;       /* dịch lên trên 1 chút */
    margin-top: -20px;
}

/* Card lớn hơn */
.container .card {
    width: 600px;            /* rộng hơn */
    padding: 30px 40px;      /* padding lớn hơn */
    font-size: 1.1rem;       /* chữ lớn hơn */
    box-shadow: 0 4px 12px rgba(0,0,0,0.15); /* nổi bật */
    border-radius: 12px;
}

.card h2{
    text-align: center;
}

.card .btn {
    display: inline-block;
    padding: 8px 16px;   /* nhỏ hơn padding mặc định */
    font-size: 0.95rem;  /* chữ nhỏ hơn */
    width: auto;         /* không full width */
    text-align: center;
    margin-top: 20px;
    text-decoration: none;
}
</style>

<div class="container">
    <div class="card">
        <h2>Hướng dẫn chuyển khoản</h2>
        <p>Mã đơn hàng: <b><?php echo htmlspecialchars($orderId); ?></b></p>
        <p>Số tiền: <b><?php echo number_format($total); ?> VND</b></p>

        <h3>Thông tin ngân hàng</h3>
        <ul>
            <li>Ngân hàng: Vietcombank</li>
            <li>Chủ tài khoản: LiveMusic VN</li>
            <li>Số tài khoản: 123456789</li>
            <li>Nội dung chuyển tiền: <b><?php echo htmlspecialchars($orderId); ?></b></li>
        </ul>

        <p style="margin-top:40px; color:#ee6307;">Sau khi chuyển khoản, đơn hàng sẽ được xác nhận và gửi email thông báo.</p>
        <a href="#" class="btn" id="confirm-transfer-btn">Đã chuyển khoản</a>
    </div>
</div>

<script>
document.getElementById('confirm-transfer-btn').addEventListener('click', async () => {
    const orderId = "<?php echo htmlspecialchars($orderId); ?>";

    const res = await fetch(`http://localhost/PR_RESERVATION_FnB_FOR_LIVEMUSIC/api_gateway/index.php?service=order&action=confirm_transfer&order_id=${orderId}`);
    const data = await res.json();

    if (data.success) {
        window.location.href = `index.php?page=user_orders&order_id=${orderId}`;
    } else {
        alert(data.message || 'Có lỗi xảy ra');
    }
});
</script>