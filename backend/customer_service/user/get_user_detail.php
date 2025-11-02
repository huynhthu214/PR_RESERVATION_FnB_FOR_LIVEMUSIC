<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once __DIR__ . '/../db.php';

// Kiểm tra tham số ID
if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo json_encode(["error" => "Thiếu ID người dùng"]);
    exit;
}

$customer_id = $conn->real_escape_string($_GET['id']);

// Câu lệnh truy vấn
$sql = "SELECT CUSTOMER_ID, USERNAME, EMAIL, CREATED_AT 
        FROM CUSTOMER_USERS 
        WHERE CUSTOMER_ID = '$customer_id' 
        LIMIT 1";

$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $user = [
        "CUSTOMER_ID" => $row["CUSTOMER_ID"],
        "USERNAME" => $row["USERNAME"],
        "EMAIL" => $row["EMAIL"],
        "CREATED_AT" => date("Y-m-d H:i:s", strtotime($row["CREATED_AT"]))
    ];
    echo json_encode($user, JSON_UNESCAPED_UNICODE);
} else {
    echo json_encode(["error" => "Không tìm thấy người dùng"]);
}

$conn->close();
?>
