<?php
header('Content-Type: application/json');
require_once __DIR__ . '/../db.php'; 

$sql = "UPDATE NOTIFICATIONS SET IS_READ = 1 WHERE IS_READ = 0";

if ($conn->query($sql) === TRUE) {
    echo json_encode(['success' => true, 'message' => 'Đã đánh dấu tất cả thông báo là đã đọc']);
} else {
    echo json_encode(['success' => false, 'message' => $conn->error]);
}

$conn->close();
