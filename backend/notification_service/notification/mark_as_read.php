<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

include_once __DIR__ . '/../db.php'; // Kết nối DB

$notification_id = $_POST['notification_id'] ?? null;

if (!$notification_id) {
    echo json_encode(["success" => false, "message" => "Thiếu notification_id"]);
    exit;
}

$sql = "UPDATE NOTIFICATIONS SET IS_READ = TRUE WHERE NOTIFICATION_ID = ?";
$stmt = $conn->prepare($sql);

if (!$stmt) {
    echo json_encode(["success" => false, "message" => "Lỗi chuẩn bị SQL: " . $conn->error]);
    exit;
}

$stmt->bind_param("s", $notification_id);

if ($stmt->execute()) {
    echo json_encode(["success" => true, "message" => "Đã đánh dấu là đã đọc."]);
} else {
    echo json_encode(["success" => false, "message" => "Lỗi truy vấn SQL: " . $conn->error]);
}

$stmt->close();
$conn->close();
?>
