<link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/user.css">

<main class="main-content user-page">
    <section class="section-header">
        <h2>Người dùng</h2>
        <button class="btn-add" onclick="window.location.href='index.php?page=add_user'">
            + Thêm người dùng
        </button>
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
            <tbody id="user-body">
                <tr><td colspan="5" style="text-align:center;">Đang tải dữ liệu...</td></tr>
            </tbody>
        </table>
    </section>
</main>

<!-- Toast container -->
<div id="toast-container"></div>

<!-- Modal chỉnh sửa người dùng -->
<div id="editModal" class="modal">
  <div class="modal-content">
    <span class="close" onclick="closeModal()">&times;</span>
    <h3>Chỉnh sửa người dùng</h3>
    <form id="editForm">
      <input type="hidden" id="editCustomerId">

      <label for="editUsername">Tên người dùng:</label>
      <input type="text" id="editUsername" required>

      <label for="editEmail">Email:</label>
      <input type="email" id="editEmail" required>

      <label for="editPassword">Mật khẩu mới (nếu muốn thay đổi):</label>
      <input type="password" id="editPassword" placeholder="Để trống nếu không đổi">

      <button type="submit">Lưu thay đổi</button>
    </form>
  </div>
</div>

<!-- Modal xác nhận xóa -->
<div id="deleteModal" class="modal">
  <div class="modal-content">
    <h3>Xác nhận xóa</h3>
    <p>Bạn có chắc muốn xóa người dùng này?</p>
    <div style="text-align:right; margin-top: 15px;">
      <button id="cancelDelete" class="btn">Hủy</button>
      <button id="confirmDelete" class="btn btn-delete">Xóa</button>
    </div>
  </div>
</div>

<script>
// ================== LOAD DANH SÁCH NGƯỜI DÙNG ==================
document.addEventListener("DOMContentLoaded", function() {
    loadUsers();
});

function loadUsers() {
    fetch('http://localhost/PR_RESERVATION_FnB_FOR_LIVEMUSIC/api_gateway/index.php?service=customer&action=get_user')
        .then(res => res.json())
        .then(data => {
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

// ================== TOAST THÔNG BÁO ==================
function showToast(message, type = 'info', duration = 3000){
    const container = document.getElementById('toast-container');
    const toast = document.createElement('div');
    toast.className = 'toast ' + type;
    toast.textContent = message;

    const closeBtn = document.createElement('span');
    closeBtn.className = 'close-toast';
    closeBtn.innerHTML = '&times;';
    closeBtn.onclick = () => {
        toast.classList.remove('show');
        setTimeout(() => container.removeChild(toast), 300);
    };
    toast.appendChild(closeBtn);

    container.appendChild(toast);
    setTimeout(() => toast.classList.add('show'), 50);

    setTimeout(() => {
        toast.classList.remove('show');
        setTimeout(() => {
            if(container.contains(toast)) container.removeChild(toast);
        }, 300);
    }, duration);
}

// ================== CHỈNH SỬA NGƯỜI DÙNG ==================
let selectedCustomerId = null;

function editUser(id) {
    selectedCustomerId = id;
    fetch(`http://localhost/PR_RESERVATION_FnB_FOR_LIVEMUSIC/api_gateway/index.php?service=customer&action=get_user_detail&id=${id}`)
        .then(res => res.json())
        .then(user => {
            if(user.error){
                showToast(user.error, 'error');
                return;
            }
            document.getElementById('editCustomerId').value = user.CUSTOMER_ID;
            document.getElementById('editUsername').value = user.USERNAME;
            document.getElementById('editEmail').value = user.EMAIL;
            document.getElementById('editPassword').value = '';
            document.getElementById('editModal').style.display = 'flex';
        })
        .catch(err => {
            console.error(err);
            showToast('Không thể tải thông tin người dùng', 'error');
        });
}

function closeModal() {
    document.getElementById('editModal').style.display = 'none';
}

document.getElementById('editForm').addEventListener('submit', function(e){
    e.preventDefault();

    const data = {
        CUSTOMER_ID: document.getElementById('editCustomerId').value,
        USERNAME: document.getElementById('editUsername').value,
        EMAIL: document.getElementById('editEmail').value,
        PASSWORD: document.getElementById('editPassword').value
    };

    fetch('http://localhost/PR_RESERVATION_FnB_FOR_LIVEMUSIC/api_gateway/index.php?service=customer&action=update_user', {
        method: 'PUT',
        headers: {'Content-Type': 'application/json'},
        body: JSON.stringify(data)
    })
    .then(res => res.json())
    .then(result => {
        if(result.success){
            showToast('Cập nhật người dùng thành công!', 'success');
            closeModal();
            loadUsers();
        } else {
            showToast(result.message || 'Cập nhật thất bại', 'error');
        }
    })
    .catch(err => {
        console.error(err);
        showToast('Không thể kết nối server', 'error');
    });
});

// ================== XÓA NGƯỜI DÙNG ==================
let deleteUserId = null;

function deleteUser(id){
    deleteUserId = id;
    document.getElementById('deleteModal').style.display = 'flex';
}

document.getElementById('cancelDelete').addEventListener('click', function(){
    document.getElementById('deleteModal').style.display = 'none';
});

document.getElementById('confirmDelete').addEventListener('click', function(){
    document.getElementById('deleteModal').style.display = 'none';
    if(!deleteUserId) return;

    fetch(`http://localhost/PR_RESERVATION_FnB_FOR_LIVEMUSIC/api_gateway/index.php?service=customer&action=delete_user&id=${deleteUserId}`, {
        method: 'DELETE'
    })
    .then(res => res.json())
    .then(result => {
        showToast(result.success ? "Xóa người dùng thành công!" : "Xóa thất bại!", result.success ? "success" : "error");
        loadUsers();
    })
    .catch(err => {
        console.error(err);
        showToast('Không thể kết nối server', 'error');
    });
});
</script>
