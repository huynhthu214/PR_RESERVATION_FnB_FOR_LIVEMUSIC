<?php
session_start();
$data = json_decode(file_get_contents('php://input'), true);
if(isset($data['order_menu'])) $_SESSION['order_menu'] = $data['order_menu'];
echo json_encode(['success'=>true]);
