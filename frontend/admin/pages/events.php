<?php
require_once __DIR__ . '/../../config.php';

$api_url = "http://localhost/PR_RESERVATION_FnB_FOR_LIVEMUSIC/api_gateway/index.php?service=admin&action=get_events";
$response = file_get_contents($api_url);

$data = json_decode($response, true);
$events = $data['data'] ?? []; 
?>

<main class="main-content event-page">
  <section class="section-header">
      <h2>Sự kiện</h2>
      <button class="btn-add">+ Thêm sự kiện</button>
  </section>

  <section class="table-section">
      <table class="data-table">
          <thead>
              <tr>
                  <th>ID</th>
                  <th>Địa điểm</th>
                  <th>Ban nhạc</th>
                  <th>Ngày diễn</th>
                  <th>Giá vé</th>
                  <th>Trạng thái</th>
                  <th>Thao tác</th>
              </tr>
          </thead>
          <tbody>
                <?php
                $events = $data['data'] ?? []; // lấy đúng mảng con chứa sự kiện
                ?>
                <?php if (!empty($events)): ?>
                <?php foreach ($events as $ev): ?>
                      <tr>
                          <td><?= htmlspecialchars($ev['id']) ?></td>
                          <td><?= htmlspecialchars($ev['venue']) ?></td>
                          <td><?= htmlspecialchars($ev['band']) ?></td>
                          <td><?= date('d/m/Y', strtotime($ev['date'])) ?></td>
                          <td><?= number_format($ev['price'], 0, ',', '.') ?> VNĐ</td>
                          <td><span class="status <?= strtolower($ev['status']) ?>"><?= htmlspecialchars($ev['status']) ?></span></td>
                          <td>
                              <button class="btn-edit" data-id="<?= $ev['id'] ?>">Sửa</button>
                              <button class="btn-delete" data-id="<?= $ev['id'] ?>">Xóa</button>
                          </td>
                      </tr>
                  <?php endforeach; ?>
              <?php else: ?>
                  <tr><td colspan="7">Không có sự kiện nào.</td></tr>
              <?php endif; ?>
          </tbody>
      </table>
  </section>
</main>
