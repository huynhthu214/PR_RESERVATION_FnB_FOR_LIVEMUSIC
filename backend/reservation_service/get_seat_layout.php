<?php
header('Content-Type: application/json');
require_once __DIR__ . '/../admin_service/db.php';

if (!isset($_GET['event_id'])) {
    echo json_encode(['success' => false, 'message' => 'Missing event_id']);
    exit;
}

$eventId = $_GET['event_id'];

// 1. Lấy VENUE_ID và giá gốc từ EVENTS
$sql = "SELECT VENUE_ID, TICKET_PRICE FROM EVENTS WHERE EVENT_ID = '$eventId'";
$res = $conn_admin->query($sql);

if (!$res || $res->num_rows === 0) {
    echo json_encode(['success' => false, 'message' => 'Event not found']);
    exit;
}

$data = $res->fetch_assoc();
$venueId = $data['VENUE_ID'];
$basePrice = floatval($data['TICKET_PRICE']);

// 2. Lấy seat layout file path từ VENUES
$sqlVenue = "SELECT SEAT_LAYOUT FROM VENUES WHERE VENUE_ID = '$venueId'";
$resVenue = $conn_admin->query($sqlVenue);

if (!$resVenue || $resVenue->num_rows === 0) {
    echo json_encode(['success' => false, 'message' => 'Venue not found']);
    exit;
}

$rowVenue = $resVenue->fetch_assoc();

// Chuẩn hóa đường dẫn file JSON
$seatLayoutFile = basename($rowVenue['SEAT_LAYOUT']); // lấy tên file
$seatLayoutPath = __DIR__ . '/seat_layouts/' . $seatLayoutFile;

if (!file_exists($seatLayoutPath)) {
    echo json_encode(['success' => false, 'message' => 'Seat layout file not found']);
    exit;
}

// 3. Đọc file JSON và decode
$jsonStr = file_get_contents($seatLayoutPath);
$seatLayoutFull = json_decode($jsonStr, true);

if (!$seatLayoutFull) {
    echo json_encode(['success' => false, 'message' => 'Invalid seat layout JSON']);
    exit;
}

// Nếu JSON có key "rows", dùng nó
$seatLayout = isset($seatLayoutFull['rows']) ? array_values($seatLayoutFull['rows']) : $seatLayoutFull;

// 4. Tính giá ghế theo PRICE_MULTIPLIER
foreach ($seatLayout as &$row) {
    if (!isset($row['seats']) || !is_array($row['seats'])) continue;
    foreach ($row['seats'] as &$seat) {
        $multiplier = isset($seat['PRICE_MULTIPLIER']) ? floatval($seat['PRICE_MULTIPLIER']) : 1;
        $seat['price'] = $basePrice * $multiplier;
    }
}

// 5. Trả dữ liệu JSON về frontend
echo json_encode([
    'success' => true,
    'data' => $seatLayout
]);