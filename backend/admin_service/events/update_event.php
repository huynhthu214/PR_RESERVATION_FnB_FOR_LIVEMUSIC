<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: PUT, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json; charset=UTF-8");

include(__DIR__ . '/../db.php');

$data = json_decode(file_get_contents("php://input"), true);

if (!isset($data['EVENT_ID'])) {
    echo json_encode(["error" => "Thiếu EVENT_ID"]);
    exit;
}

$EVENT_ID = $conn->real_escape_string($data['EVENT_ID']);
$VENUE_ID = $conn->real_escape_string($data['VENUE_ID'] ?? '');
$BAND_NAME = $conn->real_escape_string($data['BAND_NAME'] ?? '');
$EVENT_DATE = $conn->real_escape_string($data['EVENT_DATE'] ?? '');
$TICKET_PRICE = floatval($data['TICKET_PRICE'] ?? 0);
$STATUS = $conn->real_escape_string($data['STATUS'] ?? 'Đang mở');

$sql = "UPDATE EVENTS 
        SET VENUE_ID='$VENUE_ID', BAND_NAME='$BAND_NAME', EVENT_DATE='$EVENT_DATE', 
            TICKET_PRICE=$TICKET_PRICE, STATUS='$STATUS'
        WHERE EVENT_ID='$EVENT_ID'";

if ($conn->query($sql)) {
    echo json_encode(["success" => true, "message" => "Cập nhật sự kiện thành công"]);
} else {
    echo json_encode(["success" => false, "message" => "Lỗi: " . $conn->error]);
}

$conn->close();
?>
