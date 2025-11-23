<?php
header('Content-Type: application/json');
require_once __DIR__ . '/../db.php'; 

// Kiểm tra kết nối trước (không dùng die của db.php)
if (!isset($conn_noti) || $conn_noti->connect_error) {
    echo json_encode(['success' => false, 'message' => 'Không kết nối được database']);
    exit;
}

// Chỉ chấp nhận POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Phương thức không hợp lệ']);
    exit;
}

// Lấy dữ liệu
$name       = trim($_POST['name'] ?? '');
$email      = trim($_POST['email'] ?? '');
$ticket_id  = trim($_POST['ticket_id'] ?? '');
$message    = trim($_POST['message'] ?? '');

// Validate
if ($name === '' || $email === '' || $message === '') {
    echo json_encode(['success' => false, 'message' => 'Vui lòng điền đầy đủ họ tên, email và nội dung']);
    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(['success' => false, 'message' => 'Email không hợp lệ']);
    exit;
}

if (strlen($message) > 3000) {
    echo json_encode(['success' => false, 'message' => 'Nội dung quá dài']);
    exit;
}

// Dùng đúng connection trong db.php
$conn = $conn_noti;

// Lấy ID cuối
$sql = "SELECT EMAILLOG_ID FROM EMAIL_LOG ORDER BY EMAILLOG_ID DESC LIMIT 1";
$result = $conn->query($sql);

$lastId = ($result && $result->num_rows > 0) 
            ? $result->fetch_assoc()['EMAILLOG_ID']
            : 'EL000';

$newNum = str_pad(intval(substr($lastId, 2)) + 1, 3, '0', STR_PAD_LEFT);
$newId  = 'EL' . $newNum;

// Nội dung lưu
$content_detail = "Tên: $name\nEmail: $email\nMã vé: " . ($ticket_id ?: 'Không có') . "\n\nNội dung:\n$message";

// Chuẩn bị insert
$stmt = $conn->prepare("
    INSERT INTO EMAIL_LOG 
    (EMAILLOG_ID, ADMIN_ID, CUSTOMER_ID, RECIPIENT_EMAIL, SUBJECT, SENT_TIME, STATUS, ERRORMESSAGE) 
    VALUES (?, NULL, NULL, 'support@livemusic.vn', 'Liên hệ từ khách hàng', NOW(), 'new', ?)
");

if (!$stmt) {
    echo json_encode(['success' => false, 'message' => 'Lỗi truy vấn database']);
    exit;
}

$stmt->bind_param("ss", $newId, $content_detail);

// Thực thi
if ($stmt->execute()) {

    echo json_encode([
        'success' => true,
        'message' => 'Tin nhắn đã được gửi thành công.'
    ]);

} else {

    echo json_encode([
        'success' => false,
        'message' => 'Không thể lưu tin nhắn, vui lòng thử lại.'
    ]);

}

exit;
?>
