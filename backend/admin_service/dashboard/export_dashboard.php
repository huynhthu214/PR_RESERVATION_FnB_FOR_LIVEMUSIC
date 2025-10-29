<?php
require_once __DIR__ . '/../../config.php';
require_once __DIR__ . '/../../../vendor/autoload.php'; // nếu có Composer (cho ReportLab hoặc dompdf)

// Lấy dữ liệu từ API
$api_url = "http://localhost/PR_RESERVATION_FnB_FOR_LIVEMUSIC/api_gateway/index.php?service=admin&action=get_dashboard_data";
$response = file_get_contents($api_url);
$data = json_decode($response, true);

// Nếu lỗi API
if (!$data || !$data['success']) {
    die("Không thể lấy dữ liệu thống kê.");
}

// Khởi tạo file PDF bằng thư viện DOMPDF
use Dompdf\Dompdf;
$dompdf = new Dompdf();

$html = "
<h1 style='text-align:center;'>BÁO CÁO THỐNG KÊ HỆ THỐNG LYZY</h1>
<p><strong>Ngày lập báo cáo:</strong> " . date('d/m/Y H:i') . "</p>
<hr>
<h2>I. Tổng quan</h2>
<ul>
    <li><strong>Tổng doanh thu:</strong> " . number_format($data['total_revenue'], 0, ',', '.') . " VNĐ</li>
    <li><strong>Tổng sự kiện:</strong> " . $data['total_events'] . "</li>
    <li><strong>Tổng đơn hàng:</strong> " . $data['total_orders'] . "</li>
    <li><strong>Tổng khách hàng:</strong> " . $data['total_customers'] . "</li>
</ul>

<h2>II. Doanh thu theo tháng</h2>
<table border='1' cellspacing='0' cellpadding='6' width='100%'>
<tr style='background:#f2f2f2;'>
<th>Tháng</th><th>Doanh thu (VNĐ)</th>
</tr>";

foreach ($data['monthly_revenue'] as $m) {
    $html .= "<tr>
        <td>Tháng {$m['month']}</td>
        <td>" . number_format($m['total'], 0, ',', '.') . "</td>
    </tr>";
}

$html .= "</table>

<h2>III. Chi tiết sự kiện</h2>
<table border='1' cellspacing='0' cellpadding='6' width='100%'>
<tr style='background:#f2f2f2;'>
<th>ID</th><th>Tên sự kiện</th><th>Ngày diễn</th><th>Vé bán</th><th>Doanh thu (VNĐ)</th><th>Trạng thái</th>
</tr>";

foreach ($data['event_details'] as $ev) {
    $html .= "<tr>
        <td>{$ev['id']}</td>
        <td>{$ev['name']}</td>
        <td>" . date("d/m/Y", strtotime($ev['date'])) . "</td>
        <td>{$ev['tickets']}</td>
        <td>" . number_format($ev['revenue'], 0, ',', '.') . "</td>
        <td>{$ev['status']}</td>
    </tr>";
}

$html .= "</table>
<hr>
<p style='text-align:right;'>© " . date('Y') . " LYZY Music - Báo cáo nội bộ.</p>
";

// Xuất ra file PDF
$dompdf->loadHtml($html, 'UTF-8');
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();
$dompdf->stream("BaoCao_LYZY_" . date('Ymd_His') . ".pdf", ["Attachment" => true]);
