<?php
if (isset($_SESSION['ADMIN_ID'])) {
    $receiver_id = $_SESSION['ADMIN_ID'];
    $receiver_type = 'ADMIN';
} elseif (isset($_SESSION['CUSTOMER_ID'])) {
    $receiver_id = $_SESSION['CUSTOMER_ID'];
    $receiver_type = 'CUSTOMER';
} else {
    header("Location: login.php");
    exit();
}
?>

<link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/order.css">

<main class="main-content order-page">
  <section class="section-header">
    <h2>Danh sách đơn hàng</h2>
    <button class="btn-refresh" onclick="loadOrders()">⟳ Làm mới</button>
  </section>

  <section class="table-section">
    <table class="data-table">
      <thead>
        <tr>
          <th>Mã đơn</th>
          <th>Khách hàng</th>
          <th>Ngày đặt</th>
          <th>Tổng tiền</th>
          <th>Trạng thái</th>
          <th>Thao tác</th>
        </tr>
      </thead>
      <tbody id="order-body">
        <tr><td colspan="6" style="text-align:center;">Đang tải dữ liệu...</td></tr>
      </tbody>
    </table>
  </section>
</main>

<!-- Toast -->
<div id="toast-container"></div>

<!-- Modal xem chi tiết -->
<div id="detailModal" class="modal">
  <div class="modal-content">
    <span class="close" onclick="closeModal()">&times;</span>
    <h3>Chi tiết đơn hàng</h3>
    <div id="orderDetail" style="margin-top: 10px;">Đang tải...</div>
  </div>
</div>

<script>
// ---------------- Toast ----------------
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
    setTimeout(() => container.contains(toast) && container.removeChild(toast), 300);
  }, duration);
}

// ---------------- Load Orders ----------------
function loadOrders() {
  const tbody = document.getElementById('order-body');
  tbody.innerHTML = '<tr><td colspan="6" style="text-align:center;">Đang tải dữ liệu...</td></tr>';
  
  fetch('http://localhost/PR_RESERVATION_FnB_FOR_LIVEMUSIC/api_gateway/index.php?service=order&action=get_order')
    .then(res => res.json())
    .then(data => {
      if (!data.success || !Array.isArray(data.data)) {
        tbody.innerHTML = '<tr><td colspan="6" style="text-align:center;color:red;">Không thể tải dữ liệu.</td></tr>';
        return;
      }

      const orders = data.data;
      if (orders.length === 0) {
        tbody.innerHTML = '<tr><td colspan="6" style="text-align:center;">Chưa có đơn hàng nào.</td></tr>';
        return;
      }

      let html = '';
      orders.forEach(o => {
        html += `
          <tr>
            <td>${o.order_id}</td>
            <td>${o.customer_name || 'Không rõ'}</td>
            <td>${formatDateTime(o.order_time)}</td>
            <td>${formatCurrency(o.total_amount || 0)}</td>
            <td><span class="status ${getStatusClass(o.status)}">${o.status || 'Không rõ'}</span></td>
            <td>
              <button class="btn-edit" onclick="viewDetail('${o.order_id}')">Xem</button>
            </td>
          </tr>
        `;
      });
      tbody.innerHTML = html;
    })
    .catch(err => {
      console.error('Lỗi khi tải đơn hàng:', err);
      tbody.innerHTML = '<tr><td colspan="6" style="text-align:center;color:red;">Không thể kết nối đến server.</td></tr>';
    });
}

// ---------------- Xem chi tiết ----------------
function viewDetail(order_id) {
  window.location.href = `index.php?page=order_detail&order_id=${order_id}`;
}

function closeModal(){
  document.getElementById('detailModal').style.display = 'none';
}

// ---------------- Helpers ----------------
function formatDateTime(datetime) {
  if (!datetime) return '';
  const d = new Date(datetime);
  return `${String(d.getDate()).padStart(2,'0')}/${String(d.getMonth()+1).padStart(2,'0')}/${d.getFullYear()} - ${String(d.getHours()).padStart(2,'0')}:${String(d.getMinutes()).padStart(2,'0')}`;
}

function formatCurrency(amount) {
  return Number(amount).toLocaleString('vi-VN') + ' ₫';
}

function getStatusClass(status) {
  switch (status) {
    case 'PAID': return 'status-success';
    case 'PENDING': return 'status-warning';
    case 'CANCELLED': return 'status-danger';
    default: return 'status-default';
  }
}

// ---------------- Init ----------------
document.addEventListener("DOMContentLoaded", loadOrders);
</script>
