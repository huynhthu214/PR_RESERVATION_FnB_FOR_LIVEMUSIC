<link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/event_user.css">
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
