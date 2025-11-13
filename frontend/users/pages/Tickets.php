<style>
  :root {
    --primary: #d4af37; /* vàng kim */
    --secondary: #8b7355; /* nâu đồng */
    --background: #0e0c0a;
    --card: #1a1815;
    --border: #2a261f;
    --text: #f1f1f1;
    --muted: #b0a88a;
    --accent: #c9a227;
  }

  body {
    margin: 0;
    font-family: 'Poppins', sans-serif;
    background-color: var(--background);
    color: var(--text);
    line-height: 1.6;
  }

  .container {
    max-width: 1200px;
    margin: auto;
    padding: 3rem 1rem;
  }

  h1 {
    font-size: 3rem;
    color: var(--primary);
    text-align: center;
    margin-bottom: 0.5rem;
  }

  p.subtitle {
    color: var(--muted);
    text-align: center;
    margin-bottom: 3rem;
    font-size: 1.1rem;
  }

  /* Card */
  .card {
    background: var(--card);
    border: 1px solid var(--border);
    border-radius: 12px;
    overflow: hidden;
    transition: border-color 0.3s ease, transform 0.3s ease;
  }

  .card:hover {
    border-color: var(--primary);
    transform: translateY(-5px);
  }

  .ticket-grid {
    display: grid;
    gap: 2rem;
  }

  .ticket-inner {
    display: grid;
    grid-template-columns: 1fr 1.5fr 1fr;
    gap: 1rem;
  }

  .ticket-img {
    position: relative;
    height: 100%;
    overflow: hidden;
  }

  .ticket-img img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    filter: brightness(0.85);
  }

  .ticket-content {
    padding: 1.5rem;
    display: flex;
    flex-direction: column;
    justify-content: center;
  }

  .ticket-status {
    background: var(--primary);
    color: #000;
    padding: 0.3rem 0.8rem;
    border-radius: 20px;
    display: inline-block;
    font-size: 0.8rem;
    font-weight: bold;
    margin-bottom: 0.5rem;
  }

  .ticket-title {
    font-size: 1.5rem;
    color: var(--primary);
    margin-bottom: 0.2rem;
  }

  .ticket-artist {
    color: var(--muted);
    margin-bottom: 1rem;
  }

  .ticket-detail {
    color: var(--text);
    font-size: 0.95rem;
    margin-bottom: 0.3rem;
  }

  .ticket-seats {
    border-top: 1px solid var(--border);
    margin-top: 1rem;
    padding-top: 0.8rem;
  }

  .seat-badge {
    display: inline-block;
    border: 1px solid var(--accent);
    color: var(--accent);
    padding: 0.2rem 0.7rem;
    border-radius: 6px;
    font-size: 0.85rem;
    margin-right: 0.3rem;
  }

  /* Action Section */
  .ticket-actions {
    border-left: 1px solid var(--border);
    padding: 1.5rem;
    display: flex;
    flex-direction: column;
    justify-content: center;
    gap: 0.8rem;
  }

  .btn {
    background: none;
    border: 1px solid var(--primary);
    color: var(--primary);
    padding: 0.6rem 1rem;
    border-radius: 6px;
    cursor: pointer;
    font-weight: 500;
    transition: all 0.3s ease;
  }

  .btn:hover {
    background: var(--primary);
    color: #000;
  }

  .ticket-id {
    font-size: 0.8rem;
    color: var(--muted);
    text-align: center;
    margin-top: 0.5rem;
  }

  /* Empty State */
  .empty {
    text-align: center;
    padding: 4rem 1rem;
    background: var(--card);
    border: 1px solid var(--border);
    border-radius: 12px;
  }

  .empty-icon {
    font-size: 4rem;
    color: var(--muted);
    opacity: 0.5;
  }

  .empty h3 {
    color: var(--primary);
    font-size: 1.5rem;
    margin: 1rem 0 0.5rem;
  }

  .empty p {
    color: var(--muted);
    margin-bottom: 1.5rem;
  }

  .btn-accent {
    background: linear-gradient(90deg, var(--secondary), var(--primary));
    color: #000;
    font-weight: bold;
    border: none;
    border-radius: 8px;
    padding: 0.8rem 1.5rem;
    cursor: pointer;
  }

  @media (max-width: 768px) {
    .ticket-inner {
      grid-template-columns: 1fr;
    }
    .ticket-actions {
      border-left: none;
      border-top: 1px solid var(--border);
      padding-top: 1rem;
    }
  }
</style>

<div class="container">
  <h1>My Tickets</h1>
  <p class="subtitle">View and manage your upcoming event tickets</p>

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
      status: "Confirmed",
      image: "https://images.unsplash.com/photo-1470229722913-7c0e2dbbafd3?q=80&w=2070"
    },
    {
      id: "TKT002",
      eventTitle: "Rock Legends Live",
      artist: "The Thunder Band",
      date: "Fri, Dec 20, 2024 - 9:00 PM",
      location: "Stadium Rock Hall",
      seats: ["C12"],
      status: "Confirmed",
      image: "https://images.unsplash.com/photo-1501612780327-45045538702b?q=80&w=2070"
    }
  ];

  const list = document.getElementById('ticketList');

  if (tickets.length === 0) {
    list.innerHTML = `
      <div class="empty">
        <div class="empty-icon">🎫</div>
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
                <p class="ticket-detail">📅 ${ticket.date}</p>
                <p class="ticket-detail">📍 ${ticket.location}</p>

                <div class="ticket-seats">
                  <p style="color: var(--muted); font-size: 0.9rem;">Your Seats</p>
                  ${ticket.seats.map(seat => `<span class="seat-badge">Seat ${seat}</span>`).join("")}
                </div>
              </div>

              <div class="ticket-actions">
                <button class="btn">🔳 View QR Code</button>
                <button class="btn">⬇️ Download PDF</button>
                <p class="ticket-id">Ticket ID: ${ticket.id}</p>
              </div>
            </div>
          </div>
        `).join("")}
      </div>
    `;
  }
</script>
