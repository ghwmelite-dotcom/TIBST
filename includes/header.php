<?php
/**
 * Shared header partial — outputs everything from <!DOCTYPE html> through </header>.
 *
 * Expected variables before include:
 *   $pageTitle  (string) — used in <title>
 *   $activePage (string) — e.g. 'home', 'about', 'academics', etc.
 */

require_once __DIR__ . '/auth.php';
require_once __DIR__ . '/functions.php';

startSession();

$settings = getSettings();
$phone    = escape($settings['phone']    ?? '+233 302 957 663');
$email    = escape($settings['email']    ?? 'info@thrivusinstitute.edu.gh');
$facebook  = escape($settings['facebook']  ?? 'https://facebook.com');
$instagram = escape($settings['instagram'] ?? 'https://instagram.com');
$linkedin  = escape($settings['linkedin']  ?? 'https://linkedin.com');
$youtube   = escape($settings['youtube']   ?? 'https://youtube.com');
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= escape($pageTitle) ?></title>
  <meta name="description" content="Thrivus Institute of Biomedical Sciences & Technology - Your career starts with us. Offering MPhil and PhD programmes in Gene Therapy and Human Embryology.">
  <link rel="stylesheet" href="css/styles.css">
  <link rel="stylesheet" href="css/loader.css">
  <link rel="stylesheet" href="css/effects.css">
  <link rel="stylesheet" href="css/transitions.css">
  <link rel="stylesheet" href="css/bento.css">
  <link rel="stylesheet" href="css/carousel.css">
  <link rel="stylesheet" href="css/timeline.css">
  <link rel="stylesheet" href="css/nav-footer.css">
  <link rel="stylesheet" href="css/comparison.css">
  <link rel="stylesheet" href="css/research-viz.css">
  <link rel="stylesheet" href="css/gallery-lightbox.css">
  <link rel="stylesheet" href="css/dark-mode.css">
<?php if (!empty($settings['site_favicon'])): ?>
  <link rel="icon" href="<?= escape($settings['site_favicon']) ?>">
<?php else: ?>
  <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><rect fill='%234E9B17' rx='20' width='100' height='100'/><text x='50' y='68' font-size='50' text-anchor='middle' fill='white' font-family='serif' font-weight='bold'>T</text></svg>">
<?php endif; ?>
</head>
<body>

  <!-- TOP BAR -->
  <div class="top-bar">
    <div class="container" style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:8px;">
      <div style="display:flex; gap:24px; align-items:center;">
        <a href="tel:<?= escape(preg_replace('/\s+/', '', $settings['phone'] ?? '+233302957663')) ?>" style="display:flex; align-items:center; gap:6px;">
          <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z"></path></svg>
          <?= $phone ?>
        </a>
        <a href="mailto:<?= $email ?>" style="display:flex; align-items:center; gap:6px;">
          <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>
          <?= $email ?>
        </a>
      </div>
      <div style="display:flex; gap:16px; align-items:center;">
        <a href="library.php">Library</a>
        <a href="news-events.php">Blog</a>
        <a href="gallery.php">Gallery</a>
        <a href="support.php">Support Thrivus</a>
        <a href="portal.php">Portal</a>
        <div style="display:flex; gap:10px; margin-left:8px;">
          <a href="<?= $facebook ?>" target="_blank" aria-label="Facebook">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
          </a>
          <a href="<?= $instagram ?>" target="_blank" aria-label="Instagram">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/></svg>
          </a>
          <a href="<?= $linkedin ?>" target="_blank" aria-label="LinkedIn">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433a2.062 2.062 0 01-2.063-2.065 2.064 2.064 0 112.063 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>
          </a>
          <a href="<?= $youtube ?>" target="_blank" aria-label="YouTube">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>
          </a>
        </div>
      </div>
    </div>
  </div>

  <!-- HEADER -->
  <header class="main-header" id="main-header">
    <div class="nav-container">
      <a href="index.php" class="logo">
        <?php if (!empty($settings['site_logo'])): ?>
        <img src="<?= escape($settings['site_logo']) ?>" alt="<?= escape($settings['site_short_name'] ?? 'TIBST') ?>" class="logo-img">
        <?php else: ?>
        <div class="logo-icon">T</div>
        <div class="logo-text">
          <span class="logo-name"><?= escape($settings['site_short_name'] ?? 'TIBST') ?></span>
          <span class="logo-full"><?= escape($settings['site_name'] ?? 'Thrivus Institute of Biomedical Sciences & Technology') ?></span>
        </div>
        <?php endif; ?>
      </a>

      <nav>
        <ul class="nav-menu" id="nav-menu">
          <li><a href="index.php" class="nav-link<?= $activePage === 'home' ? ' active' : '' ?>">Home</a></li>
          <li class="dropdown">
            <a href="about.php" class="nav-link<?= ($activePage === 'about' || $activePage === 'student-life') ? ' active' : '' ?>">Discover <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 12 15 18 9"></polyline></svg></a>
            <ul class="dropdown-menu">
              <li><a href="about.php#mission">Mission & Vision</a></li>
              <li><a href="about.php#governing-council">Governing Council</a></li>
              <li><a href="about.php#executive-team">Executive Team</a></li>
              <li><a href="about.php#academic-staff">Academic Staff</a></li>
              <li><a href="about.php#administration">Administration</a></li>
              <li><a href="student-life.php">Life at TIBST</a></li>
              <li><a href="gallery.php">Gallery</a></li>
              <li><a href="careers.php">Join Our Team</a></li>
            </ul>
          </li>
          <li class="dropdown">
            <a href="academics.php" class="nav-link<?= $activePage === 'academics' ? ' active' : '' ?>">Academics <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 12 15 18 9"></polyline></svg></a>
            <ul class="dropdown-menu">
              <li><a href="academics.php#postgraduate">Postgraduate Degrees</a></li>
              <li><a href="academics.php#certificate">Certificate Programmes</a></li>
            </ul>
          </li>
          <li class="dropdown">
            <a href="admissions.php" class="nav-link<?= $activePage === 'admissions' ? ' active' : '' ?>">Admissions <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 12 15 18 9"></polyline></svg></a>
            <ul class="dropdown-menu">
              <li><a href="apply.php">Apply to Thrivus</a></li>
              <li><a href="financial-aid.php">Financial Aid</a></li>
            </ul>
          </li>
          <li><a href="research.php" class="nav-link<?= $activePage === 'research' ? ' active' : '' ?>">Research</a></li>
          <li><a href="contact.php" class="nav-link<?= $activePage === 'contact' ? ' active' : '' ?>">Contact</a></li>
          <li><a href="apply.php" class="btn btn-primary btn-sm" style="margin-left:8px;">Apply Now</a></li>
        </ul>
      </nav>

      <button class="hamburger" id="hamburger" onclick="toggleMobileNav()" aria-label="Toggle menu">
        <span></span><span></span><span></span>
      </button>
    </div>
  </header>
