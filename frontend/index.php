<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tổng quan hệ thống - Venue Admin</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/remixicon@4.2.0/fonts/remixicon.css">
</head>
<body>
    <div class="container">
        <!-- Sidebar -->
        <aside class="sidebar">
            <div class="logo">
                <i class="ri-music-2-fill"></i>
                <div>
                    <h2>Venue Admin</h2>
                    <p>Quản lý sự kiện</p>
                </div>
            </div>

            <nav class="menu">
                <p class="menu-title">Menu chính</p>
                <ul>
                    <li class="active"><i class="ri-dashboard-line"></i> Tổng quan</li>
                    <li><i class="ri-calendar-event-line"></i> Sự kiện</li>
                    <li><i class="ri-map-pin-line"></i> Địa điểm</li>
                    <li><i class="ri-restaurant-line"></i> Thực đơn</li>
                    <li><i class="ri-shopping-cart-2-line"></i> Đơn hàng</li>
                    <li><i class="ri-user-3-line"></i> Người dùng</li>
                    <li><i class="ri-gift-line"></i> Khuyến mãi</li>
                    <li><i class="ri-bar-chart-2-line"></i> Báo cáo</li>
                </ul>
            </nav>
        </aside>

        <!-- Main content -->
        <main class="main-content">
            <header class="header">
                <h1>Tổng quan hệ thống</h1>
                <p>Chào mừng trở lại! Đây là tổng quan hoạt động của bạn.</p>
            </header>

            <section class="stats">
                <div class="card">
                    <div class="card-icon"><i class="ri-line-chart-fill"></i></div>
                    <div class="card-info">
                        <h3>Tổng doanh thu</h3>
                        <h2>142.5M VNĐ</h2>
                        <p class="growth">+12.5%</p>
                    </div>
                </div>

                <div class="card">
                    <div class="card-icon"><i class="ri-calendar-2-fill"></i></div>
                    <div class="card-info">
                        <h3>Sự kiện</h3>
                        <h2>28</h2>
                        <p>+3 tháng này</p>
                    </div>
                </div>

                <div class="card">
                    <div class="card-icon"><i class="ri-shopping-bag-fill"></i></div>
                    <div class="card-info">
                        <h3>Đơn hàng</h3>
                        <h2>1,247</h2>
                        <p>+18.2%</p>
                    </div>
                </div>

                <div class="card">
                    <div class="card-icon"><i class="ri-user-3-fill"></i></div>
                    <div class="card-info">
                        <h3>Khách hàng</h3>
                        <h2>3,892</h2>
                        <p>+156 mới</p>
                    </div>
                </div>
            </section>

            <section class="events">
                <h2>Sự kiện gần đây</h2>

                <div class="event-card">
                    <div class="event-info">
                        <h3>Live Jazz Night</h3>
                        <p>15/10/2025</p>
                    </div>
                    <div class="event-status">
                        <p>120/150</p>
                        <span class="status selling">Đang bán</span>
                    </div>
                </div>

                <div class="event-card">
                    <div class="event-info">
                        <h3>Rock Concert</h3>
                        <p>20/10/2025</p>
                    </div>
                    <div class="event-status">
                        <p>200/200</p>
                        <span class="status soldout">Hết vé</span>
                    </div>
                </div>

                <div class="event-card">
                    <div class="event-info">
                        <h3>Acoustic Evening</h3>
                        <p>25/10/2025</p>
                    </div>
                    <div class="event-status">
                        <p>45/80</p>
                        <span class="status selling">Đang bán</span>
                    </div>
                </div>
            </section>
        </main>
    </div>
</body>
</html>
