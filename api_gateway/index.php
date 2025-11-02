<?php
header("Content-Type: application/json; charset=UTF-8");

$backendPath = __DIR__ . '/../backend/';
$service = $_GET['service'] ?? '';
$action  = $_GET['action'] ?? '';

if (empty($service) || empty($action)) {
    echo json_encode(["error" => "Thiếu tham số service hoặc action"]);
    exit;
}


// /* ====== HELPER: JSON RESPONSE ====== */
// function jsonResponse($success, $data)
// {
//     echo json_encode(["success" => $success, "data" => $data]);
//     exit;
// }

// /* ====== MIDDLEWARE: CHECK ROLE ====== */
// function checkRole(array $allowed_roles)
// {
//     if (!isset($_SESSION['ROLE'])) {
//         jsonResponse(false, "Bạn chưa đăng nhập.");
//     }
//     if (!in_array($_SESSION['ROLE'], $allowed_roles)) {
//         jsonResponse(false, "Bạn không có quyền truy cập chức năng này.");
//     }
// }

// /* ====== MIDDLEWARE: CHECK OWNERSHIP ====== */
// function checkOwnership($conn, $event_id)
// {
//     if ($_SESSION['ROLE'] === 'Admin') return;
//     $admin_id = $_SESSION['ADMIN_ID'];
//     $stmt = $conn->prepare("SELECT ADMIN_ID FROM EVENTS WHERE EVENT_ID = ?");
//     $stmt->bind_param("s", $event_id);
//     $stmt->execute();
//     $result = $stmt->get_result()->fetch_assoc();
//     if (!$result || $result['ADMIN_ID'] !== $admin_id) {
//         jsonResponse(false, "Bạn không có quyền truy cập sự kiện này.");
//     }
// }

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
    $path_promo = $base . "admin_service/promotions/";
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

        case 'get_venues':
            include_once $path_venue . "get_venues.php";
            break;

        case 'get_promotions':
            include_once $path_promo . "get_promotions.php";
            break;
            
        case 'export_dashboard':
            include_once $path_dash . "export_dashboard.php";
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

        default:
            echo json_encode(["error" => "Hành động không hợp lệ trong admin_service"]);
            break;
    }
}

/* -------------------- ORDER SERVICE -------------------- */
function routeOrderService($action, $base)
{
    $path = $base . "order_service/order";
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
