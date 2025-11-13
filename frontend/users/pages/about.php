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
    margin: 0;
    font-family: "Poppins", sans-serif;
    background: var(--background);
    color: var(--text);
  }

  section {
    padding: 6rem 1.5rem;
  }

  h1, h2 {
    font-family: "Playfair Display", serif;
  }

  /* Hero */
  .hero {
    position: relative;
    min-height: 60vh;
    display: flex;
    justify-content: center;
    align-items: center;
    text-align: center;
    overflow: hidden;
  }

  .hero::before {
    content: "";
    position: absolute;
    inset: 0;
    background: url("https://images.unsplash.com/photo-1501281668745-f7f57925c3b4?q=80&w=2070") center/cover;
    opacity: 0.2;
    mix-blend-mode: overlay;
  }

  .hero::after {
    content: "";
    position: absolute;
    inset: 0;
    background: linear-gradient(to top, var(--background), transparent 60%);
  }

  .hero-content {
    position: relative;
    z-index: 2;
    max-width: 800px;
    padding: 1rem;
  }

  .hero h1 {
    font-size: 4rem;
    color: var(--primary);
  }

  .hero p {
    font-size: 1.3rem;
    color: var(--muted);
  }

  /* Mission */
  .mission {
    text-align: center;
    max-width: 900px;
    margin: 0 auto;
  }

  .mission h2 {
    color: var(--primary);
    font-size: 3rem;
  }

  .mission p {
    color: var(--muted);
    line-height: 1.8;
    font-size: 1.1rem;
    margin-top: 1.2rem;
  }

  /* Values */
  .values h2 {
    text-align: center;
    font-size: 3rem;
    color: var(--accent);
    margin-bottom: 3rem;
  }

  .values-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
    gap: 2rem;
    max-width: 1100px;
    margin: 0 auto;
  }

  .value-card {
    background: var(--card);
    border: 1px solid var(--border);
    border-radius: 16px;
    padding: 2rem;
    text-align: center;
    transition: all 0.3s;
  }

  .value-card:hover {
    border-color: var(--primary);
    transform: scale(1.05);
  }

  .value-icon {
    background: linear-gradient(135deg, var(--secondary), var(--primary));
    width: 70px;
    height: 70px;
    border-radius: 50%;
    margin: 0 auto 1rem;
    font-size: 1.8rem;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #000;
  }

  .value-card h3 {
    color: var(--primary);
  }

  .value-card p {
    color: var(--muted);
    font-size: 0.9rem;
    line-height: 1.6;
  }

  /* Team */
  .team h2 {
    text-align: center;
    font-size: 3rem;
    color: var(--primary);
    margin-bottom: 3rem;
  }

  .team-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
    gap: 2rem;
    max-width: 1100px;
    margin: 0 auto;
  }

  .member {
    background: var(--card);
    border: 1px solid var(--border);
    border-radius: 16px;
    padding: 2rem;
    text-align: center;
    transition: all 0.3s;
  }

  .member:hover {
    border-color: var(--primary);
    transform: scale(1.05);
  }

  .member img {
    width: 120px;
    height: 120px;
    border-radius: 50%;
    border: 2px solid var(--primary);
    object-fit: cover;
    margin-bottom: 1rem;
  }

  .member h3 {
    margin: 0;
  }

  .member p {
    color: var(--accent);
    font-size: 0.9rem;
  }

  /* Partners */
  .partners h2 {
    text-align: center;
    font-size: 3rem;
    color: var(--accent);
    margin-bottom: 3rem;
  }

  .partners-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(140px, 1fr));
    gap: 1.5rem;
    max-width: 1000px;
    margin: 0 auto;
  }

  .partner-card {
    background: var(--card);
    border: 1px solid var(--border);
    border-radius: 12px;
    padding: 1.5rem;
    text-align: center;
    color: var(--muted);
    font-weight: bold;
    transition: all 0.3s;
  }

  .partner-card:hover {
    border-color: var(--primary);
    transform: scale(1.05);
  }

  /* Legal */
  .legal h2 {
    text-align: center;
    color: var(--primary);
    font-size: 3rem;
    margin-bottom: 3rem;
  }

  .legal-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
    gap: 2rem;
    max-width: 1200px;
    margin: 0 auto;
  }

  .legal-card {
    background: var(--card);
    border: 1px solid var(--border);
    border-radius: 16px;
    padding: 2rem;
    color: var(--muted);
    transition: all 0.3s;
  }

  .legal-card:hover {
    border-color: var(--primary);
  }

  .legal-card h3 {
    color: var(--primary);
    margin-bottom: 1rem;
  }

  .legal-card ul {
    margin-top: 1rem;
    padding-left: 1.2rem;
  }

  .legal-card li {
    margin: 0.3rem 0;
  }

  /* Contact */
  .contact-icons {
    display: flex;
    gap: 1rem;
    margin-top: 1rem;
  }

  .contact-icon {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    border: 1px solid var(--primary);
    color: var(--primary);
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.3s;
    cursor: pointer;
  }

  .contact-icon:hover {
    background: var(--primary);
    color: #000;
  }
</style>

<!-- HERO -->
<section class="hero">
  <div class="hero-content">
    <h1>About LiveMusic</h1>
    <p>Connecting fans and artists through unforgettable live experiences since 2024</p>
  </div>
</section>

<!-- MISSION -->
<section class="mission">
  <h2>Our Mission</h2>
  <p>LiveMusic was founded with a simple yet powerful vision: to make live music accessible to everyone. We believe that live performances create magic that cannot be replicated – the energy, the connection, the shared experience of being part of something bigger than ourselves.</p>
  <p>Our platform bridges the gap between talented artists and passionate fans, making it easier than ever to discover, book, and experience incredible live music events. Whether you're into intimate acoustic sessions or massive festival experiences, we're here to help you find your perfect show.</p>
</section>

<!-- VALUES -->
<section class="values">
  <h2>Our Values</h2>
  <div class="values-grid">
    <div class="value-card">
      <div class="value-icon">🎵</div>
      <h3>Music First</h3>
      <p>We believe in the power of live music to transform lives and create unforgettable moments.</p>
    </div>
    <div class="value-card">
      <div class="value-icon">❤️</div>
      <h3>Fan-Centric</h3>
      <p>Every decision we make puts music fans at the center, ensuring the best experience possible.</p>
    </div>
    <div class="value-card">
      <div class="value-icon">👥</div>
      <h3>Artist Support</h3>
      <p>We're committed to supporting independent artists and helping them reach wider audiences.</p>
    </div>
    <div class="value-card">
      <div class="value-icon">🌍</div>
      <h3>Global Reach</h3>
      <p>Connecting music lovers worldwide with incredible live experiences in their communities.</p>
    </div>
  </div>
</section>

<!-- TEAM -->
<section class="team">
  <h2>Meet Our Team</h2>
  <div class="team-grid">
    <div class="member">
      <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=300&h=300&fit=crop" alt="Alex Johnson">
      <h3>Alex Johnson</h3>
      <p>Founder & CEO</p>
    </div>
    <div class="member">
      <img src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?w=300&h=300&fit=crop" alt="Sarah Chen">
      <h3>Sarah Chen</h3>
      <p>Head of Artist Relations</p>
    </div>
    <div class="member">
      <img src="https://images.unsplash.com/photo-1500648767791-00dcc994a43e?w=300&h=300&fit=crop" alt="Michael Brown">
      <h3>Michael Brown</h3>
      <p>Technical Director</p>
    </div>
    <div class="member">
      <img src="https://images.unsplash.com/photo-1438761681033-6461ffad8d80?w=300&h=300&fit=crop" alt="Emma Davis">
      <h3>Emma Davis</h3>
      <p>Marketing Lead</p>
    </div>
  </div>
</section>

<!-- PARTNERS -->
<section class="partners">
  <h2>Our Partners</h2>
  <div class="partners-grid">
    <div class="partner-card">Spotify</div>
    <div class="partner-card">Apple Music</div>
    <div class="partner-card">SoundCloud</div>
    <div class="partner-card">Live Nation</div>
    <div class="partner-card">Ticketmaster</div>
    <div class="partner-card">AEG Presents</div>
  </div>
</section>

<!-- LEGAL & CONTACT -->
<section class="legal">
  <h2>Legal & Privacy</h2>
  <div class="legal-grid">
    <div class="legal-card">
      <h3>Terms of Service</h3>
      <ul>
        <li>All sales are final unless event is cancelled</li>
        <li>Tickets are non-transferable without authorization</li>
        <li>Age restrictions apply to certain events</li>
        <li>We reserve the right to refuse service</li>
      </ul>
    </div>
    <div class="legal-card">
      <h3>Privacy Policy</h3>
      <ul>
        <li>We never sell your personal data to third parties</li>
        <li>Payment information is securely encrypted</li>
        <li>Email communications can be opted out anytime</li>
      </ul>
    </div>
    <div class="legal-card">
      <h3>Refund Policy</h3>
      <ul>
        <li>Full refund if event is cancelled by organizer</li>
        <li>Partial refund available 7+ days before event</li>
        <li>No refunds within 48 hours of event</li>
      </ul>
    </div>
    <div class="legal-card">
      <h3>Contact Us</h3>
      <p>Email: support@livemusic.com</p>
      <p>Phone: +84 (028) 1234 5678</p>
      <p>Address: 123 Music Street, District 1, Ho Chi Minh City</p>
      <div class="contact-icons">
        <div class="contact-icon">f</div>
        <div class="contact-icon">in</div>
        <div class="contact-icon">ig</div>
      </div>
    </div>
  </div>
</section>
