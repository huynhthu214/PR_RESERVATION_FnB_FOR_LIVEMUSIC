<?php
session_start();
header('Content-Type: application/json; charset=UTF-8');

$input = json_decode(file_get_contents('php://input'), true);

if(!$input || !isset($input['item_id'], $input['quantity'])){
    echo json_encode(["success"=>false, "message"=>"Thiếu dữ liệu"]);
    exit;
}

$item_id = $input['item_id'];
$quantity = max(0, intval($input['quantity']));

if(!isset($_SESSION['order_menu'])) $_SESSION['order_menu'] = [];

foreach($_SESSION['order_menu'] as $k => $item){
    if($item['item_id'] === $item_id){
        if($quantity === 0){
            unset($_SESSION['order_menu'][$k]);
        } else {
            $_SESSION['order_menu'][$k]['quantity'] = $quantity;
        }
        break;
    }
}

$_SESSION['order_menu'] = array_values($_SESSION['order_menu']); // reset key

$total = 0;
foreach($_SESSION['order_menu'] as $item) $total += $item['price'] * $item['quantity'];

echo json_encode([
    "success" => true,
    "cart" => $_SESSION['order_menu'],
    "total_amount" => $total,
    "count" => count($_SESSION['order_menu'])
]);
?>
