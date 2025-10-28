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
    switch ($action) {
        case 'get_menu_items':
            include_once $path_menu . "get_menu.php";
            break;

        case 'add_menu_item':
            include_once $path_menu . "add_menu.php";
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
