<link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/cart.css">
<!-- HERO -->
<section class="hero">
  <div class="hero-content">
    <h1>Shopping Cart</h1>
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
