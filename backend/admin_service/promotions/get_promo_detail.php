<?php
include __DIR__ . '/../db.php';

$id = $_GET['id'] ?? '';

if (!$id) {
    echo json_encode(["error" => "Thiếu ID khuyến mãi"]);
    exit;
}

$stmt = $conn_admin->prepare("SELECT * FROM PROMOTIONS WHERE PROMO_ID = ?");
$stmt->bind_param("s", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $promo = $result->fetch_assoc();
    echo json_encode($promo, JSON_UNESCAPED_UNICODE);
} else {
    echo json_encode(["error" => "Không tìm thấy khuyến mãi có ID: $id"]);
}

$stmt->close();
$conn_admin->close();
?>
