<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Food & Drinks | Luxury Menu</title>
<style>
/* ======= RESET ======= */
* {
  box-sizing: border-box;
  margin: 0;
  padding: 0;
}
body {
  font-family: "Poppins", sans-serif;
  background: #0a0a0a;
  color: #f5f5f5;
  overflow-x: hidden;
}
h1, h2, h3 {
  font-weight: 600;
}

/* ======= HERO ======= */
.hero {
  position: relative;
  height: 45vh;
  display: flex;
  align-items: center;
  justify-content: center;
  overflow: hidden;
}
.hero img {
  position: absolute;
  width: 100%;
  height: 100%;
  object-fit: cover;
  filter: brightness(0.5);
  transform: scale(1.1);
  transition: transform 8s ease;
}
.hero:hover img {
  transform: scale(1.2);
}
.hero::after {
  content: "";
  position: absolute;
  inset: 0;
  background: linear-gradient(to bottom, rgba(0,0,0,0.6), #0a0a0a);
}
.hero-content {
  position: relative;
  z-index: 10;
  text-align: center;
}
.hero h1 {
  font-size: 3.2rem;
  color: gold;
  text-shadow: 0 0 20px rgba(255,215,0,0.3);
  animation: fadeInDown 1.5s ease;
}
.hero p {
  margin-top: 10px;
  font-size: 1.2rem;
  color: #b87333;
  animation: fadeInUp 1.8s ease;
}

@keyframes fadeInDown {
  from { opacity: 0; transform: translateY(-30px); }
  to { opacity: 1; transform: translateY(0); }
}
@keyframes fadeInUp {
  from { opacity: 0; transform: translateY(30px); }
  to { opacity: 1; transform: translateY(0); }
}

/* ======= CATEGORY FILTER ======= */
section {
  padding: 60px 20px;
  text-align: center;
}
.categories {
  display: flex;
  justify-content: center;
  flex-wrap: wrap;
  gap: 1rem;
  margin-bottom: 40px;
}
.category-btn {
  padding: 10px 25px;
  border-radius: 8px;
  border: 1px solid rgba(218,165,32,0.4);
  background: rgba(255,255,255,0.03);
  color: #f5f5f5;
  font-weight: 600;
  letter-spacing: 0.5px;
  cursor: pointer;
  transition: all 0.35s ease;
}
.category-btn:hover {
  border-color: gold;
  color: gold;
  box-shadow: 0 0 20px rgba(255,215,0,0.3);
  transform: translateY(-2px) scale(1.05);
}

/* ======= FOOD GRID ======= */
.container {
  max-width: 1200px;
  margin: auto;
}
.food-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(270px, 1fr));
  gap: 1.5rem;
}
.food-item {
  position: relative;
  border-radius: 15px;
  overflow: hidden;
  border: 1px solid rgba(218,165,32,0.15);
  background: rgba(255,255,255,0.03);
  transition: all 0.4s ease;
  cursor: pointer;
}
.food-item:hover {
  transform: scale(1.04);
  border-color: gold;
  box-shadow: 0 0 25px rgba(255,215,0,0.15);
}
.food-item img {
  width: 100%;
  height: 200px;
  object-fit: cover;
  transition: transform 0.8s ease;
}
.food-item:hover img {
  transform: scale(1.1);
}
.food-item .overlay {
  position: absolute;
  inset: 0;
  background: linear-gradient(to top, rgba(0,0,0,0.8), transparent 60%);
  opacity: 0;
  transition: opacity 0.4s ease;
}
.food-item:hover .overlay {
  opacity: 1;
}
.food-item .info {
  position: absolute;
  bottom: 0;
  width: 100%;
  padding: 20px;
  text-align: left;
  transform: translateY(30px);
  opacity: 0;
  transition: all 0.4s ease;
}
.food-item:hover .info {
  transform: translateY(0);
  opacity: 1;
}
.food-item h3 {
  color: gold;
  font-size: 1.3rem;
  margin-bottom: 5px;
}
.food-item .price {
  color: #b87333;
  font-weight: bold;
  font-size: 1.1rem;
}
.food-item .category {
  position: absolute;
  top: 10px;
  right: 10px;
  padding: 5px 10px;
  font-size: 0.8rem;
  background: rgba(0,0,0,0.7);
  color: gold;
  border-radius: 20px;
  border: 1px solid rgba(255,215,0,0.3);
}

/* ======= BUTTON BUY ======= */
.btn-cart {
  display: inline-block;
  margin-top: 10px;
  background: rgba(255,215,0,0.3);
  color: #000;
  padding: 8px 16px;
  border: none;
  border-radius: 8px;
  font-weight: 600;
  transition: all 0.3s ease;
}
.btn-cart:hover {
  border-color: gold;
  color: gold;
  transform: scale(1.08);
}
.btn-buy {
  display: inline-block;
  margin-top: 10px;
  background: linear-gradient(90deg, gold, #b87333);
  color: #000;
  padding: 8px 16px;
  border: none;
  border-radius: 8px;
  font-weight: 600;
  transition: all 0.3s ease;
  box-shadow: 0 0 15px rgba(255,215,0,0.25);
}
.btn-buy:hover {
  transform: scale(1.08);
  box-shadow: 0 0 25px rgba(255,215,0,0.35);
}
</style>
</head>
<body>

<!-- HERO -->
<section class="hero">
  <img src="https://images.unsplash.com/photo-1514933651103-005eec06c04b?w=1200" alt="">
  <div class="hero-content">
    <h1>🍸 Food & Drinks</h1>
    <p>Thưởng thức hương vị đẳng cấp trong không gian âm nhạc sang trọng</p>
  </div>
</section>

<!-- CATEGORY FILTER -->
<section>
  <div class="categories">
    <button class="category-btn">All</button>
    <button class="category-btn">Snacks</button>
    <button class="category-btn">Drinks</button>
  </div>
</section>

<!-- FOOD GRID -->
<section>
  <div class="container food-grid">
    
    <div class="food-item">
      <img src="https://images.unsplash.com/photo-1505686994434-e3cc5abf1330?w=400" alt="">
      <div class="overlay"></div>
      <div class="category">Snacks</div>
      <div class="info">
        <h3>Popcorn</h3>
        <div class="price">50.000đ</div>
        <button class="btn-cart">🛒 Giỏ hàng</button>
        <button class="btn-buy">⚡ Mua ngay</button>
      </div>
    </div>

    <div class="food-item">
      <img src="https://images.unsplash.com/photo-1513456852971-30c0b8199d4d?w=400" alt="">
      <div class="overlay"></div>
      <div class="category">Snacks</div>
      <div class="info">
        <h3>Nachos</h3>
        <div class="price">70.000đ</div>
        <button class="btn-cart">🛒 Giỏ hàng</button>
        <button class="btn-buy">⚡ Mua ngay</button>
      </div>
    </div>

    <div class="food-item">
      <img src="https://images.unsplash.com/photo-1612392062798-2c7c1f96061e?w=400" alt="">
      <div class="overlay"></div>
      <div class="category">Snacks</div>
      <div class="info">
        <h3>Hot Dog</h3>
        <div class="price">60.000đ</div>
        <button class="btn-cart">🛒 Giỏ hàng</button>
        <button class="btn-buy">⚡ Mua ngay</button>
      </div>
    </div>

    <div class="food-item">
      <img src="https://images.unsplash.com/photo-1513104890138-7c749659a591?w=400" alt="">
      <div class="overlay"></div>
      <div class="category">Snacks</div>
      <div class="info">
        <h3>Pizza Slice</h3>
        <div class="price">80.000đ</div>
        <button class="btn-cart">🛒 Giỏ hàng</button>
        <button class="btn-buy">⚡ Mua ngay</button>
      </div>
    </div>

    <div class="food-item">
      <img src="https://images.unsplash.com/photo-1576107232684-1279f390859f?w=400" alt="">
      <div class="overlay"></div>
      <div class="category">Snacks</div>
      <div class="info">
        <h3>French Fries</h3>
        <div class="price">45.000đ</div>
        <button class="btn-cart">🛒 Giỏ hàng</button>
        <button class="btn-buy">⚡ Mua ngay</button>
      </div>
    </div>

    <div class="food-item">
      <img src="https://images.unsplash.com/photo-1554866585-cd94860890b7?w=400" alt="">
      <div class="overlay"></div>
      <div class="category">Drinks</div>
      <div class="info">
        <h3>Coca Cola</h3>
        <div class="price">30.000đ</div>
        <button class="btn-cart">🛒 Giỏ hàng</button>
        <button class="btn-buy">⚡ Mua ngay</button>
      </div>
    </div>

    <div class="food-item">
      <img src="https://images.unsplash.com/photo-1629203851122-3726ecdf080e?w=400" alt="">
      <div class="overlay"></div>
      <div class="category">Drinks</div>
      <div class="info">
        <h3>Pepsi</h3>
        <div class="price">30.000đ</div>
        <button class="btn-cart">🛒 Giỏ hàng</button>
        <button class="btn-buy">⚡ Mua ngay</button>
      </div>
    </div>

    <div class="food-item">
      <img src="https://images.unsplash.com/photo-1600271886742-f049cd451bba?w=400" alt="">
      <div class="overlay"></div>
      <div class="category">Drinks</div>
      <div class="info">
        <h3>Orange Juice</h3>
        <div class="price">40.000đ</div>
        <button class="btn-cart">🛒 Giỏ hàng</button>
        <button class="btn-buy">⚡ Mua ngay</button>
      </div>
    </div>

  </div>
</section>

</body>
</html>
