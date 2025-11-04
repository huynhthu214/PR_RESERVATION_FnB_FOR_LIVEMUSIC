<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json; charset=UTF-8");

include(__DIR__ . '/../db.php');

if (!isset($_GET['id'])) {
    echo json_encode(["error" => "Thiếu tham số ID"]);
    exit;
}

$PROMO_ID = $conn_admin->real_escape_string($_GET['id']);
$sql = "DELETE FROM PROMOTIONS WHERE PROMO_ID = '$PROMO_ID'";

if ($conn_admin->query($sql)) {
    echo json_encode(["success" => true, "message" => "Xóa mã khuyến mãi thành công"]);
} else {
    echo json_encode(["success" => false, "message" => "Lỗi: " . $conn->error]);
}

$conn_admin->close();
?>
