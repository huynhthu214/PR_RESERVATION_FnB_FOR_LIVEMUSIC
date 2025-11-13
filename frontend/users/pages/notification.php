<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Notifications</title>
  <style>
    body {
      background-color: #0a0a0a;
      font-family: "Poppins", sans-serif;
      color: #f5f5f5;
      margin: 0;
      padding: 0;
      min-height: 100vh;
      background-image: radial-gradient(circle at top, #1c1c1c, #000);
    }

    h1 {
      text-align: center;
      font-size: 3rem;
      color: #ffcc66;
      text-shadow: 0 0 20px rgba(255, 204, 102, 0.5);
      margin-top: 60px;
      animation: glowTitle 3s ease-in-out infinite alternate;
    }

    @keyframes glowTitle {
      from { text-shadow: 0 0 10px #b8860b, 0 0 20px #ffd700; }
      to { text-shadow: 0 0 25px #ffcc33, 0 0 50px #ff9900; }
    }

    .container {
      max-width: 850px;
      margin: 40px auto;
      padding: 0 20px;
    }

    /* ===== Filter Bar ===== */
    .filter-bar {
      display: flex;
      flex-wrap: wrap;
      justify-content: space-between;
      align-items: center;
      background: rgba(25, 25, 25, 0.8);
      border: 1px solid rgba(255, 204, 102, 0.2);
      border-radius: 12px;
      padding: 15px 20px;
      margin-bottom: 35px;
      box-shadow: 0 0 10px rgba(139, 69, 19, 0.3);
      backdrop-filter: blur(6px);
    }

    .tabs {
      display: flex;
      gap: 10px;
    }

    .tab-btn {
      background: rgba(255, 204, 102, 0.08);
      color: #d3b97f;
      border: 1px solid rgba(255, 204, 102, 0.2);
      padding: 8px 20px;
      border-radius: 20px;
      font-weight: 600;
      transition: all 0.3s ease;
      cursor: pointer;
    }

    .tab-btn:hover {
      color: #000;
      background: linear-gradient(90deg, #ffcc66, #a97142);
      box-shadow: 0 0 15px rgba(255, 204, 102, 0.4);
      transform: scale(1.05);
    }

    .tab-btn.active {
      background: linear-gradient(90deg, #a97142, #ffcc66);
      color: #000;
      box-shadow: 0 0 18px rgba(255, 204, 102, 0.5);
    }

    .actions {
      display: flex;
      gap: 10px;
    }

    .action-btn {
      background: rgba(255, 204, 102, 0.08);
      color: #cda55c;
      border: 1px solid rgba(255, 204, 102, 0.2);
      padding: 8px 18px;
      border-radius: 20px;
      font-weight: 600;
      transition: all 0.3s ease;
      cursor: pointer;
    }

    .action-btn:hover {
      background: linear-gradient(90deg, #ffcc66, #a97142);
      color: #000;
      box-shadow: 0 0 18px rgba(255, 204, 102, 0.5);
      transform: scale(1.05);
    }

    /* ===== Notification Cards ===== */
    .notification {
      background: rgba(30, 30, 30, 0.85);
      border: 1px solid rgba(255, 204, 102, 0.2);
      border-radius: 15px;
      padding: 20px 25px;
      margin-bottom: 20px;
      box-shadow: 0 0 10px rgba(139, 69, 19, 0.3);
      transition: all 0.3s ease;
      backdrop-filter: blur(6px);
      animation: fadeIn 0.6s ease forwards;
    }

    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(10px); }
      to { opacity: 1; transform: translateY(0); }
    }

    .notification:hover {
      border-color: #ffcc66;
      box-shadow: 0 0 25px rgba(255, 204, 102, 0.5), 0 0 8px rgba(255, 204, 102, 0.3);
      transform: scale(1.02);
    }

    .notification-title {
      font-size: 1.2rem;
      color: #ffcc66;
      margin-bottom: 8px;
      font-weight: 600;
    }

    .notification-message {
      color: #d3b97f;
      line-height: 1.5;
      font-size: 0.95rem;
      margin-bottom: 10px;
    }

    .notification-time {
      font-size: 0.85rem;
      color: #b08a55;
    }

    .notification .action-link {
      display: inline-block;
      margin-top: 10px;
      background: linear-gradient(90deg, #a97142, #ffcc66);
      color: #1a1a1a;
      font-weight: bold;
      padding: 8px 18px;
      border-radius: 25px;
      text-decoration: none;
      transition: all 0.3s ease;
      box-shadow: 0 0 10px rgba(255, 204, 102, 0.3);
    }

    .notification .action-link:hover {
      background: linear-gradient(90deg, #ffdd88, #ffd27f);
      transform: scale(1.05);
      box-shadow: 0 0 25px rgba(255, 204, 102, 0.5);
    }

    .no-notifications {
      text-align: center;
      color: #b08a55;
      font-style: italic;
      margin-top: 50px;
      font-size: 1.1rem;
    }
  </style>
</head>
<body>

  <h1>🔔 Notifications</h1>

  <div class="container">

    <!-- Filter Bar -->
    <div class="filter-bar">
      <div class="tabs">
        <button class="tab-btn active">All (8)</button>
        <button class="tab-btn">Unread (3)</button>
      </div>
      <div class="actions">
        <button class="action-btn">✔ Mark All Read</button>
        <button class="action-btn">🗑 Clear All</button>
      </div>
    </div>

    <!-- Notification Cards -->
    <div class="notification">
      <div class="notification-title">Event Tomorrow!</div>
      <div class="notification-message">
        Don’t forget! Electronic Night Vibes is tomorrow at 8:00 PM. Get ready for an amazing night!
      </div>
      <div class="notification-time">2 hours ago</div>
      <a href="#" class="action-link">View Event</a>
    </div>

    <div class="notification">
      <div class="notification-title">Ticket Confirmed ✓</div>
      <div class="notification-message">
        Your tickets for Rock Legends Live have been confirmed. Check your email for details.
      </div>
      <div class="notification-time">5 hours ago</div>
      <a href="#" class="action-link">View Tickets</a>
    </div>

    <div class="notification">
      <div class="notification-title">New Artist Alert</div>
      <div class="notification-message">
        DJ Pulse just announced a surprise album release concert! Limited tickets available.
      </div>
      <div class="notification-time">Yesterday</div>
      <a href="#" class="action-link">Get Tickets</a>
    </div>

    <div class="notification">
      <div class="notification-title">Special Offer 🎁</div>
      <div class="notification-message">
        20% off on all Jazz concerts this weekend. Use code JAZZ20 at checkout.
      </div>
      <div class="notification-time">Yesterday</div>
      <a href="#" class="action-link">Browse Jazz Events</a>
    </div>

    <div class="notification">
      <div class="notification-title">New Event Added</div>
      <div class="notification-message">
        Indie Acoustic Sessions just added to your favorite genres. Check it out!
      </div>
      <div class="notification-time">2 days ago</div>
      <a href="#" class="action-link">Explore</a>
    </div>

    <div class="notification">
      <div class="notification-title">Profile Updated</div>
      <div class="notification-message">
        Your notification preferences have been successfully updated.
      </div>
      <div class="notification-time">3 days ago</div>
    </div>

    <div class="notification">
      <div class="notification-title">Ticket Sale Reminder</div>
      <div class="notification-message">
        EDM Mega Night tickets go on sale in 24 hours. Set your alarm!
      </div>
      <div class="notification-time">3 days ago</div>
      <a href="#" class="action-link">Set Reminder</a>
    </div>

    <div class="notification">
      <div class="notification-title">Artist You Follow</div>
      <div class="notification-message">
        The Thunder Band just posted a behind-the-scenes video from their rehearsal.
      </div>
      <div class="notification-time">1 week ago</div>
      <a href="#" class="action-link">Watch Now</a>
    </div>

  </div>
</body>
</html>
