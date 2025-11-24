<?php
require_once __DIR__ . '/../db.php'; // để lấy $conn

require_once __DIR__ . '/EmailService.php';

// ======= TEST ========
$emailService = new EmailService($conn_noti);

$to = "minhthuhuynh23@gmail.com";
$subject = "Test EmailService";
$body = "<h2>Test gửi email thành công!</h2><p>Hệ thống EmailService hoạt động.</p>";

$sent = $emailService->sendEmail($to, $subject, $body, 123, null);

if ($sent) {
    echo "OK: Email đã gửi!";
} else {
    echo "FAIL: Không gửi được email";
}
