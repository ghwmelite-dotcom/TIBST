<?php
$pageTitle = 'Contact Us - TIBST';
$activePage = 'contact';
require_once 'includes/header.php';

// ── Fetch dynamic settings ─────────────────────────────────────────
$settings    = getSettings();
$phone       = !empty($settings['phone'])    ? $settings['phone']    : '+233 302 957 663';
$mobile      = !empty($settings['mobile'])   ? $settings['mobile']   : '+233 277 715 058';
$email       = !empty($settings['email'])    ? $settings['email']    : 'info@thrivusinstitute.edu.gh';
$address     = !empty($settings['address'])  ? $settings['address']  : 'Constellations Avenue, Lashibi, Accra, Ghana';
$whatsapp    = !empty($settings['whatsapp']) ? $settings['whatsapp'] : 'https://wa.me/233277715058';
?>

  <!-- PAGE HERO -->
  <section class="page-hero" style="background-image: url('https://images.unsplash.com/photo-1423666639041-f56000c27a9a?w=1920&q=80');">
    <div class="hero-overlay"></div>
    <div class="container" style="position:relative; z-index:1;">
      <div class="breadcrumb fade-up">
        <a href="index.php">Home</a>
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9 18 15 12 9 6"></polyline></svg>
        <span>Contact</span>
      </div>
      <h1 class="fade-up">Contact Us</h1>
      <p class="fade-up">We would love to hear from you. Reach out with any questions about admissions, programmes, or partnerships.</p>
    </div>
  </section>

  <!-- CONTACT FORM & INFO -->
  <section class="section" style="background: var(--off-white);">
    <div class="container">
      <div style="display:grid; grid-template-columns: 1fr 1fr; gap:48px; align-items:start;">

        <!-- Contact Form -->
        <div class="fade-up">
          <h2 style="margin-bottom:8px;">Send Us a Message</h2>
          <p style="color:#666; margin-bottom:32px;">Fill out the form below and we will get back to you as soon as possible.</p>

          <form action="#" method="POST">
            <div class="form-group">
              <label class="form-label" for="contact-name">Full Name *</label>
              <input class="form-input" type="text" id="contact-name" name="name" placeholder="Enter your full name" required>
            </div>

            <div class="form-group">
              <label class="form-label" for="contact-email">Email Address *</label>
              <input class="form-input" type="email" id="contact-email" name="email" placeholder="Enter your email address" required>
            </div>

            <div class="form-group">
              <label class="form-label" for="contact-phone">Phone Number</label>
              <input class="form-input" type="tel" id="contact-phone" name="phone" placeholder="Enter your phone number">
            </div>

            <div class="form-group">
              <label class="form-label" for="contact-subject">Subject *</label>
              <input class="form-input" type="text" id="contact-subject" name="subject" placeholder="What is this regarding?" required>
            </div>

            <div class="form-group">
              <label class="form-label" for="contact-message">Message *</label>
              <textarea class="form-input" id="contact-message" name="message" rows="6" placeholder="Type your message here..." required></textarea>
            </div>

            <button type="submit" class="btn btn-primary" style="width:100%;">Send Message <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="22" y1="2" x2="11" y2="13"></line><polygon points="22 2 15 22 11 13 2 9 22 2"></polygon></svg></button>
          </form>
        </div>

        <!-- Contact Info -->
        <div class="fade-up fade-up-delay-1">
          <h2 style="margin-bottom:8px;">Contact Information</h2>
          <p style="color:#666; margin-bottom:32px;">You can also reach us through the following channels.</p>

          <div style="display:flex; flex-direction:column; gap:24px; margin-bottom:32px;">
            <div style="display:flex; gap:16px; align-items:flex-start;">
              <div style="width:48px; height:48px; background:#4E9B17; border-radius:12px; display:flex; align-items:center; justify-content:center; flex-shrink:0;">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
              </div>
              <div>
                <h4 style="margin-bottom:4px;">Our Location</h4>
                <p style="color:#666;"><?= escape($address) ?></p>
              </div>
            </div>

            <div style="display:flex; gap:16px; align-items:flex-start;">
              <div style="width:48px; height:48px; background:#4E9B17; border-radius:12px; display:flex; align-items:center; justify-content:center; flex-shrink:0;">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z"></path></svg>
              </div>
              <div>
                <h4 style="margin-bottom:4px;">Phone</h4>
                <p style="color:#666;"><a href="tel:<?= escape(preg_replace('/\s+/', '', $phone)) ?>"><?= escape($phone) ?></a></p>
                <p style="color:#666;"><a href="tel:<?= escape(preg_replace('/\s+/', '', $mobile)) ?>"><?= escape($mobile) ?></a> (Mobile)</p>
              </div>
            </div>

            <div style="display:flex; gap:16px; align-items:flex-start;">
              <div style="width:48px; height:48px; background:#4E9B17; border-radius:12px; display:flex; align-items:center; justify-content:center; flex-shrink:0;">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>
              </div>
              <div>
                <h4 style="margin-bottom:4px;">Email</h4>
                <p style="color:#666;"><a href="mailto:<?= escape($email) ?>"><?= escape($email) ?></a></p>
              </div>
            </div>
          </div>

          <!-- WhatsApp Button -->
          <a href="<?= escape($whatsapp) ?>" target="_blank" class="btn btn-primary" style="width:100%; background:#25D366; border-color:#25D366; margin-bottom:32px; display:flex; align-items:center; justify-content:center; gap:10px;">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="white"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
            Chat on WhatsApp
          </a>

          <!-- Office Hours -->
          <div class="feature-card" style="margin-bottom:0;">
            <h3 style="margin-bottom:16px;">
              <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#4E9B17" stroke-width="2" style="vertical-align:middle; margin-right:8px;"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
              Office Hours
            </h3>
            <div style="display:flex; flex-direction:column; gap:12px;">
              <div style="display:flex; justify-content:space-between; padding-bottom:12px; border-bottom:1px solid #eee;">
                <span style="font-weight:600;">Monday - Friday</span>
                <span style="color:#666;">8:00 AM - 5:00 PM</span>
              </div>
              <div style="display:flex; justify-content:space-between; padding-bottom:12px; border-bottom:1px solid #eee;">
                <span style="font-weight:600;">Saturday</span>
                <span style="color:#666;">9:00 AM - 1:00 PM</span>
              </div>
              <div style="display:flex; justify-content:space-between;">
                <span style="font-weight:600;">Sunday & Holidays</span>
                <span style="color:#666;">Closed</span>
              </div>
            </div>
          </div>
        </div>

      </div>
    </div>
  </section>

  <!-- GOOGLE MAP -->
  <section style="background: var(--white);">
    <div class="container" style="padding-top:48px; padding-bottom:48px;">
      <div class="section-header fade-up">
        <div class="section-label">Find Us</div>
        <h2 class="section-title">Our Location</h2>
      </div>
      <div class="fade-up" style="border-radius:16px; overflow:hidden; box-shadow:0 4px 24px rgba(0,0,0,0.1);">
        <iframe
          src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3970.5!2d-0.05!3d5.63!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2sConstellations+Avenue%2C+Lashibi%2C+Accra%2C+Ghana!5e0!3m2!1sen!2sgh!4v1700000000000"
          width="100%"
          height="450"
          style="border:0; display:block;"
          allowfullscreen=""
          loading="lazy"
          referrerpolicy="no-referrer-when-downgrade"
          title="TIBST Location - Constellations Avenue, Lashibi, Accra, Ghana">
        </iframe>
      </div>
    </div>
  </section>

<?php require_once 'includes/footer.php'; ?>
