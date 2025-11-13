<style>
  :root {
    --primary: #d4af37; /* vàng kim */
    --secondary: #8b7355; /* nâu đồng */
    --accent: #c9a227;
    --background: #0e0c0a;
    --card: #1a1815;
    --text: #f1f1f1;
    --muted: #b8b8b8;
    --border: #2a261f;
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

  /* Hero */
  .hero {
    text-align: center;
    padding: 6rem 1rem 3rem;
    background: radial-gradient(circle at top, #2a261f, transparent 70%);
  }

  .hero h1 {
    font-size: 3rem;
    color: var(--primary);
    letter-spacing: 2px;
    margin-bottom: 1rem;
  }

  .hero p {
    color: var(--muted);
    font-size: 1.1rem;
    max-width: 600px;
    margin: 0 auto;
  }

  /* Genre Buttons */
  .genres {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    gap: 1rem;
    margin-top: 2rem;
  }

  .genre-btn {
    background: var(--card);
    color: var(--text);
    border: 1px solid var(--border);
    border-radius: 30px;
    padding: 0.8rem 1.8rem;
    font-weight: 500;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    gap: 0.5rem;
  }

  .genre-btn:hover {
    border-color: var(--primary);
    color: var(--primary);
    transform: scale(1.05);
  }

  /* Section Title */
  .section-title {
    text-align: center;
    margin-bottom: 3rem;
  }

  .section-title h2 {
    font-size: 2.5rem;
    color: var(--primary);
    margin-bottom: 1rem;
  }

  .section-title p {
    color: var(--muted);
    font-size: 1.1rem;
    max-width: 600px;
    margin: 0 auto;
  }

  /* Event Cards */
  .grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
    gap: 2rem;
  }

  .card {
    background: var(--card);
    border: 1px solid var(--border);
    border-radius: 12px;
    overflow: hidden;
    transition: transform 0.3s ease, border-color 0.3s ease;
  }

  .card:hover {
    transform: translateY(-5px);
    border-color: var(--primary);
  }

  .card img {
    width: 100%;
    height: 220px;
    object-fit: cover;
    filter: brightness(0.85);
  }

  .card-content {
    padding: 1.5rem;
  }

  .card h3 {
    font-size: 1.3rem;
    color: var(--primary);
    margin-bottom: 0.5rem;
  }

  .card p {
    color: var(--muted);
    font-size: 0.95rem;
    margin: 0.25rem 0;
  }

  .price {
    color: var(--accent);
    font-weight: bold;
    font-size: 1.1rem;
    margin-top: 0.8rem;
  }

  .btn-buy {
    margin-top: 1rem;
    background: linear-gradient(90deg, var(--secondary), var(--primary));
    color: #000;
    font-weight: bold;
    border: none;
    border-radius: 8px;
    padding: 0.7rem 1.2rem;
    cursor: pointer;
    transition: opacity 0.2s ease;
    width: 100%;
  }

  .btn-buy:hover {
    opacity: 0.85;
  }
</style>

<div class="hero">
  <h1>Live Events & Music Nights</h1>
  <p>Experience the rhythm of the city — from electrifying EDM nights to soulful jazz evenings.</p>

  <div class="genres">
    <button class="genre-btn">🎧 Electronic</button>
    <button class="genre-btn">🎸 Rock</button>
    <button class="genre-btn">🎷 Jazz</button>
  </div>
</div>

<div class="container">
  <div class="section-title">
    <h2>Upcoming Events</h2>
    <p>Don’t miss out on these incredible live performances. Book your tickets now!</p>
  </div>

  <div class="grid" id="eventsGrid">
    <!-- Event cards will be loaded here -->
  </div>
</div>

<script>
  const events = [
    {
      title: "Electronic Night Vibes",
      artist: "DJ Pulse & The Synthwave",
      date: "Sat, Dec 15, 2024 - 8:00 PM",
      location: "The Neon Arena, Downtown",
      price: "$45",
      image: "https://images.unsplash.com/photo-1470229722913-7c0e2dbbafd3?q=80&w=2070",
      genre: "Electronic"
    },
    {
      title: "Rock Legends Live",
      artist: "The Thunder Band",
      date: "Fri, Dec 20, 2024 - 9:00 PM",
      location: "Stadium Rock Hall",
      price: "$60",
      image: "https://images.unsplash.com/photo-1501612780327-45045538702b?q=80&w=2070",
      genre: "Rock"
    },
    {
      title: "Jazz & Soul Evening",
      artist: "Smooth Notes Collective",
      date: "Sun, Dec 22, 2024 - 7:30 PM",
      location: "Blue Note Lounge",
      price: "$38",
      image: "https://images.unsplash.com/photo-1511192336575-5a79af67a629?q=80&w=2072",
      genre: "Jazz"
    },
    {
      title: "Hip Hop Festival",
      artist: "MC Flow & The Beats",
      date: "Sat, Dec 28, 2024 - 10:00 PM",
      location: "Urban Sound Complex",
      price: "$55",
      image: "https://images.unsplash.com/photo-1493225457124-a3eb161ffa5f?q=80&w=2070",
      genre: "Hip Hop"
    },
    {
      title: "Indie Acoustic Sessions",
      artist: "The Wandering Folk",
      date: "Thu, Jan 2, 2025 - 8:30 PM",
      location: "Cozy Corner Cafe",
      price: "$30",
      image: "https://images.unsplash.com/photo-1514320291840-2e0a9bf2a9ae?q=80&w=2070",
      genre: "Indie"
    },
    {
      title: "EDM Mega Night",
      artist: "Neon Pulse DJs",
      date: "Sat, Jan 5, 2025 - 11:00 PM",
      location: "The Electric Dome",
      price: "$70",
      image: "https://images.unsplash.com/photo-1516450360452-9312f5e86fc7?q=80&w=2070",
      genre: "EDM"
    }
  ];

  const grid = document.getElementById("eventsGrid");

  grid.innerHTML = events.map(event => `
    <div class="card">
      <img src="${event.image}" alt="${event.title}" />
      <div class="card-content">
        <h3>${event.title}</h3>
        <p><strong>${event.artist}</strong></p>
        <p>${event.date}</p>
        <p>${event.location}</p>
        <p class="price">${event.price}</p>
        <button class="btn-buy">Buy Ticket</button>
      </div>
    </div>
  `).join("");
</script>
