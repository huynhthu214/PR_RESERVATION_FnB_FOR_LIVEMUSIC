<?php
header("Content-Type: application/json; charset=UTF-8");

$backendPath = __DIR__ . '/../backend/';
$service = $_GET['service'] ?? '';
$action  = $_GET['action'] ?? '';

if (empty($service) || empty($action)) {
    echo json_encode(["error" => "Thiếu tham số service hoặc action"]);
    exit;
}

/* ====== ROUTER CHÍNH ====== */
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

    $path_menu = $base . "admin_service/menu/";
    $path_dash = $base . "admin_service/dashboard/";
    $path_event = $base . "admin_service/events/";
    $path_venue = $base . "admin_service/venues/";
    $path_cms = $base . "admin_service/cms/";
    
    switch ($action) {
        case 'get_menu_items':
            include_once $path_menu . "get_menu.php";
            break;

        case 'add_menu_item':
            include_once $path_menu . "add_menu_item.php";
            break;

        case 'update_menu_item':
            include_once $path_menu . "update_menu.php";
            break;

        case 'delete_menu_item':
            include_once $path_menu . "delete_menu.php";
            break;

        case 'get_menu_detail':
            include_once $path_menu . "get_menu_detail.php";
            break;

        case 'get_dashboard_data':
            include_once $path_dash . "get_dashboard_data.php";
            break;

        case 'get_events':
            include_once $path_event . "get_events.php";
            break;

        case 'update_event':
            include_once $path_event . "update_event.php";
            break;

        case 'get_event_detail':
            include_once $path_event . "get_event_detail.php";
            break;

        case 'add_event':
            include_once $path_event . "add_event.php";
            break;

        case 'delete_event':
            include_once $path_event . "delete_event.php";
            break;

        case 'get_venues':
            include_once $path_venue . "get_venues.php";
            break;
    
        case 'add_venue':
            include_once $path_venue . "add_venue.php";
            break;

        case 'update_venue':
            include_once $path_venue. "update_venue.php";
            break;

        case 'delete_venue':
            include_once $path_venue . "delete_venue.php";
            break;
        
        case 'get_venue_detail':
            include_once $path_venue . "get_venue_detail.php";
            break;
            
        case 'export_dashboard':
            include_once $path_dash . "export_dashboard.php";
            break;

        case 'get_cms':
            include_once $path_cms . "get_cms.php";
            break;
            
        case 'add_cms':
            include_once $path_cms . "add_cms.php";
            break;

        case 'delete_cms':
            include_once $path_cms . "delete_cms.php";
            break;

        case 'get_cms_detail':
            include_once $path_cms . "get_cms_detail.php";
            break;
    
        case 'update_cms':
            include_once $path_cms . "update_cms.php";
            break;
    
        default:
            echo json_encode(["error" => "Hành động không hợp lệ trong admin_service"]);
            break;
    }
}


/* -------------------- CUSTOMER SERVICE -------------------- */
function routeCustomerService($action, $base)
{
    if ($action === 'login') {
    include_once $base . "customer_service/index.php"; 
    return;
    }
    $path_user = $base . "customer_service/user/";
    switch ($action) {
        case 'get_user':
            include_once $path_user . "get_user.php";
            break;

        case 'add_user':
            include_once $path_user . "add_user.php";
            break;

        case 'update_user':
            include_once $path_user . "update_user.php";
            break;

        case 'delete_user':
            include_once $path_user . "delete_user.php";
            break;

        case 'get_user_detail':
            include_once $path_user . "get_user_detail.php";
            break;

        case 'send_otp':
            include_once $base . "customer_service/send_otp.php";
            break;

        case 'verify_otp':
            include_once $base . "customer_service/verify_otp.php";
            break;

        case 'reset_pwd':
            include_once $base . "customer_service/reset_pwd.php";
        break;

        default:
            echo json_encode(["error" => "Hành động không hợp lệ trong customer_service"]);
            break;
    }
}

/* -------------------- ORDER SERVICE -------------------- */
function routeOrderService($action, $base)
{
    $path = $base . "order_service/order/";
    switch ($action) {
        case 'get_order':
            include_once $path . "get_order.php";
            break;

        case 'add_order':
            include_once $path . "add_order.php";
            break;

        case 'update_order':
            include_once $path . "update_order.php";
            break;

        case 'delete_order':
            include_once $path . "delete_order.php";
            break;

        case 'get_order_detail':
            include_once $path . "get_order_detail.php";
            break;

        case 'get_customer_order':
            include_once $path . "get_customer_order.php";
            break;

        case 'get_cart_count': 
            include_once $path . "get_cart_count.php";
            break;
            
        case 'add_to_session':
            include_once $path . "add_to_session.php";
            break;

        case 'update_cart_item':
            include_once $path . "update_cart_item.php";
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

        case 'get_seat_layout':
            include_once $path . "get_seat_layout.php";
            break;
        default:
            echo json_encode(["error" => "Hành động không hợp lệ trong reservation_service"]);
            break;
    }
}

/* -------------------- NOTIFICATION SERVICE -------------------- */
function routeNotificationService($action, $base)
{
    $path = $base . "notification_service/notification/";
    switch ($action) {
        case 'get_notifications':
            include_once $path . "get_notification.php";
            break;
        case 'get_notification_detail':
            include_once $path . "get_notification_detail.php";
            break;
        case 'mark_as_read':
            include_once $path . "mark_as_read.php";
            break; 
        default:
            echo json_encode(["error" => "Hành động không hợp lệ trong notification_service"]);
            break;
    }
}
?>
