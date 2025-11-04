<?php
header('Content-Type: application/json');
require_once __DIR__ . '/../db.php';

$sql = "SELECT PROMO_ID, CODE, DISCOUNT_PERCENT, VALID_FROM, VALID_TO, IS_ACTIVE 
        FROM PROMOTIONS
        ORDER BY VALID_FROM DESC";

$result = $conn_admin->query($sql);

$promotions = [];

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $now = new DateTime();
        $validTo = new DateTime($row['VALID_TO']);
        $statusText = ($row['IS_ACTIVE'] && $validTo >= $now) ? 'Còn hạn' : 'Hết hạn';
        $statusClass = ($statusText === 'Còn hạn') ? 'active' : 'inactive';

        $promotions[] = [
            "id" => $row['PROMO_ID'],
            "code" => $row['CODE'],
            "discount" => $row['DISCOUNT_PERCENT'],
            "start_date" => $row['VALID_FROM'],
            "end_date" => $row['VALID_TO'],
            "status" => $statusText,
            "status_class" => $statusClass
        ];
    }

    echo json_encode(["success" => true, "data" => $promotions]);
} else {
    echo json_encode(["success" => false, "data" => [], "message" => "Không có khuyến mãi nào."]);
}

$conn_admin->close();
