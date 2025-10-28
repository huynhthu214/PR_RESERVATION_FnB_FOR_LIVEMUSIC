<main class="main-content notification-page">
  <section class="section-header">
      <h2>Thông báo của bạn</h2>
      <button class="btn-refresh" onclick="window.location.reload();">⟳ Làm mới</button>
  </section>

  <section class="table-section">
      <table class="data-table">
          <thead>
              <tr>
                  <th>Tiêu đề</th>
                  <th>Nội dung</th>
                  <th>Ngày nhận</th>
                  <th>Trạng thái</th>
              </tr>
          </thead>
          <tbody>
              <tr>
                  <td>Đơn hàng mới</td>
                  <td>Bạn có 1 đơn hàng chờ xác nhận từ khách hàng <strong>Nguyễn Văn A</strong>.</td>
                  <td>25/10/2025 - 14:30</td>
                  <td><span class="status pending">Chưa đọc</span></td>
              </tr>
              <tr>
                  <td>NT002</td>
                  <td>Đặt bàn mới</td>
                  <td>Khách hàng <strong>Trần B</strong> vừa đặt bàn cho sự kiện Acoustic Night.</td>
                  <td>24/10/2025 - 19:10</td>
                  <td><span class="status active">Đã đọc</span></td>
              </tr>
          </tbody>
      </table>
  </section>
</main>

<?php include __DIR__ . '/../../includes/footer_admin.php'; ?>
