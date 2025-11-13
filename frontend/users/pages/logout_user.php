<?php
session_start();
require_once __DIR__ . '/../../config.php'; // đường dẫn ra tới file config trong frontend

// Xóa toàn bộ session
session_unset();
session_destroy();

// Chuyển hướng thẳng về trang login user
header("Location: " . BASE_URL . "users/pages/login_user.php");
exit();
?>
