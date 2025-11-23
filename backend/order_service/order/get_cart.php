<?php
session_start();
header('Content-Type: application/json; charset=UTF-8');

if(!isset($_SESSION['order_menu'])) $_SESSION['order_menu'] = [];

$total = 0;
foreach($_SESSION['order_menu'] as $item) $total += $item['price'] * $item['quantity'];

echo json_encode([
    "success" => true,
    "cart" => array_values($_SESSION['order_menu']),
    "total_amount" => $total,
    "count" => count($_SESSION['order_menu'])
]);
?>
