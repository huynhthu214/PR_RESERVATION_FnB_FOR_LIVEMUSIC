<?php
require_once __DIR__ . '/../../config.php';

$api_url = "http://localhost/PR_RESERVATION_FnB_FOR_LIVEMUSIC/api_gateway/index.php?service=admin&action=get_promotions";
$response = file_get_contents($api_url);

if ($response === false) {
    $error = error_get_last();
    echo "<pre>Lỗi kết nối API:\n" . print_r($error, true) . "</pre>";
}

$data = json_decode($response, true);
$promotions = $data['data'] ?? [];
?>

<main class="main-content promotion-page">
  <section class="section-header">
      <h2>Khuyến mãi</h2>
      <button class="btn-add">+ Thêm mã giảm</button>
  </section>

  <section class="table-section">
      <table class="data-table">
          <thead>
              <tr>
                  <th>ID</th>
                  <th>Mã code</th>
                  <th>Phần trăm giảm</th>
                  <th>Ngày bắt đầu</th>
                  <th>Ngày kết thúc</th>
                  <th>Trạng thái</th>
                  <th>Thao tác</th>
              </tr>
          </thead>
          <tbody>
              <?php if (!empty($promotions)): ?>
                  <?php foreach ($promotions as $pr): ?>
                      <tr>
                          <td><?= htmlspecialchars($pr['id']) ?></td>
                          <td><?= htmlspecialchars($pr['code']) ?></td>
                          <td><?= htmlspecialchars($pr['discount']) ?>%</td>
                          <td><?= date('d/m/Y', strtotime($pr['start_date'])) ?></td>
                          <td><?= date('d/m/Y', strtotime($pr['end_date'])) ?></td>
                          <td><span class="status <?= $pr['status_class'] ?>"><?= htmlspecialchars($pr['status']) ?></span></td>
                          <td>
                              <button class="btn-edit" data-id="<?= $pr['id'] ?>">Sửa</button>
                              <button class="btn-delete" data-id="<?= $pr['id'] ?>">Xóa</button>
                          </td>
                      </tr>
                  <?php endforeach; ?>
              <?php else: ?>
                  <tr><td colspan="7">Không có khuyến mãi nào.</td></tr>
              <?php endif; ?>
          </tbody>
      </table>
  </section>
</main>
