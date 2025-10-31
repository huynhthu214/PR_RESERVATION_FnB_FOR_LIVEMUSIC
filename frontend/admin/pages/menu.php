<link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/menu.css">

<main class="main-content menu-page">
    <section class="section-header">
        <h2>Thực đơn</h2>
        <button class="btn-add" onclick="window.location.href='index.php?page=add_menu'">
            + Thêm món
        </button>
    </section>

    <section class="table-section">
        <table class="data-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tên món</th>
                    <th>Loại</th>
                    <th>Mô tả</th>
                    <th>Giá (VNĐ)</th>
                    <th>Trạng thái</th>
                    <th>Thao tác</th>
                </tr>
            </thead>
            <tbody id="menu-body">
                <tr><td colspan="7" style="text-align:center;">Đang tải dữ liệu...</td></tr>
            </tbody>
        </table>
    </section>
</main>

<!-- Toast container -->
<div id="toast-container"></div>

<!-- Modal chỉnh sửa món ăn -->
<div id="editModal" class="modal">
  <div class="modal-content">
    <span class="close" onclick="closeModal()">&times;</span>
    <h3>Chỉnh sửa món ăn</h3>
    <form id="editForm">
      <input type="hidden" id="editItemId">

      <label for="editName">Tên món:</label>
      <input type="text" id="editName" required>

      <label for="editCategory">Danh mục:</label>
      <input type="text" id="editCategory">

      <label for="editDescription">Mô tả:</label>
      <textarea id="editDescription" rows="3"></textarea>

      <label for="editPrice">Giá (VNĐ):</label>
      <div class="price-input">
        <input type="text" id="editPrice" required>
        <span class="currency-label">VNĐ</span>
      </div>

      <label for="editQuantity">Số lượng tồn:</label>
      <input type="number" id="editQuantity">

      <label for="editAvailable">Trạng thái:</label>
      <select id="editAvailable">
        <option value="1">Còn bán</option>
        <option value="0">Ngừng bán</option>
      </select>

      <button type="submit">Lưu thay đổi</button>
    </form>
  </div>
</div>

<!-- Modal xác nhận xóa -->
<div id="deleteModal" class="modal">
  <div class="modal-content">
    <h3>Xác nhận xóa</h3>
    <p>Bạn có chắc muốn xóa món này?</p>
    <div style="text-align:right; margin-top: 15px;">
      <button id="cancelDelete" class="btn">Hủy</button>
      <button id="confirmDelete" class="btn btn-delete">Xóa</button>
    </div>
  </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function() {
    loadMenuItems();
});

// ---------------- Toast notification ----------------
function showToast(message, type = 'info', duration = 3000){
    const container = document.getElementById('toast-container');
    const toast = document.createElement('div');
    toast.className = 'toast ' + type;

    // Nội dung toast
    toast.textContent = message;

    // Tạo nút đóng
    const closeBtn = document.createElement('span');
    closeBtn.className = 'close-toast';
    closeBtn.innerHTML = '&times;';
    closeBtn.onclick = () => {
        toast.classList.remove('show');
        setTimeout(() => container.removeChild(toast), 300);
    };
    toast.appendChild(closeBtn);

    container.appendChild(toast);

    // Hiển thị toast
    setTimeout(() => toast.classList.add('show'), 50);

    // Tự ẩn sau duration
    setTimeout(() => {
        toast.classList.remove('show');
        setTimeout(() => {
            if(container.contains(toast)) container.removeChild(toast);
        }, 300);
    }, duration);
}


// ---------------- Load menu ----------------
function loadMenuItems() {
    fetch('http://localhost/PR_RESERVATION_FnB_FOR_LIVEMUSIC/api_gateway/index.php?service=admin&action=get_menu_items')
        .then(res => res.json())
        .then(data => {
            let html = '';
            data.forEach(item => {
                html += `
                    <tr>    
                        <td>${item.ITEM_ID}</td>
                        <td>${item.NAME}</td>
                        <td>${item.CATEGORY || ''}</td>
                        <td>${item.DESCRIPTION || ''}</td>
                        <td>${Number(item.PRICE).toLocaleString("vi-VN")}</td>
                        <td>
                            <span class="status ${item.IS_AVAILABLE ? 'selling' : 'soldout'}">
                                ${item.IS_AVAILABLE ? 'Đang bán' : 'Hết hàng'}
                            </span>
                        </td>
                        <td>
                            <button class="btn-edit" onclick="editItem('${item.ITEM_ID}')">Sửa</button>
                            <button class="btn-delete" onclick="deleteItem('${item.ITEM_ID}')">Xóa</button>
                        </td>
                    </tr>
                `;
            });
            document.getElementById('menu-body').innerHTML = html;
        })
        .catch(error => {
            console.error('Lỗi khi tải dữ liệu:', error);
            document.getElementById('menu-body').innerHTML =
                '<tr><td colspan="7" style="text-align:center;">Lỗi tải dữ liệu</td></tr>';
        });
}

// ---------------- Modal chỉnh sửa ----------------
let selectedItemId = null;

function editItem(id) {
    selectedItemId = id;

    fetch(`http://localhost/PR_RESERVATION_FnB_FOR_LIVEMUSIC/api_gateway/index.php?service=admin&action=get_menu_detail&id=${id}`)
        .then(res => res.json())
        .then(item => {
            if(item.error){
                showToast(item.error, 'error', 4000);
                return;
            }

            document.getElementById('editItemId').value = item.ITEM_ID;
            document.getElementById('editName').value = item.NAME;
            document.getElementById('editCategory').value = item.CATEGORY || '';
            document.getElementById('editDescription').value = item.DESCRIPTION || '';
            document.getElementById('editQuantity').value = item.STOCK_QUANTITY || 0;
            document.getElementById('editAvailable').value = item.IS_AVAILABLE ? 1 : 0;
            document.getElementById('editPrice').value = Number(item.PRICE).toLocaleString("vi-VN");

            document.getElementById('editModal').style.display = 'flex';
        })
        .catch(error => {
            console.error('Lỗi khi lấy thông tin món:', error);
            showToast('Không thể tải dữ liệu món ăn.', 'error', 4000);
        });
}

function closeModal() {
    document.getElementById('editModal').style.display = 'none';
}

// ---------------- Submit form chỉnh sửa ----------------
document.getElementById('editForm').addEventListener('submit', function(e){
    e.preventDefault();

    const data = {
        ITEM_ID: document.getElementById('editItemId').value,
        NAME: document.getElementById('editName').value,
        CATEGORY: document.getElementById('editCategory').value,
        DESCRIPTION: document.getElementById('editDescription').value,
        PRICE: parseInt(document.getElementById('editPrice').value.replace(/\./g,'')),
        STOCK_QUANTITY: parseInt(document.getElementById('editQuantity').value),
        IS_AVAILABLE: parseInt(document.getElementById('editAvailable').value)
    };

    fetch('http://localhost/PR_RESERVATION_FnB_FOR_LIVEMUSIC/api_gateway/index.php?service=admin&action=update_menu_item', {
        method: 'PUT',
        headers: {'Content-Type': 'application/json'},
        body: JSON.stringify(data)
    })
    .then(res => res.json())
    .then(result => {
        if(result.success || result.message){
            showToast('Cập nhật món thành công!', 'success', 3000);
            closeModal();
            loadMenuItems();
        }else{
            showToast('Cập nhật thất bại: ' + (result.error || 'Không xác định'), 'error', 4000);
        }
    })
    .catch(error => {
        console.error('Lỗi khi cập nhật:', error);
        showToast('Không thể kết nối tới server.', 'error', 4000);
    });
});

// ---------------- Modal xác nhận xóa ----------------
let deleteItemId = null;

function deleteItem(id){
    deleteItemId = id;
    document.getElementById('deleteModal').style.display = 'flex';
}

document.getElementById('cancelDelete').addEventListener('click', function(){
    document.getElementById('deleteModal').style.display = 'none';
});

document.getElementById('confirmDelete').addEventListener('click', function(){
    document.getElementById('deleteModal').style.display = 'none';
    if(!deleteItemId) return;

    fetch('http://localhost/PR_RESERVATION_FnB_FOR_LIVEMUSIC/api_gateway/index.php?service=admin&action=delete_menu_item&id=' + deleteItemId, {
        method: 'DELETE'
    })
    .then(res => res.json())
    .then(result => {
        showToast(result.success ? "Xóa món thành công!" : "Xóa thất bại!", result.success ? "success" : "error");
        loadMenuItems();
    });
});
</script>
