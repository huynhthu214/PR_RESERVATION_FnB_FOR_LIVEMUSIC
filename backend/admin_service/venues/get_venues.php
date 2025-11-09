<?php
header('Content-Type: application/json');
require_once __DIR__ . '/../db.php';

$sql = "SELECT VENUE_ID, NAME, ADDRESS, CAPACITY, SEAT_LAYOUT FROM VENUES ORDER BY NAME ASC";
$result = $conn->query($sql);

$venues = [];

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $layoutFile = __DIR__ . "/" . $row['SEAT_LAYOUT'];
        $layoutData = null;

        if (file_exists($layoutFile)) {
            $jsonContent = file_get_contents($layoutFile);
            $layoutData = json_decode($jsonContent, true);
        }

        $venues[] = [
            "id" => $row['VENUE_ID'],
            "name" => $row['NAME'],
            "address" => $row['ADDRESS'],
            "capacity" => (int)$row['CAPACITY'],
            "seat_layout" => $row['SEAT_LAYOUT'], 
        ];
    }

    echo json_encode([
        "success" => true,
        "data" => $venues
    ], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);

} else {
    echo json_encode([
        "success" => false,
        "data" => [],
        "message" => "Không có địa điểm nào."
    ], JSON_UNESCAPED_UNICODE);
}

$conn->close();
