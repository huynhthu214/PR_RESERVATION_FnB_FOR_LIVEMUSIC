<link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/seat.css">
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

        <div class="stage">STAGE</div>

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
