<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>LiveMusic | Trang chủ</title>
<style>
body {
  margin: 0;
  font-family: "Poppins", sans-serif;
  background: #0c0c0c;
  color: #f8f8f8;
  line-height: 1.6;
}

/* Container & Section spacing */
section {
  padding: 80px 20px;
  text-align: center;
}
.container {
  max-width: 1200px;
  margin: auto;
}

/* Headings */
h1, h2, h3 {
  color: gold;
  margin-bottom: 1rem;
  letter-spacing: 0.5px;
}
p {
  color: #ccc;
  margin-bottom: 1rem;
}

/* Featured Events */
.events {
  display: grid;
  grid-template-columns: repeat(auto-fit,minmax(300px,1fr));
  gap: 1.5rem;
  margin-top: 2rem;
}
.event {
  background: rgba(255,255,255,0.05);
  border: 1px solid rgba(218,165,32,0.2);
  border-radius: 15px;
  overflow: hidden;
  transition: all 0.4s;
}
.event:hover {
  transform: scale(1.03);
  border-color: gold;
  box-shadow: 0 0 20px rgba(255,215,0,0.15);
}
.event img {
  width: 100%;
  height: 200px;
  object-fit: cover;
}
.event .info {
  padding: 1rem 1.5rem;
  text-align: left;
}
.event .title {
  font-weight: 600;
  color: gold;
  font-size: 1.1rem;
}
.event .artist {
  color: #b87333;
  font-size: 0.95rem;
}
.event .details {
  font-size: 0.85rem;
  color: #aaa;
  margin-top: 0.5rem;
}

/* Artists */
.artists {
  display: grid;
  grid-template-columns: repeat(auto-fit,minmax(180px,1fr));
  gap: 2rem;
  margin-top: 2rem;
}
.artist {
  cursor: pointer;
  transition: all 0.4s;
}
.artist img {
  width: 100%;
  border-radius: 50%;
  border: 2px solid rgba(218,165,32,0.2);
  transition: all 0.4s;
}
.artist:hover img {
  border-color: gold;
  transform: scale(1.08);
  box-shadow: 0 0 20px rgba(255,215,0,0.2);
}
.artist h3 {
  color: gold;
  margin-top: 0.8rem;
  font-size: 1rem;
}
.artist p {
  color: #b87333;
  font-size: 0.9rem;
}

/* Genres */
.genres {
  display: flex;
  flex-wrap: wrap;
  justify-content: center;
  gap: 1rem;
  margin-top: 2rem;
}
.genre {
  padding: 0.75rem 1.5rem;
  border: 1px solid rgba(218,165,32,0.3);
  border-radius: 50px;
  background: rgba(255,255,255,0.03);
  color: #f8f8f8;
  font-weight: 500;
  transition: all 0.3s;
}
.genre:hover {
  border-color: gold;
  color: gold;
  transform: scale(1.05);
  box-shadow: 0 0 10px rgba(255,215,0,0.15);
}

/* Gallery */
.gallery {
  display: grid;
  grid-template-columns: repeat(auto-fit,minmax(250px,1fr));
  gap: 1rem;
  margin-top: 2rem;
}
.gallery img {
  width: 100%;
  height: 180px;
  object-fit: cover;
  border-radius: 12px;
  transition: all 0.5s;
  border: 1px solid rgba(218,165,32,0.15);
}
.gallery img:hover {
  transform: scale(1.05);
  border-color: gold;
  box-shadow: 0 0 15px rgba(255,215,0,0.2);
}

/* Newsletter */
.newsletter {
  background: rgba(255,255,255,0.05);
  border: 1px solid rgba(218,165,32,0.3);
  border-radius: 20px;
  padding: 50px 20px;
  max-width: 600px;
  margin: 60px auto 0;
}
.newsletter input {
  width: 70%;
  padding: 0.8rem 1rem;
  border-radius: 50px;
  border: 1px solid rgba(218,165,32,0.3);
  background: rgba(0,0,0,0.6);
  color: white;
  outline: none;
  transition: all 0.3s;
}
.newsletter input:focus {
  border-color: gold;
  box-shadow: 0 0 10px rgba(255,215,0,0.3);
}
.newsletter button {
  padding: 0.8rem 1.5rem;
  border: none;
  border-radius: 50px;
  background: linear-gradient(90deg,gold,#b87333);
  color: #000;
  font-weight: 700;
  cursor: pointer;
  margin-left: 10px;
  transition: all 0.3s;
}
.newsletter button:hover {
  transform: scale(1.05);
  box-shadow: 0 0 15px rgba(255,215,0,0.3);
}

/* About */
.about {
  max-width: 700px;
  margin: auto;
}
.about a {
  color: gold;
  text-decoration: none;
  font-weight: 600;
  transition: color 0.3s;
}
.about a:hover {
  color: #b87333;
}
</style>
</head>
<body>

<!-- Hero -->
<section>
  <div class="container">
    <h1 style="font-size:2.5rem;">🎵 LiveMusic - Trải nghiệm âm nhạc sống động</h1>
    <p>Khám phá những sự kiện âm nhạc đỉnh cao, nơi cảm xúc và giai điệu hòa quyện.</p>
  </div>
</section>

<!-- Featured Events -->
<section>
  <div class="container">
    <h2>🔥 Sự kiện nổi bật</h2>
    <p>Đừng bỏ lỡ những buổi trình diễn đẳng cấp sắp tới</p>
    <div class="events">
      <div class="event">
        <img src="https://images.unsplash.com/photo-1470229722913-7c0e2dbbafd3?q=80&w=2070" alt="">
        <div class="info">
          <div class="title">Electronic Night Vibes</div>
          <div class="artist">DJ Pulse & The Synthwave</div>
          <div class="details">15/12/2024 - The Neon Arena | $45</div>
        </div>
      </div>
      <div class="event">
        <img src="https://images.unsplash.com/photo-1501612780327-45045538702b?q=80&w=2070" alt="">
        <div class="info">
          <div class="title">Rock Legends Live</div>
          <div class="artist">The Thunder Band</div>
          <div class="details">20/12/2024 - Rock Hall | $60</div>
        </div>
      </div>
      <div class="event">
        <img src="https://images.unsplash.com/photo-1511192336575-5a79af67a629?q=80&w=2072" alt="">
        <div class="info">
          <div class="title">Jazz & Soul Evening</div>
          <div class="artist">Smooth Notes Collective</div>
          <div class="details">22/12/2024 - Blue Note Lounge | $38</div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Featured Artists -->
<section>
  <div class="container">
    <h2>🎤 Nghệ sĩ nổi bật</h2>
    <p>Những tài năng mang âm nhạc đến trái tim khán giả</p>
    <div class="artists">
      <div class="artist">
        <img src="https://images.unsplash.com/photo-1571330735066-03aaa9429d89?w=400&h=400&fit=crop" alt="">
        <h3>DJ Pulse</h3>
        <p>Electronic</p>
      </div>
      <div class="artist">
        <img src="https://images.unsplash.com/photo-1498038432885-c6f3f1b912ee?w=400&h=400&fit=crop" alt="">
        <h3>The Thunder Band</h3>
        <p>Rock</p>
      </div>
      <div class="artist">
        <img src="https://images.unsplash.com/photo-1511367461989-f85a21fda167?w=400&h=400&fit=crop" alt="">
        <h3>Smooth Notes</h3>
        <p>Jazz</p>
      </div>
      <div class="artist">
        <img src="https://images.unsplash.com/photo-1506157786151-b8491531f063?w=400&h=400&fit=crop" alt="">
        <h3>MC Flow</h3>
        <p>Hip Hop</p>
      </div>
    </div>
  </div>
</section>

<!-- Explore by Genre -->
<section>
  <div class="container">
    <h2>💿 Khám phá theo thể loại</h2>
    <p>Tìm phong cách âm nhạc bạn yêu thích</p>
    <div class="genres">
      <div class="genre">Electronic</div>
      <div class="genre">Rock</div>
      <div class="genre">Jazz</div>
      <div class="genre">Pop</div>
      <div class="genre">Indie</div>
      <div class="genre">EDM</div>
    </div>
  </div>
</section>

<!-- Gallery -->
<section>
  <div class="container">
    <h2>📸 Khoảnh khắc sân khấu</h2>
    <p><i>"Mỗi nhịp beat kể một câu chuyện"</i></p>
    <div class="gallery">
      <img src="https://images.unsplash.com/photo-1540039155733-5bb30b53aa14?w=600&h=400&fit=crop" alt="">
      <img src="https://images.unsplash.com/photo-1514525253161-7a46d19cd819?w=600&h=400&fit=crop" alt="">
      <img src="https://images.unsplash.com/photo-1501281668745-f7f57925c3b4?w=600&h=400&fit=crop" alt="">
      <img src="https://images.unsplash.com/photo-1516450360452-9312f5e86fc7?w=600&h=400&fit=crop" alt="">
      <img src="https://images.unsplash.com/photo-1493225457124-a3eb161ffa5f?w=600&h=400&fit=crop" alt="">
      <img src="https://images.unsplash.com/photo-1524368535928-5b5e00ddc76b?w=600&h=400&fit=crop" alt="">
    </div>
  </div>
</section>

<!-- Newsletter -->
<section>
  <div class="newsletter">
    <h2>💌 Đăng ký nhận tin</h2>
    <p>Nhận thông báo về các buổi diễn và ưu đãi mới nhất</p>
    <form>
      <input type="email" placeholder="Nhập email của bạn">
      <button>Đăng ký</button>
    </form>
  </div>
</section>

<!-- About -->
<section>
  <div class="about">
    <h2>🏢 Về LiveMusic</h2>
    <p>Thành lập năm 2024, LiveMusic kết nối người hâm mộ và nghệ sĩ qua những trải nghiệm âm nhạc sống động. Chúng tôi đam mê lan tỏa sức mạnh của âm nhạc.</p>
    <a href="#">Tìm hiểu thêm</a>
  </div>
</section>

</body>
</html>
