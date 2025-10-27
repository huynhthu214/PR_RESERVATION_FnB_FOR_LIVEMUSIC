<?php
require_once 'db.php';
header("Content-Type: application/json");

$action = $_GET['action'] ?? '';

switch ($action) {

    case 'get_all_notifications':
        $sql = "SELECT * FROM NOTIFICATIONS ORDER BY SENT_AT DESC";
        $result = $conn->query($sql);
        $data = [];
        while ($row = $result->fetch_assoc()) $data[] = $row;
        echo json_encode($data);
        break;

    case 'log_email':
        $input = json_decode(file_get_contents("php://input"), true);
        $email = $input['email'] ?? '';
        $status = $input['status'] ?? 'sent';
        $sql = "INSERT INTO EMAIL_LOG (EMAILLOG_ID, RECIPIENT_EMAIL, SUBJECT, SENT_TIME, STATUS)
                VALUES (UUID(), '$email', 'Test Email', NOW(), '$status')";
        $conn->query($sql);
        echo json_encode(["message" => "Đã ghi log email"]);
        break;

    default:
        echo json_encode(["error" => "Action không hợp lệ trong notification_service"]);
}
$conn->close();
