<?php
header('Content-Type: application/json');
require_once __DIR__ . '/../db.php'; 

session_start();

// Giả sử CUSTOMER_ID đang login
$customer_id = $_SESSION['CUSTOMER_ID'] ?? null;
if (!$customer_id) {
    echo json_encode(["success" => false, "message" => "Chưa login"]);
    exit;
}

// Lấy notification cho customer, sắp xếp mới nhất trước
$sql = "SELECT NOTIFICATION_ID, TITLE, MESSAGE, LINK, SENT_AT, IS_READ 
        FROM NOTIFICATIONS 
        WHERE RECEIVER_ID = ? AND RECEIVER_TYPE = 'customer' 
        ORDER BY SENT_AT DESC";

$stmt = $conn_noti->prepare($sql);
$stmt->bind_param("s", $customer_id);
$stmt->execute();
$result = $stmt->get_result();

$notifications = [];
while ($row = $result->fetch_assoc()) {
    $notifications[] = [
        "id"       => $row['NOTIFICATION_ID'],
        "title"    => $row['TITLE'],
        "message"  => $row['MESSAGE'],
        "link"     => $row['LINK'],
        "sent_at"  => $row['SENT_AT'],
        "is_read"  => (bool)$row['IS_READ']
    ];
}

echo json_encode(["success" => true, "data" => $notifications]);
