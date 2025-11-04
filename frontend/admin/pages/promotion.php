<link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/promotion.css">

<main class="main-content promotion-page">
  <section class="section-header">
      <h2>Khuyến mãi</h2>
      <button class="btn-add" onclick="window.location.href='index.php?page=add_promotion'"> + Thêm mã
  </section>

  <section class="table-section">
      <table class="data-table">
          <thead>
              <tr>
                  <th>ID</th>
                  <th>Mã code</th>
                  <th>Phần trăm giảm</th>
                  <th>Ngày bắt đầu</th>
                  <th>Ngày kết thúc</th>
                  <th>Trạng thái</th>
                  <th>Thao tác</th>
              </tr>
          </thead>
            <tbody id="promo-body">
                <tr><td colspan="7" style="text-align:center;">Đang tải dữ liệu...</td></tr>
            </tbody>
        </table>
    </section>
</main>
<!-- Toast container -->
<div id="toast-container"></div>

<!-- Modal chỉnh sửa Promotion -->
<div id="editPromoModal" class="modal">
  <div class="modal-content">
    <span class="close" onclick="closePromoModal()">&times;</span>
    <h3>Chỉnh sửa khuyến mãi</h3>
    <form id="editPromoForm">
      <input type="hidden" id="editPromoId">

      <label for="editEventIdPromo">Sự kiện áp dụng:</label>
      <input type="text" id="editEventIdPromo" required>

      <label for="editPromoCode">Mã khuyến mãi:</label>
      <input type="text" id="editPromoCode" required>

      <label for="editDiscountPercent">Phần trăm giảm giá (%):</label>
      <input type="number" id="editDiscountPercent" required min="0" max="100">

      <label for="editValidFrom">Bắt đầu:</label>
      <input type="date" id="editValidFrom" required>

      <label for="editValidTo">Kết thúc:</label>
      <input type="date" id="editValidTo" required>

      <label for="editIsActive">Trạng thái:</label>
      <select id="editIsActive">
        <option value="1">Hoạt động</option>
        <option value="0">Không hoạt động</option>
      </select>

      <label for="editApplyTo">Áp dụng cho:</label>
      <input type="text" id="editApplyTo">

      <button type="submit">Lưu thay đổi</button>
    </form>
  </div>
</div>


<!-- Modal xác nhận xóa -->
<div id="deleteModal" class="modal hidden">
  <div class="modal-content">
    <h3>Xác nhận xóa</h3>
    <p>Bạn có chắc muốn xóa mã khuyến mãi này?</p>
    <div style="text-align:right; margin-top: 15px;">
      <button id="cancelDelete" class="btn">Hủy</button>
      <button id="confirmDelete" class="btn btn-delete">Xóa</button>
    </div>
  </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function() {
    loadPromotions();
});  
// ---------------- Toast ----------------
function showToast(message, type = 'info', duration = 3000) {
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
// ---------------- Load promotions ----------------
function loadPromotions() {
    fetch('http://localhost/PR_RESERVATION_FnB_FOR_LIVEMUSIC/api_gateway/index.php?service=admin&action=get_promotions')
        .then(res => res.json())
        .then(response => {
            if (!response.success || !Array.isArray(response.data)) {
                throw new Error("Dữ liệu không hợp lệ từ API");
            }

            const data = response.data;
            let html = '';

            data.forEach(promo => {
                html += `
                    <tr>
                        <td>${promo.id}</td>
                        <td>${promo.code}</td>
                        <td>${promo.discount}%</td>
                        <td>${promo.start_date ? new Date(promo.start_date).toLocaleDateString("vi-VN") : ''}</td>
                        <td>${promo.end_date ? new Date(promo.end_date).toLocaleDateString("vi-VN") : ''}</td>
                        <td>
                            <span class="status ${promo.status_class}">
                                ${promo.status}
                            </span>
                        </td>
                        <td>
                            <button class="btn-edit" onclick="editPromotion('${promo.id}')">Sửa</button>
                            <button class="btn-delete" onclick="deletePromotion('${promo.id}')">Xóa</button>
                        </td>
                    </tr>
                `;
            });

            document.getElementById('promo-body').innerHTML = html;
        })
        .catch(error => {
            console.error('Lỗi khi tải danh sách khuyến mãi:', error);
            document.getElementById('promo-body').innerHTML =
                '<tr><td colspan="7" style="text-align:center;">Lỗi tải dữ liệu</td></tr>';
        });
}

// ---------------- Modal chỉnh sửa Promotion ----------------
let selectedPromoId = null;

function editPromo(id) {
    selectedPromoId = id;

    fetch(`http://localhost/PR_RESERVATION_FnB_FOR_LIVEMUSIC/api_gateway/index.php?service=admin&action=get_promo_detail&id=${id}`)
        .then(res => res.json())
        .then(promo => {
            if(promo.error){
                showToast(promo.error, 'error', 4000);
                return;
            }

            document.getElementById('editPromoId').value = promo.PROMO_ID;
            document.getElementById('editEventIdPromo').value = promo.EVENT_ID || '';
            document.getElementById('editPromoCode').value = promo.CODE || '';
            document.getElementById('editDiscountPercent').value = promo.DISCOUNT_PERCENT || 0;
            document.getElementById('editValidFrom').value = promo.VALID_FROM ? promo.VALID_FROM.split(' ')[0] : '';
            document.getElementById('editValidTo').value = promo.VALID_TO ? promo.VALID_TO.split(' ')[0] : '';
            document.getElementById('editIsActive').value = promo.IS_ACTIVE ? 1 : 0;
            document.getElementById('editApplyTo').value = promo.APPLY_TO || '';

            document.getElementById('editPromoModal').style.display = 'flex';
        })
        .catch(error => {
            console.error('Lỗi khi lấy thông tin khuyến mãi:', error);
            showToast('Không thể tải dữ liệu khuyến mãi.', 'error', 4000);
        });
}

function closePromoModal() {
    document.getElementById('editPromoModal').style.display = 'none';
}

document.getElementById('editPromoForm').addEventListener('submit', function(e){
    e.preventDefault();

    const data = {
        PROMO_ID: document.getElementById('editPromoId').value,
        EVENT_ID: document.getElementById('editEventIdPromo').value,
        CODE: document.getElementById('editPromoCode').value,
        DISCOUNT_PERCENT: parseInt(document.getElementById('editDiscountPercent').value),
        VALID_FROM: document.getElementById('editValidFrom').value,
        VALID_TO: document.getElementById('editValidTo').value,
        IS_ACTIVE: parseInt(document.getElementById('editIsActive').value),
        APPLY_TO: document.getElementById('editApplyTo').value
    };

    fetch('http://localhost/PR_RESERVATION_FnB_FOR_LIVEMUSIC/api_gateway/index.php?service=admin&action=update_promo', {
        method: 'PUT',
        headers: {'Content-Type': 'application/json'},
        body: JSON.stringify(data)
    })
    .then(res => res.json())
    .then(result => {
        if(result.success || result.message){
            showToast('Cập nhật khuyến mãi thành công!', 'success', 3000);
            closePromoModal();
            loadPromotions();
        }else{
            showToast('Cập nhật thất bại: ' + (result.error || 'Không xác định'), 'error', 4000);
        }
    })
    .catch(error => {
        console.error('Lỗi khi cập nhật:', error);
        showToast('Không thể kết nối tới server.', 'error', 4000);
    });
});


// ---------------- Xóa sự kiện ----------------
let deletePromoId = null;

function deletePromo(id){
    deletePromoId = id;
    document.getElementById('deleteModal').style.display = 'flex';
}

document.getElementById('cancelDelete').addEventListener('click', function(){
    document.getElementById('deleteModal').style.display = 'none';
});

document.getElementById('confirmDelete').addEventListener('click', function(){
    document.getElementById('deleteModal').style.display = 'none';
    if(!deletePromoId) return;

    fetch('http://localhost/PR_RESERVATION_FnB_FOR_LIVEMUSIC/api_gateway/index.php?service=admin&action=delete_promo&id=' + deletePromoId, {
        method: 'DELETE'
    })
    .then(res => res.json())
    .then(result => {
        showToast(result.success ? "Xóa món thành công!" : "Xóa thất bại!", result.success ? "success" : "error");
        loadMenuItems();
    });
});
</script>
