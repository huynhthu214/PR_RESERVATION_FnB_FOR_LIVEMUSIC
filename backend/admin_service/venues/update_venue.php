<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: PUT, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json; charset=UTF-8");

include(__DIR__ . '/../db.php');

$data = json_decode(file_get_contents("php://input"), true);

if (!isset($data['VENUE_ID'])) {
    echo json_encode(["error" => "Thiếu VENUE_ID"]);
    exit;
}

$VENUE_ID = $conn_admin->real_escape_string($data['VENUE_ID']);
$NAME = $conn_admin->real_escape_string($data['NAME'] ?? '');
$ADDRESS = $conn_admin->real_escape_string($data['ADDRESS'] ?? '');
$CAPACITY = intval($data['CAPACITY'] ?? 0);
$STATUS = intval($data['STATUS'] ?? 1);

$sql = "UPDATE VENUES 
        SET NAME='$NAME', ADDRESS='$ADDRESS', CAPACITY=$CAPACITY, STATUS=$STATUS
        WHERE VENUE_ID='$VENUE_ID'";

if ($conn_admin->query($sql)) {
    echo json_encode(["success" => true, "message" => "Cập nhật địa điểm thành công"]);
} else {
    echo json_encode(["success" => false, "message" => "Lỗi: " . $conn_admin->error]);
}

$conn_admin->close();
?>
