<?php
require_once __DIR__ . '/../db.php';
header('Content-Type: application/json');

try {
    // Tổng số sự kiện
    $totalEvents = $conn->query("SELECT COUNT(*) AS total_events FROM EVENTS")->fetch_assoc()['total_events'];

    // Giả sử mỗi event có số lượng vé bán (SOLD_TICKETS) và giá vé (TICKET_PRICE)
    $revenueQuery = $conn->query("SELECT SUM(TICKET_PRICE * COALESCE(SOLD_TICKETS, 0)) AS total_revenue FROM EVENTS");
    $totalRevenue = $revenueQuery->fetch_assoc()['total_revenue'] ?? 0;

    // 3 sự kiện gần đây nhất
    $recentEvents = [];
    $result = $conn->query("SELECT EVENT_ID, BAND_NAME, EVENT_DATE, STATUS, TICKET_PRICE FROM EVENTS ORDER BY EVENT_DATE DESC LIMIT 3");
    while ($row = $result->fetch_assoc()) {
        $recentEvents[] = $row;
    }

    // Doanh thu theo tháng (từ EVENTS)
    $monthly = [];
    $res = $conn->query("
        SELECT DATE_FORMAT(EVENT_DATE, '%Y-%m') AS month, 
               SUM(TICKET_PRICE * COALESCE(SOLD_TICKETS, 0)) AS revenue
        FROM EVENTS
        GROUP BY month
        ORDER BY month
    ");
    while ($row = $res->fetch_assoc()) {
        $monthly[] = $row;
    }

    echo json_encode([
        "success" => true,
        "data" => [
            "totalRevenue" => $totalRevenue,
            "totalEvents" => $totalEvents,
            "recentEvents" => $recentEvents,
            "monthlyRevenue" => $monthly
        ]
    ]);
} catch (Exception $e) {
    echo json_encode(["success" => false, "error" => $e->getMessage()]);
}
