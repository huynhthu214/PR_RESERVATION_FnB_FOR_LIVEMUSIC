<?php
require_once __DIR__ . '/../../config.php'; // session đã start trong config.php
header('Content-Type: application/json; charset=UTF-8');

$input = json_decode(file_get_contents('php://input'), true);

if (!$input || !is_array($input)) {
    echo json_encode(['success'=>false, 'message'=>'Dữ liệu không hợp lệ']);
    exit;
}

// Lưu vào session
$_SESSION['selectedSeats'] = $input;

echo json_encode(['success'=>true]);
