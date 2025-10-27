<?php
require_once 'db.php';
header("Content-Type: application/json");

$action = $_GET['action'] ?? '';

switch ($action) {

    case 'get_all_customers':
        $sql = "SELECT CUSTOMER_ID, USERNAME, EMAIL, CREATED_AT FROM CUSTOMER_USERS";
        $result = $conn->query($sql);
        $customers = [];
        while ($row = $result->fetch_assoc()) $customers[] = $row;
        echo json_encode($customers);
        break;

    case 'get_customer_by_id':
        $id = $_GET['id'] ?? '';
        if (!$id) {
            echo json_encode(["error" => "Thiếu id khách hàng"]);
            exit;
        }
        $stmt = $conn->prepare("SELECT * FROM CUSTOMER_USERS WHERE CUSTOMER_ID = ?");
        $stmt->bind_param("s", $id);
        $stmt->execute();
        $res = $stmt->get_result()->fetch_assoc();
        echo json_encode($res ?: ["error" => "Không tìm thấy khách hàng"]);
        break;

    default:
        echo json_encode(["error" => "Action không hợp lệ trong customer_service"]);
}
$conn->close();
