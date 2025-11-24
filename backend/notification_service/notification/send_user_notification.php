<?php
header("Content-Type: application/json; charset=UTF-8");
require_once __DIR__ . '/../db.php';
require_once __DIR__ . '/NotificationModel.php';
require_once __DIR__ . '/../email/EmailService.php';

$input = json_decode(file_get_contents('php://input'), true);
if (!$input || !isset($input['CUSTOMER_ID'], $input['TITLE'], $input['MESSAGE'], $input['TYPE'])) {
    echo json_encode(['success'=>false, 'message'=>'Thiếu dữ liệu']);
    exit;
}

$customerId = $input['CUSTOMER_ID'];
$title = $input['TITLE'];
$message = $input['MESSAGE'];
$type = $input['TYPE'];
$link = $input['LINK'] ?? null;
$senderId = $input['SENDER_ID'] ?? 'SYSTEM';
$sentAt = date("Y-m-d H:i:s");
$isRead = 0;
$email = $input['EMAIL'] ?? null;

// 1. Chèn notification
$notificationModel = new NotificationModel($conn_noti);
$notificationId = $notificationModel->addNotification([
    'CUSTOMER_ID'=>$customerId,
    'ADMIN_ID'=>null,
    'SENDER_ID'=>$senderId,
    'RECEIVER_ID'=>$customerId,
    'RECEIVER_TYPE'=>'CUSTOMER',
    'TITLE'=>$title,
    'MESSAGE'=>$message,
    'TYPE'=>$type,
    'LINK'=>$link,
    'SENT_AT'=>$sentAt,
    'IS_READ'=>$isRead
]);

// 2. Gửi email
$emailService = new EmailService($conn_noti);
$emailStatus = null;
if ($email) {
    $emailStatus = $emailService->sendEmail($email, $title, $message . ($link ? "\nChi tiết: $link" : ''), $customerId);
}

echo json_encode([
    'success'=>true,
    'notification_id'=>$notificationId,
    'email_status'=>$emailStatus
]);
?>
