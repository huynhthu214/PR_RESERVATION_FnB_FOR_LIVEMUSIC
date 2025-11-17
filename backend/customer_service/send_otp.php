<?php
require __DIR__ . '/db.php';
require __DIR__ . '/../../vendor/PHPMailer-master/src/PHPMailer.php';
require __DIR__ . '/../../vendor/PHPMailer-master/src/SMTP.php';
require __DIR__ . '/../../vendor/PHPMailer-master/src/Exception.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

header('Content-Type: application/json');
date_default_timezone_set('Asia/Ho_Chi_Minh');
$input = json_decode(file_get_contents("php://input"), true);
$email = trim($input['email'] ?? '');

if (!$email) {
    echo json_encode(["error" => "Thiếu email"]);
    exit;
}

/* Lấy CUSTOMER_ID từ CUSTOMER_USERS */
$stmt = $conn_customer->prepare("SELECT CUSTOMER_ID FROM CUSTOMER_USERS WHERE EMAIL=?");
$stmt->bind_param("s", $email);
$stmt->execute();
$res = $stmt->get_result();
if ($res->num_rows === 0) {
    echo json_encode(["error" => "Không tìm thấy tài khoản với email này"]);
    exit;
}
$row = $res->fetch_assoc();
$customer_id = $row['CUSTOMER_ID'];
$stmt->close();

/* Tạo OTP */
$otp = str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT);
$expires_seconds = 120;
$expires_at = date("Y-m-d H:i:s", time() + $expires_seconds);
$otp_id = uniqid("OTP");

/* Lưu OTP vào bảng OTP */
$stmt = $conn_customer->prepare("
    INSERT INTO OTP (OTP_ID, CUSTOMER_ID, CODE, CREATED_AT, EXPIRES_AT, IS_USED, STATUS) 
    VALUES (?, ?, ?, NOW(), ?, 0, 'ACTIVE')
");
$stmt->bind_param("ssss", $otp_id, $customer_id, $otp, $expires_at);
if (!$stmt->execute()) {
    echo json_encode(["error" => "Lưu OTP thất bại"]);
    exit;
}
$stmt->close();
$conn_customer->close();

/* Gửi email OTP */
$mail = new PHPMailer(true);
try {
    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = 'minhthuhuynh23@gmail.com';
    $mail->Password   = 'kapendjgusnxwczc';
    $mail->SMTPSecure = 'ssl';
    $mail->Port       = 465;
    $mail->CharSet    = 'UTF-8';

    $mail->setFrom('minhthuhuynh23@gmail.com', 'LYZY LIVE MUSIC');
    $mail->addAddress($email);
    $mail->isHTML(true);
    $mail->Subject = 'Mã OTP xác thực - LYZY';
    $mail->Body = "<h3>Mã OTP của bạn: <b>$otp</b></h3><p>Hết hạn trong <b>$expires_seconds giây</b></p>";
    $mail->send();

    echo json_encode([
        "success" => true,
        "otp_sent_time" => time(),
        "expires_in" => $expires_seconds
    ]);
} catch (Exception $e) {
    echo json_encode(["error" => "Không gửi được OTP: {$mail->ErrorInfo}"]);
}
