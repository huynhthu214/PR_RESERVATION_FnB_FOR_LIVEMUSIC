<?php
require_once dirname(__DIR__) . '../frontend/config.php';
$page = $page ?? ($_GET['page'] ?? 'dashboard');
?>

<aside class="sidebar">
  <nav class="menu">
    <ul>
      <li class="<?= ($page == 'dashboard') ? 'active' : ''; ?>">
        <i data-lucide="layout-dashboard"></i> Tổng quan
      </li>
      <li class="<?= ($page == 'events') ? 'active' : ''; ?>">
        <i data-lucide="calendar-days"></i> Sự kiện
      </li>
      <li class="<?= ($page == 'locations') ? 'active' : ''; ?>">
        <i data-lucide="map-pin"></i> Địa điểm
      </li>
      <li class="<?= ($page == 'menu') ? 'active' : ''; ?>">
        <i data-lucide="utensils"></i> Thực đơn
      </li>
      <li class="<?= ($page == 'orders') ? 'active' : ''; ?>">
        <i data-lucide="shopping-cart"></i> Đơn hàng
      </li>
      <li class="<?= ($page == 'users') ? 'active' : ''; ?>">
        <i data-lucide="user"></i> Người dùng
      </li>
      <li class="<?= ($page == 'promotions') ? 'active' : ''; ?>">
        <i data-lucide="gift"></i> Khuyến mãi
      </li>
      <li class="<?= ($page == 'reports') ? 'active' : ''; ?>">
        <i data-lucide="bar-chart-3"></i> Thống kê
      </li>
    </ul>
  </nav>
</aside>
