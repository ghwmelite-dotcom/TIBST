<?php
$pageTitle = 'Join Our Team - TIBST | Thrivus Institute of Biomedical Sciences & Technology';
$activePage = 'about';
require_once 'includes/header.php';
?>

  <!-- PAGE HERO -->
  <section class="page-hero">
    <div class="hero-bg" style="background-image: url('https://images.unsplash.com/photo-1521737711867-e3b97375f902?w=1920&q=80');"></div>
    <div class="hero-overlay"></div>
    <div class="hero-pattern"></div>
    <div class="hero-content">
      <div class="breadcrumb">
        <a href="index.php">Home</a>
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9 18 15 12 9 6"></polyline></svg>
        <span>Careers</span>
      </div>
      <h1>Join Our <span class="highlight">Team</span></h1>
      <p class="hero-subtitle">We are looking for qualified people to fill the following positions.</p>
    </div>
  </section>

  <!-- CURRENT OPENINGS -->
  <section class="section" style="background: var(--off-white);">
    <div class="container">
      <div class="section-header fade-up">
        <div class="section-label">Opportunities</div>
        <h2 class="section-title">Current Openings</h2>
        <p class="section-subtitle">Explore available positions at TIBST and become part of our mission to advance biomedical science.</p>
      </div>

      <div class="fade-up" style="max-width: 800px; margin: 0 auto;">
        <div class="feature-card" style="text-align: left;">
          <div class="feature-icon">
            <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="7" width="20" height="14" rx="2" ry="2"></rect><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"></path></svg>
          </div>
          <h3>Administrative Assistant</h3>
          <p>We are seeking a qualified Administrative Assistant to join our team. The ideal candidate will have strong organizational skills, attention to detail, and a passion for supporting academic institutions.</p>
          <p style="margin-top: 16px; color: var(--gray-700);">Interested candidates should submit their CV and Cover Letter to:</p>
          <p style="margin-top: 8px;">
            <a href="mailto:info@thrivusinstitute.edu.gh" class="btn btn-primary btn-sm" style="display: inline-flex; align-items: center; gap: 8px;">
              <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>
              info@thrivusinstitute.edu.gh
            </a>
          </p>
        </div>
      </div>
    </div>
  </section>

  <!-- CTA -->
  <section class="cta-section section-sm">
    <div class="container">
      <div class="cta-content fade-up">
        <h2>Don't See a Fit?</h2>
        <p>We are always on the lookout for talented individuals. Send us your CV and we will keep it on file for future opportunities.</p>
        <a href="mailto:info@thrivusinstitute.edu.gh" class="btn btn-white">Send Your CV</a>
      </div>
    </div>
  </section>

<?php require_once 'includes/footer.php'; ?>
