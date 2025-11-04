<link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/order.css">

<main class="main-content order-detail-page">
  <section class="section-header">
    <h2>Chi tiết đơn hàng</h2>
    <button class="btn-back" onclick="window.location.href='index.php?page=order'">← Quay lại</button>
  </section>

  <section class="order-detail">
    <div id="loading" class="loading">Đang tải chi tiết đơn hàng...</div>

    <div id="detail-container" class="detail-container" style="display:none;">
      <div class="detail-row"><strong>Mã đơn hàng:</strong> <span id="order-id"></span></div>
      <div class="detail-row"><strong>Khách hàng:</strong> <span id="order-customer"></span></div>
      <div class="detail-row"><strong>Email:</strong> <span id="order-email"></span></div>
      <div class="detail-row"><strong>Ngày đặt:</strong> <span id="order-date"></span></div>
      <div class="detail-row"><strong>Trạng thái:</strong> <span id="order-status" class="status"></span></div>
      <div class="detail-row"><strong>Tổng tiền:</strong> <span id="order-total"></span></div>

      <hr class="divider">

      <h3>Chi tiết sản phẩm</h3>
      <table class="data-table">
        <thead>
          <tr>
            <th>Tên món</th>
            <th>Số lượng</th>
            <th>Đơn giá</th>
            <th>Thành tiền</th>
          </tr>
        </thead>
        <tbody id="order-items">
          <!-- Dữ liệu món sẽ được load tại đây -->
        </tbody>
      </table>
    </div>
  </section>
</main>

<script>
document.addEventListener("DOMContentLoaded", async () => {
  const params = new URLSearchParams(window.location.search);
  const order_id = params.get("order_id");

  if (!order_id) {
    document.getElementById("loading").innerText = "Thiếu mã đơn hàng.";
    return;
  }

  try {
    // 🔹 Gọi API lấy chi tiết đơn hàng
    const res = await fetch(`http://localhost/PR_RESERVATION_FnB_FOR_LIVEMUSIC/api_gateway/index.php?service=order&action=get_order_detail&order_id=${order_id}`);
    const data = await res.json();
    console.log("Chi tiết đơn hàng:", data);

    if (!data.success || !data.data) {
      document.getElementById("loading").innerText = "Không tìm thấy đơn hàng.";
      return;
    }

    const o = data.data;
    document.getElementById("order-id").innerText = o.ORDER_ID;
    document.getElementById("order-customer").innerText = o.CUSTOMER_NAME || "Không rõ";
    document.getElementById("order-email").innerText = o.EMAIL || "-";
    document.getElementById("order-date").innerText = formatDateTime(o.ORDER_DATE);
    document.getElementById("order-status").innerText = formatStatus(o.STATUS);
    document.getElementById("order-total").innerText = formatCurrency(o.TOTAL_AMOUNT);

    const statusEl = document.getElementById("order-status");
    statusEl.classList.remove("success", "pending", "cancelled");
    if (o.STATUS === "completed") statusEl.classList.add("success");
    else if (o.STATUS === "pending") statusEl.classList.add("pending");
    else statusEl.classList.add("cancelled");

    // 🔹 Hiển thị sản phẩm
    const tbody = document.getElementById("order-items");
    tbody.innerHTML = "";
    if (o.ITEMS && o.ITEMS.length > 0) {
      o.ITEMS.forEach(item => {
        const tr = document.createElement("tr");
        tr.innerHTML = `
          <td>${item.PRODUCT_NAME}</td>
          <td>${item.QUANTITY}</td>
          <td>${formatCurrency(item.UNIT_PRICE)}</td>
          <td>${formatCurrency(item.SUBTOTAL)}</td>
        `;
        tbody.appendChild(tr);
      });
    } else {
      tbody.innerHTML = `<tr><td colspan="4" style="text-align:center;">Không có sản phẩm nào</td></tr>`;
    }

    document.getElementById("loading").style.display = "none";
    document.getElementById("detail-container").style.display = "block";

  } catch (err) {
    console.error("Lỗi khi tải chi tiết:", err);
    document.getElementById("loading").innerText = "Lỗi khi tải dữ liệu.";
  }
});

function formatCurrency(value) {
  if (!value) return "0₫";
  return parseInt(value).toLocaleString("vi-VN") + "₫";
}

function formatDateTime(datetime) {
  if (!datetime) return '';
  const d = new Date(datetime);
  return `${String(d.getDate()).padStart(2, '0')}/${String(d.getMonth() + 1).padStart(2, '0')}/${d.getFullYear()} - ${String(d.getHours()).padStart(2, '0')}:${String(d.getMinutes()).padStart(2, '0')}`;
}

function formatStatus(status) {
  switch(status) {
    case "completed": return "Hoàn tất";
    case "pending": return "Đang xử lý";
    case "cancelled": return "Đã hủy";
    default: return status;
  }
}
</script>
