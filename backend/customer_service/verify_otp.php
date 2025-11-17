<?php
require __DIR__ . '/db.php';
header('Content-Type: application/json');

// Đồng bộ timezone
date_default_timezone_set('Asia/Ho_Chi_Minh');

$input = json_decode(file_get_contents("php://input"), true);
$email = trim($input['email'] ?? '');
$otp   = trim($input['otp'] ?? '');

if (!$email || !$otp) {
    echo json_encode(["error" => "Thiếu email hoặc OTP"]);
    exit;
}

/* Lấy CUSTOMER_ID */
$stmt = $conn_customer->prepare("SELECT CUSTOMER_ID FROM CUSTOMER_USERS WHERE EMAIL=?");
$stmt->bind_param("s", $email);
$stmt->execute();
$res = $stmt->get_result();
if ($res->num_rows === 0) {
    echo json_encode(["error" => "Không tìm thấy tài khoản"]);
    exit;
}
$row = $res->fetch_assoc();
$customer_id = $row['CUSTOMER_ID'];
$stmt->close();

/* Lấy OTP mới nhất còn ACTIVE */
$stmt = $conn_customer->prepare("
    SELECT OTP_ID, CODE, EXPIRES_AT 
    FROM OTP 
    WHERE CUSTOMER_ID=? AND STATUS='ACTIVE' AND IS_USED=0 
    ORDER BY CREATED_AT DESC LIMIT 1
");
$stmt->bind_param("s", $customer_id);
$stmt->execute();
$res = $stmt->get_result();
if ($res->num_rows === 0) {
    echo json_encode(["error" => "Không tìm thấy OTP hợp lệ"]);
    exit;
}
$otp_row = $res->fetch_assoc();
$stmt->close();

/* Kiểm tra hết hạn */
$current_time = new DateTime('now', new DateTimeZone('Asia/Ho_Chi_Minh'));
$expires_at   = new DateTime($otp_row['EXPIRES_AT'], new DateTimeZone('Asia/Ho_Chi_Minh'));
if ($expires_at < $current_time) {
    echo json_encode(["error" => "OTP đã hết hạn"]);
    exit;
}

/* Kiểm tra mã OTP */
if (trim($otp_row['CODE']) !== trim((string)$otp)) {
    echo json_encode(["error" => "OTP không hợp lệ"]);
    exit;
}

/* Đánh dấu OTP đã dùng */
$upd = $conn_customer->prepare("UPDATE OTP SET IS_USED=1, STATUS='USED' WHERE OTP_ID=?");
$upd->bind_param("s", $otp_row['OTP_ID']);
$upd->execute();
$upd->close();

$conn_customer->close();

/* Trả về thành công */
echo json_encode(["success" => true]);
