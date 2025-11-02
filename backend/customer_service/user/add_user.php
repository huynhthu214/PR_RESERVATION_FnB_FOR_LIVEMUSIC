<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json; charset=UTF-8");

include_once __DIR__ . '/../db.php';

$input = json_decode(file_get_contents("php://input"), true);

if (!isset($input["username"], $input["email"], $input["password"])) {
    echo json_encode(["success" => false, "message" => "Thiếu dữ liệu bắt buộc!"]);
    exit;
}

$username = $conn->real_escape_string($input["username"]);
$email = $conn->real_escape_string($input["email"]);
$password = $conn->real_escape_string($input["password"]);

// Lấy ID lớn nhất hiện có
$query = "SELECT CUSTOMER_ID FROM CUSTOMER_USERS ORDER BY CUSTOMER_ID DESC LIMIT 1";
$result = $conn->query($query);

if ($result && $result->num_rows > 0) {
    $lastID = $result->fetch_assoc()["CUSTOMER_ID"];
    $num = (int)substr($lastID, 2) + 1;
    $newID = "CU" . str_pad($num, 3, "0", STR_PAD_LEFT);
} else {
    $newID = "CU001";
}

// Thêm người dùng
$sql = "INSERT INTO CUSTOMER_USERS (CUSTOMER_ID, USERNAME, EMAIL, PASSWORD, CREATED_AT)
        VALUES ('$newID', '$username', '$email', '$password', NOW())";

if ($conn->query($sql)) {
    echo json_encode(["success" => true, "message" => "Thêm người dùng thành công", "CUSTOMER_ID" => $newID]);
} else {
    echo json_encode(["success" => false, "message" => "Lỗi khi thêm người dùng: " . $conn->error]);
}

$conn->close();
?>
