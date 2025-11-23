<?php
session_start();
header('Content-Type: application/json');
$data = json_decode(file_get_contents('php://input'), true);
if(!isset($data['item_id'])) { echo json_encode(['success'=>false]); exit; }

if(!isset($_SESSION['order_menu'])) $_SESSION['order_menu'] = [];
foreach($_SESSION['order_menu'] as $k=>$item){
    if($item['item_id']==$data['item_id']){
        if(isset($data['delete']) && $data['delete']) {
            unset($_SESSION['order_menu'][$k]);
        } elseif(isset($data['quantity'])) {
            $_SESSION['order_menu'][$k]['quantity'] = $data['quantity'];
        }
        break;
    }
}
$_SESSION['order_menu'] = array_values($_SESSION['order_menu']);
echo json_encode(['success'=>true]);
