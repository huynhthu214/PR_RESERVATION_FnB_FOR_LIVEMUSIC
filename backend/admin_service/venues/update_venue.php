<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json; charset=UTF-8");

include(__DIR__ . '/../db.php');

$VENUE_ID = $_POST['VENUE_ID'] ?? '';
$NAME = $_POST['NAME'] ?? '';
$ADDRESS = $_POST['ADDRESS'] ?? '';
$CAPACITY = intval($_POST['CAPACITY'] ?? 0);

if (!$VENUE_ID) {
    echo json_encode(["success" => false, "message" => "Thiếu VENUE_ID"]);
    exit;
}

/* Xử lý file nếu có */
if (isset($_FILES['seat_layout']) && $_FILES['seat_layout']['error'] == 0) {
    $uploadDir = __DIR__ . '/../seat_layouts/';
    if (!file_exists($uploadDir)) mkdir($uploadDir, 0777, true);

    $fileName = basename($_FILES['seat_layout']['name']);
    $targetFile = $uploadDir . $fileName;

    if (move_uploaded_file($_FILES['seat_layout']['tmp_name'], $targetFile)) {
        $SEAT_LAYOUT = $conn_admin->real_escape_string('seat_layouts/' . $fileName);
        $sql = "UPDATE VENUES 
                SET NAME='$NAME', ADDRESS='$ADDRESS', CAPACITY=$CAPACITY, SEAT_LAYOUT='$SEAT_LAYOUT'
                WHERE VENUE_ID='$VENUE_ID'";
    } else {
        echo json_encode(["success" => false, "message" => "Không thể upload file"]);
        exit;
    }
} else {
    $sql = "UPDATE VENUES 
            SET NAME='$NAME', ADDRESS='$ADDRESS', CAPACITY=$CAPACITY
            WHERE VENUE_ID='$VENUE_ID'";
}

if ($conn_admin->query($sql)) {
    echo json_encode(["success" => true, "message" => "Cập nhật địa điểm thành công"]);
} else {
    echo json_encode(["success" => false, "message" => "Lỗi: " . $conn_admin->error]);
}

$conn_admin->close();
?>
