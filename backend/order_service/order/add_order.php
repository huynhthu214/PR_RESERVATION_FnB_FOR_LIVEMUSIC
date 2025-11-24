<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header("Content-Type: application/json; charset=UTF-8");
session_start();
require_once __DIR__ . '/../db.php';

// Đọc input JSON
$input = json_decode(file_get_contents("php://input"), true);

if (!$input || !is_array($input)) {
    echo json_encode(["success" => false, "message" => "Thiếu dữ liệu JSON hoặc JSON không hợp lệ"]);
    exit;
}

// Lấy dữ liệu cơ bản
$name = $conn_order->real_escape_string($input['name'] ?? '');
$email = $conn_order->real_escape_string($input['email'] ?? '');
$phone = $conn_order->real_escape_string($input['phone'] ?? '');
$idCard = $conn_order->real_escape_string($input['idCard'] ?? '');
$paymentMethod = $conn_order->real_escape_string($input['paymentMethod'] ?? '');
$seats = $input['seats'] ?? [];
$menu = $input['menu'] ?? [];
$total = floatval($input['total'] ?? 0);

// Lấy CUSTOMER_ID từ session nếu có
$customerId = $_SESSION['CUSTOMER_ID'] ?? null;

// Tạo ORDER_ID duy nhất
$orderId = 'O' . uniqid('', true);

// Tạo ORDER
$orderSql = "INSERT INTO ORDERS (ORDER_ID, CUSTOMER_ID, RESERVATION_ID, TOTAL_AMOUNT, STATUS, DELIVERY_NOTES, ORDER_TIME)
             VALUES ('$orderId', ".($customerId ? "'$customerId'" : "NULL").", NULL, $total, 'Pending', '', NOW())";

if (!$conn_order->query($orderSql)) {
    echo json_encode(["success" => false, "message" => "Lỗi tạo đơn hàng: " . $conn_order->error]);
    exit;
}

// Thêm ORDER_ITEMS cho ghế
foreach ($seats as $seat) {
    $orderItemId = 'OI' . uniqid('', true);
    $itemId = $conn_order->real_escape_string($seat['id']);
    $qty = intval($seat['quantity'] ?? 1);
    $unitPrice = floatval($seat['price']);

    $sqlItem = "INSERT INTO ORDER_ITEMS (ORDER_ITEM_ID, ORDER_ID, ITEM_ID, QUANTITY, UNIT_PRICE)
                VALUES ('$orderItemId', '$orderId', '$itemId', $qty, $unitPrice)";
    if (!$conn_order->query($sqlItem)) {
        echo json_encode(["success" => false, "message" => "Lỗi thêm ghế: " . $conn_order->error]);
        exit;
    }
}

// Thêm ORDER_ITEMS cho menu
foreach ($menu as $item) {
    $orderItemId = 'OI' . uniqid('', true);
    $itemId = $conn_order->real_escape_string($item['item_id']);
    $qty = intval($item['quantity']);
    $unitPrice = floatval($item['unit_price']);

    $sqlItem = "INSERT INTO ORDER_ITEMS (ORDER_ITEM_ID, ORDER_ID, ITEM_ID, QUANTITY, UNIT_PRICE)
                VALUES ('$orderItemId', '$orderId', '$itemId', $qty, $unitPrice)";
    if (!$conn_order->query($sqlItem)) {
        echo json_encode(["success" => false, "message" => "Lỗi thêm món: " . $conn_order->error]);
        exit;
    }
}

// Tạo PAYMENT
$paymentId = 'P' . uniqid('', true);
$transactionId = 'T' . uniqid('', true);

$paymentSql = "INSERT INTO PAYMENTS (PAYMENT_ID, ORDER_ID, CUSTOMER_ID, AMOUNT, PAYMENT_METHOD, TRANSACTION_ID, PAYMENT_TIME, PAYMENT_STATUS)
               VALUES ('$paymentId', '$orderId', ".($customerId ? "'$customerId'" : "NULL").", $total, '$paymentMethod', '$transactionId', NOW(), 'Completed')";

if (!$conn_order->query($paymentSql)) {
    echo json_encode(["success" => false, "message" => "Lỗi tạo payment: " . $conn_order->error]);
    exit;
}

// Xóa session tạm
unset($_SESSION['selectedSeats']);
unset($_SESSION['order_menu']);

// Trả kết quả
echo json_encode([
    "success" => true,
    "order_id" => $orderId,
    "message" => "Đặt hàng thành công"
]);
