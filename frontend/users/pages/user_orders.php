<link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/user_orders.css">
<style>
  /* Nút thanh toán / đã thanh toán */
.btn-pay {
    display: inline-block;
    padding: 8px 20px;           /* khoảng cách trong nút */
    font-size: 0.95rem;          /* chữ vừa phải */
    font-weight: 600;
    border-radius: 8px;          /* bo góc */
    border: none;
    cursor: pointer;
    transition: background-color 0.3s, transform 0.2s;
    color: #ffffffff;
}

/* Chưa thanh toán */
.btn-pay:not([disabled]) {
    background-color: #ffa200ff;   /* xanh dương */
}

.btn-pay:not([disabled]):hover {
    background-color: #b37a00ff;
    transform: translateY(-2px); /* nhấn nổi bật khi hover */
}

/* Đã thanh toán */
.btn-pay[disabled] {
    background-color: #28a745;   /* xanh lá */
    cursor: default;
    opacity: 0.7;                /* mờ đi */
}
</style>
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

        const isPaid = payment?.PAYMENT_STATUS === 'Completed';
        const statusClass = isPaid ? 'done' : 'pending';
        const statusText = isPaid ? 'Đã thanh toán' : 'Chưa thanh toán';

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
                    <div class="${statusClass==='done'?'done-box':'qr-box'}" id="qr-container-${order.ORDER_ID}"></div>
                    <p style="font-size:0.8rem;color:#b87333;text-align:center;">
                        ${isPaid?'Hiển thị mã QR tại quầy':'Hiển thị mã QR tại quầy'}
                    </p>
                    <button class="btn-pay" id="btn-pay-${order.ORDER_ID}" ${isPaid?'disabled':''}>
                        ${isPaid?'Đã thanh toán':'Thanh toán'}
                    </button>
                </div>
            </div>
        `;

        container.appendChild(orderCard);

        // Tạo QR code (giả lập mã vé)
        const qrDiv = document.getElementById(`qr-container-${order.ORDER_ID}`);
        const qr = new QRCode(qrDiv, {
            text: `ORDER:${order.ORDER_ID}`, 
            width: 100,
            height: 100,
            colorDark : "#000000",
            colorLight : "#ffffff",
            correctLevel : QRCode.CorrectLevel.H
        });

        // Nút thanh toán
        const btnPay = document.getElementById(`btn-pay-${order.ORDER_ID}`);
        if(!isPaid){
            btnPay.addEventListener('click', () => {
                window.location.href = `index.php?page=payment&order_id=${order.ORDER_ID}`;
            });
        }
    });
}

loadUserOrders();
</script>
