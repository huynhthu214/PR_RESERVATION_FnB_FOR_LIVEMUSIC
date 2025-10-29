<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json; charset=UTF-8");

include_once __DIR__ . '/../db.php';

$data = json_decode(file_get_contents("php://input"), true);

if (empty($data['CUSTOMER_ID']) || empty($data['EMAIL'])) {
    echo json_encode(["error" => "Thiếu dữ liệu bắt buộc"]);
    exit;
}

$ITEM_ID = $data['CUSTOMER_ID'] ?? uniqid("CU");
$USERNAME = $conn->real_escape_string($data['USERNAME']);
$EMAIL = $conn->real_escape_string($data['EMAIL'] ?? "");
$PASSWORD = floatval($data['PASSWORD']);
$CREATED_AT = $conn->real_escape_string($data['CREATED_AT'] ?? "");

$sql = "INSERT INTO CUSTOMER_USERS (CUSTOMER_ID, USERNAME, EMAIL, PASSWORD, CREATED_AT)
        VALUES ('$CUSTOMER_ID', '$USERNAME', '$EMAIL', '$PASSWORD', $CREATED_AT)";

if ($conn->query($sql)) {
    echo json_encode(["message" => "Thêm người dùng thành công", "CUSTOMER_ID" => $CUSTOMER_ID]);
} else {
    echo json_encode(["error" => "Lỗi khi thêm người dùng: " . $conn->error]);
}

$conn->close();
?>
