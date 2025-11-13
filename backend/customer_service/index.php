<?php
require_once 'db.php';
header("Content-Type: application/json");

// lấy action từ URL (?action=...)
$action = $_GET['action'] ?? '';

switch ($action) {

    case 'get_all_customers':
        $sql = "SELECT CUSTOMER_ID, USERNAME, EMAIL, CREATED_AT FROM CUSTOMER_USERS";
        $result = $conn_customer->query($sql);
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
        $stmt = $conn_customer->prepare("SELECT * FROM CUSTOMER_USERS WHERE CUSTOMER_ID = ?");
        $stmt->bind_param("s", $id);
        $stmt->execute();
        $res = $stmt->get_result()->fetch_assoc();
        echo json_encode($res ?: ["error" => "Không tìm thấy khách hàng"]);
        break;

    case 'login':
        // Nhận email & password từ POST
        $data = json_decode(file_get_contents("php://input"), true);
        $email = $data['email'] ?? '';
        $password = $data['password'] ?? '';

        if (!$email || !$password) {
            echo json_encode(["error" => "Vui lòng nhập đầy đủ email và mật khẩu"]);
            exit;
        }

        $stmt = $conn_customer->prepare("SELECT * FROM CUSTOMER_USERS WHERE EMAIL = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        if (!$user) {
            echo json_encode(["error" => "Email không tồn tại"]);
        } else {
            // Kiểm tra mật khẩu
            if ($user['PASSWORD'] === $password) {
                // Có thể loại bỏ PASSWORD trước khi trả về
                unset($user['PASSWORD']);
                echo json_encode([
                    "success" => true,
                    "message" => "Đăng nhập thành công",
                    "user" => $user
                ]);
            } else {
                echo json_encode(["error" => "Sai mật khẩu"]);
            }
        }
        break;

    default:
        echo json_encode(["error" => "Action không hợp lệ trong customer_service"]);
}

$conn_customer->close();
?>
