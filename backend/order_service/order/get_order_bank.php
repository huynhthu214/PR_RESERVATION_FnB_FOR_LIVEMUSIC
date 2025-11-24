<?php
header('Content-Type: application/json; charset=UTF-8');
require_once __DIR__ . '/../db.php';
$action = $_GET['action'] ?? null;

if ($action === 'get_order_bank') {
    $orderId = $_GET['order_id'] ?? null;

    if (!$orderId) {
        echo json_encode(['success' => false, 'message' => 'Order ID không hợp lệ']);
        exit;
    }

    // Query DB lấy thông tin order
    $stmt = $conn_order->prepare("SELECT ORDER_ID, CUSTOMER_ID, TOTAL_AMOUNT, STATUS, ORDER_TIME FROM ORDERS WHERE ORDER_ID = ?");
    $stmt->bind_param("s", $orderId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        echo json_encode(['success' => false, 'message' => 'Đơn hàng không tồn tại']);
        exit;
    }

    $order = $result->fetch_assoc();

    // Lấy chi tiết ORDER_ITEMS (ghế + menu)
    $stmtItems = $conn_order->prepare("SELECT ITEM_ID, QUANTITY, UNIT_PRICE FROM ORDER_ITEMS WHERE ORDER_ID = ?");
    $stmtItems->bind_param("s", $orderId);
    $stmtItems->execute();
    $itemsResult = $stmtItems->get_result();

    $items = [];
    while ($row = $itemsResult->fetch_assoc()) {
        $items[] = $row;
    }

    $order['items'] = $items;

    echo json_encode([
        'success' => true,
        'order' => $order
    ]);
    exit;
}