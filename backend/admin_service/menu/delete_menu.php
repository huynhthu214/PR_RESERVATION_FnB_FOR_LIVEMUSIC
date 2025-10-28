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

$ITEM_ID = $conn->real_escape_string($_GET['id']);
$sql = "DELETE FROM MENU_ITEMS WHERE ITEM_ID = '$ITEM_ID'";

if ($conn->query($sql)) {
    echo json_encode(["success" => true, "message" => "Xóa món thành công"]);
} else {
    echo json_encode(["success" => false, "message" => "Lỗi: " . $conn->error]);
}

$conn->close();
?>
