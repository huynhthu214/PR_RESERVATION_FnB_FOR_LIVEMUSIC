<?php
require_once 'db.php';
header("Content-Type: application/json");

$action = $_GET['action'] ?? '';

switch ($action) {

    case 'get_all_reservations':
        $sql = "SELECT RESERVATION_ID, EVENT_ID, SEAT_ID, CUSTOMER_ID, STATUS, TOTAL_AMOUNT FROM RESERVATIONS";
        $result = $conn->query($sql);
        $res = [];
        while ($row = $result->fetch_assoc()) $res[] = $row;
        echo json_encode($res);
        break;

    case 'get_available_seats':
        $eventId = $_GET['event_id'] ?? '';
        if (!$eventId) {
            echo json_encode(["error" => "Thiếu mã sự kiện"]);
            exit;
        }
        $sql = "SELECT s.SEAT_ID, s.ROW_NUMBER, s.SEAT_NUMBER, s.SEAT_TYPE, s.IS_AVAILABLE
                FROM SEATS s
                JOIN VENUES v ON s.VENUE_ID = v.VENUE_ID
                JOIN EVENTS e ON e.VENUE_ID = v.VENUE_ID
                WHERE e.EVENT_ID = '$eventId' AND s.IS_AVAILABLE = 1";
        $result = $conn->query($sql);
        $seats = [];
        while ($row = $result->fetch_assoc()) $seats[] = $row;
        echo json_encode($seats);
        break;

    default:
        echo json_encode(["error" => "Action không hợp lệ trong reservation_service"]);
}
$conn->close();
