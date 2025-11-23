<?php
session_start();
header('Content-Type: application/json; charset=UTF-8');

// Kiểm tra session
if (!isset($_SESSION['CUSTOMER_ID'])) {
    echo json_encode(["success" => false, "message" => "Chưa đăng nhập"]);
    exit;
}

$customerId = $_SESSION['CUSTOMER_ID'];

// Kết nối tới 3 database riêng biệt
require_once __DIR__ . '/../db.php';                 // chứa $conn_order
require_once __DIR__ . '/../../admin_service/db.php'; // chứa $conn_admin
require_once __DIR__ . '/../../customer_service/db.php'; // chứa $conn_customer

/* ============================================================
   LẤY ĐƠN HÀNG GẦN NHẤT CỦA KHÁCH HÀNG
============================================================ */
$sql_order = "SELECT 
                  ORDER_ID, CUSTOMER_ID, RESERVATION_ID, PROMO_ID, 
                  ORDER_TIME, TOTAL_AMOUNT, STATUS, DELIVERY_NOTES
              FROM ORDERS
              WHERE CUSTOMER_ID = ?
              ORDER BY ORDER_TIME DESC
              LIMIT 1";

$stmt_order = $conn_order->prepare($sql_order);
if (!$stmt_order) {
    echo json_encode(["success" => false, "error" => "Lỗi prepare (order): " . $conn_order->error]);
    exit;
}

$stmt_order->bind_param("s", $customerId);
$stmt_order->execute();
$order_result = $stmt_order->get_result();
$order = $order_result->fetch_assoc();
$stmt_order->close();

if (!$order) {
    echo json_encode(["success" => false, "message" => "Chưa có đơn hàng nào"]);
    exit;
}

/* ============================================================
   LẤY THÔNG TIN KHÁCH HÀNG
============================================================ */
$customer_name = "(Không xác định)";
$sql_customer = "SELECT USERNAME FROM CUSTOMER_USERS WHERE CUSTOMER_ID = ?";
$stmt_cus = $conn_customer->prepare($sql_customer);
if ($stmt_cus) {
    $stmt_cus->bind_param("s", $customerId);
    $stmt_cus->execute();
    $res_cus = $stmt_cus->get_result();
    if ($row_cus = $res_cus->fetch_assoc()) {
        $customer_name = $row_cus['USERNAME'];
    }
    $stmt_cus->close();
}

/* ============================================================
   LẤY DANH SÁCH MÓN ĂN
============================================================ */
$sql_items = "SELECT ORDER_ITEM_ID, ITEM_ID, QUANTITY, UNIT_PRICE
              FROM ORDER_ITEMS
              WHERE ORDER_ID = ?";
$stmt_items = $conn_order->prepare($sql_items);
if (!$stmt_items) {
    echo json_encode(["success" => false, "error" => "Lỗi prepare (items): " . $conn_order->error]);
    exit;
}
$stmt_items->bind_param("s", $order['ORDER_ID']);
$stmt_items->execute();
$items_result = $stmt_items->get_result();

$items = [];
while ($item_row = $items_result->fetch_assoc()) {
    $item_name = "(Không xác định)";

    // Lấy tên món ăn từ admin DB
    $stmt_menu = $conn_admin->prepare("SELECT NAME FROM MENU_ITEMS WHERE ITEM_ID = ?");
    if ($stmt_menu) {
        $stmt_menu->bind_param("s", $item_row['ITEM_ID']);
        $stmt_menu->execute();
        $res_menu = $stmt_menu->get_result();
        if ($menu_row = $res_menu->fetch_assoc()) {
            $item_name = $menu_row['NAME'];
        }
        $stmt_menu->close();
    }

    $items[] = [
        "order_item_id" => $item_row['ORDER_ITEM_ID'],
        "item_id"       => $item_row['ITEM_ID'],
        "item_name"     => $item_name,
        "quantity"      => $item_row['QUANTITY'],
        "unit_price"    => $item_row['UNIT_PRICE']
    ];
}
$stmt_items->close();

/* ============================================================
   ĐÓNG KẾT NỐI & TRẢ KẾT QUẢ
============================================================ */
$conn_order->close();
$conn_admin->close();
$conn_customer->close();

echo json_encode([
    "success" => true,
    "data" => [
        "ORDER_ID"      => $order['ORDER_ID'],
        "CUSTOMER_NAME" => $customer_name,
        "EMAIL"         => "", // có thể thêm email từ CUSTOMER_USERS
        "ORDER_DATE"    => $order['ORDER_TIME'],
        "STATUS"        => strtolower($order['STATUS']),
        "TOTAL_AMOUNT"  => $order['TOTAL_AMOUNT'],
        "ITEMS"         => array_map(function($i) {
            return [
                "PRODUCT_NAME" => $i['item_name'],
                "QUANTITY"     => $i['quantity'],
                "UNIT_PRICE"   => $i['unit_price'],
                "SUBTOTAL"     => $i['quantity'] * $i['unit_price']
            ];
        }, $items)
    ]
]);
?>
