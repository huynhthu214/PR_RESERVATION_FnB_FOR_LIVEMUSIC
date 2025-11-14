<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, OPTIONS"); // dùng POST để upload file
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json; charset=UTF-8");

include(__DIR__ . '/../db.php'); // điều chỉnh đường dẫn nếu cần

$PAGE_ID = $_POST['PAGE_ID'] ?? '';
$ADMIN_ID = $conn_admin->real_escape_string($_POST['ADMIN_ID'] ?? '');
$TYPE = $conn_admin->real_escape_string($_POST['TYPE'] ?? '');
$TITLE = $conn_admin->real_escape_string($_POST['TITLE'] ?? '');
$CONTENT = $conn_admin->real_escape_string($_POST['CONTENT'] ?? '');

if (!$PAGE_ID) {
    echo json_encode(["success" => false, "message" => "Thiếu PAGE_ID"]);
    exit;
}

// Xử lý file nếu có
if (isset($_FILES['CONTENT_FILE']) && $_FILES['CONTENT_FILE']['error'] === 0) {
    $allowedExt = ['txt','html'];
    $ext = strtolower(pathinfo($_FILES['CONTENT_FILE']['name'], PATHINFO_EXTENSION));

    if (!in_array($ext, $allowedExt)) {
        echo json_encode(["success" => false, "message" => "File không hợp lệ"]);
        exit;
    }

    $uploadDir = __DIR__ . '/cms/content/';
    if (!file_exists($uploadDir)) mkdir($uploadDir, 0755, true);

    $fileName = uniqid('cms_') . '_' . basename($_FILES['CONTENT_FILE']['name']);
    $targetFile = $uploadDir . $fileName;

    if (!move_uploaded_file($_FILES['CONTENT_FILE']['tmp_name'], $targetFile)) {
        echo json_encode(["success" => false, "message" => "Không thể upload file"]);
        exit;
    }

    // Lưu đường dẫn tương đối vào DB
    $CONTENT = $conn_admin->real_escape_string('backend/admin_service/cms/content/' . $fileName);
}

// Cập nhật DB
$UPDATED_AT = date("Y-m-d H:i:s");
$sql = "UPDATE CMS_PAGES
        SET ADMIN_ID='$ADMIN_ID',
            TYPE='$TYPE',
            TITLE='$TITLE',
            CONTENT='$CONTENT',
            UPDATED_AT='$UPDATED_AT'
        WHERE PAGE_ID='$PAGE_ID'";

if ($conn_admin->query($sql)) {
    echo json_encode(["success" => true, "message" => "Cập nhật CMS thành công"]);
} else {
    echo json_encode(["success" => false, "message" => "Lỗi SQL: " . $conn_admin->error]);
}

$conn_admin->close();
?>
