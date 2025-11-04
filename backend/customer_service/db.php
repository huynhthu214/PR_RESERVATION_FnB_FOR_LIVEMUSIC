<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "customerdb";

$conn_customer = new mysqli($servername, $username, $password, $database);
if ($conn_customer->connect_error) {
    die("Connection failed (customerdb): " . $conn_customer->connect_error);
}
?>
