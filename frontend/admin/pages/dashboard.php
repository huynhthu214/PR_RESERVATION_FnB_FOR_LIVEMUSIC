<main class="main-content">

  <section class="section-header">
      <h2>Thống kê</h2>
      <button class="btn-export">Xuất báo cáo</button>
  </section>

  <section class="stats">
      <div class="card">
          <div class="card-icon"><i class="ri-line-chart-fill"></i></div>
          <div class="card-info">
              <h3>Tổng doanh thu</h3>
              <h2>142.5M VNĐ</h2>
              <p class="growth">+12.5%</p>
          </div>
      </div>

      <div class="card">
          <div class="card-icon"><i class="ri-calendar-2-fill"></i></div>
          <div class="card-info">
              <h3>Sự kiện</h3>
              <h2>28</h2>
              <p>+3 tháng này</p>
          </div>
      </div>

      <div class="card">
          <div class="card-icon"><i class="ri-shopping-bag-fill"></i></div>
          <div class="card-info">
              <h3>Đơn hàng</h3>
              <h2>1,247</h2>
              <p>+18.2%</p>
          </div>
      </div>

      <div class="card">
          <div class="card-icon"><i class="ri-user-3-fill"></i></div>
          <div class="card-info">
              <h3>Khách hàng</h3>
              <h2>3,892</h2>
              <p>+156 mới</p>
          </div>
      </div>
  </section>

  <!-- ======= BIỂU ĐỒ DOANH THU ======= -->
  <section class="table-section">
      <h2>Doanh thu theo tháng</h2>
      <canvas id="revenueChart"></canvas>
  </section>

  <!-- ======= SỰ KIỆN GẦN ĐÂY ======= -->
  <section class="events">
      <h2>Sự kiện gần đây</h2>

      <div class="event-card">
          <div class="event-info">
              <h3>Live Jazz Night</h3>
              <p>15/10/2025</p>
          </div>
          <div class="event-status">
              <p>120/150</p>
              <span class="status selling">Đang bán</span>
          </div>
      </div>

      <div class="event-card">
          <div class="event-info">
              <h3>Rock Concert</h3>
              <p>20/10/2025</p>
          </div>
          <div class="event-status">
              <p>200/200</p>
              <span class="status soldout">Hết vé</span>
          </div>
      </div>

      <div class="event-card">
          <div class="event-info">
              <h3>Acoustic Evening</h3>
              <p>25/10/2025</p>
          </div>
          <div class="event-status">
              <p>45/80</p>
              <span class="status selling">Đang bán</span>
          </div>
      </div>
  </section>

  <!-- ======= BẢNG THỐNG KÊ CHI TIẾT ======= -->
  <section class="table-section">
      <h2>Chi tiết sự kiện và doanh thu</h2>
      <table class="data-table">
          <thead>
              <tr>
                  <th>ID</th>
                  <th>Tên sự kiện</th>
                  <th>Ngày diễn</th>
                  <th>Vé bán</th>
                  <th>Doanh thu (VNĐ)</th>
                  <th>Trạng thái</th>
              </tr>
          </thead>
          <tbody>
              <tr>
                  <td>EV001</td>
                  <td>Live Jazz Night</td>
                  <td>15/10/2025</td>
                  <td>120</td>
                  <td>24,000,000</td>
                  <td><span class="status active">Đang bán</span></td>
              </tr>
              <tr>
                  <td>EV002</td>
                  <td>Rock Concert</td>
                  <td>20/10/2025</td>
                  <td>200</td>
                  <td>50,000,000</td>
                  <td><span class="status soldout">Hết vé</span></td>
              </tr>
              <tr>
                  <td>EV003</td>
                  <td>Acoustic Evening</td>
                  <td>25/10/2025</td>
                  <td>45</td>
                  <td>9,000,000</td>
                  <td><span class="status pending">Sắp diễn</span></td>
              </tr>
          </tbody>
      </table>
  </section>
</main>

<!-- ===== SCRIPT BIỂU ĐỒ ===== -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const ctx = document.getElementById('revenueChart').getContext('2d');
const revenueChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: ['Tháng 5', 'Tháng 6', 'Tháng 7', 'Tháng 8', 'Tháng 9', 'Tháng 10'],
        datasets: [{
            label: 'Doanh thu (VNĐ)',
            data: [90, 105, 120, 135, 150, 142.5],
            backgroundColor: ['#ffb300cc', '#ffb300bb', '#ffb300aa', '#ffb30099', '#ffb300dd', '#ffb300'],
            borderRadius: 6
        }]
    },
    options: {
        scales: {
            y: {
                beginAtZero: true,
                ticks: { color: '#fff' },
                grid: { color: '#333' }
            },
            x: {
                ticks: { color: '#fff' },
                grid: { display: false }
            }
        },
        plugins: {
            legend: { labels: { color: '#fff' } }
        }
    }
});
</script>
