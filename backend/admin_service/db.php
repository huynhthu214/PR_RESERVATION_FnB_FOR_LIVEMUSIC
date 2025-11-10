<?php
$host = "localhost";
$user = "root"; 
$pass = "";     
$db   = "admindb";

$conn_admin = new mysqli($host, $user, $pass, $db);

if ($conn_admin->connect_error) {
    die("Kết nối thất bại: " . $conn_admin->connect_error);
}
?>
