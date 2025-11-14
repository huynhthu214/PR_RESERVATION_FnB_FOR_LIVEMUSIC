<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json; charset=UTF-8");

include_once __DIR__ . '/../db.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Lấy dữ liệu JSON từ request
$data = json_decode(file_get_contents("php://input"), true);

// Kiểm tra dữ liệu bắt buộc
if (empty($data['type']) || empty($data['title']) || empty($data['content'])) {
    http_response_code(400); 
    echo json_encode([
        "success" => false, 
        "message" => "Thiếu dữ liệu bắt buộc (type, title, content)"
    ]);
    exit;
}

// Kiểm tra admin login
if (!isset($_SESSION['ADMIN_ID'])) { 
    http_response_code(401); 
    echo json_encode([
        "success" => false, 
        "message" => "Chưa đăng nhập. Vui lòng đăng nhập."
    ]);
    $conn_admin->close();
    exit;
}
$ADMIN_ID = $_SESSION['ADMIN_ID'];

// Tạo PAGE_ID tự động
$sql_get_id = "SELECT PAGE_ID FROM CMS_PAGES ORDER BY PAGE_ID DESC LIMIT 1";
$result = $conn_admin->query($sql_get_id);

if ($result && $result->num_rows > 0) {
    $last_id = $result->fetch_assoc()['PAGE_ID'];
    $num = intval(substr($last_id, 1)) + 1;
    $PAGE_ID = 'P' . str_pad($num, 3, '0', STR_PAD_LEFT);
} else {
    $PAGE_ID = 'P001';
}

// Lấy dữ liệu input và escape để tránh SQL Injection
$TYPE = $conn_admin->real_escape_string($data['type']);
$TITLE = $conn_admin->real_escape_string($data['title']);
$CONTENT = $conn_admin->real_escape_string($data['content']);
$UPDATED_AT = date('Y-m-d H:i:s'); // thời gian hiện tại

// Thực hiện insert
$sql = "INSERT INTO CMS_PAGES 
            (PAGE_ID, ADMIN_ID, TYPE, TITLE, CONTENT, UPDATED_AT)
        VALUES 
            ('$PAGE_ID', '$ADMIN_ID', '$TYPE', '$TITLE', '$CONTENT', '$UPDATED_AT')";

if ($conn_admin->query($sql)) {
    http_response_code(201); 
    echo json_encode([
        "success" => true, 
        "message" => "Thêm CMS thành công", 
        "PAGE_ID" => $PAGE_ID
    ]);
} else {
    http_response_code(500); 
    echo json_encode([
        "success" => false, 
        "message" => "Lỗi khi thêm CMS: " . $conn_admin->error
    ]);
}

$conn_admin->close();
?>
