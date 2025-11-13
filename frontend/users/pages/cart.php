<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Shopping Cart | Luxury Food</title>
<style>
/* RESET */
* {margin:0;padding:0;box-sizing:border-box;}
body {
  font-family: "Poppins", sans-serif;
  background: #0a0a0a;
  color: #f5f5f5;
}

/* HERO */
.hero {
  position: relative;
  height: 35vh;
  display: flex;
  align-items: center;
  justify-content: center;
  text-align: center;
}
.hero::before {
  content:"";
  position:absolute;
  inset:0;
  background:linear-gradient(to bottom, rgba(0,0,0,0.7), #0a0a0a);
}
.hero-content {
  position: relative;
  z-index:10;
  animation: fadeIn 1.5s ease;
}
.hero h1 {
  font-size:3rem;
  color: gold;
  text-shadow: 0 0 20px rgba(255,215,0,0.4);
}
.hero p {
  margin-top:10px;
  font-size:1.1rem;
  color:#b87333;
}
@keyframes fadeIn {
  from{opacity:0;transform:translateY(30px);}
  to{opacity:1;transform:translateY(0);}
}

/* CONTAINER */
.container {
  max-width:1200px;
  margin:50px auto;
  padding:0 20px;
}

/* GRID */
.grid {
  display:grid;
  grid-template-columns: 1fr 350px;
  gap:40px;
}
@media(max-width:900px){
  .grid {grid-template-columns:1fr;}
}

/* CARD BASE */
.glass-card {
  background: rgba(255,255,255,0.03);
  border:1px solid rgba(218,165,32,0.15);
  border-radius:15px;
  transition:all 0.4s ease;
}
.glass-card:hover {
  border-color: gold;
  box-shadow: 0 0 25px rgba(255,215,0,0.1);
  transform: translateY(-3px);
}

/* CART ITEMS */
.cart-item {
  display:flex;
  gap:20px;
  padding:20px;
  align-items:center;
  border-bottom:1px solid rgba(218,165,32,0.1);
}
.cart-item img {
  width:90px;
  height:90px;
  object-fit:cover;
  border-radius:10px;
}
.cart-item h3 {
  font-size:1.2rem;
  color:#fff;
}
.cart-item .price {
  color:gold;
  font-weight:600;
}
.quantity-box {
  display:flex;
  align-items:center;
  border:1px solid rgba(218,165,32,0.2);
  border-radius:8px;
  overflow:hidden;
}
.quantity-box button {
  background:none;
  border:none;
  color:gold;
  font-weight:bold;
  width:32px;
  height:30px;
  cursor:pointer;
  transition:all 0.3s ease;
}
.quantity-box button:hover {
  background:rgba(255,215,0,0.1);
}
.quantity-box span {
  padding:0 10px;
  font-weight:600;
}
.remove {
  color:#ff5555;
  cursor:pointer;
  font-weight:600;
  transition: color 0.3s;
}
.remove:hover { color:#ff7777; }

/* ORDER SUMMARY */
.summary {
  padding:25px;
  position: sticky;
  top:80px;
}
.summary h2 {
  font-size:1.8rem;
  margin-bottom:20px;
}
.summary-row {
  display:flex;
  justify-content:space-between;
  margin-bottom:12px;
  font-size:1rem;
}
.summary-row span:last-child {
  font-weight:600;
}
.summary .total {
  border-top:1px solid rgba(218,165,32,0.15);
  padding-top:15px;
  margin-top:10px;
  font-size:1.3rem;
  display:flex;
  justify-content:space-between;
  font-weight:700;
  color:gold;
}
.btn-checkout {
  margin-top:25px;
  width:100%;
  padding:14px 0;
  background:linear-gradient(90deg, gold, #b87333);
  color:#000;
  font-weight:700;
  border:none;
  border-radius:10px;
  cursor:pointer;
  transition:all 0.3s ease;
  box-shadow:0 0 20px rgba(255,215,0,0.2);
}
.btn-checkout:hover {
  transform:scale(1.03);
  box-shadow:0 0 35px rgba(255,215,0,0.35);
}
.payment-methods {
  margin-top:30px;
  padding-top:15px;
  border-top:1px solid rgba(218,165,32,0.15);
}
.payment-methods h3 {
  margin-bottom:10px;
}
.method {
  display:inline-block;
  margin:5px;
  padding:6px 12px;
  border:1px solid rgba(218,165,32,0.15);
  border-radius:8px;
  background:rgba(255,255,255,0.03);
  font-size:0.9rem;
}

/* CONTINUE LINK */
.continue {
  display:inline-block;
  margin-top:20px;
  color:gold;
  font-weight:600;
  transition:color 0.3s;
}
.continue:hover {
  color:#ffeb7a;
}
</style>
</head>
<body>

<!-- HERO -->
<section class="hero">
  <div class="hero-content">
    <h1>🛒 Shopping Cart</h1>
    <p>Review your items before checkout</p>
  </div>
</section>

<!-- MAIN -->
<div class="container">
  <div class="grid">
    
    <!-- LEFT: CART ITEMS -->
    <div>
      <h2 style="font-size:1.8rem;margin-bottom:20px;">Cart Items (2)</h2>

      <div class="glass-card">
        <div class="cart-item">
          <img src="https://images.unsplash.com/photo-1505686994434-e3cc5abf1330?w=200" alt="Popcorn">
          <div style="flex:1;">
            <h3>Popcorn</h3>
            <p class="price">50.000đ</p>
          </div>
          <div style="text-align:right;">
            <div class="remove">Remove</div>
            <div class="quantity-box" style="margin-top:8px;">
              <button>-</button><span>2</span><button>+</button>
            </div>
          </div>
        </div>

        <div class="cart-item">
          <img src="https://images.unsplash.com/photo-1554866585-cd94860890b7?w=200" alt="Coca Cola">
          <div style="flex:1;">
            <h3>Coca Cola</h3>
            <p class="price">30.000đ</p>
          </div>
          <div style="text-align:right;">
            <div class="remove">Remove</div>
            <div class="quantity-box" style="margin-top:8px;">
              <button>-</button><span>1</span><button>+</button>
            </div>
          </div>
        </div>
      </div>

      <a href="#" class="continue">← Continue Shopping</a>
    </div>

    <!-- RIGHT: ORDER SUMMARY -->
    <div class="glass-card summary">
      <h2>Order Summary</h2>
      <div class="summary-row"><span>Subtotal</span><span>130.000đ</span></div>
      <div class="summary-row"><span>Tax (10%)</span><span>13.000đ</span></div>
      <div class="total"><span>Total</span><span>143.000đ</span></div>
      <button class="btn-checkout">Proceed to Checkout</button>

      <div class="payment-methods">
        <h3>We Accept</h3>
        <div class="method">💳 Card</div>
        <div class="method">🏦 Bank</div>
        <div class="method">📱 Momo</div>
        <div class="method">📲 QR</div>
      </div>
    </div>

  </div>
</div>

</body>
</html>
