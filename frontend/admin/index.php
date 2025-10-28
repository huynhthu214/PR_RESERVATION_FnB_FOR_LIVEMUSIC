<?php
session_start(); // BẮT BUỘC phải có để đọc session

// Kiểm tra đăng nhập
if (!isset($_SESSION['ADMIN_ID']) || empty($_SESSION['ADMIN_ID'])) {
    header("Location: pages/login.php");
    exit();
}

// Xác định trang đang hiển thị
$page = $_GET['page'] ?? 'dashboard';
$namePage = ucfirst($page);

// Include header
require_once __DIR__ . '/../../includes/header_admin.php';
?>

<div class="main-container">
    <?php require_once __DIR__ . '/../../includes/sidebar_admin.php'; ?>

    <main class="main-content">
        <?php
        // Kiểm tra file trang con có tồn tại không
        $file = __DIR__ . "/pages/$page.php";
        if (file_exists($file)) {
            include $file;
        } else {
            echo "<div class='alert alert-warning'>";
            echo "<h4>Trang không tồn tại!</h4>";
            echo "<p>Không tìm thấy trang <strong>$page</strong>.</p>";
            echo "<a href='?page=dashboard' class='btn btn-primary'>Về trang chủ</a>";
            echo "</div>";
        }
        ?>
    </main>
</div>

<?php require_once __DIR__ . '/../../includes/footer_admin.php'; ?>
