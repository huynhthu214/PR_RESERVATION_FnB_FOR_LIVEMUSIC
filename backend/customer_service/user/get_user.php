<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once __DIR__ . '/../db.php';

$sql = "SELECT CUSTOMER_ID, USERNAME, EMAIL, CREATED_AT FROM CUSTOMER_USERS";
$result = $conn_customer->query($sql);

$Customer = [];

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $Customer[] = [
            "CUSTOMER_ID" => $row["CUSTOMER_ID"],
            "USERNAME" => $row["USERNAME"],
            "EMAIL" => $row["EMAIL"],
            "CREATED_AT" => date("Y-m-d H:i:s", strtotime($row["CREATED_AT"])),
        ];
    }
    echo json_encode($Customer);
} else {
    echo json_encode([]);
}

$conn_customer->close();
?>
