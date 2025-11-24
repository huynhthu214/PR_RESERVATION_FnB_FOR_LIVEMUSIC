<?php
header("Content-Type: application/json; charset=UTF-8");
require_once __DIR__ . '/../db.php';
require_once __DIR__ . '/NotificationModel.php';
require_once __DIR__ . '../email/EmailService.php';

// Lấy tất cả user
$users = [];
$res = $conn_noti->query("SELECT CUSTOMER_ID, EMAIL FROM CUSTOMER"); // giả sử có bảng CUSTOMER
while($row = $res->fetch_assoc()) {
    $users[] = $row;
}

$input = json_decode(file_get_contents('php://input'), true);
if (!$input || !isset($input['TITLE'], $input['MESSAGE'], $input['TYPE'])) {
    echo json_encode(['success'=>false, 'message'=>'Thiếu dữ liệu']);
    exit;
}

$title = $input['TITLE'];
$message = $input['MESSAGE'];
$type = $input['TYPE'];
$link = $input['LINK'] ?? null;
$senderId = $input['SENDER_ID'] ?? 'ADMIN';
$sentAt = date("Y-m-d H:i:s");
$isRead = 0;

$notificationModel = new NotificationModel($conn_noti);
$emailService = new EmailService($conn_noti);

$successCount = 0;

foreach($users as $user) {
    $customerId = $user['CUSTOMER_ID'];
    $email = $user['EMAIL'] ?? null;

    // Notification
    $notificationModel->addNotification([
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

    // Email
    if ($email) {
        $emailService->sendEmail($email, $title, $message . ($link ? "\nChi tiết: $link" : ''), $customerId);
    }

    $successCount++;
}

echo json_encode([
    'success'=>true,
    'sent_to'=>$successCount
]);
?>
