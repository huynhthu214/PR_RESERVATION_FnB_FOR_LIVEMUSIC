<?php
header('Content-Type: application/json');
require_once __DIR__ . '/../db.php'; 

$action = $_GET['action'] ?? '';

if ($action === 'delete_all_noti') {
    $customer_id = $_GET['customer_id'] ?? null;

    if (!$customer_id) {
        echo json_encode(['success' => false, 'message' => 'Missing customer ID']);
        exit;
    }

    try {
        $stmt = $conn->prepare("DELETE FROM NOTIFICATIONS WHERE CUSTOMER_ID = ?");
        $stmt->bind_param("s", $customer_id);
        $stmt->execute();
        echo json_encode(['success' => true, 'message' => 'Đã xóa tất cả thông báo']);
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
    exit;
}
