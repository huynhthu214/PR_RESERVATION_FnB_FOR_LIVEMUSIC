<link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/tickets.css">
<div class="container">
  <h1>Vé của tôi</h1>
  <p class="subtitle">Xem và quản lý vé sự kiện sắp tới của bạn</p>
  <div id="ticketList"></div>
</div>

<script>
  const tickets = [
    {
      id: "TKT001",
      eventTitle: "Electronic Night Vibes",
      artist: "DJ Pulse & The Synthwave",
      date: "Sat, Dec 15, 2024 - 8:00 PM",
      location: "The Neon Arena, Downtown",
      seats: ["A5", "A6"],
      status: "Đã xác nhận",
      image: "https://images.unsplash.com/photo-1470229722913-7c0e2dbbafd3?q=80&w=2070"
    },
    {
      id: "TKT002",
      eventTitle: "Rock Legends Live",
      artist: "The Thunder Band",
      date: "Fri, Dec 20, 2024 - 9:00 PM",
      location: "Stadium Rock Hall",
      seats: ["C12"],
      status: "Đã xác nhận",
      image: "https://images.unsplash.com/photo-1501612780327-45045538702b?q=80&w=2070"
    }
  ];

  const list = document.getElementById('ticketList');

  if (tickets.length === 0) {
    list.innerHTML = `
      <div class="empty">
        <div class="empty-icon"></div>
        <h3>No tickets yet</h3>
        <p>Start exploring amazing events and book your first ticket!</p>
        <button class="btn-accent">Browse Events</button>
      </div>
    `;
  } else {
    list.innerHTML = `
      <div class="ticket-grid">
        ${tickets.map(ticket => `
          <div class="card">
            <div class="ticket-inner">
              <div class="ticket-img">
                <img src="${ticket.image}" alt="${ticket.eventTitle}">
              </div>

              <div class="ticket-content">
                <span class="ticket-status">${ticket.status}</span>
                <h3 class="ticket-title">${ticket.eventTitle}</h3>
                <p class="ticket-artist">${ticket.artist}</p>
                <p class="ticket-detail"> ${ticket.date}</p>
                <p class="ticket-detail"> ${ticket.location}</p>

                <div class="ticket-seats">
                  <p style="color: var(--muted); font-size: 0.9rem;">Chỗ ngồi</p>
                  ${ticket.seats.map(seat => `<span class="seat-badge">${seat}</span>`).join("")}
                </div>
              </div>

              <div class="ticket-actions">
                <button class="btn">View QR Code</button>
                <p class="ticket-id">Ticket ID: ${ticket.id}</p>
              </div>
            </div>
          </div>
        `).join("")}
      </div>
    `;
  }
</script>
