<?php
require_once __DIR__ . '/../../config.php';

$api_url = "http://localhost/PR_RESERVATION_FnB_FOR_LIVEMUSIC/api_gateway/index.php?service=admin&action=get_venues";
$response = file_get_contents($api_url);

if ($response === false) {
    $error = error_get_last();
    echo "<pre>Lỗi kết nối API:\n" . print_r($error, true) . "</pre>";
}

$data = json_decode($response, true);
$venues = $data['data'] ?? [];
?>

<main class="main-content venue-page">
  <section class="section-header">
      <h2>Địa điểm</h2>
      <button class="btn-add">+ Thêm địa điểm</button>
  </section>

  <section class="table-section">
      <table class="data-table">
          <thead>
              <tr>
                  <th>ID</th>
                  <th>Tên địa điểm</th>
                  <th>Địa chỉ</th>
                  <th>Sức chứa</th>
                  <th>Trạng thái</th>
                  <th>Thao tác</th>
              </tr>
          </thead>
          <tbody>
              <?php if (!empty($venues)): ?>
                  <?php foreach ($venues as $v): ?>
                      <tr>
                          <td><?= htmlspecialchars($v['id']) ?></td>
                          <td><?= htmlspecialchars($v['name']) ?></td>
                          <td><?= htmlspecialchars($v['address']) ?></td>
                          <td><?= htmlspecialchars($v['capacity']) ?></td>
                          <td><span class="status active"><?= htmlspecialchars($v['status']) ?></span></td>
                          <td>
                              <button class="btn-edit" data-id="<?= $v['id'] ?>">Sửa</button>
                              <button class="btn-delete" data-id="<?= $v['id'] ?>">Xóa</button>
                          </td>
                      </tr>
                  <?php endforeach; ?>
              <?php else: ?>
                  <tr><td colspan="6">Không có địa điểm nào.</td></tr>
              <?php endif; ?>
          </tbody>
      </table>
  </section>
</main>
