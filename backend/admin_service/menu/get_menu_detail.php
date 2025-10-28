<?php
include __DIR__ . '/../db.php';

$id = $_GET['id'] ?? '';

if (!$id) {
    echo json_encode(["error" => "Thiếu ID món ăn"]);
    exit;
}

$stmt = $conn->prepare("SELECT * FROM MENU_ITEMS WHERE ITEM_ID = ?");
$stmt->bind_param("s", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $item = $result->fetch_assoc();
    echo json_encode($item, JSON_UNESCAPED_UNICODE);
} else {
    echo json_encode(["error" => "Không tìm thấy món ăn có ID: $id"]);
}

$stmt->close();
$conn->close();
?>
