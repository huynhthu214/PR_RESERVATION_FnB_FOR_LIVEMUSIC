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

      <!-- Modal thêm sự kiện -->
        <div id="addEventModal" class="modal hidden">
        <div class="modal-content">
            <span class="modal-close">&times;</span>
            <h3>Thêm sự kiện mới</h3>
            <form id="addEventForm">
            <label>Ban nhạc:</label>
            <input type="text" name="band_name" required>

            <label>Địa điểm:</label>
            <input type="number" name="venue_id" required>

            <label>Ngày diễn:</label>
            <input type="datetime-local" name="event_date" required>

            <label>Giá vé:</label>
            <input type="number" name="ticket_price" required>

            <label>Trạng thái:</label>
            <select name="status">
                <option value="ACTIVE">ACTIVE</option>
                <option value="INACTIVE">INACTIVE</option>
            </select>

            <div class="modal-actions">
                <button type="submit" class="btn-save">Lưu</button>
                <button type="button" class="btn-cancel">Hủy</button>
            </div>
            </form>
        </div>
        </div>

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
  <script>
        document.addEventListener("DOMContentLoaded", () => {
        document.querySelector('.btn-add').addEventListener('click', () => {
            document.getElementById('addEventModal').classList.remove('hidden');
        });

        document.querySelector('.btn-cancel').addEventListener('click', () => {
            document.getElementById('addEventModal').classList.add('hidden');
        });

        document.querySelector('.modal-close').addEventListener('click', () => {
            document.getElementById('addEventModal').classList.add('hidden');
        });
        });
        document.getElementById('addEventForm').addEventListener('submit', async (e) => {
        e.preventDefault();

        const formData = new FormData(e.target);
        const payload = Object.fromEntries(formData.entries());

        try {
            const res = await fetch(
            'http://localhost/PR_RESERVATION_FnB_FOR_LIVEMUSIC/api_gateway/index.php?service=admin&action=add_event',
            {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(payload)
            }
            );
            const data = await res.json();

            if (data.success) {
            alert('Thêm sự kiện thành công!');
            location.reload();
            } else {
            alert('Thêm sự kiện thất bại: ' + data.error);
            }
        } catch (err) {
            console.error(err);
            alert('Có lỗi xảy ra khi gửi dữ liệu.');
        }
        });

</script>
</main>
