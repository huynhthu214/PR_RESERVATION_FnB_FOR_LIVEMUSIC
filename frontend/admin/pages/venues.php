<link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/venues.css">

<main class="main-content venue-page">
  <section class="section-header">
      <h2>Địa điểm</h2>
      <button class="btn-add" onclick="window.location.href='index.php?page=add_venue'"> + Thêm địa điểm
  </section>

  <section class="table-section">
      <table class="data-table">
          <thead>
              <tr>
                  <th>ID</th>
                  <th>Tên địa điểm</th>
                  <th>Địa chỉ</th>
                  <th>Sức chứa</th>
                  <th>Trạng thái</th>
                  <th>Thao tác</th>
              </tr>
          </thead>
            <tbody id="venue-body">
                <tr><td colspan="6" style="text-align:center;">Đang tải dữ liệu...</td></tr>
            </tbody>
        </table>
    </section>
</main>
<!-- Toast container -->
<div id="toast-container"></div>

<!-- Modal chỉnh sửa Venue -->
<div id="editVenueModal" class="modal">
  <div class="modal-content">
    <span class="close" onclick="closeVenueModal()">&times;</span>
    <h3>Chỉnh sửa địa điểm</h3>
    <form id="editVenueForm">
      <input type="hidden" id="editVenueId">

      <label for="editVenueName">Tên địa điểm:</label>
      <input type="text" id="editVenueName" required>

      <label for="editAddress">Địa chỉ:</label>
      <input type="text" id="editAddress">

      <label for="editCapacity">Sức chứa:</label>
      <input type="number" id="editCapacity">

      <label for="editSeatLayout">Sơ đồ chỗ ngồi:</label>
      <textarea id="editSeatLayout" rows="3"></textarea>

      <button type="submit">Lưu thay đổi</button>
    </form>
  </div>
</div>


<!-- Modal xác nhận xóa -->
<div id="deleteModal" class="modal hidden">
  <div class="modal-content">
    <h3>Xác nhận xóa</h3>
    <p>Bạn có chắc muốn xóa địa điểm này?</p>
    <div style="text-align:right; margin-top: 15px;">
      <button id="cancelDelete" class="btn">Hủy</button>
      <button id="confirmDelete" class="btn btn-delete">Xóa</button>
    </div>
  </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function() {
    loadVenues();
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

// ---------------- Load venues ----------------
function loadVenues() {
    fetch('http://localhost/PR_RESERVATION_FnB_FOR_LIVEMUSIC/api_gateway/index.php?service=admin&action=get_venues')
        .then(res => res.json())
        .then(result => {
            let html = '';
            if (!result.success || !result.data || result.data.length === 0) {
                html = '<tr><td colspan="6" style="text-align:center;">Chưa có dữ liệu</td></tr>';
            } else {
                result.data.forEach(venue => {
                    html += `
                        <tr>
                            <td>${venue.id}</td>
                            <td>${venue.name}</td>
                            <td>${venue.address}</td>
                            <td>${venue.capacity}</td>
                            <td>
                                <span class="status ${venue.status === 'Hoạt động' ? 'active' : 'inactive'}">
                                    ${venue.status}
                                </span>
                            </td>
                            <td>
                                <button class="btn-edit" onclick="editVenue('${venue.id}')">Sửa</button>
                                <button class="btn-delete" onclick="deleteVenue('${venue.id}')">Xóa</button>
                            </td>
                        </tr>
                    `;
                });
            }
            document.getElementById('venue-body').innerHTML = html;
        })
        .catch(error => {
            console.error('Lỗi khi tải địa điểm:', error);
            document.getElementById('venue-body').innerHTML =
                '<tr><td colspan="6" style="text-align:center;">Lỗi tải dữ liệu</td></tr>';
        });
}

// ---------------- Modal chỉnh sửa Venue ----------------
let selectedVenueId = null;

function editVenue(id) {
    selectedVenueId = id;

    fetch(`http://localhost/PR_RESERVATION_FnB_FOR_LIVEMUSIC/api_gateway/index.php?service=admin&action=get_venue_detail&id=${id}`)
        .then(res => res.json())
        .then(venue => {
            if(venue.error){
                showToast(venue.error, 'error', 4000);
                return;
            }

            document.getElementById('editVenueId').value = venue.VENUE_ID;
            document.getElementById('editVenueName').value = venue.NAME || '';
            document.getElementById('editAddress').value = venue.ADDRESS || '';
            document.getElementById('editCapacity').value = venue.CAPACITY || 0;
            document.getElementById('editSeatLayout').value = venue.SEAT_LAYOUT || '';

            document.getElementById('editVenueModal').style.display = 'flex';
        })
        .catch(error => {
            console.error('Lỗi khi lấy thông tin địa điểm:', error);
            showToast('Không thể tải dữ liệu địa điểm.', 'error', 4000);
        });
}

function closeVenueModal() {
    document.getElementById('editVenueModal').style.display = 'none';
}

document.getElementById('editVenueForm').addEventListener('submit', function(e){
    e.preventDefault();

    const data = {
        VENUE_ID: document.getElementById('editVenueId').value,
        NAME: document.getElementById('editVenueName').value,
        ADDRESS: document.getElementById('editAddress').value,
        CAPACITY: parseInt(document.getElementById('editCapacity').value),
        SEAT_LAYOUT: document.getElementById('editSeatLayout').value
    };

    fetch('http://localhost/PR_RESERVATION_FnB_FOR_LIVEMUSIC/api_gateway/index.php?service=admin&action=update_venue', {
        method: 'PUT',
        headers: {'Content-Type': 'application/json'},
        body: JSON.stringify(data)
    })
    .then(res => res.json())
    .then(result => {
        if(result.success || result.message){
            showToast('Cập nhật địa điểm thành công!', 'success', 3000);
            closeVenueModal();
            loadVenues(); 
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
let deleteVenueId = null;
function deleteVenue(id){
    deleteVenueId = id;
    document.getElementById('deleteModal').style.display = 'flex';
}

document.getElementById('cancelDelete').addEventListener('click', function(){
    document.getElementById('deleteModal').style.display = 'none';
});

document.getElementById('confirmDelete').addEventListener('click', function(){
    document.getElementById('deleteModal').style.display = 'none';
    if(!deleteVenueId) return;

    fetch('http://localhost/PR_RESERVATION_FnB_FOR_LIVEMUSIC/api_gateway/index.php?service=admin&action=delete_venue&id=' + deleteVenueId, {
        method: 'DELETE'
    })
    .then(res => res.json())
    .then(result => {
        showToast(result.success ? "Xóa địa điểm thành công!" : "Xóa thất bại!", result.success ? "success" : "error");
        loadVenues();
    });
});
</script>
