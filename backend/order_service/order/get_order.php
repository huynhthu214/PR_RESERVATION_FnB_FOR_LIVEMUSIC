<?php
header('Content-Type: application/json; charset=UTF-8');

// Kết nối tới 2 database
require_once __DIR__ . '/../db.php'; // => $conn_order (orderdb)
require_once __DIR__ . '/../../customer_service/db.php'; // => $conn_customer (customerdb)

if (!$conn_order || !$conn_customer) {
    echo json_encode(["success" => false, "message" => "Không thể kết nối database."]);
    exit;
}

// Nếu có customer_id thì lọc, nếu không thì lấy tất cả
$has_customer = isset($_GET['customer_id']);
if ($has_customer) {
    $sql = "SELECT * FROM ORDERS WHERE CUSTOMER_ID = ? ORDER BY ORDER_TIME DESC";
    $stmt = $conn_order->prepare($sql);
    $stmt->bind_param("s", $_GET['customer_id']);
} else {
    $sql = "SELECT * FROM ORDERS ORDER BY ORDER_TIME DESC";
    $stmt = $conn_order->prepare($sql);
}

if (!$stmt) {
    echo json_encode(["success" => false, "error" => $conn_order->error]);
    exit;
}

$stmt->execute();
$result = $stmt->get_result();

$orders = [];
while ($row = $result->fetch_assoc()) {
    // --- Lấy tên khách hàng từ customerdb ---
    $customer_name = "Không rõ";
    if (!empty($row['CUSTOMER_ID'])) {
        $sql_cus = "SELECT USERNAME FROM CUSTOMER_USERS WHERE CUSTOMER_ID = ?";
        $stmt_cus = $conn_customer->prepare($sql_cus);
        if ($stmt_cus) {
            $stmt_cus->bind_param("s", $row['CUSTOMER_ID']);
            $stmt_cus->execute();
            $res_cus = $stmt_cus->get_result();
            if ($cus = $res_cus->fetch_assoc()) {
                $customer_name = $cus['USERNAME'];
            }
            $stmt_cus->close();
        }
    }

    // --- Gom dữ liệu đơn hàng ---
    $orders[] = [
        "order_id"       => $row['ORDER_ID'],
        "customer_id"    => $row['CUSTOMER_ID'],
        "customer_name"  => $customer_name,
        "reservation_id" => $row['RESERVATION_ID'],
        "order_time"     => $row['ORDER_TIME'],
        "total_amount"   => $row['TOTAL_AMOUNT'],
        "status"         => $row['STATUS'],
        "delivery_notes" => $row['DELIVERY_NOTES']
    ];
}

// --- Xuất kết quả ---
echo json_encode([
    "success" => true,
    "mode"    => $has_customer ? "customer" : "admin",
    "count"   => count($orders),
    "data"    => $orders
]);

$stmt->close();
$conn_order->close();
$conn_customer->close();
?>
