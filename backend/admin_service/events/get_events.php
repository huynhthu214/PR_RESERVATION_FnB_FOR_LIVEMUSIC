<?php
header('Content-Type: application/json');
require_once __DIR__ . '/../db.php';

// Lấy danh sách sự kiện
$sql = "SELECT 
            E.EVENT_ID,
            E.EVENT_NAME,
            V.NAME AS VENUE_NAME,
            V.ADDRESS AS VENUE_ADDRESS,
            V.CAPACITY AS VENUE_CAPACITY,
            E.BAND_NAME,
            E.ARTIST_NAME,
            E.EVENT_DATE,
            E.START_TIME,
            E.END_TIME,
            E.TICKET_PRICE,
            E.STATUS,
            E.DESCRIPTION,
            COALESCE(E.IMAGE_URL, '') AS IMAGE_URL,
            COALESCE(E.IMG_ARTIST, '') AS IMG_ARTIST
        FROM EVENTS E
        LEFT JOIN VENUES V ON E.VENUE_ID = V.VENUE_ID
        ORDER BY E.EVENT_DATE DESC";

$result = $conn_admin->query($sql);

if(!$result){
    echo json_encode(["success"=>false, "error"=>"Lỗi truy vấn DB"]);
    exit;
}

$events = [];
while($row = $result->fetch_assoc()){
    $events[] = [
        "id" => $row['EVENT_ID'],
        "event_name" => $row['EVENT_NAME'],
        "venue_name" => $row['VENUE_NAME'],
        "venue_address" => $row['VENUE_ADDRESS'],
        "capacity" => $row['VENUE_CAPACITY'],
        "band" => $row['BAND_NAME'],
        "artist_name" => $row['ARTIST_NAME'] ?: $row['BAND_NAME'],
        "date" => $row['EVENT_DATE'],
        "start_time" => $row['START_TIME'],
        "end_time" => $row['END_TIME'],
        "price" => $row['TICKET_PRICE'],
        "status" => $row['STATUS'],
        "description" => $row['DESCRIPTION'],
        "image_url" => $row['IMAGE_URL'] ?: "https://picsum.photos/800/400",
        "img_artist" => $row['IMG_ARTIST'] ?: "https://picsum.photos/200/200?grayscale"
    ];
}

echo json_encode([
    "success" => true,
    "data" => $events
]);
