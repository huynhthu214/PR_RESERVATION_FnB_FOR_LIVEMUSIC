<link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/contact.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

<div class="container">
  <div class="hero">
    <h1>Chúng tôi có thể giúp gì cho bạn?</h1>
    <p>Tìm câu trả lời nhanh cho các câu hỏi thường gặp hoặc liên hệ trực tiếp với đội ngũ hỗ trợ của chúng tôi.</p>
  </div>

  <div class="grid lg-2">
    <!-- FAQ -->
    <div class="card">
      <h2>Câu Hỏi Thường Gặp</h2>
      <div class="accordion" id="faqAccordion">
        <?php
        function loadCmsContent($type) {
            $url = 'http://localhost/PR_RESERVATION_FnB_FOR_LIVEMUSIC/api_gateway/index.php?service=admin&action=get_content&type=' . urlencode($type);
            $json = @file_get_contents($url);
            if ($json === false) {
                echo '<p style="color:#999; text-align:center;">Đang tải FAQ...</p>';
                return;
            }
            $data = json_decode($json, true);
            if ($data && $data['success']) {
                echo $data['content'];
            } else {
                echo '<p style="color:#999; text-align:center;">Chưa có câu hỏi nào.</p>';
            }
        }
        loadCmsContent('faqs');
        ?>
      </div>
    </div>

    <!-- Form liên hệ -->
    <div class="card">
      <h2>Gửi Tin Nhắn Cho Chúng Tôi</h2>
      <form id="contactForm">
        <label>Họ và tên</label>
        <input type="text" name="name" placeholder="Nguyễn Văn A" required />

        <label>Địa chỉ email</label>
        <input type="email" name="email" placeholder="bạn@email.com" required />

        <label>Mã vé (nếu có)</label>
        <input type="text" name="ticket_id" placeholder="TKT123456" />

        <label>Nội dung liên hệ</label>
        <textarea name="message" placeholder="Bạn cần hỗ trợ gì ạ?" required></textarea>

        <button type="submit" class="submit-btn">Gửi Tin Nhắn</button>
      </form>
    </div>
  </div>
</div>

<div id="toast-container"></div>

<script>
// Toast
function showToast(message, type = 'success') {
    const container = document.getElementById('toast-container');
    const toast = document.createElement('div');
    toast.className = `toast-notification ${type}`;
    toast.innerHTML = `<span>${message}</span><span class="toast-close">&times;</span>`;
    container.appendChild(toast);

    setTimeout(() => toast.classList.add('show'), 100);

    const autoClose = setTimeout(() => hideToast(toast), 5000);

    toast.querySelector('.toast-close').addEventListener('click', () => {
        clearTimeout(autoClose);
        hideToast(toast);
    });
}

function hideToast(toast) {
    toast.classList.remove('show');
    setTimeout(() => toast.remove(), 300);
}

// Submit form
document.getElementById('contactForm').addEventListener('submit', async function(e){
    e.preventDefault();

    const btn = this.querySelector('.submit-btn');
    const oldText = btn.innerHTML;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Đang gửi...';
    btn.disabled = true;

    try {
        const formData = new FormData(this);

        const res = await fetch('http://localhost/PR_RESERVATION_FnB_FOR_LIVEMUSIC/api_gateway/index.php?service=notification&action=submit_contact', {
            method: 'POST',
            body: formData
        });
        const data = await res.json();
        showToast(data.message, data.success ? 'success' : 'error');
        if (data.success) this.reset();

    } catch (err) {
        console.error(err);
        showToast('Lỗi kết nối, vui lòng thử lại sau', 'error');
    } finally {
        btn.innerHTML = oldText;
        btn.disabled = false;
    }
});

// Accordion FAQ
document.addEventListener("DOMContentLoaded", function () {
    const items = document.querySelectorAll(".accordion-item");

    items.forEach(item => {
        const header = item.querySelector(".accordion-header");

        header.addEventListener("click", () => {
            // Đóng tất cả item khác
            items.forEach(i => {
                if (i !== item) i.classList.remove("active");
            });

            // Toggle item hiện tại
            item.classList.toggle("active");
        });
    });
});

</script>
