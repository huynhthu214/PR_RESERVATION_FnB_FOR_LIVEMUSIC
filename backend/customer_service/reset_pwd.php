<?php
header('Content-Type: application/json');
require __DIR__ . '/db.php'; 

$input = json_decode(file_get_contents("php://input"), true);

$email    = trim($input["email"] ?? "");
$password = trim($input["password"] ?? "");

if (!$email || !$password) {
    echo json_encode(["error" => "Thiếu dữ liệu"]);
    exit;
}

// Lấy CUSTOMER_ID từ CUSTOMER_USERS
$sql = "SELECT CUSTOMER_ID FROM CUSTOMER_USERS WHERE EMAIL = ?";
$stmt = $conn_customer->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$res = $stmt->get_result();

if ($res->num_rows === 0) {
    echo json_encode(["error" => "Email không tồn tại"]);
    exit;
}

$user = $res->fetch_assoc();
$customerId = $user["CUSTOMER_ID"];
$stmt->close();

// Cập nhật mật khẩu mới
$sqlUp = "UPDATE CUSTOMER_USERS SET PASSWORD = ? WHERE CUSTOMER_ID = ?";
$stmt = $conn_customer->prepare($sqlUp);
$stmt->bind_param("ss", $password, $customerId);

if ($stmt->execute()) {
    echo json_encode(["success" => "Đặt lại mật khẩu thành công!"]);
} else {
    echo json_encode(["error" => "Không thể cập nhật mật khẩu"]);
}

$stmt->close();
$conn_customer->close();
