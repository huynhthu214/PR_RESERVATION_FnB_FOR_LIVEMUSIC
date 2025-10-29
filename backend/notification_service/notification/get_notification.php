<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once __DIR__ . '/../db.php';

$sql = "SELECT NOTIFICATION_ID, CUSTOMER_ID, MESSAGE, TYPE, SENT_AT, IS_READ FROM NOTIFICATIONS";
$result = $conn->query($sql);

$notifications = [];

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $notifications[] = [
            "NOTIFICATION_ID" => $row["NOTIFICATION_ID"],
            "CUSTOMER_ID" => $row["CUSTOMER_ID"],
            "MESSAGE" => $row["MESSAGE"],
            "TYPE" => $row["TYPE"],
            "SENT_AT" => $row["SENT_AT"],
            "IS_READ" => $row["IS_READ"] ? true : false
        ];
    }
    echo json_encode([
        "success" => true,
        "data" => $notifications
    ], JSON_UNESCAPED_UNICODE);
} else {
    echo json_encode([
        "success" => true,
        "data" => []
    ]);
}

$conn->close();
?>
