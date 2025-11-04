<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: PUT, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json; charset=UTF-8");

include(__DIR__ . '/../db.php');

$data = json_decode(file_get_contents("php://input"), true);

if (!isset($data['ITEM_ID'])) {
    echo json_encode(["error" => "Thiếu ITEM_ID"]);
    exit;
}

$ITEM_ID = $conn_admin->real_escape_string($data['ITEM_ID']);
$NAME = $conn_admin->real_escape_string($data['NAME'] ?? '');
$DESCRIPTION = $conn_admin->real_escape_string($data['DESCRIPTION'] ?? '');
$PRICE = floatval($data['PRICE'] ?? 0);
$CATEGORY = $conn_admin->real_escape_string($data['CATEGORY'] ?? '');
$STOCK_QUANTITY = intval($data['STOCK_QUANTITY'] ?? 0);
$IS_AVAILABLE = intval($data['IS_AVAILABLE'] ?? 1);

$sql = "UPDATE MENU_ITEMS 
        SET NAME='$NAME', DESCRIPTION='$DESCRIPTION', PRICE=$PRICE, CATEGORY='$CATEGORY',
            STOCK_QUANTITY=$STOCK_QUANTITY, IS_AVAILABLE=$IS_AVAILABLE
        WHERE ITEM_ID='$ITEM_ID'";

if ($conn_admin->query($sql)) {
    echo json_encode(["success" => true, "message" => "Cập nhật món ăn thành công"]);
} else {
    echo json_encode(["success" => false, "message" => "Lỗi: " . $conn_admin->error]);
}

$conn_admin->close();
?>
