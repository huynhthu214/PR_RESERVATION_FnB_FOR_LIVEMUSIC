<?php
include __DIR__ . '/../db.php';

$id = $_GET['id'] ?? '';

if (!$id) {
    echo json_encode(["error" => "Thiếu ID sự kiện"]);
    exit;
}

$sql = "
    SELECT 
        E.EVENT_ID,
        E.EVENT_NAME,
        E.BAND_NAME,
        E.EVENT_DATE,
        E.START_TIME,
        E.END_TIME,
        E.TICKET_PRICE,
        E.STATUS,
        E.DESCRIPTION,
        E.IMAGE_URL,
        V.VENUE_ID,
        V.NAME AS VENUE_NAME
    FROM EVENTS E
    LEFT JOIN VENUES V ON E.VENUE_ID = V.VENUE_ID
    WHERE E.EVENT_ID = ?
";

$stmt = $conn_admin->prepare($sql);
$stmt->bind_param("s", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $event = $result->fetch_assoc();
    echo json_encode($event, JSON_UNESCAPED_UNICODE);
} else {
    echo json_encode(["error" => "Không tìm thấy sự kiện có ID: $id"]);
}

$stmt->close();
$conn_admin->close();
?>
