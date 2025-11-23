<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once __DIR__ . '/../db.php'; 
$receiver_id = $_GET['receiver_id'] ?? null;
$receiver_type = $_GET['receiver_type'] ?? 'CUSTOMER';

if (!$receiver_id) {
    echo json_encode(["success" => false, "message" => "Thiếu receiver_id"]);
    exit;
}

$sql = "SELECT NOTIFICATION_ID, TITLE, MESSAGE, TYPE, LINK, SENT_AT, IS_READ 
        FROM NOTIFICATIONS 
        WHERE RECEIVER_ID = ? AND RECEIVER_TYPE = ?
        ORDER BY SENT_AT DESC";

$stmt = $conn_noti->prepare($sql);
if (!$stmt) {
    echo json_encode(["success" => false, "message" => "Lỗi chuẩn bị SQL: " . $conn_noti->error]);
    exit;
}

$stmt->bind_param("ss", $receiver_id, $receiver_type);

if ($stmt->execute()) {
    $result = $stmt->get_result();
    $notifications = $result->fetch_all(MYSQLI_ASSOC);
    echo json_encode(["success" => true, "data" => $notifications]);
} else {
    echo json_encode(["success" => false, "message" => "Lỗi truy vấn SQL: " . $conn_noti->error]);
}

$stmt->close();
$conn_noti->close();
?>
