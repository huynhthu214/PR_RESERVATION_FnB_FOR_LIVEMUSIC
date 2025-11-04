<link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/events.css">

<main class="main-content event-page">
    <section class="section-header">
      <h2>Sự kiện</h2>
      <button class="btn-add" onclick="window.location.href='index.php?page=add_event'">+ Thêm sự kiện</button>
  </section>

  <section class="table-section">
      <table class="data-table">
          <thead>
              <tr>
                  <th>ID</th>
                  <th>Địa điểm</th>
                  <th>Ban nhạc</th>
                  <th>Ngày diễn</th>
                  <th>Giá vé</th>
                  <th>Trạng thái</th>
                  <th>Thao tác</th>
              </tr>
          </thead>
            <tbody id="event-body">
                <tr><td colspan="7" style="text-align:center;">Đang tải dữ liệu...</td></tr>
            </tbody>
        </table>
    </section>
</main>

<!-- Toast container -->
<div id="toast-container"></div>

<!-- Modal chỉnh sửa Event -->
<div id="editEventModal" class="modal">
  <div class="modal-content">
    <span class="close" onclick="closeEventModal()">&times;</span>
    <h3>Chỉnh sửa sự kiện</h3>
    <form id="editEventForm">
      <input type="hidden" id="editEventId">

      <label for="editBandName">Tên ban nhạc / chương trình:</label>
      <input type="text" id="editBandName" required>

      <label for="editVenueId">Địa điểm:</label>
      <input type="text" id="editVenueId" required>

      <label for="editEventDate">Ngày diễn:</label>
      <input type="date" id="editEventDate" required>

      <label for="editStartTime">Thời gian bắt đầu:</label>
      <input type="time" id="editStartTime" required>

      <label for="editEndTime">Thời gian kết thúc:</label>
      <input type="time" id="editEndTime">

      <label for="editTicketPrice">Giá vé (VNĐ):</label>
      <div class="price-input">
        <input type="text" id="editTicketPrice" required>
        <span class="currency-label">VNĐ</span>
      </div>

      <label for="editStatus">Trạng thái:</label>
      <select id="editStatus">
        <option value="Scheduled">Đang lên lịch</option>
        <option value="Cancelled">Hủy</option>
        <option value="Completed">Đã diễn</option>
      </select>

      <label for="editDescription">Mô tả:</label>
      <textarea id="editDescription" rows="3"></textarea>

        <label for="editImageUrl">URL hình ảnh:</label>
        <input type="text" id="editImageUrl" placeholder="Chọn hình ảnh..." readonly style="cursor: pointer;">
        <input type="file" id="editImageFile" accept="image/*" style="display: none;">

      <button type="submit">Lưu thay đổi</button>
    </form>
  </div>
</div>

<!-- Modal xác nhận xóa -->
<div id="deleteModal" class="modal hidden">
  <div class="modal-content">
    <h3>Xác nhận xóa</h3>
    <p>Bạn có chắc muốn xóa sự kiện này?</p>
    <div style="text-align:right; margin-top: 15px;">
      <button id="cancelDelete" class="btn">Hủy</button>
      <button id="confirmDelete" class="btn btn-delete">Xóa</button>
    </div>
  </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        loadEvents();
    });
    
    // Khi nhấn vào ô URL -> mở hộp chọn ảnh
document.getElementById('editImageUrl').addEventListener('click', function () {
  document.getElementById('editImageFile').click();
});

// Khi người dùng chọn ảnh -> hiển thị tên file
document.getElementById('editImageFile').addEventListener('change', function (event) {
  const file = event.target.files[0];
  if (file) {
    document.getElementById('editImageUrl').value = file.name;
  } else {
    document.getElementById('editImageUrl').value = '';
  }
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
// ---------------- Load events ----------------
function loadEvents() {
    fetch('http://localhost/PR_RESERVATION_FnB_FOR_LIVEMUSIC/api_gateway/index.php?service=admin&action=get_events')
        .then(res => res.json())
        .then(response => {
            if (!response.success || !Array.isArray(response.data)) {
                throw new Error("Dữ liệu không hợp lệ từ API");
            }

            const data = response.data;
            let html = '';

            data.forEach(event => {
                html += `
                    <tr>
                        <td>${event.id}</td>
                        <td>${event.venue || ''}</td>
                        <td>${event.band || ''}</td>
                        <td>${event.date ? new Date(event.date).toLocaleDateString("vi-VN") : ''}</td>
                        <td>${Number(event.price || 0).toLocaleString("vi-VN")}</td>
                        <td>
                            <span class="status ${event.status?.toLowerCase() === 'active' ? 'selling' : 'soldout'}">
                                ${event.status?.toLowerCase() === 'active' ? 'Đang mở' : 'Đã kết thúc'}
                            </span>
                        </td>
                        <td>
                            <button class="btn-edit" onclick="editEvent('${event.id}')">Sửa</button>
                            <button class="btn-delete" onclick="deleteEvent('${event.id}')">Xóa</button>
                        </td>
                    </tr>
                `;
            });

            document.getElementById('event-body').innerHTML = html;
        })
        .catch(error => {
            console.error('Lỗi khi tải dữ liệu sự kiện:', error);
            document.getElementById('event-body').innerHTML =
                '<tr><td colspan="7" style="text-align:center;">Lỗi tải dữ liệu</td></tr>';
        });
}

// ---------------- Modal chỉnh sửa Event ----------------
let selectedEventId = null;

function editEvent(id) {
    selectedEventId = id;

    fetch(`http://localhost/PR_RESERVATION_FnB_FOR_LIVEMUSIC/api_gateway/index.php?service=admin&action=get_event_detail&id=${id}`)
        .then(res => res.json())
        .then(event => {
            if(event.error){
                showToast(event.error, 'error', 4000);
                return;
            }

            document.getElementById('editEventId').value = event.EVENT_ID;
            document.getElementById('editBandName').value = event.BAND_NAME || '';
            document.getElementById('editVenueId').value = event.VENUE_ID || '';
            document.getElementById('editEventDate').value = event.EVENT_DATE ? event.EVENT_DATE.split(' ')[0] : '';
            document.getElementById('editStartTime').value = event.START_TIME ? event.START_TIME.split(' ')[1] : '';
            document.getElementById('editEndTime').value = event.END_TIME ? event.END_TIME.split(' ')[1] : '';
            document.getElementById('editTicketPrice').value = Number(event.TICKET_PRICE).toLocaleString("vi-VN");
            document.getElementById('editStatus').value = event.STATUS || '';
            document.getElementById('editDescription').value = event.DESCRIPTION || '';
            document.getElementById('editImageUrl').value = event.IMAGE_URL || '';

            document.getElementById('editEventModal').style.display = 'flex';
        })
        .catch(error => {
            console.error('Lỗi khi lấy thông tin sự kiện:', error);
            showToast('Không thể tải dữ liệu sự kiện.', 'error', 4000);
        });
}

function closeEventModal() {
    document.getElementById('editEventModal').style.display = 'none';
}

document.getElementById('editEventForm').addEventListener('submit', function(e){
    e.preventDefault();

    const data = {
        EVENT_ID: document.getElementById('editEventId').value,
        BAND_NAME: document.getElementById('editBandName').value,
        VENUE_ID: document.getElementById('editVenueId').value,
        EVENT_DATE: document.getElementById('editEventDate').value,
        START_TIME: document.getElementById('editStartTime').value,
        END_TIME: document.getElementById('editEndTime').value,
        TICKET_PRICE: parseInt(document.getElementById('editTicketPrice').value.replace(/\./g,'')),
        STATUS: document.getElementById('editStatus').value,
        DESCRIPTION: document.getElementById('editDescription').value,
        IMAGE_URL: document.getElementById('editImageUrl').value
    };

    fetch('http://localhost/PR_RESERVATION_FnB_FOR_LIVEMUSIC/api_gateway/index.php?service=admin&action=update_event', {
        method: 'PUT',
        headers: {'Content-Type': 'application/json'},
        body: JSON.stringify(data)
    })
    .then(res => res.json())
    .then(result => {
        if(result.success || result.message){
            showToast('Cập nhật sự kiện thành công!', 'success', 3000);
            closeEventModal();
            loadEvents(); 
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
let deleteEventId = null;

function deleteEvent(id){
    deleteEventId = id;
    document.getElementById('deleteModal').style.display = 'flex';
}

document.getElementById('cancelDelete').addEventListener('click', function(){
    document.getElementById('deleteModal').style.display = 'none';
});

document.getElementById('confirmDelete').addEventListener('click', function(){
    document.getElementById('deleteModal').style.display = 'none';
    if(!deleteEventId) return;

    fetch('http://localhost/PR_RESERVATION_FnB_FOR_LIVEMUSIC/api_gateway/index.php?service=admin&action=delete_event&id=' + deleteEventId, {
        method: 'DELETE'
    })
    .then(res => res.json())
    .then(result => {
        showToast(result.success ? "Xóa sự kiện thành công!" : "Xóa thất bại!", result.success ? "success" : "error");
        loadEvents();
    });
});
</script>
