<?php 
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once __DIR__ . '/../db.php';

$sql = "SELECT ITEM_ID, NAME, CATEGORY, DESCRIPTION, PRICE, IS_AVAILABLE FROM MENU_ITEMS";
$result = $conn_admin->query($sql);

$menuItems = [];

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $menuItems[] = [
            "ITEM_ID" => $row["ITEM_ID"],
            "NAME" => $row["NAME"],
            "CATEGORY" => $row["CATEGORY"],
            "DESCRIPTION" => $row["DESCRIPTION"], 
            "PRICE" => floatval($row["PRICE"]),  
            "IS_AVAILABLE" => $row["IS_AVAILABLE"] ? true : false
        ];
    }
    echo json_encode($menuItems);
} else {
    echo json_encode([]);
}

$conn_admin->close();
?>
