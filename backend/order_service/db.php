<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "orderdb";

$conn_order = new mysqli($servername, $username, $password, $database);
if ($conn_order->connect_error) {
    die("Connection failed (orderdb): " . $conn_order->connect_error);
}
?>
