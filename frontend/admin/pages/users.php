<main class="main-content user-page">
    <section class="section-header">
        <h2>Người dùng</h2>
        <button class="btn-add">+ Thêm người dùng</button>
    </section>

    <section class="table-section">
        <table class="data-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tên người dùng</th>
                    <th>Email</th>
                    <th>Ngày tạo</th>
                    <th>Thao tác</th>
                </tr>
            </thead>
            <tbody id="user-body"></tbody>
        </table>
    </section>
</main>

<script>
document.addEventListener("DOMContentLoaded", function() {
    loadUsers();
});

function loadUsers() {
    fetch('http://localhost/PR_RESERVATION_FnB_FOR_LIVEMUSIC/api_gateway/index.php?service=customer&action=get_user')
        .then(res => res.json())
        .then(data => {
            console.log("Users:", data);
            let html = '';

            if (Array.isArray(data) && data.length > 0) {
                data.forEach(user => {
                    html += `
                        <tr>
                            <td>${user.CUSTOMER_ID}</td>
                            <td>${user.USERNAME}</td>
                            <td>${user.EMAIL}</td>
                            <td>${user.CREATED_AT}</td>
                            <td>
                                <button class="btn-edit" onclick="editUser('${user.CUSTOMER_ID}')">Sửa</button>
                                <button class="btn-delete" onclick="deleteUser('${user.CUSTOMER_ID}')">Xóa</button>
                            </td>
                        </tr>
                    `;
                });
            } else {
                html = `<tr><td colspan="5" style="text-align:center;">Không có dữ liệu</td></tr>`;
            }

            document.getElementById('user-body').innerHTML = html;
        })
        .catch(error => {
            console.error('Lỗi khi tải dữ liệu:', error);
            document.getElementById('user-body').innerHTML =
                '<tr><td colspan="5" style="text-align:center;">Lỗi tải dữ liệu</td></tr>';
        });
}
</script>