<?php
header("Content-Type: application/json; charset=UTF-8");
session_start();
require_once __DIR__ . '/../db.php';

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

// ======================= TẠO ORDER_ID ============================
$sqlLastOrder = "SELECT ORDER_ID FROM ORDERS ORDER BY ORDER_TIME DESC LIMIT 1";
$resOrder = $conn_order->query($sqlLastOrder);
$lastOrderId = ($resOrder && $resOrder->num_rows > 0) ? $resOrder->fetch_assoc()['ORDER_ID'] : 'O000';

$newOrderNum = intval(substr($lastOrderId, 1)) + 1;
$orderId = 'O' . str_pad($newOrderNum, 3, '0', STR_PAD_LEFT);
// ================================================================

// Lấy CUSTOMER_ID từ session nếu có
$customerId = $_SESSION['CUSTOMER_ID'] ?? null;

// Tạo ORDER (STATUS luôn Pending)
$orderSql = "INSERT INTO ORDERS (ORDER_ID, CUSTOMER_ID, RESERVATION_ID, TOTAL_AMOUNT, STATUS, DELIVERY_NOTES, ORDER_TIME)
             VALUES ('$orderId', ".($customerId ? "'$customerId'" : "NULL").", NULL, $total, 'Pending', '', NOW())";

if(!$conn_order->query($orderSql)){
    echo json_encode(["success"=>false,"message"=>"Lỗi tạo đơn hàng: ".$conn_order->error]);
    exit;
}

// ======================= TẠO ORDER_ITEM_ID =======================
$sqlLastItem = "SELECT ORDER_ITEM_ID FROM ORDER_ITEMS ORDER BY ORDER_ITEM_ID DESC LIMIT 1";
$resItem = $conn_order->query($sqlLastItem);
$lastItemId = ($resItem && $resItem->num_rows > 0) ? $resItem->fetch_assoc()['ORDER_ITEM_ID'] : 'OI000';

$itemCounter = intval(substr($lastItemId, 2));
// ================================================================


// Tạo ORDER_ITEMS
foreach($menu as $item){
    $itemCounter++;
    $orderItemId = 'OI' . str_pad($itemCounter, 3, '0', STR_PAD_LEFT);

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

// ======================= TẠO PAYMENT_ID ===========================
$sqlLastPay = "SELECT PAYMENT_ID FROM PAYMENTS ORDER BY PAYMENT_TIME DESC LIMIT 1";
$resPay = $conn_order->query($sqlLastPay);
$lastPayId = ($resPay && $resPay->num_rows > 0) ? $resPay->fetch_assoc()['PAYMENT_ID'] : 'PAY000';

$newPayNum = intval(substr($lastPayId, 3)) + 1;

$paymentId = 'PAY' . str_pad($newPayNum, 3, '0', STR_PAD_LEFT);
$transactionId = 'T' . str_pad($newPayNum, 3, '0', STR_PAD_LEFT);
// =================================================================


// Tạo PAYMENT → LUÔN để trạng thái Pending
$paymentSql = "INSERT INTO PAYMENTS (PAYMENT_ID, ORDER_ID, CUSTOMER_ID, AMOUNT, PAYMENT_METHOD, TRANSACTION_ID, PAYMENT_TIME, PAYMENT_STATUS)
               VALUES ('$paymentId', '$orderId', ".($customerId ? "'$customerId'" : "NULL").", 
               $total, '$paymentMethod', '$transactionId', NOW(), 'Pending')";

if(!$conn_order->query($paymentSql)){
    echo json_encode(["success"=>false,"message"=>"Lỗi tạo payment: ".$conn_order->error]);
    exit;
}

// Xóa session tạm
unset($_SESSION['selectedSeats']);
unset($_SESSION['order_menu']);

echo json_encode([
    "success"=>true,
    "order_id"=>$orderId,
    "message"=>"Đặt hàng thành công. Vui lòng chuyển khoản để hoàn tất thanh toán."
]);
?>
