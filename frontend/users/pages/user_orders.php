<link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/user_orders.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>

<style>
/* Nút thanh toán */
.btn-pay {
    display:inline-block;
    padding:8px 20px;
    font-size:0.95rem;
    font-weight:600;
    border-radius:8px;
    border:none;
    cursor:pointer;
    transition:0.3s;
    color:#fff;
}
.btn-pay:not([disabled]){background:#ffa200;}
.btn-pay:not([disabled]):hover{background:#b37a00; transform:translateY(-2px);}
.btn-pay[disabled]{background:#28a745; cursor:default; opacity:0.7;}

/* Order card */
.order-card{background:black;padding:15px;margin-bottom:20px;border-radius:10px;box-shadow:0 3px 10px rgba(0,0,0,0.1);}
.order-header{display:flex;justify-content:space-between;align-items:center;margin-bottom:10px;}
.status.pending{color:#ff9800;font-weight:bold;}
.status.done{color:#28a745;font-weight:bold;}
.order-body{display:flex;justify-content:space-between;}
.order-items{flex:1;margin-right:20px;}
.order-side{width:150px;text-align:center;}
.qr-box,.done-box{margin:10px auto;width:100px;height:100px;}

/* Flex row cho item */
.item-row{display:flex;justify-content:space-between;padding:4px 0;}
.item-row span{flex:1;text-align:center;}
.item-row span:first-child{text-align:left;}
.item-row span:last-child{text-align:right;}
.order-total{display:flex;justify-content:space-between;font-weight:bold;margin-top:10px;}
.reservation-info p{margin:3px 0;}
</style>

<section class="hero">
  <div class="hero-content">
    <h1>Đơn hàng của tôi</h1>
    <p>Xem lại các món ăn & đồ uống, vé sự kiện đã đặt</p>
  </div>
</section>

<div class="container" id="orders-container"></div>

<script>
async function loadUserOrders(){
    const res = await fetch('/PR_RESERVATION_FnB_FOR_LIVEMUSIC/api_gateway/index.php?service=order&action=get_user_order');
    const data = await res.json();
    if(!data.success){ alert(data.message||'Lỗi tải đơn hàng'); return; }

    const container = document.getElementById('orders-container');
    container.innerHTML='';

    data.orders.forEach(o=>{
        const order=o.order, items=o.items, payment=o.payment, reservation=o.reservation;
        const isPaid = payment?.PAYMENT_STATUS==='Completed';
        const statusClass = isPaid?'done':'pending';
        const statusText = isPaid?'Đã thanh toán':'Chưa thanh toán';
        // Ghế từ ORDER.seats (dùng đúng key SEAT_NUMBER và PRICE)
        const seatRows = order?.seats?.map(s => `
            <div class="item-row">
                <span>${s.number || 'Chưa rõ'} (${s.type || 'Standard'})</span>
                <span>1</span>
                <span>${s.price?.toLocaleString() || '0'}đ</span>
            </div>
        `).join('') || '';

        // Đồ ăn / thức uống
        const foodRows = items?.map(i=>`
            <div class="item-row">
                <span>${i.NAME}</span>
                <span>${i.QUANTITY}</span>
                <span>${(i.UNIT_PRICE*i.QUANTITY).toLocaleString()}đ</span>
            </div>
        `).join('') || '';

        const orderCard = document.createElement('div');
        orderCard.className='order-card';
        orderCard.innerHTML=`
            <div class="order-header">
                <span class="status ${statusClass}">${statusText}</span>
                <h3>Order #${order.ORDER_ID}</h3>
                <p>${order.ORDER_TIME}</p>
            </div>
            <div class="order-body">
                <div class="order-items">
                    ${seatRows?`<h4>Chỗ ngồi</h4>${seatRows}`:''}
                    ${foodRows?`<h4>Đồ ăn / đồ uống</h4>${foodRows}`:''}
                    <div class="order-total">
                        <span>Tổng:</span><span>${order.TOTAL_AMOUNT.toLocaleString()}đ</span>
                    </div>
                    ${reservation?`<div class="reservation-info">
                        <p><b>Sự kiện:</b> ${reservation.EVENT_NAME}</p>
                        <p><b>Ngày diễn ra:</b> ${reservation.EVENT_DATE} ${reservation.START_TIME} - ${reservation.END_TIME}</p>
                        <p><b>Địa điểm:</b> ${reservation.VENUE_NAME}, ${reservation.VENUE_ADDRESS}</p>
                    </div>`:''}
                </div>
                <div class="order-side">
                    <div class="${isPaid?'done-box':'qr-box'}" id="qr-container-${order.ORDER_ID}"></div>
                    <p style="font-size:0.8rem;color:#b87333;text-align:center;">
                        Hiển thị mã QR tại quầy
                    </p>
                    <button class="btn-pay" id="btn-pay-${order.ORDER_ID}" ${isPaid?'disabled':''}>
                        ${isPaid?'Đã thanh toán':'Thanh toán'}
                    </button>
                </div>
            </div>
        `;
        container.appendChild(orderCard);

        // QR code giả lập
        new QRCode(document.getElementById(`qr-container-${order.ORDER_ID}`),{
            text:`ORDER:${order.ORDER_ID}`,
            width:100, height:100,
            colorDark:"#000000", colorLight:"#ffffff",
            correctLevel:QRCode.CorrectLevel.H
        });

        // Nút thanh toán
        const btnPay=document.getElementById(`btn-pay-${order.ORDER_ID}`);
        if(!isPaid){
            btnPay.addEventListener('click', ()=>{
                window.location.href=`index.php?page=payment&order_id=${order.ORDER_ID}`;
            });
        }
    });
}
loadUserOrders();
</script>
