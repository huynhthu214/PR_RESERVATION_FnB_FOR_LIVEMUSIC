<?php
session_start();
header('Content-Type: application/json; charset=UTF-8');

// Lấy dữ liệu JSON
$input = json_decode(file_get_contents("php://input"), true);

// Debug: không nhận được body
if ($input === null) {
    echo json_encode([
        "success" => false,
        "message" => "Không nhận được JSON từ frontend",
        "raw" => file_get_contents("php://input")
    ]);
    exit;
}

if (!isset($input['seats']) || !is_array($input['seats'])) {
    echo json_encode([
        "success" => false,
        "message" => "Dữ liệu ghế không hợp lệ",
        "received" => $input
    ]);
    exit;
}

// Lưu vào session
$_SESSION['selectedSeats'] = $input['seats'];

echo json_encode([
    "success" => true,
    "saved" => $_SESSION['selectedSeats']
]);
exit;
