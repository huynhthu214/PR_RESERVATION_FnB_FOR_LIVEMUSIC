<?php
header('Content-Type: application/json');
require_once __DIR__ . '/../db.php';

$sql = "SELECT PROMO_ID, CODE, DISCOUNT_PERCENT, DESCRIPTION, VALID_FROM, VALID_TO, IS_ACTIVE, APPLY_TO 
        FROM PROMOTIONS
        ORDER BY VALID_FROM DESC";

$result = $conn_admin->query($sql);

if (!$result) {
    echo json_encode(["success" => false, "message" => "Lỗi SQL: " . $conn_admin->error]);
    exit;
}


$promotions = [];

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $now = new DateTime();
        $validTo = new DateTime($row['VALID_TO']);
        $statusText = ($row['IS_ACTIVE'] && $validTo >= $now) ? 'Còn hạn' : 'Hết hạn';

        $promotions[] = [
            "id" => $row['PROMO_ID'],
            "code" => $row['CODE'],
            "discount" => $row['DISCOUNT_PERCENT'],
            "description" => $row['DESCRIPTION'],
            "start_date" => $row['VALID_FROM'],
            "end_date" => $row['VALID_TO'],
            "status" => $statusText,
            "apply_to" => $row['APPLY_TO']
        ];
    }

    echo json_encode(["success" => true, "data" => $promotions]);
} else {
    echo json_encode(["success" => false, "data" => [], "message" => "Không có khuyến mãi nào."]);
}

$conn_admin->close();
