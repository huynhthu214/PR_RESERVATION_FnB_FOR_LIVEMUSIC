<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json; charset=UTF-8");

include(__DIR__ . '/../db.php');

// Kiểm tra xem có truyền ID hay không
if (!isset($_GET['id'])) {
    echo json_encode(["error" => "Thiếu tham số ID"]);
    exit;
}

$CUSTOMER_ID = $conn->real_escape_string($_GET['id']);

// Câu lệnh xóa người dùng theo ID
$sql = "DELETE FROM CUSTOMER_USERS WHERE CUSTOMER_ID = '$CUSTOMER_ID'";

if ($conn->query($sql)) {
    echo json_encode([
        "success" => true,
        "message" => "Xóa người dùng thành công"
    ]);
} else {
    echo json_encode([
        "success" => false,
        "message" => "Lỗi khi xóa người dùng: " . $conn->error
    ]);
}

$conn->close();
?>
