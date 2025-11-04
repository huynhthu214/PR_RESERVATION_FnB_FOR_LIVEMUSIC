<?php
$host = "localhost";
$user = "root";   // hoặc user MySQL bạn đã tạo
$pass = "";       // password MySQL
$db   = "notificationdb"; // database của user_service

$conn_noti = new mysqli($host, $user, $pass, $db);

if ($conn_noti->connect_error) {
    die("Kết nối thất bại: " . $conn_noti->connect_error);
}
?>
