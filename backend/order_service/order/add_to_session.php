<?php
session_start();
header('Content-Type: application/json; charset=UTF-8');

// Lấy dữ liệu JSON từ body
$input = json_decode(file_get_contents('php://input'), true);

if(!$input || !isset($input['item_id'], $input['name'], $input['price'], $input['quantity'])){
    echo json_encode(["success"=>false, "message"=>"Thiếu dữ liệu món hàng"]);
    exit;
}

$item_id = $input['item_id'];
$name    = $input['name'];
$price   = intval($input['price']);
$quantity= intval($input['quantity']);

if(!isset($_SESSION['order_menu'])) $_SESSION['order_menu'] = [];

// Kiểm tra xem món đã có trong giỏ chưa
$found = false;
foreach($_SESSION['order_menu'] as &$item){
    if($item['item_id'] === $item_id){
        $item['quantity'] += $quantity;
        $found = true;
        break;
    }
}
unset($item);

if(!$found){
    $_SESSION['order_menu'][] = [
        "item_id"  => $item_id,
        "name"     => $name,
        "price"    => $price,
        "quantity" => $quantity
    ];
}

// Tính tổng tiền
$total = 0;
foreach($_SESSION['order_menu'] as $item) $total += $item['price'] * $item['quantity'];

echo json_encode([
    "success" => true,
    "message" => "Đã thêm món vào giỏ",
    "cart" => array_values($_SESSION['order_menu']),
    "total_amount" => $total,
    "count" => count($_SESSION['order_menu'])
]);
?>
