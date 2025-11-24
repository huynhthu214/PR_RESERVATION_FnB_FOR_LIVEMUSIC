<?php
require_once __DIR__ . '/../../config.php';

$orderId = $_GET['order_id'] ?? null;

if (!$orderId) {
    echo "Order ID không hợp lệ";
    exit;
}

// Lấy thông tin đơn hàng
$orderSql = "SELECT TOTAL_AMOUNT FROM ORDERS WHERE ORDER_ID = '$orderId'";
$result = $conn_order->query($orderSql);
$order = $result ? $result->fetch_assoc() : null;

if (!$order) {
    echo "Đơn hàng không tồn tại";
    exit;
}

$total = $order['TOTAL_AMOUNT'];

// Tạo QR code (mẫu tĩnh, thay bằng cổng thanh toán thật)
$qrContent = "LIVE-MUSIC-PAY|$orderId|$total";
$qrUrl = "https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=" . urlencode($qrContent);
?>

<link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/payment_user.css">
<div class="container">
    <div class="card">
        <h2>Thanh toán bằng QR</h2>
        <p>Mã đơn hàng: <b><?php echo $orderId; ?></b></p>
        <p>Số tiền: <b><?php echo number_format($total); ?>đ</b></p>

        <p>Quét QR bên dưới bằng ứng dụng ngân hàng hoặc ví điện tử:</p>
        <img src="<?php echo $qrUrl; ?>" alt="QR Payment">

        <p>Sau khi thanh toán, hệ thống sẽ tự động xác nhận đơn hàng.</p>
        <a href="index.php?page=receipt&order_id=<?php echo $orderId; ?>" class="btn">Xem biên nhận</a>
    </div>
</div>
