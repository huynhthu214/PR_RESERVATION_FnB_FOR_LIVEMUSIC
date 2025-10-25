<?php
require_once dirname(__DIR__) . '../frontend/config.php';
$page = $page ?? ($_GET['page'] ?? 'dashboard');
?>

<aside class="sidebar">
  <nav class="menu">
    <ul>
      <li class="<?= ($page == 'dashboard') ? 'active' : ''; ?>">
        <a href="index.php?page=dashboard">
          <i data-lucide="layout-dashboard"></i> Tổng quan
        </a>
      </li>
      <li class="<?= ($page == 'events') ? 'active' : ''; ?>">
        <a href="index.php?page=events">
          <i data-lucide="calendar-days"></i> Sự kiện
        </a>
      </li>
      <li class="<?= ($page == 'venues') ? 'active' : ''; ?>">
        <a href="index.php?page=venues">
          <i data-lucide="map-pin"></i> Địa điểm
        </a>
      </li>
      <li class="<?= ($page == 'menu') ? 'active' : ''; ?>">
        <a href="index.php?page=menu">
          <i data-lucide="utensils"></i> Thực đơn
        </a>
      </li>
      <li class="<?= ($page == 'order') ? 'active' : ''; ?>">
        <a href="index.php?page=order">
          <i data-lucide="shopping-cart"></i> Đơn hàng
        </a>
      </li>
      <li class="<?= ($page == 'users') ? 'active' : ''; ?>">
        <a href="index.php?page=users">
          <i data-lucide="user"></i> Người dùng
        </a>
      </li>
      <li class="<?= ($page == 'promotion') ? 'active' : ''; ?>">
        <a href="index.php?page=promotion">
          <i data-lucide="gift"></i> Khuyến mãi
        </a>
      </li>
      <li class="<?= ($page == 'reports') ? 'active' : ''; ?>">
        <a href="index.php?page=reports">
          <i data-lucide="bar-chart-3"></i> Thống kê
        </a>
      </li>
    </ul>
  </nav>
</aside>
