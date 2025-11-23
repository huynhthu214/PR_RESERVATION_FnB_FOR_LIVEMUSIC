<?php
header('Content-Type: application/json');
require_once __DIR__ . '/../db.php';

$type = $_GET['type'] ?? '';
if (!$type) {
    echo json_encode(['success' => false, 'message' => 'Type not specified']);
    exit;
}

// === SỬA TỪ ĐÂY: DÙNG MySQLi CHUẨN ===
$stmt = $conn_admin->prepare("SELECT CONTENT FROM CMS_PAGES WHERE TYPE = ?");
if (!$stmt) {
    echo json_encode(['success' => false, 'message' => 'Prepare failed: ' . $conn_admin->error]);
    exit;
}

$stmt->bind_param("s", $type);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();  // ← MySQLi đúng cách
$stmt->close();
// === ĐẾN ĐÂY ===

if (!$row || empty($row['CONTENT'])) {
    echo json_encode(['success' => false, 'message' => 'No content path in database']);
    exit;
}

// Đường dẫn file HTML
$filePath = __DIR__ . '/content/' . basename($row['CONTENT']);

if (!file_exists($filePath)) {
    error_log("CMS File not found: " . $filePath);
    echo json_encode(['success' => false, 'message' => 'File not found: ' . basename($filePath)]);
    exit;
}

$content = file_get_contents($filePath);
echo json_encode(['success' => true, 'content' => $content]);
exit;
?>