<?php
header('Content-Type: application/json; charset=UTF-8');

//KẾT NỐI ĐẾN TỪNG SERVICE DB 
$admin_conn = new mysqli("localhost", "root", "", "admindb");
$order_conn = new mysqli("localhost", "root", "", "orderdb");
$customer_conn = new mysqli("localhost", "root", "", "customerdb");
$reservation_conn = new mysqli("localhost", "root", "", "reservationdb");

// Kiểm tra kết nối
if ($admin_conn->connect_error || $order_conn->connect_error || $customer_conn->connect_error || $reservation_conn->connect_error) {
    echo json_encode(["success" => false, "error" => "Không thể kết nối đến database!"]);
    exit;
}

//TỔNG DOANH THU (PAYMENTS)
$revenueQuery = $order_conn->query("SELECT SUM(AMOUNT) AS total FROM PAYMENTS WHERE PAYMENT_STATUS = 'success'");
$total_revenue = $revenueQuery->fetch_assoc()['total'] ?? 0;

//TỔNG SỰ KIỆN (EVENTS)
$eventCount = $admin_conn->query("SELECT COUNT(*) AS total FROM EVENTS");
$total_events = $eventCount->fetch_assoc()['total'] ?? 0;

//ỔNG ĐƠN HÀNG (ORDERS)
$orderCount = $order_conn->query("SELECT COUNT(*) AS total FROM ORDERS");
$total_orders = $orderCount->fetch_assoc()['total'] ?? 0;

//TỔNG KHÁCH HÀNG (CUSTOMER_USERS)
$customerCount = $customer_conn->query("SELECT COUNT(*) AS total FROM CUSTOMER_USERS");
$total_customers = $customerCount->fetch_assoc()['total'] ?? 0;

//DOANH THU THEO THÁNG
$monthly = $order_conn->query("
    SELECT 
        MONTH(PAYMENT_TIME) AS month, 
        SUM(AMOUNT) AS total
    FROM PAYMENTS
    WHERE YEAR(PAYMENT_TIME) = YEAR(CURDATE()) 
      AND PAYMENT_STATUS = 'success'
    GROUP BY MONTH(PAYMENT_TIME)
    ORDER BY MONTH(PAYMENT_TIME)
");
$monthly_revenue = [];
while ($row = $monthly->fetch_assoc()) {
    $monthly_revenue[] = $row;
}
//SỰ KIỆN GẦN ĐÂY
$recentQuery = $admin_conn->query("
    SELECT E.EVENT_ID, E.BAND_NAME, E.EVENT_DATE, E.STATUS, V.CAPACITY 
    FROM EVENTS E
    JOIN VENUES V ON E.VENUE_ID = V.VENUE_ID
    ORDER BY E.EVENT_DATE DESC
    LIMIT 3
");
$recent = [];
while ($row = $recentQuery->fetch_assoc()) {
    // Lấy tổng số vé đã được đặt từ RESERVATIONS service
    $resv = $reservation_conn->query("
        SELECT COUNT(*) AS sold 
        FROM RESERVATIONS 
        WHERE EVENT_ID = '{$row['EVENT_ID']}'
    ")->fetch_assoc()['sold'] ?? 0;

    $recent[] = [
        "name" => $row['BAND_NAME'],
        "date" => $row['EVENT_DATE'],
        "status" => $row['STATUS'],
        "sold" => $resv,
        "capacity" => $row['CAPACITY']
    ];
}

//CHI TIẾT SỰ KIỆN & DOANH THU
$eventDetails = [];
$events = $admin_conn->query("SELECT EVENT_ID, BAND_NAME, EVENT_DATE, STATUS FROM EVENTS");

while ($ev = $events->fetch_assoc()) {
    // Lấy danh sách RESERVATION_ID từ reservationdb
    $resSql = "
        SELECT RESERVATION_ID 
        FROM RESERVATIONS 
        WHERE EVENT_ID = '{$ev['EVENT_ID']}'
    ";
    $resList = $reservation_conn->query($resSql);
    $reservation_ids = [];
    while ($r = $resList->fetch_assoc()) {
        $reservation_ids[] = "'{$r['RESERVATION_ID']}'";
    }

    // Nếu chưa có reservation nào => bỏ qua
    if (empty($reservation_ids)) {
        $eventDetails[] = [
            "id" => $ev['EVENT_ID'],
            "name" => $ev['BAND_NAME'],
            "date" => $ev['EVENT_DATE'],
            "tickets" => 0,
            "revenue" => 0,
            "status" => $ev['STATUS']
        ];
        continue;
    }

    // Lấy doanh thu từ PAYMENTS qua ORDERS trong orderdb
    $resIdsStr = implode(",", $reservation_ids);
    $revenueSql = "
        SELECT SUM(P.AMOUNT) AS total
        FROM PAYMENTS P
        JOIN ORDERS O ON P.ORDER_ID = O.ORDER_ID
        WHERE O.RESERVATION_ID IN ($resIdsStr)
          AND P.PAYMENT_STATUS = 'success'
    ";
    $revenue = $order_conn->query($revenueSql)->fetch_assoc()['total'] ?? 0;

    // Tổng số vé = số RESERVATION_ID
    $tickets = count($reservation_ids);

    // Thêm vào mảng kết quả
    $eventDetails[] = [
        "id" => $ev['EVENT_ID'],
        "name" => $ev['BAND_NAME'],
        "date" => $ev['EVENT_DATE'],
        "tickets" => $tickets,
        "revenue" => $revenue,
        "status" => $ev['STATUS']
    ];
}


// TRẢ KẾT QUẢ
echo json_encode([
    "success" => true,
    "total_revenue" => $total_revenue,
    "total_events" => $total_events,
    "total_orders" => $total_orders,
    "total_customers" => $total_customers,
    "monthly_revenue" => $monthly_revenue,
    "recent_events" => $recent,
    "event_details" => $eventDetails
], JSON_UNESCAPED_UNICODE);

// Đóng kết nối
$admin_conn->close();
$order_conn->close();
$customer_conn->close();
$reservation_conn->close();
