<?php
header('Content-Type: application/json');
require_once __DIR__ . '/../db.php';

$sql = "SELECT VENUE_ID, NAME, ADDRESS, CAPACITY FROM VENUES ORDER BY NAME ASC";
$result = $conn_admin->query($sql);

$venues = [];

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $venues[] = [
            "id" => $row['VENUE_ID'],
            "name" => $row['NAME'],
            "address" => $row['ADDRESS'],
            "capacity" => $row['CAPACITY'],
            "status" => "Hoạt động"
        ];
    }
    echo json_encode(["success" => true, "data" => $venues]);
} else {
    echo json_encode(["success" => false, "data" => [], "message" => "Không có địa điểm nào."]);
}

$conn_admin->close();
