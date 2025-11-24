<?php
header("Content-Type: application/json; charset=UTF-8");

require_once __DIR__ . '/../db.php';
require_once __DIR__ . '/NotificationModel.php';
require_once __DIR__ . '/../email/EmailLogModel.php';

// Lấy tất cả notification gửi cho admin
$notificationModel = new NotificationModel($conn_noti);
$stmt = $conn_noti->prepare("SELECT * FROM NOTIFICATIONS WHERE RECEIVER_TYPE='ADMIN' ORDER BY SENT_AT DESC");
$stmt->execute();
$result = $stmt->get_result();
$notifications = [];
while($row = $result->fetch_assoc()){
    $notifications[] = $row;
}
$stmt->close();

// Lấy tất cả email logs
$emailLogModel = new EmailLogModel($conn_noti);
$stmt2 = $conn_noti->prepare("SELECT * FROM EMAIL_LOG ORDER BY SENT_TIME DESC");
$stmt2->execute();
$result2 = $stmt2->get_result();
$email_logs = [];
while($row = $result2->fetch_assoc()){
    $email_logs[] = $row;
}
$stmt2->close();

// Trả dữ liệu JSON
echo json_encode([
    'success' => true,
    'notifications' => $notifications,
    'email_logs' => $email_logs
]);
