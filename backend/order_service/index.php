<?php
require_once 'db.php';
header("Content-Type: application/json");

$action = $_GET['action'] ?? '';

switch ($action) {

    case 'get_all_orders':
        $sql = "SELECT ORDER_ID, CUSTOMER_ID, TOTAL_AMOUNT, STATUS, ORDER_TIME FROM ORDERS";
        $result = $conn->query($sql);
        $orders = [];
        while ($row = $result->fetch_assoc()) $orders[] = $row;
        echo json_encode($orders);
        break;

    case 'get_order_items':
        $orderId = $_GET['order_id'] ?? '';
        if (!$orderId) {
            echo json_encode(["error" => "Thiếu mã đơn hàng"]);
            exit;
        }
        $stmt = $conn->prepare("SELECT * FROM ORDER_ITEMS WHERE ORDER_ID = ?");
        $stmt->bind_param("s", $orderId);
        $stmt->execute();
        $res = $stmt->get_result();
        $items = [];
        while ($row = $res->fetch_assoc()) $items[] = $row;
        echo json_encode($items);
        break;

    default:
        echo json_encode(["error" => "Action không hợp lệ trong order_service"]);
}
$conn->close();
