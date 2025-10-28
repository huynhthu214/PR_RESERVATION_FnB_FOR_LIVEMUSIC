<main class="main-content menu-page">
    <section class="section-header">
        <h2>Thực đơn</h2>
        <button class="btn-add" onclick="window.location.href='add-menu-item.php'">+ Thêm món</button>
    </section>

    <section class="table-section">
        <table class="data-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tên món</th>
                    <th>Loại</th>
                    <th>Giá (VNĐ)</th>
                    <th>Trạng thái</th>
                    <th>Thao tác</th>
                </tr>
            </thead>
            <tbody id="menu-body">
                <tr><td colspan="6" style="text-align:center;">Đang tải dữ liệu...</td></tr>
            </tbody>
        </table>
    </section>
</main>

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

      <label for="editPrice">Giá:</label>
      <input type="number" id="editPrice" required>

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

<script>
document.addEventListener("DOMContentLoaded", function() {
    loadMenuItems();
});

function loadMenuItems() {
    fetch('http://localhost/PR_RESERVATION_FnB_FOR_LIVEMUSIC/api_gateway/index.php?service=admin&action=get_menu_items')
        .then(res => res.json())
        .then(data => {
            console.log("Menu items:", data);
            let html = '';
            data.forEach(item => {
                html += `
                    <tr>
                        <td>${item.ITEM_ID}</td>
                        <td>${item.NAME}</td>
                        <td>${item.CATEGORY}</td>
                        <td>${item.PRICE}</td>
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
                '<tr><td colspan="6" style="text-align:center;">Lỗi tải dữ liệu</td></tr>';
        });
}

let selectedItemId = null;

// 🟩 Mở modal và tải dữ liệu chi tiết
function editItem(id) {
    selectedItemId = id;
    console.log("Đang chỉnh sửa:", id);

    fetch(`http://localhost/PR_RESERVATION_FnB_FOR_LIVEMUSIC/api_gateway/index.php?service=admin&action=get_menu_detail&id=${id}`)
        .then(res => res.json())
        .then(item => {
            if (item.error) {
                alert(item.error);
                return;
            }

            document.getElementById('editItemId').value = item.ITEM_ID;
            document.getElementById('editName').value = item.NAME;
            document.getElementById('editCategory').value = item.CATEGORY || '';
            document.getElementById('editPrice').value = item.PRICE;
            document.getElementById('editQuantity').value = item.STOCK_QUANTITY || 0;
            document.getElementById('editAvailable').value = item.IS_AVAILABLE ? 1 : 0;

            document.getElementById('editModal').style.display = 'flex';
            console.log("Mở modal");
        })
        .catch(error => {
            console.error('Lỗi khi lấy thông tin món:', error);
            alert('Không thể tải dữ liệu món ăn.');
        });
}

// 🔻 Đóng modal
function closeModal() {
    document.getElementById('editModal').style.display = 'none';
}

// 🟨 Xử lý lưu cập nhật
document.getElementById('editForm').addEventListener('submit', function(e) {
    e.preventDefault();

    const data = {
        ITEM_ID: document.getElementById('editItemId').value,
        NAME: document.getElementById('editName').value,
        CATEGORY: document.getElementById('editCategory').value,
        PRICE: parseFloat(document.getElementById('editPrice').value),
        STOCK_QUANTITY: parseInt(document.getElementById('editQuantity').value),
        IS_AVAILABLE: parseInt(document.getElementById('editAvailable').value)
    };

    console.log("Dữ liệu cập nhật:", data);

    fetch('http://localhost/PR_RESERVATION_FnB_FOR_LIVEMUSIC/api_gateway/index.php?service=admin&action=update_menu_item', {
        method: 'PUT',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(data)
    })
    .then(res => res.json())
    .then(result => {
        console.log("Phản hồi API:", result);
        if (result.success || result.message) {
            alert('Cập nhật món thành công!');
            closeModal();
            loadMenuItems(); // 🔄 reload lại bảng mà không cần reload trang
        } else {
            alert('Cập nhật thất bại: ' + (result.error || 'Không xác định'));
        }
    })
    .catch(error => {
        console.error('Lỗi khi cập nhật:', error);
        alert('Không thể kết nối tới server.');
    });
});

// 🔴 Xóa món ăn
function deleteItem(id) {
    if (!confirm('Bạn có chắc muốn xóa món này?')) return;

    fetch(`http://localhost/PR_RESERVATION_FnB_FOR_LIVEMUSIC/api_gateway/index.php?service=admin&action=delete_menu_item&id=${id}`, {
        method: 'DELETE'
    })
    .then(response => response.json())
    .then(result => {
        console.log("Kết quả xóa:", result);
        if (result.success) {
            alert('Xóa món thành công!');
            loadMenuItems();
        } else {
            alert('Không thể xóa món này: ' + (result.message || 'Lỗi không xác định'));
        }
    })
    .catch(error => {
        console.error('Lỗi khi xóa món:', error);
        alert('Lỗi khi kết nối tới server!');
    });
}
</script>



