<style>
  :root {
    --primary: #9b6d09;
    --accent: #9b6d09;
    --secondary: #9b6d09;
    --background: #000000;
    --card: #8a8181;
    --text: #725a08;
    --muted: #6b7280;
    --border: #c1bfba;
  }

  body {
    font-family: 'Inter', sans-serif;
    background: var(--background);
    color: var(--text);
    margin: 0;
    padding: 0;
    line-height: 1.6;
  }

  .container {
    max-width: 1200px;
    margin: auto;
    padding: 2rem 1rem;
  }

  h1, h2, h3 {
    font-family: 'Poppins', sans-serif;
    font-weight: bold;
  }

  /* Hero Section */
  .hero {
    text-align: center;
    margin-bottom: 3rem;
  }

  .hero h1 {
    font-size: 2.5rem;
    background: linear-gradient(90deg, var(--primary), var(--accent));
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
  }

  .hero p {
    color: var(--muted);
    font-size: 1.1rem;
    max-width: 600px;
    margin: 0 auto;
  }

  /* Grid Sections */
  .grid {
    display: grid;
    gap: 1.5rem;
  }

  .lg-3 {
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
  }

  .lg-2 {
    grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
  }

  /* Card */
  .card {
    background: var(--card);
    border: 1px solid var(--border);
    border-radius: 12px;
    padding: 1.5rem;
    text-align: center;
    transition: border 0.3s ease;
  }

  .card:hover {
    border-color: var(--primary);
  }

  .icon-box {
    width: 60px;
    height: 60px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1rem;
    font-size: 24px;
  }

  .primary { background: var(--primary); color: #fff; }
  .accent { background: var(--accent); color: #fff; }
  .secondary { background: var(--secondary); color: #fff; }

  button {
    width: 100%;
    padding: 0.75rem;
    border: none;
    border-radius: 6px;
    font-weight: bold;
    cursor: pointer;
    transition: opacity 0.2s;
  }

  button.primary-btn { background: var(--primary); color: #fff; }
  button.accent-btn { border: 2px solid var(--accent); color: var(--accent); background: transparent; }
  button.secondary-btn { border: 2px solid var(--secondary); color: var(--secondary); background: transparent; }
  button:hover { opacity: 0.9; }

  /* FAQ Accordion */
  .accordion-item {
    border: 1px solid var(--border);
    border-radius: 8px;
    margin-bottom: 10px;
    overflow: hidden;
  }

  .accordion-header {
    background: #f3f4f6;
    padding: 1rem;
    cursor: pointer;
    text-align: left;
    font-weight: bold;
    transition: background 0.3s;
  }

  .accordion-header:hover {
    background: #e5e7eb;
    color: var(--primary);
  }

  .accordion-content {
    display: none;
    padding: 1rem;
    color: var(--muted);
    text-align: left;
    background: #fff;
  }

  .accordion-item.active .accordion-content {
    display: block;
  }

  /* Form */
  form label {
    display: block;
    margin-bottom: 4px;
    font-weight: 500;
  }

  input, textarea {
    width: 100%;
    padding: 10px;
    border: 1px solid var(--border);
    border-radius: 6px;
    margin-bottom: 1rem;
    font-family: inherit;
    background: #f9fafb;
  }

  textarea {
    resize: vertical;
    height: 120px;
  }

  .submit-btn {
    background: linear-gradient(90deg, var(--primary), var(--accent));
    color: white;
    font-weight: bold;
  }
</style>

<div class="container">
  <div class="hero">
    <h1>How Can We Help?</h1>
    <p>Find answers to common questions or get in touch with our support team.</p>
  </div>

  <!-- Contact Methods -->
  <div class="grid lg-3" style="margin-bottom: 2rem;">
    <div class="card">
      <div class="icon-box primary">💬</div>
      <h3>Live Chat</h3>
      <p>Chat with our support team in real-time</p>
      <button class="primary-btn">Start Chat</button>
    </div>
    <div class="card">
      <div class="icon-box accent">✉️</div>
      <h3>Email Support</h3>
      <p>Get help via email within 24 hours</p>
      <button class="accent-btn">Send Email</button>
    </div>
    <div class="card">
      <div class="icon-box secondary">📞</div>
      <h3>Phone Support</h3>
      <p>Call us Mon-Fri, 9AM - 6PM</p>
      <button class="secondary-btn">+1 (555) 123-4567</button>
    </div>
  </div>

  <!-- FAQ and Contact Form -->
  <div class="grid lg-2">
    <!-- FAQ -->
    <div class="card">
      <h2>Frequently Asked Questions</h2>

      <div class="accordion">
        <div class="accordion-item">
          <div class="accordion-header">How do I book tickets?</div>
          <div class="accordion-content">
            Simply browse our events, select your preferred show, choose your seats, and proceed to checkout. You'll receive instant confirmation via email.
          </div>
        </div>

        <div class="accordion-item">
          <div class="accordion-header">Can I cancel or refund my tickets?</div>
          <div class="accordion-content">
            Tickets can be refunded up to 48 hours before the event. Contact our support team with your ticket ID to process a refund.
          </div>
        </div>

        <div class="accordion-item">
          <div class="accordion-header">How do I receive my tickets?</div>
          <div class="accordion-content">
            After successful payment, you'll receive a confirmation email with your digital tickets.
          </div>
        </div>

        <div class="accordion-item">
          <div class="accordion-header">Can I book tickets for a group?</div>
          <div class="accordion-content">
            Yes! We offer group discounts for bookings of 10 or more tickets.
          </div>
        </div>

        <div class="accordion-item">
          <div class="accordion-header">What payment methods do you accept?</div>
          <div class="accordion-content">
            We accept Visa, Mastercard, American Express, debit cards, and digital wallets.
          </div>
        </div>

        <div class="accordion-item">
          <div class="accordion-header">Is there wheelchair accessibility?</div>
          <div class="accordion-content">
            Yes, all our venues are wheelchair accessible.
          </div>
        </div>
      </div>
    </div>

    <!-- Contact Form -->
    <div class="card">
      <h2>Send Us a Message</h2>
      <form id="contactForm">
        <label>Your Name</label>
        <input type="text" placeholder="John Doe" required />

        <label>Email Address</label>
        <input type="email" placeholder="john@example.com" required />

        <label>Ticket ID (if applicable)</label>
        <input type="text" placeholder="TKT001" />

        <label>Your Message</label>
        <textarea placeholder="How can we help you?" required></textarea>

        <button type="submit" class="submit-btn">Send Message</button>
      </form>
    </div>
  </div>
</div>

<script>
  // Accordion Toggle Logic
  document.querySelectorAll('.accordion-header').forEach(header => {
    header.addEventListener('click', () => {
      const item = header.parentElement;
      item.classList.toggle('active');
    });
  });

  // Contact Form Handler
  document.getElementById('contactForm').addEventListener('submit', e => {
    e.preventDefault();
    alert('✅ Your message has been sent! Our team will get back to you soon.');
    e.target.reset();
  });
</script>
