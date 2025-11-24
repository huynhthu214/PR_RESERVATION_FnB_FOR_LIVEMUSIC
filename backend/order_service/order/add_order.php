<?php
header("Content-Type: application/json; charset=UTF-8");
session_start();

// Kết nối DB order service
require_once __DIR__ . '/../db.php'; // $conn_order
// Kết nối DB reservation service
require_once __DIR__ . '/../../reservation_service/db.php'; // $conn_reservation

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
$eventId = $conn_order->real_escape_string($input['event_id'] ?? 'E001');

// Lấy CUSTOMER_ID từ session
$customerId = $_SESSION['CUSTOMER_ID'] ?? null;

// ==========================
// 1. Tạo RESERVATION
// ==========================
$sqlLastRes = "SELECT RESERVATION_ID FROM RESERVATIONS ORDER BY RESERVATION_ID DESC LIMIT 1";
$resRes = $conn->query($sqlLastRes);
$lastResId = ($resRes && $resRes->num_rows > 0) ? $resRes->fetch_assoc()['RESERVATION_ID'] : 'R000';
$newResNum = intval(substr($lastResId,1)) + 1;
$reservationId = 'R' . str_pad($newResNum, 3, '0', STR_PAD_LEFT);

$sqlInsertRes = "INSERT INTO RESERVATIONS
    (RESERVATION_ID, EVENT_ID, CUSTOMER_ID, RESERVATION_TIME, STATUS, TOTAL_AMOUNT)
    VALUES
    ('$reservationId', '$eventId', ".($customerId ? "'$customerId'" : "NULL").", NOW(), 'Pending', $total)";
if(!$conn->query($sqlInsertRes)){
    echo json_encode(["success"=>false,"message"=>"Lỗi tạo reservation: ".$conn->error]);
    exit;
}

// ==========================
// 2. Tạo ORDER
// ==========================
$sqlLastOrder = "SELECT ORDER_ID FROM ORDERS ORDER BY ORDER_ID DESC LIMIT 1";
$resOrder = $conn_order->query($sqlLastOrder);
$lastOrderId = ($resOrder && $resOrder->num_rows > 0) ? $resOrder->fetch_assoc()['ORDER_ID'] : 'O000';
$newOrderNum = intval(substr($lastOrderId,1)) + 1;
$orderId = 'O'.str_pad($newOrderNum,3,'0',STR_PAD_LEFT);

$orderSql = "INSERT INTO ORDERS
    (ORDER_ID, CUSTOMER_ID, RESERVATION_ID, TOTAL_AMOUNT, STATUS, DELIVERY_NOTES, ORDER_TIME)
    VALUES
    ('$orderId', ".($customerId ? "'$customerId'" : "NULL").", '$reservationId', $total, 'Pending', '', NOW())";
if(!$conn_order->query($orderSql)){
    echo json_encode(["success"=>false,"message"=>"Lỗi tạo order: ".$conn_order->error]);
    exit;
}

// ==========================
// 3. Tạo ORDER_ITEMS
// ==========================
$sqlLastItem = "SELECT ORDER_ITEM_ID FROM ORDER_ITEMS ORDER BY ORDER_ITEM_ID DESC LIMIT 1";
$resItem = $conn_order->query($sqlLastItem);
$lastItemId = ($resItem && $resItem->num_rows > 0) ? $resItem->fetch_assoc()['ORDER_ITEM_ID'] : 'OI000';
$itemCounter = intval(substr($lastItemId,2));

foreach($menu as $item){
    $itemCounter++;
    $orderItemId = 'OI'.str_pad($itemCounter,3,'0',STR_PAD_LEFT);
    $itemId = $conn_order->real_escape_string($item['item_id']);
    $qty = intval($item['quantity']);
    $unitPrice = floatval($item['unit_price']);

    $sqlItem = "INSERT INTO ORDER_ITEMS
        (ORDER_ITEM_ID, ORDER_ID, ITEM_ID, QUANTITY, UNIT_PRICE)
        VALUES ('$orderItemId', '$orderId', '$itemId', $qty, $unitPrice)";
    if(!$conn_order->query($sqlItem)){
        echo json_encode(["success"=>false,"message"=>"Lỗi thêm món: ".$conn_order->error]);
        exit;
    }
}

// ==========================
// 4. Tạo PAYMENT (Pending)
// ==========================
$sqlLastPay = "SELECT PAYMENT_ID FROM PAYMENTS ORDER BY PAYMENT_ID DESC LIMIT 1";
$resPay = $conn_order->query($sqlLastPay);
$lastPayId = ($resPay && $resPay->num_rows > 0) ? $resPay->fetch_assoc()['PAYMENT_ID'] : 'PAY000';
$newPayNum = intval(substr($lastPayId,3)) + 1;
$paymentId = 'PAY'.str_pad($newPayNum,3,'0',STR_PAD_LEFT);
$transactionId = 'T'.str_pad($newPayNum,3,'0',STR_PAD_LEFT);

$paymentSql = "INSERT INTO PAYMENTS
    (PAYMENT_ID, ORDER_ID, CUSTOMER_ID, AMOUNT, PAYMENT_METHOD, TRANSACTION_ID, PAYMENT_TIME, PAYMENT_STATUS)
    VALUES
    ('$paymentId', '$orderId', ".($customerId ? "'$customerId'" : "NULL").", $total, '$paymentMethod', '$transactionId', NOW(), 'Pending')";
if(!$conn_order->query($paymentSql)){
    echo json_encode(["success"=>false,"message"=>"Lỗi tạo payment: ".$conn_order->error]);
    exit;
}

// ==========================
// 5. Xóa session tạm
// ==========================
unset($_SESSION['selectedSeats']);
unset($_SESSION['order_menu']);
unset($_SESSION['reservation_id']);

// ==========================
// 6. Trả kết quả
// ==========================
echo json_encode([
    "success" => true,
    "reservation_id" => $reservationId,
    "order_id" => $orderId,
    "payment_id" => $paymentId,
    "message" => "Đặt hàng thành công, thanh toán đang ở trạng thái Pending."
]);
?>
