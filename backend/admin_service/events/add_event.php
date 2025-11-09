<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json; charset=UTF-8");

include_once __DIR__ . '/../db.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$data = json_decode(file_get_contents("php://input"), true);

if (empty($data['band_name']) || empty($data['venue_name']) || empty($data['event_date']) || !isset($data['ticket_price']) || empty($data['status'])) {
    http_response_code(400); 
    echo json_encode(["success" => false, "message" => "Thiếu dữ liệu bắt buộc (band_name, venue_name, event_date, ticket_price, status)"]);
    exit;
}

/* Tạo EVENT_ID tự động sinh.                   */
$sql_get_id = "SELECT EVENT_ID FROM EVENTS ORDER BY EVENT_ID DESC LIMIT 1";
$result = $conn->query($sql_get_id);

if ($result && $result->num_rows > 0) {
    $last_id = $result->fetch_assoc()['EVENT_ID'];
    $num = intval(substr($last_id, 1)) + 1;
    $EVENT_ID = 'E' . str_pad($num, 3, '0', STR_PAD_LEFT);
} else {
    $EVENT_ID = 'E001';
}

if (!isset($_SESSION['ADMIN_ID'])) { 
    http_response_code(401); 
    echo json_encode(["success" => false, "message" => "Chưa đăng nhập. Vui lòng đăng nhập."]);
    $conn->close();
    exit;
}
$ADMIN_ID = $_SESSION['ADMIN_ID']; 

$BAND_NAME = $conn->real_escape_string($data['band_name']);
$VENUE_NAME = $conn->real_escape_string($data['venue_name']);
$STATUS = $conn->real_escape_string($data['status']);
$TICKET_PRICE = floatval($data['ticket_price']);

try {
    $event_date_input = $data['event_date'];
    $start_time_obj = new DateTime($event_date_input);
    
    $EVENT_DATE_sql = $start_time_obj->format('Y-m-d H:i:s');
    $START_TIME_sql = $EVENT_DATE_sql;

    $end_time_obj = (new DateTime($event_date_input))->modify('+3 hours');
    $END_TIME_sql = $end_time_obj->format('Y-m-d H:i:s');

} catch (Exception $e) {
    http_response_code(400);
    echo json_encode(["success" => false, "message" => "Định dạng ngày giờ không hợp lệ."]);
    $conn->close();
    exit;
}

$DESCRIPTION = "NULL";
$IMAGE_URL = "NULL";

// Tra cứu VENUE_ID từ VENUE_NAME
$sql_venue = "SELECT VENUE_ID FROM VENUES WHERE NAME = '{$VENUE_NAME}' LIMIT 1";
$result_venue = $conn->query($sql_venue);

if ($result_venue && $result_venue->num_rows > 0) {
    $VENUE_ID = $result_venue->fetch_assoc()['VENUE_ID'];
} else {
    http_response_code(400);
    echo json_encode(["success" => false, "message" => "Địa điểm không tồn tại."]);
    $conn->close();
    exit;
}

$sql = "INSERT INTO EVENTS 
            (EVENT_ID, ADMIN_ID, VENUE_ID, BAND_NAME, EVENT_DATE, START_TIME, TICKET_PRICE, STATUS, DESCRIPTION, END_TIME, IMAGE_URL)
        VALUES 
            ('$EVENT_ID', '$ADMIN_ID', '$VENUE_ID', '$BAND_NAME', '$EVENT_DATE_sql', '$START_TIME_sql', $TICKET_PRICE, '$STATUS', $DESCRIPTION, '$END_TIME_sql', $IMAGE_URL)";

if ($conn->query($sql)) {
    http_response_code(201); 
    echo json_encode(["success" => true, "message" => "Thêm sự kiện thành công", "EVENT_ID" => $EVENT_ID]);
} else {
    http_response_code(500); 
    
    if (str_contains($conn->error, 'foreign key constraint')) {
         echo json_encode(["success" => false, "message" => "Lỗi: ID Địa điểm (Venue ID) không tồn tại hoặc không hợp lệ."]);
    } else {
         echo json_encode(["success" => false, "message" => "Lỗi khi thêm sự kiện: " . $conn->error]);
    }
}

$conn->close();
?>