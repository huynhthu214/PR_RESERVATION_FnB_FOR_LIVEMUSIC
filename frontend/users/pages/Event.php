<link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/event_user.css">

<div class="hero">
  <h1>Sự kiện trực tiếp & Đêm nhạc</h1>
  <p>Trải nghiệm nhịp điệu của thành phố — từ những đêm nhạc EDM sôi động đến những buổi tối nhạc jazz đầy cảm xúc.</p>
</div>

<div class="container">
  <div class="section-title">
    <h2>Sự kiện sắp tới</h2>
    <p>Đừng bỏ lỡ những màn trình diễn trực tiếp tuyệt vời này. Đặt vé ngay!</p>
  </div>

  <div class="grid" id="eventsGrid"></div>
  <div style="text-align:center; margin-top:20px;">
    <button id="loadMoreBtn" class="btn">Xem thêm</button>
  </div>
</div>
<script>
const grid = document.getElementById("eventsGrid");
const loadMoreBtn = document.getElementById("loadMoreBtn");

let allEvents = [];
let currentIndex = 0;
const pageSize = 6;

async function loadEvents() {
    try {
        const res = await fetch("/PR_RESERVATION_FnB_FOR_LIVEMUSIC/api_gateway/index.php?service=admin&action=get_events");
        const result = await res.json();

        if (!result.success || !Array.isArray(result.data)) {
            grid.innerHTML = "<p>Không thể tải sự kiện.</p>";
            loadMoreBtn.style.display = "none";
            return;
        }

        allEvents = result.data;
        renderEvents();
    } catch (err) {
        console.error(err);
        grid.innerHTML = "<p>Lỗi khi tải dữ liệu.</p>";
        loadMoreBtn.style.display = "none";
    }
}

// ==== Thay thế đoạn renderEvents và viewEvent ====
function renderEvents() {
    const slice = allEvents.slice(currentIndex, currentIndex + pageSize);
    grid.innerHTML += slice.map(ev => `
        <div class="card">
            <img src="${ev.image_url}" alt="${ev.band}" />
            <div class="card-content">
                <h3>${ev.band}</h3>
                <p><strong>${ev.artist_name}</strong></p>
                <p>${new Date(ev.date).toLocaleString("vi-VN")}</p>
                <p>${ev.venue_name} — ${ev.venue_address}</p>
                <p class="price">${ev.price.toLocaleString()} VND</p>
                <button class="btn-buy" onclick="viewEvent('${encodeURIComponent(ev.id)}')">Xem chi tiết</button>
            </div>
        </div>
    `).join("");

    currentIndex += pageSize;

    if (currentIndex >= allEvents.length) {
        loadMoreBtn.style.display = "none";
    }
}

function viewEvent(id) {
    window.location.href = "index.php?page=event_details&id=" + encodeURIComponent(id);
}
// ==== Kết thúc đoạn sửa ====

loadMoreBtn.addEventListener("click", renderEvents);

// Load 6 event đầu tiên
loadEvents();
</script>