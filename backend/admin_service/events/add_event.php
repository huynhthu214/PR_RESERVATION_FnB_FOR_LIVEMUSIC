<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json; charset=UTF-8");

include_once __DIR__ . '/../db.php';
if (session_status() == PHP_SESSION_NONE) session_start();

$data = json_decode(file_get_contents("php://input"), true);

if (empty($data['band_name']) || empty($data['event_name']) || empty($data['venue_id']) 
    || empty($data['event_date']) || !isset($data['ticket_price']) || empty($data['status'])) {
    http_response_code(400);
    echo json_encode(["success" => false, "message" => "Thiếu dữ liệu bắt buộc"]);
    exit;
}

// Tạo EVENT_ID tự động
$sql_get_id = "SELECT EVENT_ID FROM EVENTS ORDER BY EVENT_ID DESC LIMIT 1";
$result = $conn_admin->query($sql_get_id);
if ($result && $result->num_rows > 0) {
    $last_id = $result->fetch_assoc()['EVENT_ID'];
    $num = intval(substr($last_id, 1)) + 1;
    $EVENT_ID = 'E' . str_pad($num, 3, '0', STR_PAD_LEFT);
} else {
    $EVENT_ID = 'E001';
}

if (!isset($_SESSION['ADMIN_ID'])) {
    http_response_code(401);
    echo json_encode(["success" => false, "message" => "Chưa đăng nhập"]);
    $conn_admin->close();
    exit;
}

$ADMIN_ID = $_SESSION['ADMIN_ID']; 
$EVENT_NAME = $conn_admin->real_escape_string($data['event_name']);
$BAND_NAME = $conn_admin->real_escape_string($data['band_name']);
$VENUE_ID = $conn_admin->real_escape_string($data['venue_id']);
$STATUS = $conn_admin->real_escape_string($data['status']);
$TICKET_PRICE = floatval($data['ticket_price']);

try {
    $start_time_obj = new DateTime($data['event_date']);
    $EVENT_DATE_sql = $start_time_obj->format('Y-m-d H:i:s');
    $START_TIME_sql = $EVENT_DATE_sql;
    $END_TIME_sql = (clone $start_time_obj)->modify('+3 hours')->format('Y-m-d H:i:s');
} catch (Exception $e) {
    http_response_code(400);
    echo json_encode(["success" => false, "message" => "Định dạng ngày giờ không hợp lệ."]);
    $conn_admin->close();
    exit;
}

$DESCRIPTION = "''";
$IMAGE_URL = "''";

// Chèn event
$sql = "INSERT INTO EVENTS 
            (EVENT_ID, ADMIN_ID, VENUE_ID, BAND_NAME, EVENT_DATE, START_TIME, TICKET_PRICE, STATUS, DESCRIPTION, END_TIME, IMAGE_URL, EVENT_NAME)
        VALUES 
            ('$EVENT_ID', '$ADMIN_ID', '$VENUE_ID', '$BAND_NAME', '$EVENT_DATE_sql', '$START_TIME_sql', $TICKET_PRICE, '$STATUS', $DESCRIPTION, '$END_TIME_sql', $IMAGE_URL, '$EVENT_NAME')";

if ($conn_admin->query($sql)) {
    http_response_code(201); 
    echo json_encode(["success" => true, "message" => "Thêm sự kiện thành công", "EVENT_ID" => $EVENT_ID]);
} else {
    http_response_code(500); 
    if (str_contains($conn_admin->error, 'foreign key constraint')) {
         echo json_encode(["success" => false, "message" => "Lỗi: Venue ID không hợp lệ."]);
    } else {
         echo json_encode(["success" => false, "message" => "Lỗi khi thêm sự kiện: " . $conn_admin->error]);
    }
}

$conn_admin->close();
?>
