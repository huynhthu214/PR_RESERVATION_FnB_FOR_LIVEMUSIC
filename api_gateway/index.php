<?php
header("Content-Type: application/json");

// Load config service
$config = json_decode(file_get_contents(__DIR__ . '/config.json'), true);

// Lấy service và action
$service = $_GET['service'] ?? '';
$action  = $_GET['action'] ?? '';

if (!$service || !$action) {
    echo json_encode(["error" => "Thiếu tham số service hoặc action"]);
    exit;
}

// Tạo key dạng ADMIN_SERVICE, CUSTOMER_SERVICE,...
$serviceKey = strtoupper($service) . "_SERVICE";

if (!isset($config[$serviceKey])) {
    echo json_encode(["error" => "Service không tồn tại: $service"]);
    exit;
}

// Lấy URL base
$serviceBase = $config[$serviceKey];
$url = "$serviceBase/index.php?action=$action";

// Nếu có dữ liệu POST từ client (frontend)
$method = $_SERVER['REQUEST_METHOD'];
if ($method === 'POST') {
    $context = stream_context_create([
        "http" => [
            "method" => "POST",
            "header" => "Content-Type: application/json",
            "content" => file_get_contents("php://input")
        ]
    ]);
    $response = file_get_contents($url, false, $context);
} else {
    $response = file_get_contents($url);
}

echo $response;
