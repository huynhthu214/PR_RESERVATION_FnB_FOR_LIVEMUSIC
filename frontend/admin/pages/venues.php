<link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/venues.css">

<main class="main-content venue-page">
  <section class="section-header">
      <h2>Địa điểm</h2>
      <button class="btn-add" onclick="window.location.href='index.php?page=add_venue'">+ Thêm địa điểm</button>
  </section>

  <section class="table-section">
      <table class="data-table">
          <thead>
              <tr>
                  <th>ID</th>
                  <th>Tên địa điểm</th>
                  <th>Địa chỉ</th>
                  <th>Sức chứa</th>
                  <th>Sơ đồ chỗ ngồi</th>
                  <th>Thao tác</th>
              </tr>
          </thead>
            <tbody id="venue-body">
                <tr><td colspan="7" style="text-align:center;">Đang tải dữ liệu...</td></tr>
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
      <input type="number" id="editCapacity" step="5" min="0">

      <label for="editSeatLayout">Sơ đồ chỗ ngồi:</label>
      <div class="seat-layout-input">
      <input type="text" id="seatLayoutDisplay" readonly placeholder="Chưa có file">
      <a id="currentSeatLayout" href="#" target="_blank" class="hidden"></a>
      <input type="file" id="editSeatLayout" accept=".json" hidden>
      <label for="editSeatLayout" class="btn btn-upload">Chọn tệp</label>
      </div>
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
        .then(response => {
            if (!response.success || !Array.isArray(response.data)) {
                throw new Error("Dữ liệu không hợp lệ từ API");
            }

            const data = response.data;
            let html = '';

            data.forEach(venue => {
                html += `
                    <tr>
                        <td>${venue.id}</td>
                        <td>${venue.name}</td>
                        <td>${venue.address}</td>
                        <td>${venue.capacity}</td>
                        <td>
                            ${venue.seat_layout ? `<a href="http://localhost/PR_RESERVATION_FnB_FOR_LIVEMUSIC/frontend/admin/${venue.seat_layout}" target="_blank" class="seat-link">${venue.seat_layout.split('/').pop()}</a>` : '—'}
                        </td>
                        <td>
                            <button class="btn-edit" onclick="editVenue('${venue.id}')">Sửa</button>
                            <button class="btn-delete" onclick="deleteVenue('${venue.id}')">Xóa</button>
                        </td>
                    </tr>
                `;
            });

            document.getElementById('venue-body').innerHTML = html;
        })
        .catch(error => {
            console.error('Lỗi khi tải danh sách địa điểm:', error);
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
      if (venue.error) {
        showToast(venue.error, 'error', 4000);
        return;
      }

      document.getElementById('editVenueId').value = venue.VENUE_ID || '';
      document.getElementById('editVenueName').value = venue.NAME || '';
      document.getElementById('editAddress').value = venue.ADDRESS || '';
      document.getElementById('editCapacity').value = venue.CAPACITY || 0;

      const seatDisplay = document.getElementById('seatLayoutDisplay');
      const link = document.getElementById('currentSeatLayout');
      const fileInput = document.getElementById('editSeatLayout');

      // Nếu có file seat layout
      if (venue.SEAT_LAYOUT) {
        const filePath = `http://localhost/PR_RESERVATION_FnB_FOR_LIVEMUSIC/frontend/admin/${venue.SEAT_LAYOUT}`;
        const fileName = venue.SEAT_LAYOUT.split('/').pop();

        seatDisplay.value = fileName;
        seatDisplay.classList.add('link-mode');

        link.href = filePath;
        link.classList.remove('hidden');

        // cho phép click vào input mở link
        seatDisplay.onclick = () => window.open(filePath, '_blank');
      } else {
        seatDisplay.value = 'Chưa có file';
        seatDisplay.classList.remove('link-mode');
        link.classList.add('hidden');
        seatDisplay.onclick = null;
      }

      fileInput.value = '';
      fileInput.onchange = function () {
        const fileName = this.files.length ? this.files[0].name : 'Chưa có file';
        seatDisplay.value = fileName;
        seatDisplay.classList.remove('link-mode');
        seatDisplay.onclick = null;
      };

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

    const formData = new FormData();
    formData.append('VENUE_ID', document.getElementById('editVenueId').value);
    formData.append('NAME', document.getElementById('editVenueName').value);
    formData.append('ADDRESS', document.getElementById('editAddress').value);
    formData.append('CAPACITY', document.getElementById('editCapacity').value);

    // Nếu người dùng chọn file mới, thêm vào formData
    const fileInput = document.getElementById('editSeatLayout');
    if (fileInput.files.length > 0) {
        formData.append('seat_layout', fileInput.files[0]);
    }

    fetch('http://localhost/PR_RESERVATION_FnB_FOR_LIVEMUSIC/api_gateway/index.php?service=admin&action=update_venue', {
        method: 'POST',
        body: formData
    })
    .then(res => res.json())
    .then(result => {
        if(result.success){
            showToast('Cập nhật địa điểm thành công!', 'success', 3000);
            closeVenueModal();
            loadVenues();
        } else {
            showToast('Cập nhật thất bại: ' + (result.message || 'Không xác định'), 'error', 4000);
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
