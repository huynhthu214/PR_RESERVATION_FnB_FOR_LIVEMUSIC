<?php
include __DIR__ . '/../db.php';

$id = $_GET['id'] ?? '';

if (!$id) {
    echo json_encode(["error" => "Thiếu ID cms"]);
    exit;
}

$stmt = $conn_admin->prepare("SELECT * FROM CMS_PAGES WHERE PAGE_ID = ?");
$stmt->bind_param("s", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $event = $result->fetch_assoc();
    echo json_encode($event, JSON_UNESCAPED_UNICODE);
} else {
    echo json_encode(["error" => "Không tìm thấy cms có ID: $id"]);
}

$stmt->close();
$conn_admin->close();
?>
