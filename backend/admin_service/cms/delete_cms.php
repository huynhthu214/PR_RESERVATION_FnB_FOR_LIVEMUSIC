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

$PAGE_ID = $conn_admin->real_escape_string($_GET['id']);
$sql = "DELETE FROM CMS_PAGES WHERE PAGE_ID = '$PAGE_ID'";

if ($conn_admin->query($sql)) {
    echo json_encode(["success" => true, "message" => "Xóa cms thành công"]);
} else {
    echo json_encode(["success" => false, "message" => "Lỗi: " . $conn_admin_admin->error]);
}

$conn_admin->close();
?>
