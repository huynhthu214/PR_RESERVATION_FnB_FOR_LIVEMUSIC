<?php
header('Content-Type: application/json; charset=UTF-8');
session_start();

// Kết nối các service
require_once __DIR__ . '/../db.php';                   // order_service
require_once __DIR__ . '/../../customer_service/db.php';
require_once __DIR__ . '/../../reservation_service/db.php';
require_once __DIR__ . '/../../admin_service/db.php';  // admin_service

// Đảm bảo session có CUSTOMER_ID
$userId = $_SESSION['CUSTOMER_ID'] ?? null;
if (!$userId) {
    echo json_encode(['success'=>false, 'message'=>'Bạn chưa đăng nhập']);
    exit;
}

$orders = [];

// Lấy tất cả order của user từ order service
$stmt = $conn_order->prepare("SELECT * FROM ORDERS WHERE CUSTOMER_ID=? ORDER BY ORDER_TIME DESC");
$stmt->bind_param("s", $userId);
$stmt->execute();
$resOrders = $stmt->get_result();

while ($order = $resOrders->fetch_assoc()) {
    $orderId = $order['ORDER_ID'];

    // Lấy ORDER_ITEMS + tên món từ MENU_ITEMS
    $stmtItem = $conn_order->prepare("
        SELECT oi.ORDER_ITEM_ID, oi.ORDER_ID, oi.ITEM_ID, oi.QUANTITY, oi.UNIT_PRICE, mi.NAME
        FROM ORDER_ITEMS oi
        LEFT JOIN admindb.MENU_ITEMS mi ON oi.ITEM_ID = mi.ITEM_ID
        WHERE oi.ORDER_ID=?
    ");
    $stmtItem->bind_param("s", $orderId);
    $stmtItem->execute();
    $resItem = $stmtItem->get_result();
    $items = [];
    while ($row = $resItem->fetch_assoc()) {
        $items[] = $row;
    }

    // Lấy PAYMENT
    $stmtPay = $conn_order->prepare("SELECT * FROM PAYMENTS WHERE ORDER_ID=?");
    $stmtPay->bind_param("s", $orderId);
    $stmtPay->execute();
    $payment = $stmtPay->get_result()->fetch_assoc() ?? null;

    // Lấy RESERVATION + EVENT + VENUE nếu có
    $reservation = null;
    if (!empty($order['RESERVATION_ID'])) {
        $stmtRes = $conn->prepare("
            SELECT r.*, e.EVENT_NAME, e.EVENT_DATE, e.START_TIME, e.END_TIME, e.TICKET_PRICE, v.NAME as VENUE_NAME, v.ADDRESS as VENUE_ADDRESS
            FROM RESERVATIONS r
            LEFT JOIN admindb.EVENTS e ON r.EVENT_ID = e.EVENT_ID
            LEFT JOIN admindb.VENUES v ON e.VENUE_ID = v.VENUE_ID
            WHERE r.RESERVATION_ID=?
        ");
        $stmtRes->bind_param("s", $order['RESERVATION_ID']);
        $stmtRes->execute();
        $reservation = $stmtRes->get_result()->fetch_assoc() ?? null;
    }
    $order['seats'] = json_decode($order['SEATS_JSON'] ?? '[]', true);

    $orders[] = [
        'order' => $order,
        'items' => $items,
        'payment' => $payment,
        'reservation' => $reservation
    ];

}


// Trả về JSON
echo json_encode(['success'=>true,'orders'=>$orders]);
exit;
?>
