<?php
header("Content-Type: application/json; charset=UTF-8");
require_once __DIR__ . '/../db.php'; 

$orderId = $_GET['order_id'] ?? null;

if (!$orderId) {
    echo json_encode(["success"=>false,"message"=>"Order ID không hợp lệ"]);
    exit;
}

// Lấy thông tin đơn hàng
$orderSql = "SELECT TOTAL_AMOUNT, STATUS FROM ORDERS WHERE ORDER_ID = '$orderId'";
$result = $conn_order->query($orderSql);
$order = $result ? $result->fetch_assoc() : null;

if (!$order) {
    echo json_encode(["success"=>false,"message"=>"Đơn hàng không tồn tại"]);
    exit;
}

$total = $order['TOTAL_AMOUNT'];
$status = $order['STATUS'];

// Tạo QR code (hiện tại là QR tĩnh)
$qrContent = "LIVE-MUSIC-PAY|$orderId|$total";
$qrUrl = "https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=" . urlencode($qrContent);

echo json_encode([
    "success" => true,
    "order_id" => $orderId,
    "total" => $total,
    "status" => $status,
    "qr_url" => $qrUrl
]);
