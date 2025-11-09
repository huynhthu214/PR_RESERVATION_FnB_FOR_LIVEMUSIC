<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: PUT, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json; charset=UTF-8");

include(__DIR__ . '/../db.php');

$data = json_decode(file_get_contents("php://input"), true);

if (!isset($data['PROMO_ID'])) {
    echo json_encode(["error" => "Thiếu PROMO_ID"]);
    exit;
}

$PROMO_ID = $conn_admin->real_escape_string($data['PROMO_ID']);
$CODE = $conn_admin->real_escape_string($data['CODE'] ?? '');
$DISCOUNT_PERCENT = floatval($data['DISCOUNT_PERCENT'] ?? 0);
$DESCRIPTION = $conn->real_escape_string($data['DESCRIPTION']);
$VALID_FROM = $conn->real_escape_string($data['VALID_FROM'] ?? null);
$VALID_TO = $conn->real_escape_string($data['VALID_TO'] ?? null);
$IS_ACTIVE = intval($data['IS_ACTIVE'] ?? 1);
$APPlY_TO = $conn->real_escape_string($data['APPLY_TO']);

$sql = "UPDATE PROMOTIONS 
        SET CODE='$CODE', DISCOUNT_PERCENT=$DISCOUNT_PERCENT, DESCRIPTION='$DESCRIPTION',
            VALID_FROM='$VALID_FROM', VALID_TO='$VALID_TO', IS_ACTIVE=$IS_ACTIVE, APPLY_TO = '$APPLY_TO'
        WHERE PROMO_ID='$PROMO_ID'";

if ($conn_admin->query($sql)) {
    echo json_encode(["success" => true, "message" => "Cập nhật khuyến mãi thành công"]);
} else {
    echo json_encode(["success" => false, "message" => "Lỗi: " . $conn_admin->error]);
}

$conn_admin->close();
?>
