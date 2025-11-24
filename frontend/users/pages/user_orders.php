<link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/user_orders.css">

<!-- Thêm thư viện QRCode.js -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>

<section class="hero">
  <div class="hero-content">
    <h1>Đơn hàng của tôi</h1>
    <p>Xem lại các món ăn & đồ uống, vé sự kiện đã đặt</p>
  </div>
</section>

<div class="container" id="orders-container"></div>

<script>
async function loadUserOrders() {
    const res = await fetch('/PR_RESERVATION_FnB_FOR_LIVEMUSIC/api_gateway/index.php?service=order&action=get_user_order');
    const data = await res.json();

    if (!data.success) {
        alert(data.message || 'Lỗi tải đơn hàng');
        return;
    }

    const container = document.getElementById('orders-container');
    container.innerHTML = '';

    data.orders.forEach(o => {
        const order = o.order;
        const items = o.items;
        const payment = o.payment;
        const reservation = o.reservation;

        // Món ăn / đồ uống
        const itemRows = items.map(i => `
            <div class="item-row">
                <span>${i.NAME || i.ITEM_ID} x ${i.QUANTITY}</span>
                <span>${(i.UNIT_PRICE*i.QUANTITY).toLocaleString()}đ</span>
            </div>
        `).join('');

        // Vé / event
        let reservationHTML = '';
        if (reservation) {
            reservationHTML = `
            <div class="reservation-info">
                <p><b>Sự kiện:</b> ${reservation.EVENT_NAME}</p>
                <p><b>Ngày:</b> ${reservation.EVENT_DATE} ${reservation.START_TIME} - ${reservation.END_TIME}</p>
                <p><b>Địa điểm:</b> ${reservation.VENUE_NAME}, ${reservation.VENUE_ADDRESS}</p>
                <p><b>Giá vé:</b> ${reservation.TICKET_PRICE.toLocaleString()}đ</p>
            </div>
            `;
        }

        const statusClass = payment?.PAYMENT_STATUS === 'Completed' ? 'done' : 'pending';
        const statusText = payment?.PAYMENT_STATUS === 'Completed' ? 'Đã thanh toán' : 'Chưa thanh toán';

        const orderCard = document.createElement('div');
        orderCard.className = 'order-card';
        orderCard.innerHTML = `
            <div class="order-header">
                <span class="status ${statusClass}">${statusText}</span>
                <h3>Order #${order.ORDER_ID}</h3>
                <p>${order.ORDER_TIME}</p>
            </div>
            <div class="order-body">
                <div class="order-items">
                    ${itemRows}
                    <div class="order-total">
                        <span>Tổng</span>
                        <span>${order.TOTAL_AMOUNT.toLocaleString()}đ</span>
                    </div>
                    ${reservationHTML}
                </div>
                <div class="order-side">
                    <div class="${statusClass==='done'?'done-box':'qr-box'}" id="qr-container-${order.ORDER_ID}">
                        <div class="emoji"></div>
                        <p>${statusClass==='done'?'Đơn hàng đã hoàn thành!':'QR Code'}</p>
                    </div>
                    <p style="font-size:0.8rem;color:#b87333;text-align:center;">
                        ${statusClass==='done'?'Hiển thị QR này tại quầy':'Show this QR code at the pickup counter'}
                    </p>
                    <button class="btn-download" id="download-${order.ORDER_ID}">Download QR</button>
                </div>
            </div>
        `;

        container.appendChild(orderCard);

        // Tạo QR code nếu chưa thanh toán
        if (statusClass !== 'done') {
            const qrDiv = document.getElementById(`qr-container-${order.ORDER_ID}`);
            const qr = new QRCode(qrDiv, {
                text: `ORDER:${order.ORDER_ID}`,
                width: 100,
                height: 100,
                colorDark : "#000000",
                colorLight : "#ffffff",
                correctLevel : QRCode.CorrectLevel.H
            });

            // Nút download QR
            document.getElementById(`download-${order.ORDER_ID}`).addEventListener('click', () => {
                const img = qrDiv.querySelector('img') || qrDiv.querySelector('canvas');
                if (img) {
                    const url = img.src || img.toDataURL("image/png");
                    const a = document.createElement('a');
                    a.href = url;
                    a.download = `QR-${order.ORDER_ID}.png`;
                    a.click();
                }
            });
        } else {
            // Nếu đã thanh toán, ẩn nút download
            document.getElementById(`download-${order.ORDER_ID}`).style.display = 'none';
        }
    });
}

loadUserOrders();
</script>
