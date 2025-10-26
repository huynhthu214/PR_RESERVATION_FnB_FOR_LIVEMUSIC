<?php
session_start();

// Xoá toàn bộ session của admin
session_unset();
session_destroy();

// Chuyển hướng về trang đăng nhập
header("Location: login.php");
exit();
?>
