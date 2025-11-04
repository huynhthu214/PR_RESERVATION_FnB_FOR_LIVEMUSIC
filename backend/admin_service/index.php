<?php
require_once 'db.php';
header('Content-Type: application/json; charset=UTF-8');

$action = $_GET['action'] ?? '';

switch ($action) {

    /* 🔹 Đăng nhập admin */
    case 'login':
        $input = json_decode(file_get_contents("php://input"), true);
        $email = $input['email'] ?? '';
        $password = $input['password'] ?? '';

        $stmt = $conn->prepare("SELECT ADMIN_ID, USERNAME, PASSWORD FROM ADMIN_USERS WHERE EMAIL = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($row = $result->fetch_assoc()) {
            if ($password === $row['PASSWORD']) {
                echo json_encode(["success" => true, "data" => $row]);
            } else {
                echo json_encode(["success" => false, "error" => "Sai mật khẩu!"]);
            }
        } else {
            echo json_encode(["success" => false, "error" => "Không tìm thấy email!"]);
        }

        $stmt->close();
        break;

    /* 🔹 Thêm sự kiện mới */
    case 'add_event':
        $input = json_decode(file_get_contents("php://input"), true);

        $band_name = trim($input['band_name'] ?? '');
        $venue_id = trim($input['venue_id'] ?? '');
        $event_date = trim($input['event_date'] ?? '');
        $ticket_price = $input['ticket_price'] ?? 0;
        $status = trim($input['status'] ?? 'INACTIVE');
        $description = trim($input['description'] ?? '');
        $image_url = trim($input['image_url'] ?? '');
        $admin_id = trim($input['admin_id'] ?? 'A001'); // giả định admin mặc định

        if (empty($band_name) || empty($venue_id) || empty($event_date)) {
            echo json_encode(["success" => false, "error" => "Thiếu thông tin bắt buộc!"]);
            break;
        }

        $stmt = $conn->prepare("
            INSERT INTO EVENTS (EVENT_ID, ADMIN_ID, VENUE_ID, BAND_NAME, EVENT_DATE, TICKET_PRICE, STATUS, DESCRIPTION, IMAGE_URL)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
        ");

        $event_id = 'E' . time(); // tạo ID duy nhất

        $stmt->bind_param(
            "sssssdsss",
            $event_id,
            $admin_id,
            $venue_id,
            $band_name,
            $event_date,
            $ticket_price,
            $status,
            $description,
            $image_url
        );

        if ($stmt->execute()) {
            echo json_encode(["success" => true, "message" => "Thêm sự kiện thành công!", "event_id" => $event_id]);
        } else {
            echo json_encode(["success" => false, "error" => $stmt->error]);
        }

        $stmt->close();
        break;

    /* 🔹 Lấy danh sách sự kiện */
    case 'get_events':
        $result = $conn->query("
            SELECT EVENT_ID AS id, VENUE_ID AS venue, BAND_NAME AS band,
                   EVENT_DATE AS date, TICKET_PRICE AS price, STATUS AS status
            FROM EVENTS
            ORDER BY EVENT_DATE ASC
        ");

        $events = [];
        while ($row = $result->fetch_assoc()) {
            $events[] = $row;
        }

        echo json_encode(["success" => true, "data" => $events]);
        break;

    default:
        echo json_encode(["success" => false, "error" => "Hành động không hợp lệ!"]);
        break;
}

$conn->close();
