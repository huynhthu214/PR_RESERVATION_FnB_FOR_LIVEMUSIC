<?php
require_once __DIR__ . '/../../config.php';
?>

<link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/order_user.css">
<link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/modal.css">

<!-- HERO -->
<section class="hero">
    <img src="https://images.unsplash.com/photo-1514933651103-005eec06c04b?w=1200" alt="">
    <div class="hero-content">
        <h1>Đồ ăn và Thức uống</h1>
        <p>Thưởng thức hương vị đẳng cấp trong không gian âm nhạc sang trọng</p>
    </div>
</section>

<!-- CATEGORY FILTER -->
<section>
    <div class="categories">
        <button class="category-btn active">Tất cả</button>
        <button class="category-btn">Đồ ăn</button>
        <button class="category-btn">Nước uống</button>
    </div>
</section>

<!-- FOOD GRID -->
<section>
    <div class="container food-grid" id="menu-list"></div>
</section>

<!-- CART SIDEBAR -->
<div id="cart-sidebar" class="cart-sidebar">
    <div class="cart-header">
        <h3>Giỏ hàng</h3>
        <div id="cart-items-count" class="cart-count"></div>
    </div>
    <div id="cart-items"></div>
    <div class="cart-footer">
        <div>Tổng cộng: <span id="cart-total">0đ</span></div>
        <button id="cart-continue" class="btn-buy-full">Tiếp tục</button>
    </div>
</div>

<!-- Toggle Button -->
<button id="btn-toggle-cart" class="btn-toggle-cart">🧺<span id="toggle-count">0</span></button>

<script>
window.addEventListener("DOMContentLoaded", async () => {

    const grid = document.getElementById("menu-list");
    const cartSidebar = document.getElementById("cart-sidebar");
    const cartItemsEl = document.getElementById("cart-items");
    const cartTotalEl = document.getElementById("cart-total");
    const cartContinueBtn = document.getElementById("cart-continue");
    const btnToggleCart = document.getElementById("btn-toggle-cart");
    const toggleCount = document.getElementById("toggle-count");

    // ===================== RENDER CART =====================
    function renderCart(cart){
        cartItemsEl.innerHTML = "";
        let total = 0;
        let count = 0;

        cart.forEach(item => {
            total += item.price * item.quantity;
            count += item.quantity;

            const div = document.createElement("div");
            div.className = "cart-item";
            div.innerHTML = `
                <span>${item.name} x ${item.quantity}</span>
                <span>${(item.price * item.quantity).toLocaleString()}đ</span>
                <div>
                    <button class="btn-inc">+</button>
                    <button class="btn-dec">-</button>
                    <button class="btn-del">🗑️</button>
                </div>
            `;
            cartItemsEl.appendChild(div);

            div.querySelector(".btn-inc").onclick = () => updateCartItem(item.item_id, item.quantity + 1);
            div.querySelector(".btn-dec").onclick = () => updateCartItem(item.item_id, item.quantity - 1);
            div.querySelector(".btn-del").onclick = () => updateCartItem(item.item_id, 0);
        });

        cartTotalEl.textContent = total.toLocaleString() + "đ";
        toggleCount.textContent = count;
    }

    // ===================== UPDATE CART ITEM =====================
    async function updateCartItem(item_id, quantity){
        try {
            const res = await fetch("/PR_RESERVATION_FnB_FOR_LIVEMUSIC/api_gateway/index.php?service=order&action=update_cart_item", {
                method: "POST",
                headers: { "Content-Type":"application/json" },
                body: JSON.stringify({ item_id, quantity })
            });
            const data = await res.json();
            if(data.success){
                renderCart(data.cart);
            } else alert(data.message || "Lỗi cập nhật giỏ hàng");
        } catch(err){ console.error(err); }
    }

    // ===================== LOAD CART =====================
    async function loadCart(){
        try{
            const res = await fetch("/PR_RESERVATION_FnB_FOR_LIVEMUSIC/api_gateway/index.php?service=order&action=get_cart_count");
            const data = await res.json();
            if(data.success){
                renderCart(data.cart);
                cartSidebar.style.display = "flex";
            }
        } catch(err){ console.error(err); }
    }

    // ===================== LOAD MENU =====================
    async function loadMenu() {
        try {
            const res = await fetch("/PR_RESERVATION_FnB_FOR_LIVEMUSIC/api_gateway/index.php?service=admin&action=get_menu_items");
            const items = await res.json();

            if(!Array.isArray(items) || items.length === 0){
                grid.innerHTML = "<p style='text-align:center;'>Không có món</p>";
                return;
            }

            grid.innerHTML = items.map(item => `
                <div class="food-item" data-id="${item.ITEM_ID}" data-category="${item.CATEGORY}">
                    <div class="overlay"></div>
                    <div class="category">${item.CATEGORY}</div>
                    <div class="info">
                        <h3>${item.NAME}</h3>
                        <div class="price">${item.PRICE.toLocaleString()}đ</div>
                        <div class="btn-group">
                            <button class="btn-cart">Thêm</button>
                        </div>
                    </div>
                </div>
            `).join("");

            // ==== Thêm món vào giỏ hàng ====
            grid.querySelectorAll(".btn-cart").forEach(btn => {
                btn.addEventListener("click", async e => {
                    e.stopPropagation();
                    const card = btn.closest(".food-item");
                    const id = card.dataset.id;
                    const name = card.querySelector("h3").textContent;
                    const price = parseInt(card.querySelector(".price").textContent.replace(/\D/g,''));

                    try {
                        const res = await fetch("/PR_RESERVATION_FnB_FOR_LIVEMUSIC/api_gateway/index.php?service=order&action=add_to_session", {
                            method: "POST",
                            headers: { "Content-Type": "application/json" },
                            body: JSON.stringify({ item_id: id, name, price, quantity: 1 })
                        });
                        const data = await res.json();
                        if(data.success){
                            renderCart(data.cart);
                            cartSidebar.style.display = "flex"; // luôn hiển thị sidebar
                        } else alert(data.message || "Lỗi thêm món vào giỏ hàng");
                    } catch(err) {
                        console.error(err);
                        alert("Lỗi thêm món vào giỏ hàng");
                    }
                });
            });

        } catch(err){
            console.error(err);
            grid.innerHTML = "<p style='text-align:center;'>Lỗi tải menu</p>";
        }
    }

    // ===================== CART CONTINUE =====================
    cartContinueBtn.onclick = async () => {
        try {
            const res = await fetch("/PR_RESERVATION_FnB_FOR_LIVEMUSIC/api_gateway/index.php?service=order&action=get_cart_count");
            const data = await res.json();
            if(data.count > 0){
                window.location.href = "index.php?page=payment";
            } else {
                alert("Bạn chưa chọn món nào!");
            }
        } catch(err){ console.error(err); }
    }

    // ===================== CATEGORY FILTER =====================
    document.querySelectorAll(".category-btn").forEach(btn => {
        btn.addEventListener("click", () => {
            const selectedCategory = btn.textContent.trim().toLowerCase();
            document.querySelectorAll(".category-btn").forEach(b => b.classList.remove("active"));
            btn.classList.add("active");
            document.querySelectorAll(".food-item").forEach(item => {
                const itemCategory = item.dataset.category.toLowerCase();
                item.style.display = (selectedCategory === "all" || itemCategory === selectedCategory) ? "block" : "none";
            });
        });
    });

    // ===================== CART TOGGLE =====================
    btnToggleCart.addEventListener("click", () => {
        cartSidebar.classList.toggle("collapsed");
    });

    // ===================== INITIAL LOAD =====================
    await loadMenu();
    await loadCart();
    
    cartContinueBtn.onclick = async () => {
    try {
        const res = await fetch("/PR_RESERVATION_FnB_FOR_LIVEMUSIC/api_gateway/index.php?service=order&action=get_cart_count");
        const data = await res.json();
        if(data.count > 0){
            // Lưu cart vào session trước
            await fetch('save_session_order.php', {
                method:'POST',
                headers:{'Content-Type':'application/json'},
                body: JSON.stringify({order_menu: data.cart})
            });
            window.location.href = "index.php?page=payment";
        } else alert("Bạn chưa chọn món nào!");
    } catch(err){ console.error(err); }
}

});
</script>

