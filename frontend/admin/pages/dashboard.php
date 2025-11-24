<?php
require_once __DIR__ . '/../../config.php';

// Gọi API tổng hợp dữ liệu dashboard
$api_url = "http://localhost/PR_RESERVATION_FnB_FOR_LIVEMUSIC/api_gateway/index.php?service=admin&action=get_dashboard_data";
$response = file_get_contents($api_url);
$data = json_decode($response, true);

// Nếu lỗi hoặc không có dữ liệu, gán mặc định
if (!$data || !isset($data['success']) || !$data['success']) {
    $data = [
        "total_revenue" => 0,
        "total_events" => 0,
        "total_orders" => 0,
        "total_customers" => 0,
        "monthly_revenue" => [],
        "recent_events" => [],
        "event_details" => []
    ];
}
?>
<main class="main-content">
<section class="section-header" style="display: flex; justify-content: space-between; align-items: center; color:black;">
    <h2>Thống kê</h2>

    <!-- Bộ lọc thời gian + nút xuất báo cáo -->
    <form action="http://localhost/PR_RESERVATION_FnB_FOR_LIVEMUSIC/api_gateway/index.php?service=admin&action=export_dashboard" method="POST" style="display: flex; gap: 10px; align-items: center; margin: 0;">
        <label for="from_month">Từ:</label>
        <input type="month" name="from_month" id="from_month" required>

        <label for="to_month">Đến:</label>
        <input type="month" name="to_month" id="to_month" required>

        <button type="submit" class="btn-export">Xuất báo cáo</button>
    </form>
</section>

<!-- THỐNG KÊ CHUNG -->
<section class="stats">
    <div class="card">
        <div class="card-icon"><i class="ri-line-chart-fill"></i></div>
        <div class="card-info">
            <h3>Tổng doanh thu</h3>
            <h2><?= number_format($data['total_revenue'] ?? 0, 0, ',', '.') ?> VNĐ</h2>
        </div>
    </div>

    <div class="card">
        <div class="card-icon"><i class="ri-calendar-2-fill"></i></div>
        <div class="card-info">
            <h3>Sự kiện</h3>
            <h2><?= $data['total_events'] ?? 0 ?></h2>
        </div>
    </div>

    <div class="card">
        <div class="card-icon"><i class="ri-shopping-bag-fill"></i></div>
        <div class="card-info">
            <h3>Đơn hàng</h3>
            <h2><?= $data['total_orders'] ?? 0 ?></h2>
        </div>
    </div>

    <div class="card">
        <div class="card-icon"><i class="ri-user-3-fill"></i></div>
        <div class="card-info">
            <h3>Khách hàng</h3>
            <h2><?= $data['total_customers'] ?? 0 ?></h2>
        </div>
    </div>
</section>

<!-- BIỂU ĐỒ DOANH THU -->
<section class="table-section">
    <h2>Doanh thu theo tháng</h2>
    <canvas id="revenueChart"></canvas>
</section>

<!-- SỰ KIỆN GẦN ĐÂY -->
<section class="events">
    <h2>Sự kiện gần đây</h2>
    <?php if (!empty($data['recent_events'])): ?>
        <?php foreach ($data['recent_events'] as $event): ?>
            <div class="event-card" style="display:flex; justify-content:space-between; align-items:center; padding:10px; border-radius:8px; margin-bottom:8px;">
                <div class="event-info">
                    <h3><?= htmlspecialchars($event['name']) ?></h3>
                    <p><?= date("d/m/Y", strtotime($event['date'])) ?></p>

                </div>
                <div class="event-status" style="text-align:right;">
                    <p><?= $event['sold'] ?>/<?= $event['capacity'] ?> vé</p>
                    <a href="index.php?page=events" class="btn-detail">Chi tiết</a>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p>Không có sự kiện nào gần đây.</p>
    <?php endif; ?>
</section>

<!-- BẢNG THỐNG KÊ CHI TIẾT -->
<section class="table-section">
    <h2>Chi tiết sự kiện và doanh thu</h2>
    <table class="data-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Tên sự kiện</th>
                <th>Ngày diễn</th>
                <th>Vé bán</th>
                <th>Tỷ lệ đặt chỗ</th>
                <th>Doanh thu (VNĐ)</th>
                <th>Trạng thái</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($data['event_details'])): ?>
                <?php foreach ($data['event_details'] as $ev): ?>
                    <tr>
                        <td><?= htmlspecialchars($ev['id']) ?></td>
                        <td><?= htmlspecialchars($ev['name']) ?></td>
                        <td><?= date("d/m/Y", strtotime($ev['date'])) ?></td>
                        <td><?= $ev['tickets'] ?></td>
                        <td>
                            <?= isset($ev['capacity']) && $ev['capacity'] > 0 
                                ? round(($ev['tickets'] / $ev['capacity']) * 100, 1) . '%' 
                                : '0%' ?>
                        </td>
                        <td><?= number_format($ev['revenue'], 0, ',', '.') ?></td>
                        <td><span class="status <?= strtolower($ev['status']) ?>"><?= htmlspecialchars($ev['status']) ?></span></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr><td colspan="7">Không có dữ liệu sự kiện.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</section>
</main>

<!--SCRIPT BIỂU ĐỒ-->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const ctx = document.getElementById('revenueChart').getContext('2d');
const monthlyData = <?= json_encode(array_column($data['monthly_revenue'] ?? [], 'total')) ?>;
const labels = <?= json_encode(array_column($data['monthly_revenue'] ?? [], 'month')) ?>;

new Chart(ctx, {
    type: 'bar',
    data: {
        labels: labels.map(m => 'Tháng ' + m),
        datasets: [{
            label: 'Doanh thu (VNĐ)',
            data: monthlyData,
            backgroundColor: '#ffb300',
            borderRadius: 6
        }]
    },
    options: {
        scales: {
            y: { beginAtZero: true },
            x: { grid: { display: false } }
        }
    }
});
</script>
