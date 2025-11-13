<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json; charset=UTF-8");

include_once __DIR__ . '/../db.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

/* Lấy dữ liệu từ FormData hoặc JSON */
$data = $_POST;
if (empty($data)) {
    $data = json_decode(file_get_contents("php://input"), true);
}

/* Kiểm tra dữ liệu bắt buộc */
if (empty($data['venue_name']) || empty($data['address']) || !isset($data['capacity']) || !is_numeric($data['capacity'])) {
    http_response_code(400);
    echo json_encode([
        "success" => false,
        "message" => "Thiếu dữ liệu bắt buộc (venue_name, address, capacity)"
    ]);
    exit;
}

/* Kiểm tra đăng nhập */
if (!isset($_SESSION['ADMIN_ID'])) {
    http_response_code(401);
    echo json_encode([
        "success" => false,
        "message" => "Chưa đăng nhập. Vui lòng đăng nhập."
    ]);
    exit;
}

$ADMIN_ID = $_SESSION['ADMIN_ID'];

/* Tạo VENUE_ID tự động */
$sql_get_id = "SELECT VENUE_ID FROM VENUES ORDER BY VENUE_ID DESC LIMIT 1";
$result = $conn_admin->query($sql_get_id);
if ($result && $result->num_rows > 0) {
    $last_id = $result->fetch_assoc()['VENUE_ID'];
    $num = intval(substr($last_id, 1)) + 1;
    $VENUE_ID = 'V' . str_pad($num, 3, '0', STR_PAD_LEFT);
} else {
    $VENUE_ID = 'V001';
}

/* Xử lý dữ liệu */
$VENUE_NAME = $conn_admin->real_escape_string($data['venue_name']);
$ADDRESS = $conn_admin->real_escape_string($data['address']);
$CAPACITY = intval($data['capacity']);
$SEAT_LAYOUT = "NULL";

/* Upload sơ đồ chỗ ngồi nếu có */
if (isset($_FILES['seat_layout']) && !empty($_FILES['seat_layout']['name'])) {
    $uploadDir = __DIR__ . '/../../uploads/seat_layouts/';
    if (!file_exists($uploadDir)) mkdir($uploadDir, 0777, true);

    $fileName = uniqid('layout_') . '_' . basename($_FILES['seat_layout']['name']);
    $targetPath = $uploadDir . $fileName;

    if (move_uploaded_file($_FILES['seat_layout']['tmp_name'], $targetPath)) {
        // Lưu đường dẫn tương đối
        $SEAT_LAYOUT = 'uploads/seat_layouts/' . $fileName;
    } else {
        echo json_encode([
            "success" => false,
            "message" => "Lỗi khi tải file sơ đồ chỗ ngồi."
        ]);
        exit;
    }
}

/* Thêm địa điểm vào DB */
$sql = "INSERT INTO VENUES (VENUE_ID, ADMIN_ID, NAME, ADDRESS, CAPACITY, SEAT_LAYOUT)
        VALUES ('$VENUE_ID', '$ADMIN_ID', '$VENUE_NAME', '$ADDRESS', $CAPACITY, " . ($SEAT_LAYOUT === 'NULL' ? "NULL" : "'$SEAT_LAYOUT'") . ")";

if ($conn_admin->query($sql)) {
    http_response_code(201);
    echo json_encode([
        "success" => true,
        "message" => "Thêm địa điểm thành công",
        "VENUE_ID" => $VENUE_ID
    ]);
} else {
    http_response_code(500);
    echo json_encode([
        "success" => false,
        "message" => "Lỗi khi thêm địa điểm: " . $conn_admin->error
    ]);
}

$conn_admin->close();
?>
