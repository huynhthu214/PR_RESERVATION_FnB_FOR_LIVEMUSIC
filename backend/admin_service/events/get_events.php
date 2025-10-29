<?php
header('Content-Type: application/json');
require_once __DIR__ . '/../db.php';

// Nếu có session admin → có thể lọc theo người tạo
session_start();
$role = $_SESSION['ROLE'] ?? 'Staff';
$admin_id = $_SESSION['ADMIN_ID'] ?? '';

$sql = "SELECT E.EVENT_ID, V.NAME AS VENUE_NAME, E.BAND_NAME, E.EVENT_DATE, 
               E.TICKET_PRICE, E.STATUS
        FROM EVENTS E
        LEFT JOIN VENUES V ON E.VENUE_ID = V.VENUE_ID";

// if ($role === 'Staff') {
//     // Staff chỉ được xem sự kiện của họ
//     $sql .= " WHERE E.ADMIN_ID = '$admin_id'";
// }

$sql .= " ORDER BY E.EVENT_DATE DESC";

$result = $conn->query($sql);
$events = [];

while ($row = $result->fetch_assoc()) {
    $events[] = [
        "id" => $row['EVENT_ID'],
        "venue" => $row['VENUE_NAME'],
        "band" => $row['BAND_NAME'],
        "date" => $row['EVENT_DATE'],
        "price" => $row['TICKET_PRICE'],
        "status" => $row['STATUS']
    ];
}

echo json_encode(["success" => true, "data" => $events]);
