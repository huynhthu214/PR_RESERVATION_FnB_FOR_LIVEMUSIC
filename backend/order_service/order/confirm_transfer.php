<?php
header('Content-Type: application/json; charset=UTF-8');
require_once __DIR__ . '/../db.php';                 // kết nối $conn_order
require_once __DIR__ . '/../../customer_service/db.php'; // kết nối $conn_customer
require_once __DIR__ . '/../../notification_service/db.php'; // kết nối $conn_noti
require_once __DIR__ . '/../../../vendor/PHPMailer-master/src/PHPMailer.php';
require_once __DIR__ . '/../../../vendor/PHPMailer-master/src/SMTP.php';
require_once __DIR__ . '/../../../vendor/PHPMailer-master/src/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$orderId = $_GET['order_id'] ?? null;
if (!$orderId) {
    echo json_encode(['success' => false, 'message' => 'Order ID không hợp lệ']);
    exit;
}

// ---------------- Lấy thông tin đơn hàng ----------------
$stmtOrder = $conn_order->prepare("SELECT * FROM ORDERS WHERE ORDER_ID = ?");
$stmtOrder->bind_param("s", $orderId);
$stmtOrder->execute();
$order = $stmtOrder->get_result()->fetch_assoc();

if (!$order) {
    echo json_encode(['success' => false, 'message' => 'Đơn hàng không tồn tại']);
    exit;
}

// ---------------- Lấy email khách hàng ----------------
$customerId = $order['CUSTOMER_ID'];
$email = null;
if ($customerId) {
    $stmtCust = $conn_customer->prepare("SELECT EMAIL FROM CUSTOMER_USERS WHERE CUSTOMER_ID = ?");
    $stmtCust->bind_param("s", $customerId);
    $stmtCust->execute();
    $cust = $stmtCust->get_result()->fetch_assoc();
    $email = $cust['EMAIL'] ?? null;
}

// ---------------- Kiểm tra thanh toán ----------------
$stmtCheck = $conn_order->prepare("SELECT PAYMENT_STATUS FROM PAYMENTS WHERE ORDER_ID = ?");
$stmtCheck->bind_param("s", $orderId);
$stmtCheck->execute();
$payCheck = $stmtCheck->get_result()->fetch_assoc();

if ($payCheck && $payCheck['PAYMENT_STATUS'] === 'Completed') {
    echo json_encode(['success' => false, 'message' => 'Đơn hàng đã được thanh toán trước đó']);
    exit;
}

// ---------------- Cập nhật thanh toán ----------------
$stmtUpdate = $conn_order->prepare("UPDATE PAYMENTS SET PAYMENT_STATUS='Completed', PAYMENT_TIME=NOW() WHERE ORDER_ID=?");
$stmtUpdate->bind_param("s", $orderId);
$stmtUpdate->execute();

$stmtOrderUpdate = $conn_order->prepare("UPDATE ORDERS SET STATUS='Paid' WHERE ORDER_ID=?");
$stmtOrderUpdate->bind_param("s", $orderId);
$stmtOrderUpdate->execute();

// ---------------- Lấy chi tiết đơn hàng và payment ----------------
$stmtItems = $conn_order->prepare("SELECT * FROM ORDER_ITEMS WHERE ORDER_ID=?");
$stmtItems->bind_param("s", $orderId);
$stmtItems->execute();
$items = $stmtItems->get_result()->fetch_all(MYSQLI_ASSOC);

$stmtPay = $conn_order->prepare("SELECT * FROM PAYMENTS WHERE ORDER_ID=?");
$stmtPay->bind_param("s", $orderId);
$stmtPay->execute();
$payment = $stmtPay->get_result()->fetch_assoc() ?? null;

// ---------------- Gửi email xác nhận ----------------
$mailResult = '';
$mailStatus = 'Failed';
$mailError = '';
$mailSubject = "Xác nhận thanh toán đơn hàng $orderId";

if ($email) {
    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'minhthuhuynh23@gmail.com';
        $mail->Password = 'kapendjgusnxwczc';
        $mail->SMTPSecure = 'ssl';
        $mail->Port = 465;
        $mail->CharSet = 'UTF-8';

        $mail->setFrom('minhthuhuynh23@gmail.com', 'LYZY LiveMusic');
        $mail->addAddress($email);
        $mail->isHTML(true);
        $mail->Subject = $mailSubject;
        $mail->Body = "<h3>Thanh toán đơn hàng <b>$orderId</b> thành công</h3>
                       <p>Số tiền: <b>" . number_format($order['TOTAL_AMOUNT']) . " VND</b></p>
                       <p>Cảm ơn bạn đã sử dụng dịch vụ của LYZY LiveMusic.</p>";
        $mail->send();

        $mailResult = "Email đã gửi thành công";
        $mailStatus = 'Sent';
    } catch (Exception $e) {
        $mailResult = "Không gửi được email: {$mail->ErrorInfo}";
        $mailError = $mail->ErrorInfo;
    }
} else {
    $mailResult = "Không có email khách hàng";
    $mailError = "No email";
}

// ---------------- Ghi vào EMAIL_LOG (try riêng) ----------------
try {
    $emailLogId = uniqid('elog_'); // tạo ID duy nhất
    $adminId = null; // Nếu admin xác định, điền admin ID ở đây

    $stmtLog = $conn_noti->prepare("INSERT INTO EMAIL_LOG
        (EMAILLOG_ID, ADMIN_ID, CUSTOMER_ID, RECIPIENT_EMAIL, SUBJECT, SENT_TIME, STATUS, ERRORMESSAGE)
        VALUES (?, ?, ?, ?, ?, NOW(), ?, ?)");
    $stmtLog->bind_param("sssssss", $emailLogId, $adminId, $customerId, $email, $mailSubject, $mailStatus, $mailError);
    $stmtLog->execute();
} catch (\Throwable $t) {
    // Không stop luồng thanh toán, chỉ log lỗi
    error_log("Lỗi ghi EMAIL_LOG: " . $t->getMessage());
}

// ---------------- Trả JSON ----------------
echo json_encode([
    'success' => true,
    'message' => 'Thanh toán thành công',
    'order' => $order,
    'items' => $items,
    'payment' => $payment,
    'mail' => $mailResult
]);
exit;
?>
