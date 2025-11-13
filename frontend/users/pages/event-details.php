<style>
  :root {
    --primary: #d4af37;
    --secondary: #8b7355;
    --accent: #c9a227;
    --background: #0e0c0a;
    --card: #1a1815;
    --border: #2a261f;
    --muted: #b0a88a;
    --text: #f2f2f2;
  }

  body {
    background: var(--background);
    color: var(--text);
    font-family: "Poppins", sans-serif;
    margin: 0;
  }

  .hero {
    position: relative;
    height: 60vh;
    overflow: hidden;
  }

  .hero img {
    width: 100%;
    height: 100%;
    object-fit: cover;
  }

  .hero::after {
    content: "";
    position: absolute;
    inset: 0;
    background: linear-gradient(to top, var(--background), transparent 60%);
  }

  .container {
    max-width: 1200px;
    margin: -180px auto 0;
    padding: 0 1rem 4rem;
    position: relative;
    z-index: 10;
  }

  .grid {
    display: grid;
    gap: 2rem;
  }

  @media (min-width: 992px) {
    .grid {
      grid-template-columns: 2fr 1fr;
    }
  }

  .card {
    background: var(--card);
    border: 1px solid var(--border);
    border-radius: 12px;
    box-shadow: 0 0 20px rgba(0, 0, 0, 0.3);
    overflow: hidden;
  }

  .card-content {
    padding: 2rem;
  }

  .badge {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    background: rgba(139, 115, 85, 0.2);
    border: 1px solid var(--secondary);
    color: var(--secondary);
    border-radius: 50px;
    padding: 6px 12px;
    font-size: 0.85rem;
    margin-bottom: 1rem;
  }

  h1 {
    font-size: 2.5rem;
    color: var(--primary);
    margin-bottom: 0.3rem;
  }

  h2 {
    color: var(--accent);
    margin-bottom: 0.8rem;
  }

  p {
    color: var(--text);
    line-height: 1.6;
  }

  .details-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
    gap: 1rem;
    border-top: 1px solid var(--border);
    border-bottom: 1px solid var(--border);
    padding: 1.5rem 0;
    margin: 1.5rem 0;
  }

  .detail-item {
    display: flex;
    align-items: flex-start;
    gap: 0.8rem;
  }

  .icon-box {
    background: rgba(212, 175, 55, 0.1);
    border-radius: 8px;
    padding: 8px;
    font-size: 1.2rem;
  }

  .detail-item p {
    margin: 0;
  }

  .detail-label {
    color: var(--muted);
    font-size: 0.85rem;
  }

  .booking-card {
    position: sticky;
    top: 120px;
    background: var(--card);
    border: 1px solid var(--border);
    border-radius: 12px;
    padding: 2rem;
  }

  .price {
    text-align: center;
    border-bottom: 1px solid var(--border);
    padding-bottom: 1.5rem;
    margin-bottom: 1.5rem;
  }

  .price h3 {
    font-size: 3rem;
    color: var(--primary);
    margin: 0.3rem 0;
  }

  .button {
    display: block;
    width: 100%;
    text-align: center;
    padding: 1rem;
    border: none;
    border-radius: 8px;
    font-weight: bold;
    font-size: 1rem;
    cursor: pointer;
    margin-bottom: 1rem;
    transition: opacity 0.3s, transform 0.2s;
  }

  .button:hover {
    opacity: 0.9;
    transform: scale(1.02);
  }

  .button-primary {
    background: linear-gradient(90deg, var(--secondary), var(--primary));
    color: #000;
  }

  .button-outline {
    background: transparent;
    border: 2px solid var(--accent);
    color: var(--accent);
  }

  .booking-info {
    border-top: 1px solid var(--border);
    padding-top: 1rem;
    color: var(--muted);
    font-size: 0.9rem;
    line-height: 1.4;
  }

</style>

<div class="hero">
  <img src="https://images.unsplash.com/photo-1470229722913-7c0e2dbbafd3?q=80&w=2070" alt="Electronic Night Vibes">
</div>

<div class="container">
  <div class="grid">
    <!-- Left: Event Info -->
    <div>
      <div class="card">
        <div class="card-content">
          <div class="badge">✨ Electronic / EDM</div>

          <h1>Electronic Night Vibes</h1>
          <p style="font-size:1.2rem;color:var(--muted);margin-bottom:1rem;">
            DJ Pulse & The Synthwave
          </p>

          <div class="details-grid">
            <div class="detail-item">
              <div class="icon-box">📅</div>
              <div>
                <p class="detail-label">Date</p>
                <p>Saturday, December 15, 2024</p>
              </div>
            </div>

            <div class="detail-item">
              <div class="icon-box">⏰</div>
              <div>
                <p class="detail-label">Time</p>
                <p>8:00 PM - 2:00 AM</p>
              </div>
            </div>

            <div class="detail-item">
              <div class="icon-box">📍</div>
              <div>
                <p class="detail-label">Venue</p>
                <p>The Neon Arena, Downtown</p>
                <p class="detail-label">123 Music Street, City Center</p>
              </div>
            </div>

            <div class="detail-item">
              <div class="icon-box">👥</div>
              <div>
                <p class="detail-label">Capacity</p>
                <p>500 people</p>
              </div>
            </div>
          </div>

          <div>
            <h2>About This Event</h2>
            <p>
              Get ready for an unforgettable night of electronic music! DJ Pulse teams up with The Synthwave
              for a spectacular performance that will keep you dancing all night long.
              Experience the best in electronic beats, stunning visuals, and an atmosphere that will blow your mind.
            </p>
          </div>
        </div>
      </div>

      <div class="card" style="margin-top:1.5rem;">
        <div class="card-content">
          <h2>About the Artist</h2>
          <p>
            DJ Pulse is a renowned electronic music producer known for high-energy performances and innovative beats.
            Joined by The Synthwave, this collaboration promises to deliver an experience you won't forget.
          </p>
        </div>
      </div>
    </div>

    <!-- Right: Booking Card -->
    <div>
      <div class="booking-card">
        <div class="price">
          <p style="color:var(--muted);font-size:0.9rem;">Starting from</p>
          <h3>$45</h3>
          <p style="color:var(--muted);font-size:0.9rem;">per ticket</p>
        </div>

        <button class="button button-primary" onclick="window.location.href='seat-reservation.html'">
          🎟 Select Seats
        </button>

        <button class="button button-outline">
          📆 Add to Calendar
        </button>

        <div class="booking-info">
          ✓ Instant ticket confirmation<br>
          ✓ Secure payment processing<br>
          ✓ Mobile ticket access<br>
          ✓ 24/7 customer support
        </div>
      </div>
    </div>
  </div>
</div>
