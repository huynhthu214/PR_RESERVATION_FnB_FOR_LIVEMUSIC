<?php
require_once 'db.php';
header('Content-Type: application/json');

$action = $_GET['action'] ?? '';

if ($action === 'login') {
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
    exit;
}
