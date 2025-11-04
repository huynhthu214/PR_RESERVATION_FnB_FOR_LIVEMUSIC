<?php
include __DIR__ . '/../db.php';

$id = $_GET['id'] ?? '';

if (!$id) {
    echo json_encode(["error" => "Thiếu ID địa điểm"]);
    exit;
}

$stmt = $conn_admin->prepare("SELECT * FROM VENUES WHERE VENUE_ID = ?");
$stmt->bind_param("s", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $venue = $result->fetch_assoc();
    echo json_encode($venue, JSON_UNESCAPED_UNICODE);
} else {
    echo json_encode(["error" => "Không tìm thấy địa điểm có ID: $id"]);
}

$stmt->close();
$conn_admin->close();
?>
