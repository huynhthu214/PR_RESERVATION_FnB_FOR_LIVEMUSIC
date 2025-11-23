<?php
$host = "localhost";
$user = "root";  
$pass = "";     
$db   = "notificationdb"; 

$conn_noti = new mysqli($host, $user, $pass, $db);

if ($conn_noti->connect_error) {
    die("Kết nối thất bại: " . $conn_noti->connect_error);
}
?>
