<?php
header('Content-Type: application/json; charset=UTF-8');
require_once __DIR__ . '/../db.php';
require_once __DIR__ . '/../../customer_service/db.php';
require __DIR__ . '/../../../vendor/PHPMailer-master/src/PHPMailer.php';
require __DIR__ . '/../../../vendor/PHPMailer-master/src/SMTP.php';
require __DIR__ . '/../../../vendor/PHPMailer-master/src/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$orderId = $_GET['order_id'] ?? null;

if (!$orderId) {
    echo json_encode(['success' => false, 'message' => 'Order ID không hợp lệ']);
    exit;
}

// Lấy thông tin đơn hàng
$stmtOrder = $conn_order->prepare("SELECT * FROM ORDERS WHERE ORDER_ID = ?");
$stmtOrder->bind_param("s", $orderId);
$stmtOrder->execute();
$orderResult = $stmtOrder->get_result();
$order = $orderResult->fetch_assoc();

if (!$order) {
    echo json_encode(['success' => false, 'message' => 'Đơn hàng không tồn tại']);
    exit;
}

// Lấy CUSTOMER_ID và email
$customerId = $order['CUSTOMER_ID'];
$email = null;
if ($customerId) {
    $stmtCust = $conn_customer->prepare("SELECT EMAIL FROM CUSTOMER_USERS WHERE CUSTOMER_ID = ?");
    $stmtCust->bind_param("s", $customerId);
    $stmtCust->execute();
    $resCust = $stmtCust->get_result();
    $cust = $resCust->fetch_assoc();
    $email = $cust['EMAIL'] ?? null;
}

// Kiểm tra trạng thái PAYMENT
$stmtCheck = $conn_order->prepare("SELECT PAYMENT_STATUS FROM PAYMENTS WHERE ORDER_ID = ?");
$stmtCheck->bind_param("s", $orderId);
$stmtCheck->execute();
$payCheck = $stmtCheck->get_result()->fetch_assoc();

if ($payCheck && $payCheck['PAYMENT_STATUS'] === 'Completed') {
    echo json_encode([
        'success' => false,
        'message' => 'Đơn hàng đã được thanh toán trước đó'
    ]);
    exit;
}

// Cập nhật PAYMENT sang Completed
$stmtUpdate = $conn_order->prepare("UPDATE PAYMENTS SET PAYMENT_STATUS='Completed', PAYMENT_TIME=NOW() WHERE ORDER_ID=?");
$stmtUpdate->bind_param("s", $orderId);
$stmtUpdate->execute();

// Cập nhật ORDERS.STATUS sang Paid
$stmtOrderUpdate = $conn_order->prepare("UPDATE ORDERS SET STATUS='Paid' WHERE ORDER_ID=?");
$stmtOrderUpdate->bind_param("s", $orderId);
$stmtOrderUpdate->execute();

// Lấy ORDER_ITEMS
$stmtItems = $conn_order->prepare("SELECT * FROM ORDER_ITEMS WHERE ORDER_ID=?");
$stmtItems->bind_param("s", $orderId);
$stmtItems->execute();
$itemResult = $stmtItems->get_result();
$items = [];
while ($row = $itemResult->fetch_assoc()) {
    $items[] = $row;
}

// Lấy PAYMENT
$stmtPay = $conn_order->prepare("SELECT * FROM PAYMENTS WHERE ORDER_ID=?");
$stmtPay->bind_param("s", $orderId);
$stmtPay->execute();
$payResult = $stmtPay->get_result();
$payment = $payResult->fetch_assoc() ?? null;

// Gửi mail xác nhận
$mailResult = '';
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
        $mail->Subject = "Xác nhận thanh toán đơn hàng $orderId";
        $mail->Body = "<h3>Thanh toán đơn hàng <b>$orderId</b> thành công</h3>
                       <p>Số tiền: <b>" . number_format($order['TOTAL_AMOUNT']) . " VND</b></p>
                       <p>Cảm ơn bạn đã sử dụng dịch vụ của LYZY LiveMusic.</p>";
        $mail->send();
        $mailResult = "Email đã gửi thành công";
    } catch (Exception $e) {
        $mailResult = "Không gửi được email: {$mail->ErrorInfo}";
    }
} else {
    $mailResult = "Không có email khách hàng";
}

// Trả về JSON đầy đủ để load vào trang User Order
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
