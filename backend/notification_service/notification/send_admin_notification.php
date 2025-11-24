<?php
header("Content-Type: application/json; charset=UTF-8");
require_once __DIR__ . '/../db.php';
require_once __DIR__ . 'NotificationModel.php';

$input = json_decode(file_get_contents('php://input'), true);
if (!$input || !isset($input['ADMIN_ID'], $input['TITLE'], $input['MESSAGE'], $input['TYPE'])) {
    echo json_encode(['success'=>false, 'message'=>'Thiếu dữ liệu']);
    exit;
}

$adminId = $input['ADMIN_ID'];
$title = $input['TITLE'];
$message = $input['MESSAGE'];
$type = $input['TYPE'];
$link = $input['LINK'] ?? null;
$senderId = $input['SENDER_ID'] ?? 'SYSTEM';
$sentAt = date("Y-m-d H:i:s");
$isRead = 0;

// Chèn notification
$notificationModel = new NotificationModel($conn_noti);
$notificationId = $notificationModel->addNotification([
    'CUSTOMER_ID'=>null,
    'ADMIN_ID'=>$adminId,
    'SENDER_ID'=>$senderId,
    'RECEIVER_ID'=>$adminId,
    'RECEIVER_TYPE'=>'ADMIN',
    'TITLE'=>$title,
    'MESSAGE'=>$message,
    'TYPE'=>$type,
    'LINK'=>$link,
    'SENT_AT'=>$sentAt,
    'IS_READ'=>$isRead
]);

echo json_encode([
    'success'=>true,
    'notification_id'=>$notificationId
]);
?>
