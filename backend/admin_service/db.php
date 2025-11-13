<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "admindb";

$conn = new mysqli($servername, $username, $password, $database);
if ($conn->connect_error) {
    die("Connection failed (admindb): " . $conn->connect_error);
}
?>
