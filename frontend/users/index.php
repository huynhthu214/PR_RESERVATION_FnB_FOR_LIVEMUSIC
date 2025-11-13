<?php
session_start();

// Kiểm tra đăng nhập
if (!isset($_SESSION['CUSTOMER_ID']) || empty($_SESSION['CUSTOMER_ID'])) {
    header("Location: pages/login_user.php");
    exit();
}
// Lấy trang hiện tại, mặc định là home
$page = $_GET['page'] ?? 'home';
$namePage = ucfirst($page);
?>
<div class="main-container">
    <!-- Gọi header + sidebar -->
    <?php require_once __DIR__ . '/../../includes/navbar_user.php'; ?>

    <main class="main-content">
        <?php
        $page = str_replace('.php', '', $page);
        $file = __DIR__ . "/pages/{$page}.php";
        if (file_exists($file)) {
            include $file;
        } else {
            echo "<div class='alert alert-warning'>
                    <h4>Trang không tồn tại!</h4>
                    <p>Không tìm thấy trang <strong>$page</strong>.</p>
                    <a href='?page=home' class='btn btn-primary'>Về trang chủ</a>
                  </div>";
        }
        ?>
    </main>
</div>
<?php require_once __DIR__ . '/../../includes/footer_user.php'; ?>
