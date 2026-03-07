<?php
/**
 * Shared footer partial — outputs everything from <footer> through </html>.
 */

if (!function_exists('getSettings')) {
    require_once __DIR__ . '/functions.php';
}

$_footerSettings = getSettings();
$_footerPhone     = escape($_footerSettings['phone']     ?? '+233 302 957 663');
$_footerEmail     = escape($_footerSettings['email']     ?? 'info@thrivusinstitute.edu.gh');
$_footerFacebook  = escape($_footerSettings['facebook']  ?? 'https://facebook.com');
$_footerInstagram = escape($_footerSettings['instagram'] ?? 'https://instagram.com');
$_footerLinkedin  = escape($_footerSettings['linkedin']  ?? 'https://linkedin.com');
$_footerYoutube   = escape($_footerSettings['youtube']   ?? 'https://youtube.com');
?>

  <!-- FOOTER -->
  <footer class="footer">
    <div class="container">
      <div class="footer-grid">
        <div class="footer-brand">
          <div class="logo" style="margin-bottom:8px;">
            <?php if (!empty($_footerSettings['site_logo'])): ?>
            <img src="<?= escape($_footerSettings['site_logo']) ?>" alt="<?= escape($_footerSettings['site_short_name'] ?? 'TIBST') ?>" class="logo-img">
            <?php else: ?>
            <div class="logo-icon">T</div>
            <div class="logo-text">
              <span class="logo-name" style="color:white;"><?= escape($_footerSettings['site_short_name'] ?? 'TIBST') ?></span>
              <span class="logo-full"><?= escape($_footerSettings['site_name'] ?? 'Thrivus Institute of Biomedical Sciences & Technology') ?></span>
            </div>
            <?php endif; ?>
          </div>
          <p>Shaping the future of biomedical science through innovative research and world-class postgraduate education. Your career starts with us.</p>
          <div class="footer-social">
            <a href="<?= $_footerFacebook ?>" target="_blank" aria-label="Facebook"><svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg></a>
            <a href="<?= $_footerInstagram ?>" target="_blank" aria-label="Instagram"><svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/></svg></a>
            <a href="<?= $_footerLinkedin ?>" target="_blank" aria-label="LinkedIn"><svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433a2.062 2.062 0 01-2.063-2.065 2.064 2.064 0 112.063 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg></a>
            <a href="<?= $_footerYoutube ?>" target="_blank" aria-label="YouTube"><svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg></a>
          </div>
        </div>

        <div>
          <h4>Quick Links</h4>
          <ul class="footer-links">
            <li><a href="about.php">About Us</a></li>
            <li><a href="academics.php">Programmes</a></li>
            <li><a href="admissions.php">Admissions</a></li>
            <li><a href="research.php">Research</a></li>
            <li><a href="news-events.php">News & Events</a></li>
            <li><a href="contact.php">Contact</a></li>
            <li><a href="apply.php">Apply Now</a></li>
            <li><a href="financial-aid.php">Financial Aid</a></li>
          </ul>
        </div>

        <div>
          <h4>Resources</h4>
          <ul class="footer-links">
            <li><a href="library.php">Library</a></li>
            <li><a href="portal.php">Student Portal</a></li>
            <li><a href="portal.php">Staff Portal</a></li>
            <li><a href="admissions.php#financial-aid">Financial Aid</a></li>
            <li><a href="student-life.php">Campus Life</a></li>
            <li><a href="gallery.php">Gallery</a></li>
            <li><a href="support.php">Support Thrivus</a></li>
            <li><a href="careers.php">Careers</a></li>
          </ul>
        </div>

        <div>
          <h4>Contact Us</h4>
          <ul class="footer-links">
            <li style="display:flex; gap:8px; align-items:flex-start;">
              <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="flex-shrink:0; margin-top:3px;"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
              <?= escape($_footerSettings['address'] ?? 'Constellations Avenue, Lashibi - Accra, Ghana') ?>
            </li>
            <li style="display:flex; gap:8px; align-items:center;">
              <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="flex-shrink:0;"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z"></path></svg>
              <?= $_footerPhone ?>
            </li>
            <li style="display:flex; gap:8px; align-items:center;">
              <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="flex-shrink:0;"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>
              <?= $_footerEmail ?>
            </li>
          </ul>
          <div class="footer-newsletter" style="margin-top:16px;">
            <input type="email" placeholder="Subscribe to newsletter...">
            <button class="btn btn-primary btn-sm" style="width:100%;">Subscribe</button>
          </div>
        </div>
      </div>

      <div class="footer-bottom">
        &copy; <?= date('Y') ?> <?= escape($_footerSettings['site_name'] ?? 'Thrivus Institute of Biomedical Sciences & Technology') ?>. All rights reserved.
      </div>
    </div>
  </footer>

  <script src="js/main.js"></script>
  <script src="js/chatbot.js"></script>
</body>
</html>
