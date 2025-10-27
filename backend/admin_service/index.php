<?php
require_once 'db.php';
header("Content-Type: application/json");

$action = $_GET['action'] ?? '';

switch ($action) {

    case 'get_all_events':
        $sql = "SELECT EVENT_ID, BAND_NAME, EVENT_DATE, TICKET_PRICE, STATUS FROM EVENTS";
        $result = $conn->query($sql);
        $events = [];
        while ($row = $result->fetch_assoc()) $events[] = $row;
        echo json_encode($events);
        break;

    case 'get_dashboard_stats':
        $stats = [
            "revenue" => 142500000,
            "events" => 28,
            "orders" => 1247,
            "customers" => 3892
        ];
        echo json_encode($stats);
        break;

    case 'get_promotions':
        $sql = "SELECT * FROM PROMOTIONS";
        $result = $conn->query($sql);
        $promos = [];
        while ($row = $result->fetch_assoc()) $promos[] = $row;
        echo json_encode($promos);
        break;

    default:
        echo json_encode(["error" => "Action không hợp lệ trong admin_service"]);
}
$conn->close();
