<style>
  :root {
    --primary: #d4af37;
    --secondary: #8b7355;
    --background: #0e0c0a;
    --card: #1a1815;
    --border: #2a261f;
    --text: #f1f1f1;
    --muted: #b0a88a;
    --accent: #c9a227;
  }

  body {
    background: var(--background);
    color: var(--text);
    font-family: "Poppins", sans-serif;
    margin: 0;
    line-height: 1.6;
  }

  .container {
    max-width: 1200px;
    margin: auto;
    padding: 3rem 1rem;
  }

  h2, h3 {
    color: var(--primary);
  }

  a.back-link {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    color: var(--muted);
    text-decoration: none;
    margin-bottom: 1.5rem;
    transition: color 0.3s;
  }

  a.back-link:hover {
    color: var(--primary);
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
    padding: 2rem;
  }

  /* Legend */
  .legend {
    display: flex;
    flex-wrap: wrap;
    gap: 1.5rem;
    font-size: 0.9rem;
    margin-bottom: 1.5rem;
  }

  .legend div {
    display: flex;
    align-items: center;
    gap: 0.5rem;
  }

  .legend-box {
    width: 22px;
    height: 22px;
    border-radius: 4px;
    border: 1px solid var(--border);
  }

  /* Stage */
  .stage {
    text-align: center;
    background: linear-gradient(90deg, var(--secondary), var(--primary));
    color: #000;
    padding: 0.8rem;
    border-radius: 10px;
    font-weight: bold;
    margin-bottom: 1.5rem;
  }

  /* Seat Map */
  .seat-row {
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 8px;
  }

  .row-label {
    width: 25px;
    text-align: center;
    color: var(--muted);
  }

  .seat {
    width: 32px;
    height: 32px;
    border-radius: 6px;
    border: 1px solid var(--border);
    margin: 2px;
    font-size: 0.75rem;
    font-weight: bold;
    cursor: pointer;
    transition: all 0.2s;
  }

  .seat.available:hover {
    transform: scale(1.1);
    border-color: var(--primary);
  }

  .seat.available {
    background: var(--card);
    color: var(--text);
  }

  .seat.vip {
    background: rgba(212, 175, 55, 0.1);
    border: 1px solid var(--primary);
    color: var(--primary);
  }

  .seat.selected {
    background: var(--primary);
    color: #000;
    border-color: var(--primary);
    transform: scale(1.1);
  }

  .seat.reserved {
    background: var(--border);
    color: var(--muted);
    cursor: not-allowed;
  }

  /* Booking Summary */
  .summary {
    position: sticky;
    top: 100px;
  }

  .summary h3 {
    margin-bottom: 1rem;
  }

  .seat-list {
    max-height: 180px;
    overflow-y: auto;
    border-top: 1px solid var(--border);
    border-bottom: 1px solid var(--border);
    padding: 0.5rem 0;
  }

  .seat-item {
    display: flex;
    justify-content: space-between;
    padding: 6px 0;
    border-bottom: 1px solid var(--border);
  }

  .seat-type {
    font-size: 0.75rem;
    background: var(--secondary);
    color: #000;
    border-radius: 6px;
    padding: 2px 6px;
    margin-right: 5px;
  }

  .total {
    border-top: 1px solid var(--border);
    padding-top: 0.8rem;
    font-weight: bold;
    display: flex;
    justify-content: space-between;
    color: var(--primary);
  }

  .btn {
    width: 100%;
    margin-top: 1rem;
    padding: 0.8rem;
    background: linear-gradient(90deg, var(--secondary), var(--primary));
    color: #000;
    border: none;
    border-radius: 6px;
    cursor: pointer;
    font-weight: bold;
    transition: opacity 0.3s;
  }

  .btn:hover {
    opacity: 0.9;
  }

  .hint {
    color: var(--muted);
    font-size: 0.8rem;
    margin-top: 1.2rem;
  }

</style>

<div class="container">
  <a href="#" class="back-link">← Back to Event Details</a>

  <div class="grid">
    <!-- Seat Selection -->
    <div>
      <div class="card">
        <h2>Select Your Seats</h2>

        <div class="legend">
          <div><div class="legend-box" style="background:var(--card);"></div> Available</div>
          <div><div class="legend-box" style="background:rgba(212,175,55,0.1);border-color:var(--primary);"></div> VIP</div>
          <div><div class="legend-box" style="background:var(--primary);"></div> Selected</div>
          <div><div class="legend-box" style="background:var(--border);"></div> Reserved</div>
        </div>

        <div class="stage">🎵 STAGE 🎵</div>

        <div id="seatMap"></div>
      </div>
    </div>

    <!-- Summary -->
    <div>
      <div class="card summary">
        <h3>Booking Summary</h3>
        <div id="seatSummary"></div>
        <div class="hint">
          ✓ Seats reserved for 10 minutes<br>
          ✓ Secure checkout process<br>
          ✓ Instant ticket confirmation
        </div>
      </div>
    </div>
  </div>
</div>

<script>
  const seatMap = document.getElementById("seatMap");
  const seatSummary = document.getElementById("seatSummary");

  const rows = ["A","B","C","D","E","F"];
  const seats = [];

  rows.forEach((row, rowIndex) => {
    for (let i = 1; i <= 10; i++) {
      seats.push({
        id: row + i,
        row,
        number: i,
        status: Math.random() > 0.75 ? "reserved" : "available",
        price: rowIndex < 2 ? 60 : 45,
        type: rowIndex < 2 ? "VIP" : "Standard"
      });
    }
  });

  function renderSeats() {
    seatMap.innerHTML = rows.map(row => {
      const rowSeats = seats.filter(s => s.row === row);
      return `
        <div class="seat-row">
          <span class="row-label">${row}</span>
          ${rowSeats.map(seat => `
            <button
              class="seat ${seat.type === 'VIP' ? 'vip' : ''} ${seat.status}"
              onclick="toggleSeat('${seat.id}')"
              title="${seat.id} - $${seat.price} (${seat.type})"
              ${seat.status === "reserved" ? "disabled" : ""}
            >${seat.number}</button>
          `).join('')}
        </div>
      `;
    }).join('');
  }

  function toggleSeat(id) {
    const seat = seats.find(s => s.id === id);
    if (seat.status === "reserved") return;
    seat.status = seat.status === "selected" ? "available" : "selected";
    renderSeats();
    renderSummary();
  }

  function renderSummary() {
    const selected = seats.filter(s => s.status === "selected");
    if (selected.length === 0) {
      seatSummary.innerHTML = `
        <p style="text-align:center;color:var(--muted);">No seats selected</p>
        <p style="text-align:center;font-size:0.9rem;color:var(--muted);">Click on available seats to select them</p>
      `;
      return;
    }

    const totalPrice = selected.reduce((sum, s) => sum + s.price, 0);
    const total = totalPrice + 5;

    seatSummary.innerHTML = `
      <div class="seat-list">
        ${selected.map(s => `
          <div class="seat-item">
            <div><span class="seat-type">${s.type}</span>Seat ${s.id}</div>
            <div>$${s.price}</div>
          </div>
        `).join("")}
      </div>
      <div style="margin-top:0.5rem;display:flex;justify-content:space-between;font-size:0.9rem;color:var(--muted);">
        <span>Seats (${selected.length})</span><span>$${totalPrice}</span>
      </div>
      <div style="display:flex;justify-content:space-between;font-size:0.9rem;color:var(--muted);">
        <span>Service Fee</span><span>$5</span>
      </div>
      <div class="total"><span>Total</span><span>$${total}</span></div>
      <button class="btn">Continue to Food & Drinks</button>
    `;
  }

  renderSeats();
  renderSummary();
</script>
