<?php
require_once __DIR__ . '/../../../frontend/config.php';
require_once __DIR__ . '/../../../vendor/autoload.php'; // cần openpyxl (PHPSpreadsheet)

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

// Gọi API Gateway để lấy dữ liệu dashboard
$api_url = "http://localhost/PR_RESERVATION_FnB_FOR_LIVEMUSIC/api_gateway/index.php?service=admin&action=get_dashboard_data";
$response = file_get_contents($api_url);
$data = json_decode($response, true);

if (!$data || !$data['success']) {
    die("Không thể lấy dữ liệu từ API Dashboard!");
}

// Tạo đối tượng Spreadsheet
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// ====== SHEET 1: Tổng quan ======
$sheet->setTitle("Tổng quan");
$sheet->setCellValue('A1', 'BÁO CÁO THỐNG KÊ HỆ THỐNG LIVE MUSIC');
$sheet->mergeCells('A1:B1');
$sheet->getStyle('A1')->getFont()->setBold(true)->setSize(16);
$sheet->setCellValue('A2', 'Ngày xuất:');
$sheet->setCellValue('B2', date('d/m/Y H:i'));

$sheet->fromArray([
    ['Chỉ số', 'Giá trị'],
    ['Tổng doanh thu (VNĐ)', number_format($data['total_revenue'], 0, ',', '.')],
    ['Tổng sự kiện', $data['total_events']],
    ['Tổng đơn hàng', $data['total_orders']],
    ['Tổng khách hàng', $data['total_customers']],
], NULL, 'A4');

// ====== SHEET 2: Doanh thu theo tháng ======
$monthlySheet = $spreadsheet->createSheet();
$monthlySheet->setTitle('Doanh thu theo tháng');
$monthlySheet->fromArray(['Tháng', 'Doanh thu (VNĐ)'], NULL, 'A1');

$row = 2;
foreach ($data['monthly_revenue'] as $m) {
    $monthlySheet->setCellValue("A$row", 'Tháng ' . $m['month']);
    $monthlySheet->setCellValue("B$row", $m['total']);
    $row++;
}

// ====== SHEET 3: Chi tiết sự kiện ======
$eventSheet = $spreadsheet->createSheet();
$eventSheet->setTitle('Chi tiết sự kiện');
$eventSheet->fromArray(['Mã sự kiện', 'Tên sự kiện', 'Ngày diễn', 'Vé bán', 'Doanh thu (VNĐ)', 'Trạng thái'], NULL, 'A1');

$row = 2;
foreach ($data['event_details'] as $ev) {
    $eventSheet->setCellValue("A$row", $ev['id']);
    $eventSheet->setCellValue("B$row", $ev['name']);
    $eventSheet->setCellValue("C$row", date('d/m/Y', strtotime($ev['date'])));
    $eventSheet->setCellValue("D$row", $ev['tickets']);
    $eventSheet->setCellValue("E$row", $ev['revenue']);
    $eventSheet->setCellValue("F$row", $ev['status']);
    $row++;
}

// ====== Định dạng nhẹ ======
foreach ($spreadsheet->getAllSheets() as $sheet) {
    foreach (range('A', $sheet->getHighestColumn()) as $col) {
        $sheet->getColumnDimension($col)->setAutoSize(true);
    }
    $sheet->getStyle('A1')->getFont()->setBold(true);
}

// ====== Xuất file Excel ======
$filename = "BaoCao_Dashboard_" . date("Ymd_His") . ".xlsx";
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header("Content-Disposition: attachment; filename=\"$filename\"");
header('Cache-Control: max-age=0');

$writer = new Xlsx($spreadsheet);
$writer->save('php://output');
exit;
?>
