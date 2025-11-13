<link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/contact.css">
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
    alert(' Your message has been sent! Our team will get back to you soon.');
    e.target.reset();
  });
</script>
