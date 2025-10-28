<?php
header("Content-Type: application/json; charset=UTF-8");

$backendPath = __DIR__ . '/../backend/';
$service = $_GET['service'] ?? '';
$action  = $_GET['action'] ?? '';

if (empty($service) || empty($action)) {
    echo json_encode(["error" => "Thiếu tham số service hoặc action"]);
    exit;
}

switch ($service) {
    case 'admin':
        routeAdminService($action, $backendPath);
        break;

    case 'customer':
        routeCustomerService($action, $backendPath);
        break;

    case 'order':
        routeOrderService($action, $backendPath);
        break;

    case 'reservation':
        routeReservationService($action, $backendPath);
        break;

    case 'notification':
        routeNotificationService($action, $backendPath);
        break;

    default:
        echo json_encode(["error" => "Service không hợp lệ"]);
        break;
}

/* -------------------- ADMIN SERVICE -------------------- */
function routeAdminService($action, $base)
{
    if ($action === 'login') {
    include_once $base . "admin_service/index.php"; 
    return;
    }
    $path = $base . "admin_service/menu/";

    switch ($action) {
        case 'get_menu_items':
            include_once $path . "get_menu.php";
            break;

        case 'add_menu_item':
            include_once $path . "add_menu.php";
            break;

        case 'update_menu_item':
            include_once $path . "update_menu.php";
            break;

        case 'delete_menu_item':
            include_once $path . "delete_menu.php";
            break;

        case 'get_menu_detail':
            include_once $path . "get_menu_detail.php";
            break;

        default:
            echo json_encode(["error" => "Hành động không hợp lệ trong admin_service"]);
            break;
    }
}


/* -------------------- CUSTOMER SERVICE -------------------- */
function routeCustomerService($action, $base)
{
    $path = $base . "customer_service/";
    switch ($action) {
        case 'get_customers':
            include_once $path . "get_customers.php";
            break;
        case 'add_customer':
            include_once $path . "add_customer.php";
            break;
        default:
            echo json_encode(["error" => "Hành động không hợp lệ trong customer_service"]);
            break;
    }
}

/* -------------------- ORDER SERVICE -------------------- */
function routeOrderService($action, $base)
{
    $path = $base . "order_service/";
    switch ($action) {
        case 'get_orders':
            include_once $path . "get_orders.php";
            break;
        case 'add_order':
            include_once $path . "add_order.php";
            break;
        default:
            echo json_encode(["error" => "Hành động không hợp lệ trong order_service"]);
            break;
    }
}

/* -------------------- RESERVATION SERVICE -------------------- */
function routeReservationService($action, $base)
{
    $path = $base . "reservation_service/";
    switch ($action) {
        case 'get_reservations':
            include_once $path . "get_reservations.php";
            break;
        case 'add_reservation':
            include_once $path . "add_reservation.php";
            break;
        default:
            echo json_encode(["error" => "Hành động không hợp lệ trong reservation_service"]);
            break;
    }
}

/* -------------------- NOTIFICATION SERVICE -------------------- */
function routeNotificationService($action, $base)
{
    $path = $base . "notification_service/";
    switch ($action) {
        case 'get_notifications':
            include_once $path . "get_notifications.php";
            break;
        case 'add_notification':
            include_once $path . "add_notification.php";
            break;
        default:
            echo json_encode(["error" => "Hành động không hợp lệ trong notification_service"]);
            break;
    }
}
?>
