<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json; charset=UTF-8");

include_once __DIR__ . '/../db.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
$data = json_decode(file_get_contents("php://input"), true);
if (
    empty($data['promo_code']) ||
    empty($data['description']) ||
    !isset($data['discount_percent']) ||
    empty($data['start_date']) ||
    empty($data['end_date']) ||
    empty($data['status']) ||
    empty($data['apply_to'])
) {
    http_response_code(400);
    echo json_encode([
        "success" => false,
        "message" => "Thiếu dữ liệu bắt buộc (promo_code, description, discount_percent, start_date, end_date, status, apply_to)"
    ]);
    exit;
}

// Kiểm tra đăng nhập admin
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

// Tạo PROMO_ID tự động
$sql_get_id = "SELECT PROMO_ID FROM PROMOTIONS ORDER BY PROMO_ID DESC LIMIT 1";
$result = $conn_admin->query($sql_get_id);
if ($result && $result->num_rows > 0) {
    $last_id = $result->fetch_assoc()['PROMO_ID'];
    $num = intval(substr($last_id, 1)) + 1;
    $PROMO_ID = 'P' . str_pad($num, 3, '0', STR_PAD_LEFT);
} else {
    $PROMO_ID = 'P001';
}

// Gán dữ liệu
$CODE = $conn_admin->real_escape_string($data['promo_code']);
$DESCRIPTION = $conn_admin->real_escape_string($data['description']);
$DISCOUNT_PERCENT = floatval($data['discount_percent']);
$VALID_FROM = $conn_admin->real_escape_string($data['start_date']);
$VALID_TO = $conn_admin->real_escape_string($data['end_date']);
$IS_ACTIVE = ($data['status'] === "ACTIVE") ? 1 : 0;
$APPLY_TO = $conn_admin->real_escape_string($data['apply_to']);

// Tuỳ chọn nếu muốn khuyến mãi gắn cho sự kiện cụ thể
$EVENT_ID = $data['event_id'] ?? null;
$APPLY_TO = $data['apply_to'] ?? null;

// Truy vấn thêm khuyến mãi
$sql = "INSERT INTO PROMOTIONS 
(PROMO_ID, EVENT_ID, ADMIN_ID, CODE, DISCOUNT_PERCENT, VALID_FROM, VALID_TO, IS_ACTIVE, APPLY_TO, DESCRIPTION)
VALUES 
(?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

$stmt = $conn_admin->prepare($sql);
$stmt->bind_param(
    "ssssdssiss",
    $PROMO_ID,
    $EVENT_ID,
    $ADMIN_ID,
    $CODE,
    $DISCOUNT_PERCENT,
    $VALID_FROM,
    $VALID_TO,
    $IS_ACTIVE,
    $APPLY_TO,
    $DESCRIPTION
);

if ($stmt->execute()) {
    http_response_code(201);
    echo json_encode([
        "success" => true,
        "message" => "Thêm khuyến mãi thành công",
        "PROMO_ID" => $PROMO_ID
    ]);
} else {
    http_response_code(500);
    echo json_encode([
        "success" => false,
        "message" => "Lỗi khi thêm khuyến mãi: " . $stmt->error
    ]);
}

$stmt->close();
$conn_admin->close();
?>
