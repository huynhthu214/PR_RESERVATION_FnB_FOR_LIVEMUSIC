<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once __DIR__ . '/../db.php'; // Kết nối DB

$notification_id = $_GET['notification_id'] ?? null;

if (!$notification_id) {
    echo json_encode(["success" => false, "message" => "Thiếu notification_id"]);
    exit;
}

$sql = "SELECT NOTIFICATION_ID, SENDER_ID, RECEIVER_ID, RECEIVER_TYPE, TITLE, MESSAGE, TYPE, LINK, SENT_AT, IS_READ 
        FROM NOTIFICATIONS 
        WHERE NOTIFICATION_ID = ?";

$stmt = $conn->prepare($sql);
if (!$stmt) {
    echo json_encode(["success" => false, "message" => "Lỗi chuẩn bị SQL: " . $conn->error]);
    exit;
}

$stmt->bind_param("s", $notification_id);
$stmt->execute();
$result = $stmt->get_result();
$notification = $result->fetch_assoc();

if (!$notification) {
    echo json_encode(["success" => false, "message" => "Không tìm thấy thông báo."]);
    exit;
}

// Nếu chưa đọc thì tự động đánh dấu là đã đọc
if (!$notification['IS_READ']) {
    $update = $conn->prepare("UPDATE NOTIFICATIONS SET IS_READ = TRUE WHERE NOTIFICATION_ID = ?");
    $update->bind_param("s", $notification_id);
    $update->execute();
    $update->close();
}

echo json_encode(["success" => true, "data" => $notification]);

$stmt->close();
$conn->close();
?>
