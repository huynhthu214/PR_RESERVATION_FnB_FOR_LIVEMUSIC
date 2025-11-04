<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "admindb";

$conn_admin = new mysqli($servername, $username, $password, $database);
if ($conn_admin->connect_error) {
    die("Connection failed (admindb): " . $conn_admin->connect_error);
}
?>
