
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Thông tin người dùng</title>
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/user_details.css">
</head>
<body>

<div class="container">

   <aside class="user-sidebar">
        <img src="https://images.unsplash.com/photo-1535713875002-d1d0cf377fde?w=200" alt="Avatar">
        <h3><?php echo htmlspecialchars($username); ?></h3>
        <p><?php echo htmlspecialchars($email); ?></p>

        <div class="tabs">
            <button class="tab active" onclick="location.href='index.php?page=user_details'">Thông tin cá nhân</button>
            <button class="tab" onclick="location.href='index.php?page=tickets'">Vé của tôi</button>
            <button class="tab" onclick="location.href='index.php?page=user_orders'">Đơn hàng</button>
            <button class="tab" onclick="location.href='index.php?page=notification'">Thông báo</button>
        </div>

    </aside>

    <section class="content">
        <h2>Thông tin tài khoản</h2>

        <form class="profile-form">

            <div class="form-group">
                <label>Họ và tên</label>
                <input type="text" value="<?php echo htmlspecialchars($username); ?>">
            </div>

            <div class="form-group">
                <label>Email</label>
                <input type="email" value="<?php echo htmlspecialchars($email); ?>">
            </div>

            <div class="form-group">
                <label>Ngày tạo tài khoản</label>
                <input type="text" value="<?php echo htmlspecialchars($created_at); ?>" readonly>
            </div>

            <div class="form-actions">
                <button type="button" class="btn-edit">Chỉnh sửa</button>
                <button class="btn-save">Lưu thay đổi</button>
            </div>

        </form>
    </section>
</div>

</body>
</html>

<script>
const CUSTOMER_ID = "<?php echo $_SESSION['CUSTOMER_ID']; ?>";

async function loadUserDetail() {

    if (!CUSTOMER_ID) {
        alert("Không tìm thấy ID người dùng. Vui lòng đăng nhập lại.");
        window.location.href = "login_user.php";
        return;
    }

    try {
        const res = await fetch(
            `/PR_RESERVATION_FnB_FOR_LIVEMUSIC/api_gateway/index.php?service=customer&action=get_user_detail&id=${CUSTOMER_ID}`
        );

        const data = await res.json();

        if (data.error) {
            alert("Lỗi tải dữ liệu: " + data.error);
            return;
        }

        // Render user info
        document.querySelector(".user-sidebar h3").textContent = data.USERNAME;
        document.querySelector(".user-sidebar p").textContent = data.EMAIL;

        document.querySelector(".profile-form input[type=text]").value = data.USERNAME;
        document.querySelector(".profile-form input[type=email]").value = data.EMAIL;
        document.querySelector(".profile-form input[readonly]").value = data.CREATED_AT;

    } catch (err) {
        console.error("Error:", err);
        alert("Lỗi kết nối API Gateway!");
    }
}

loadUserDetail();
</script>
