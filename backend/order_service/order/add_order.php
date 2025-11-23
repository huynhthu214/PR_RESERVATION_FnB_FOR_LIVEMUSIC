<?php
header("Content-Type: application/json; charset=UTF-8");
session_start();
require_once __DIR__ . '/../db.php'; // Kết nối DB $conn_order

$input = json_decode(file_get_contents("php://input"), true);

if(!$input){
    echo json_encode(["success"=>false,"message"=>"Thiếu dữ liệu"]);
    exit;
}

// Dữ liệu cơ bản
$name = $conn_order->real_escape_string($input['name'] ?? '');
$email = $conn_order->real_escape_string($input['email'] ?? '');
$phone = $conn_order->real_escape_string($input['phone'] ?? '');
$idCard = $conn_order->real_escape_string($input['idCard'] ?? '');
$paymentMethod = $conn_order->real_escape_string($input['paymentMethod'] ?? '');
$seats = $input['seats'] ?? [];
$menu = $input['menu'] ?? [];
$total = floatval($input['total'] ?? 0);

// Tạo ORDER_ID
$orderId = 'O'.time();

// Lấy CUSTOMER_ID từ session nếu có
$customerId = $_SESSION['CUSTOMER_ID'] ?? null;

// Tạo ORDER
$orderSql = "INSERT INTO ORDERS (ORDER_ID, CUSTOMER_ID, RESERVATION_ID, TOTAL_AMOUNT, STATUS, DELIVERY_NOTES, ORDER_TIME)
             VALUES ('$orderId', ".($customerId ? "'$customerId'" : "NULL").", NULL, $total, 'Pending', '', NOW())";

if(!$conn_order->query($orderSql)){
    echo json_encode(["success"=>false,"message"=>"Lỗi tạo đơn hàng: ".$conn_order->error]);
    exit;
}

// Tạo ORDER_ITEMS
foreach($menu as $item){
    $orderItemId = 'OI'.time().rand(100,999);
    $itemId = $conn_order->real_escape_string($item['item_id']);
    $qty = intval($item['quantity']);
    $unitPrice = floatval($item['unit_price']);

    $sqlItem = "INSERT INTO ORDER_ITEMS (ORDER_ITEM_ID, ORDER_ID, ITEM_ID, QUANTITY, UNIT_PRICE)
                VALUES ('$orderItemId', '$orderId', '$itemId', $qty, $unitPrice)";
    if(!$conn_order->query($sqlItem)){
        echo json_encode(["success"=>false,"message"=>"Lỗi thêm món: ".$conn_order->error]);
        exit;
    }
}

// Tạo PAYMENT
$paymentId = 'P'.time();
$transactionId = 'T'.time();
$paymentSql = "INSERT INTO PAYMENTS (PAYMENT_ID, ORDER_ID, CUSTOMER_ID, AMOUNT, PAYMENT_METHOD, TRANSACTION_ID, PAYMENT_TIME, PAYMENT_STATUS)
               VALUES ('$paymentId', '$orderId', ".($customerId ? "'$customerId'" : "NULL").", $total, '$paymentMethod', '$transactionId', NOW(), 'Completed')";

if(!$conn_order->query($paymentSql)){
    echo json_encode(["success"=>false,"message"=>"Lỗi tạo payment: ".$conn_order->error]);
    exit;
}

// Xóa session tạm thời
unset($_SESSION['selectedSeats']);
unset($_SESSION['order_menu']);

// Trả kết quả
echo json_encode([
    "success"=>true,
    "order_id"=>$orderId,
    "message"=>"Đặt hàng thành công"
]);
?>
