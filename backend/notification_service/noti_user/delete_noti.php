<?php
header('Content-Type: application/json');
require_once __DIR__ . '/../db.php'; 

$id = $_GET['id'] ?? '';

if (!$id) {
    echo json_encode(['success' => false, 'message' => 'Thiếu ID thông báo']);
    exit;
}

$sql = "DELETE FROM NOTIFICATIONS WHERE NOTIFICATION_ID = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $id);

if ($stmt->execute()) {
    echo json_encode(['success' => true, 'message' => 'Thông báo đã được xóa']);
} else {
    echo json_encode(['success' => false, 'message' => $stmt->error]);
}
$stmt->close();
$conn->close();
