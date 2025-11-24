<?php
require_once __DIR__ . '/../../config.php';
$customerId = $_SESSION['CUSTOMER_ID'] ?? '';
?>
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
        <h3 class="sidebar-username">...</h3>
        <p class="sidebar-email">...</p>

        <div class="tabs">
            <button class="tab active" onclick="location.href='index.php?page=user_details'">Thông tin cá nhân</button>
            <button class="tab" onclick="location.href='index.php?page=user_orders'">Đơn hàng</button>
            <button class="tab" onclick="location.href='index.php?page=notification'">Thông báo</button>
        </div>
    </aside>

    <section class="content">
        <h2>Thông tin tài khoản</h2>

        <form class="profile-form">
            <div class="form-group">
                <label>Họ và tên</label>
                <input type="text" disabled>
            </div>

            <div class="form-group">
                <label>Email</label>
                <input type="email" disabled>
            </div>

            <div class="form-group">
                <label>Ngày tạo tài khoản</label>
                <input type="text" readonly>
            </div>

            <div class="form-actions">
                <button type="button" class="btn-edit">Chỉnh sửa</button>
                <button type="button" class="btn-save" disabled>Lưu thay đổi</button>
            </div>
        </form>
    </section>
</div>

<script>
const CUSTOMER_ID = "<?php echo $customerId; ?>";
const btnEdit = document.querySelector(".btn-edit");
const btnSave = document.querySelector(".btn-save");
const inputs = document.querySelectorAll(".profile-form input[type=text], .profile-form input[type=email]");

// Load user detail từ API
async function loadUserDetail() {
    if (!CUSTOMER_ID) {
        alert("Không tìm thấy ID người dùng. Vui lòng đăng nhập lại.");
        window.location.href = "login_user.php";
        return;
    }

    try {
        const res = await fetch(`/PR_RESERVATION_FnB_FOR_LIVEMUSIC/api_gateway/index.php?service=customer&action=get_user_detail&id=${CUSTOMER_ID}`);
        const data = await res.json();

        if (data.error) {
            alert("Lỗi tải dữ liệu: " + data.error);
            return;
        }

        // Render sidebar
        document.querySelector(".sidebar-username").textContent = data.USERNAME;
        document.querySelector(".sidebar-email").textContent = data.EMAIL;

        // Render form
        inputs[0].value = data.USERNAME;
        inputs[1].value = data.EMAIL;
        inputs[2].value = data.CREATED_AT;

    } catch (err) {
        console.error(err);
        alert("Lỗi kết nối API Gateway!");
    }
}

loadUserDetail();

// Nút Chỉnh sửa
btnEdit.addEventListener("click", () => {
    inputs.forEach(input => {
        if (!input.hasAttribute('readonly')) input.disabled = false;
    });
    btnSave.disabled = false;
    btnEdit.disabled = true;
});

// Nút Lưu thay đổi
btnSave.addEventListener("click", async () => {
    const USERNAME = inputs[0].value.trim();
    const EMAIL = inputs[1].value.trim();

    if (!USERNAME || !EMAIL) {
        alert("Tên và Email không được để trống.");
        return;
    }

    try {
        const res = await fetch('/PR_RESERVATION_FnB_FOR_LIVEMUSIC/api_gateway/index.php?service=customer&action=update_user', {
            method: 'PUT',
            headers: {'Content-Type': 'application/json'},
            body: JSON.stringify({ CUSTOMER_ID, USERNAME, EMAIL })
        });

        const data = await res.json();

        if (data.success) {
            alert("Cập nhật thành công!");
            // cập nhật sidebar
            document.querySelector(".sidebar-username").textContent = USERNAME;
            document.querySelector(".sidebar-email").textContent = EMAIL;
            // khóa input
            inputs.forEach(input => input.disabled = true);
            btnSave.disabled = true;
            btnEdit.disabled = false;
        } else {
            alert("Lỗi: " + data.message);
        }

    } catch (err) {
        console.error(err);
        alert("Lỗi kết nối server.");
    }
});
</script>
</body>
</html>
