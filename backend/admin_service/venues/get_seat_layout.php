<?php
header('Content-Type: application/json');
require_once __DIR__ . '/../db.php'; 

if (!isset($_GET['event_id'])) {
    echo json_encode(['success' => false, 'message' => 'Missing event_id']);
    exit;
}

$eventId = $_GET['event_id'];

// 1. Lấy VENUE_ID và TICKET_PRICE gốc từ bảng EVENTS
$sqlEvent = "SELECT VENUE_ID, TICKET_PRICE FROM EVENTS WHERE EVENT_ID = '$eventId'";
$resEvent = $conn_admin->query($sqlEvent);

if (!$resEvent || $resEvent->num_rows === 0) {
    echo json_encode(['success' => false, 'message' => 'Event not found']);
    exit;
}

$eventData = $resEvent->fetch_assoc();
$venueId   = $eventData['VENUE_ID'];
$basePrice = floatval($eventData['TICKET_PRICE']);

// 2. Lấy danh sách ghế từ bảng SEATS
// Sắp xếp theo ROW_NUMBER rồi đến SEAT_NUMBER để hiển thị đúng thứ tự
$sqlSeats = "SELECT * FROM SEATS WHERE VENUE_ID = '$venueId' ORDER BY ROW_NUMBER ASC, SEAT_NUMBER ASC";
$resSeats = $conn_admin->query($sqlSeats);

$layout = []; // Biến này sẽ map đúng cấu trúc frontend cần

if ($resSeats->num_rows > 0) {
    while ($row = $resSeats->fetch_assoc()) {
        $rowNum = intval($row['ROW_NUMBER']);
        
        // Logic tính giá: Giá gốc * Hệ số
        $multiplier = floatval($row['PRICE_MULTIPLIER']) > 0 ? floatval($row['PRICE_MULTIPLIER']) : 1;
        $finalPrice = $basePrice * $multiplier;

        // Map dữ liệu DB sang tên biến JS của bạn
        // seat.type === 'VIP' để kích hoạt class .vip
        $seatType = strtoupper($row['SEAT_TYPE']) === 'VIP' ? 'VIP' : 'Standard'; 
        
        // seat.status: 'reserved' (đã đặt) hoặc '' (trống)
        // Bạn có thể join thêm bảng BOOKING để check chính xác, ở đây tôi dùng IS_AVAILABLE tạm
        $status = ($row['IS_AVAILABLE'] == 1) ? '' : 'reserved';

        // Tạo cấu trúc row nếu chưa tồn tại
        if (!isset($layout[$rowNum])) {
            $layout[$rowNum] = [
                'row' => "Hàng " . $rowNum, // row.row (Hiển thị label)
                'seats' => []
            ];
        }

        // Đẩy ghế vào mảng seats
        $layout[$rowNum]['seats'][] = [
            'id'     => $row['SEAT_ID'],     // seat.id
            'number' => $row['SEAT_NUMBER'], // seat.number (để hiển thị số trên ghế)
            'type'   => $seatType,           // seat.type (để check class vip)
            'status' => $status,             // seat.status (để disable button)
            'price'  => $finalPrice          // seat.price (để tính tổng tiền)
        ];
    }
}

// Chuyển mảng key-value sang mảng tuần tự để trả về JSON
echo json_encode([
    'success' => true,
    'data' => array_values($layout)
]);

exit;
?>