<?php
require_once __DIR__ . '/../../config.php';
?>
<link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/home.css">
<link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/event_user.css">
</head>
<body>

<!-- Hero -->
<section class="hero">
  <div class="overlay"></div>
  
  <div class="container">
    <h1 style="font-size:2.5rem;">LiveMusic - Trải nghiệm âm nhạc sống động</h1>
    <p>Khám phá những sự kiện âm nhạc đỉnh cao, nơi cảm xúc và giai điệu hòa quyện.</p>
  </div>
</section>

<!-- Featured Events -->
<section>
  <div class="container">
    <h2>Sự kiện nổi bật</h2>
    <p>Đừng bỏ lỡ những buổi trình diễn đẳng cấp sắp tới</p>
    
    <div class="grid" id="eventsGrid"></div>
    <div style="text-align:center; margin-top:20px;">
      <a href="index.php?page=event" class="see-more-btn">Xem thêm</a>
    </div>
  </div>
</section>

<!-- Featured Artists -->
<section>
  <div class="container">
    <h2>Nghệ sĩ nổi bật</h2>
    <p>Những tài năng mang âm nhạc đến trái tim khán giả</p>
    <div class="artists" id="artistsContainer"></div>
    <button id="moreArtistsBtn" class="see-more-btn" style="display:none; margin:10px auto;">Xem thêm</button>
    <button id="lessArtistsBtn" class="see-more-btn" style="display:none;">Rút gọn</button>
  </div>
</section>

<script>
const eventsGrid = document.getElementById("eventsGrid");
const artistsContainer = document.getElementById("artistsContainer");
const moreArtistsBtn = document.getElementById("moreArtistsBtn");
const lessArtistsBtn = document.getElementById("lessArtistsBtn");

let allEvents = [];
let uniqueArtists = [];
let displayedArtistCount = 5;

// Load sự kiện và nghệ sĩ
async function loadEventsAndArtists() {
    try {
        const res = await fetch("http://localhost/PR_RESERVATION_FnB_FOR_LIVEMUSIC/api_gateway/index.php?service=admin&action=get_events");
        const data = await res.json();
        if(!data.success || !Array.isArray(data.data)){
            eventsGrid.innerHTML = "<p>Không thể tải sự kiện.</p>";
            return;
        }

        // Sắp xếp theo ngày mới nhất
        allEvents = data.data.sort((a,b) => new Date(b.date) - new Date(a.date));

        // Hiển thị 6 sự kiện đầu
        const firstSlice = allEvents.slice(0,6);
        eventsGrid.innerHTML = firstSlice.map(ev => `
            <div class="card">
                <img src="${ev.image_url}" alt="${ev.band}" />
                <div class="card-content">
                    <h3>${ev.band}</h3>
                    <p><strong>${ev.artist_name}</strong></p>
                    <p>${new Date(ev.date).toLocaleString("vi-VN")}</p>
                    <p>${ev.venue}</p>
                    <p class="price">${ev.price.toLocaleString()} VND</p>
                    <button class="btn-buy" onclick="viewEvent('${encodeURIComponent(ev.id)}')">Xem chi tiết</button>
                </div>
            </div>
        `).join("");

        // Tạo danh sách nghệ sĩ duy nhất
        const artistSet = new Set();
        uniqueArtists = [];
        allEvents.forEach(ev => {
            if(ev.artist_name && !artistSet.has(ev.artist_name)){
                artistSet.add(ev.artist_name);
                uniqueArtists.push({name: ev.artist_name, img: ev.img_artist});
            }
        });

        renderArtists();
        moreArtistsBtn.style.display = uniqueArtists.length > displayedArtistCount ? "block" : "none";

    } catch(err){
        console.error("Lỗi fetch events:", err);
        eventsGrid.innerHTML = "<p>Lỗi khi tải dữ liệu.</p>";
    }
}

function renderArtists() {
    artistsContainer.innerHTML = "";
    uniqueArtists.forEach((artist,index)=>{
        const artDiv = document.createElement("div");
        artDiv.classList.add("artist");
        artDiv.innerHTML = `<img src="${artist.img}" alt=""><h3>${artist.name}</h3>`;
        if(index >= displayedArtistCount) artDiv.style.display="none";
        artistsContainer.appendChild(artDiv);
    });
}

// Nút Xem thêm nghệ sĩ
moreArtistsBtn.onclick = () => {
    const hidden = Array.from(artistsContainer.children).filter((el,i)=>i>=displayedArtistCount);
    hidden.slice(0,5).forEach(el=>el.style.display="inline-block");
    displayedArtistCount += 5;
    if(displayedArtistCount >= uniqueArtists.length){
        moreArtistsBtn.style.display="none";
        lessArtistsBtn.style.display="block";
    }
};

// Nút Rút gọn nghệ sĩ
lessArtistsBtn.onclick = () => {
    Array.from(artistsContainer.children).forEach((el,i)=>{
        if(i>=5) el.style.display="none";
    });
    displayedArtistCount = 5;
    moreArtistsBtn.style.display = uniqueArtists.length > 5 ? "block" : "none";
    lessArtistsBtn.style.display = "none";
};

// Xem chi tiết event
function viewEvent(id){
    window.location.href = "index.php?page=event_details&id=" + encodeURIComponent(id);
}

// Load dữ liệu khi trang load
loadEventsAndArtists();
</script>

</body>
</html>
