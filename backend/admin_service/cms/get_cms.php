<?php
header('Content-Type: application/json');
require_once __DIR__ . '/../db.php';

session_start();

$sql = "SELECT PAGE_ID, ADMIN_ID, TYPE, TITLE, CONTENT, UPDATED_AT 
        FROM CMS_PAGES
        ORDER BY UPDATED_AT DESC";

$result = $conn_admin->query($sql);
$pages = [];

while ($row = $result->fetch_assoc()) {
    $pages[] = [
        "PAGE_ID"        => $row['PAGE_ID'],
        "ADMIN_ID"     => $row['ADMIN_ID'],
        "TYPE"      => $row['TYPE'],
        "TITLE"     => $row['TITLE'],
        "CONTENT"   => $row['CONTENT'],
        "UPDATED_AT"   => $row['UPDATED_AT']
    ];
}

echo json_encode(["success" => true, "data" => $pages]);
