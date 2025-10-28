<?php
$apiUrl = "http://localhost/PR_RESERVATION_FnB_FOR_LIVEMUSIC/api_gateway/index.php?service=admin&action=get_dashboard_data";
$response = file_get_contents($apiUrl);
$data = json_decode($response, true);

$totalRevenue = number_format($data['data']['totalRevenue'] ?? 0, 0, ',', '.');
$totalEvents = $data['data']['totalEvents'] ?? 0;
$recentEvents = $data['data']['recentEvents'] ?? [];
$monthlyRevenue = $data['data']['monthlyRevenue'] ?? [];
?>
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
      <h2><?= $totalRevenue ?> VNĐ</h2>
    </div>
  </div>

  <div class="card">
    <div class="card-icon"><i class="ri-calendar-2-fill"></i></div>
    <div class="card-info">
      <h3>Sự kiện</h3>
      <h2><?= $totalEvents ?></h2>
    </div>
  </div>
</section>

<section class="events">
  <h2>Sự kiện gần đây</h2>
  <?php foreach ($recentEvents as $event): ?>
    <div class="event-card">
      <div class="event-info">
        <h3><?= htmlspecialchars($event['BAND_NAME']) ?></h3>
        <p><?= date("d/m/Y", strtotime($event['EVENT_DATE'])) ?></p>
      </div>
      <div class="event-status">
        <p><?= number_format($event['TICKET_PRICE'], 0, ',', '.') ?>đ</p>
        <span class="status <?= strtolower($event['STATUS']) ?>"><?= ucfirst($event['STATUS']) ?></span>
      </div>
    </div>
  <?php endforeach; ?>
</section>

<section class="table-section">
  <h2>Doanh thu theo tháng</h2>
  <canvas id="revenueChart"></canvas>
</section>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const ctx = document.getElementById('revenueChart').getContext('2d');
const chartData = <?= json_encode($monthlyRevenue) ?>;
const labels = chartData.map(e => e.month);
const data = chartData.map(e => e.revenue);

new Chart(ctx, {
  type: 'bar',
  data: {
    labels,
    datasets: [{
      label: 'Doanh thu (VNĐ)',
      data,
      backgroundColor: '#ffb300cc',
      borderRadius: 6
    }]
  },
  options: {
    scales: {
      y: { beginAtZero: true, ticks: { color: '#fff' } },
      x: { ticks: { color: '#fff' } }
    }
  }
});
</script>
</main>
