<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json; charset=UTF-8");

include_once __DIR__ . '/../db.php';

$data = json_decode(file_get_contents("php://input"), true);

if (empty($data['NAME']) || empty($data['PRICE'])) {
    echo json_encode(["error" => "Thiếu dữ liệu bắt buộc"]);
    exit;
}

$ITEM_ID = $data['ITEM_ID'] ?? uniqid("M");
$ADMIN_ID = $data['ADMIN_ID'] ?? "AD001";
$NAME = $conn->real_escape_string($data['NAME']);
$DESCRIPTION = $conn->real_escape_string($data['DESCRIPTION'] ?? "");
$PRICE = floatval($data['PRICE']);
$CATEGORY = $conn->real_escape_string($data['CATEGORY'] ?? "Khác");
$STOCK_QUANTITY = intval($data['STOCK_QUANTITY'] ?? 0);
$IS_AVAILABLE = isset($data['IS_AVAILABLE']) ? intval($data['IS_AVAILABLE']) : 1;

$sql = "INSERT INTO MENU_ITEMS (ITEM_ID, ADMIN_ID, NAME, DESCRIPTION, PRICE, CATEGORY, STOCK_QUANTITY, IS_AVAILABLE)
        VALUES ('$ITEM_ID', '$ADMIN_ID', '$NAME', '$DESCRIPTION', $PRICE, '$CATEGORY', $STOCK_QUANTITY, $IS_AVAILABLE)";

if ($conn->query($sql)) {
    echo json_encode(["message" => "Thêm món thành công", "ITEM_ID" => $ITEM_ID]);
} else {
    echo json_encode(["error" => "Lỗi khi thêm món: " . $conn->error]);
}

$conn->close();
?>
