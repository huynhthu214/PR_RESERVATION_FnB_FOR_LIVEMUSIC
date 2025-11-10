<?php
require_once 'db.php';
header('Content-Type: application/json; charset=UTF-8');

$action = $_GET['action'] ?? '';

switch ($action) {

    /*Đăng nhập admin */
    case 'login':
        $input = json_decode(file_get_contents("php://input"), true);
        $email = $input['email'] ?? '';
        $password = $input['password'] ?? '';

        $stmt = $conn_admin->prepare("SELECT ADMIN_ID, USERNAME, PASSWORD FROM ADMIN_USERS WHERE EMAIL = ?");
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
    }
$conn_admin->close();
