<?php
header('Content-Type: application/json; charset=UTF-8');
session_start();

$cart = $_SESSION['order_menu'] ?? [];

$count = 0;
$total_amount = 0;

foreach($cart as $item){
    $count += $item['quantity'];
    $total_amount += $item['price'] * $item['quantity'];
}

echo json_encode([
    "success" => true,
    "count"   => $count,
    "total_amount" => $total_amount,
    "cart"    => $cart
]);
