<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: PUT, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json; charset=UTF-8");

include(__DIR__ . '/../db.php');

// Xử lý preflight
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

// Đọc JSON từ body
$raw = file_get_contents("php://input");
$data = json_decode($raw, true);

if (!$data) {
    echo json_encode(["success" => false, "message" => "Dữ liệu không hợp lệ"]);
    exit;
}

// Bắt buộc phải có CUSTOMER_ID
if (empty($data['CUSTOMER_ID'])) {
    echo json_encode(["success" => false, "message" => "Thiếu tham số CUSTOMER_ID"]);
    exit;
}

$CUSTOMER_ID = $conn->real_escape_string($data['CUSTOMER_ID']);
$USERNAME = isset($data['USERNAME']) ? $conn->real_escape_string($data['USERNAME']) : null;
$EMAIL = isset($data['EMAIL']) ? $conn->real_escape_string($data['EMAIL']) : null;
$PASSWORD_RAW = isset($data['PASSWORD']) ? $data['PASSWORD'] : null;

// Build dynamic update query (chỉ cập nhật các trường thực sự có)
$updates = [];
if ($USERNAME !== null) $updates[] = "USERNAME = '$USERNAME'";
if ($EMAIL !== null) $updates[] = "EMAIL = '$EMAIL'";
if (!empty($PASSWORD_RAW)) {
    // hash password khi người dùng nhập mới
    $hashed = password_hash($PASSWORD_RAW, PASSWORD_BCRYPT);
    $updates[] = "PASSWORD = '$hashed'";
}

if (count($updates) === 0) {
    echo json_encode(["success" => false, "message" => "Không có trường nào để cập nhật"]);
    exit;
}

$set_clause = implode(', ', $updates);
$sql = "UPDATE CUSTOMER_USERS SET $set_clause WHERE CUSTOMER_ID = '$CUSTOMER_ID'";

if ($conn->query($sql)) {
    echo json_encode(["success" => true, "message" => "Cập nhật người dùng thành công"]);
} else {
    echo json_encode(["success" => false, "message" => "Lỗi khi cập nhật: " . $conn->error]);
}

$conn->close();
?>
