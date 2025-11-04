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

/* ===== TỰ ĐỘNG TẠO ITEM_ID DẠNG M001, M002,... ===== */
$sql_get_id = "SELECT ITEM_ID FROM MENU_ITEMS ORDER BY ITEM_ID DESC LIMIT 1";
$result = $conn_admin->query($sql_get_id);

if ($result && $result->num_rows > 0) {
    $last_id = $result->fetch_assoc()['ITEM_ID'];
    $num = intval(substr($last_id, 1)) + 1; // bỏ 'M' và cộng 1
    $ITEM_ID = 'M' . str_pad($num, 3, '0', STR_PAD_LEFT); // luôn có 3 chữ số
} else {
    $ITEM_ID = 'M001'; // nếu chưa có món nào
}

/* ===== DỮ LIỆU KHÁC ===== */
$ADMIN_ID = $data['ADMIN_ID'] ?? "AD001";
$NAME = $conn_admin->real_escape_string($data['NAME']);
$DESCRIPTION = $conn_admin->real_escape_string($data['DESCRIPTION'] ?? "");
$PRICE = floatval($data['PRICE']);
$CATEGORY = $conn_admin->real_escape_string($data['CATEGORY'] ?? "Khác");
$STOCK_QUANTITY = intval($data['STOCK_QUANTITY'] ?? 0);
$IS_AVAILABLE = isset($data['IS_AVAILABLE']) ? intval($data['IS_AVAILABLE']) : 1;

/* ===== THÊM VÀO DATABASE ===== */
$sql = "INSERT INTO MENU_ITEMS (ITEM_ID, ADMIN_ID, NAME, DESCRIPTION, PRICE, CATEGORY, STOCK_QUANTITY, IS_AVAILABLE)
        VALUES ('$ITEM_ID', '$ADMIN_ID', '$NAME', '$DESCRIPTION', $PRICE, '$CATEGORY', $STOCK_QUANTITY, $IS_AVAILABLE)";

if ($conn_admin->query($sql)) {
    echo json_encode(["message" => "Thêm món thành công", "ITEM_ID" => $ITEM_ID]);
} else {
    echo json_encode(["error" => "Lỗi khi thêm món: " . $conn_admin->error]);
}

$conn_admin->close();
?>
