<?php
$pageTitle = 'Financial Aid & Scholarships - TIBST | Thrivus Institute of Biomedical Sciences & Technology';
$activePage = 'admissions';
require_once 'includes/header.php';
?>

  <!-- PAGE HERO -->
  <section class="page-hero">
    <div class="hero-bg" style="background-image: url('https://images.unsplash.com/photo-1434030216411-0b793f4b4173?w=1920&q=80');"></div>
    <div class="hero-overlay"></div>
    <div class="hero-pattern"></div>
    <div class="hero-content">
      <div class="breadcrumb">
        <a href="index.php">Home</a>
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9 18 15 12 9 6"></polyline></svg>
        <span>Financial Aid</span>
      </div>
      <h1>Financial Aid & <span class="highlight">Scholarships</span></h1>
      <p class="hero-subtitle">TIBST is committed to making postgraduate education accessible through a range of scholarships and financial support programmes.</p>
    </div>
  </section>

  <!-- ELIGIBILITY -->
  <section class="section" style="background: var(--off-white);">
    <div class="container">
      <div class="section-header fade-up">
        <div class="section-label">Requirements</div>
        <h2 class="section-title">Eligibility</h2>
        <p class="section-subtitle">To be considered for financial aid, applicants must demonstrate the following:</p>
      </div>

      <div class="fade-up" style="max-width: 800px; margin: 0 auto;">
        <div class="feature-card" style="text-align: left;">
          <ul style="list-style: disc; padding-left: 20px; display: flex; flex-direction: column; gap: 12px; font-size: 1.05rem; color: var(--gray-700);">
            <li>Strong academic record</li>
            <li>Aptitude for research</li>
            <li>Originality and innovation in research proposal</li>
            <li>Financial need</li>
            <li>Commitment to biomedical research in their home country</li>
          </ul>
        </div>
      </div>
    </div>
  </section>

  <!-- AVAILABLE SCHOLARSHIPS -->
  <section class="section" style="background: var(--white);">
    <div class="container">
      <div class="section-header fade-up">
        <div class="section-label">Funding Opportunities</div>
        <h2 class="section-title">Available Scholarships</h2>
        <p class="section-subtitle">Explore our range of scholarships designed to support exceptional students in their academic journey.</p>
      </div>

      <div class="features-grid" style="grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));">
        <div class="feature-card fade-up">
          <div class="feature-icon">
            <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2L2 7l10 5 10-5-10-5z"></path><path d="M2 17l10 5 10-5"></path><path d="M2 12l10 5 10-5"></path></svg>
          </div>
          <h3>Thrivus Research Grant</h3>
          <p>Partial funding for MPhil and PhD students conducting research in Gene Therapy and Human Embryology. Selection is based on project proposals and academic performance.</p>
          <p style="margin-top: 12px; font-size: 0.9rem; color: var(--gray-500);"><strong>Deadline:</strong> Within 7 days of admission application submission.</p>
        </div>

        <div class="feature-card fade-up fade-up-delay-1">
          <div class="feature-icon">
            <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><path d="M12 16v-4"></path><path d="M12 8h.01"></path></svg>
          </div>
          <h3>City of Hope Embryology (CoHE) Grant</h3>
          <p>Funding for PhD students researching Human Embryology in donor-determined project areas.</p>
          <p style="margin-top: 12px; font-size: 0.9rem; color: var(--gray-500);"><strong>Deadline:</strong> Within 7 days of admission application submission.</p>
        </div>

        <div class="feature-card fade-up fade-up-delay-2">
          <div class="feature-icon">
            <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
          </div>
          <h3>Akoben-Thrivus Scholarship</h3>
          <p>For PhD candidates studying Gene Therapy and Human Embryology who demonstrate research excellence.</p>
          <p style="margin-top: 12px; font-size: 0.9rem; color: var(--gray-500);"><strong>Deadline:</strong> Within 7 days of admission application submission.</p>
        </div>

        <div class="feature-card fade-up">
          <div class="feature-icon">
            <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path></svg>
          </div>
          <h3>Barroga Family Scholarship for Women in Science</h3>
          <p>Merit and need-based award for women pursuing Gene Therapy PhDs:</p>
          <ul style="list-style: disc; padding-left: 20px; margin-top: 8px; color: var(--gray-700); font-size: 0.95rem;">
            <li>$5,000 per year for 3 years ($15,000 total tuition)</li>
            <li>$1,000 per year for books and expenses</li>
            <li>Personal laptop computer</li>
          </ul>
        </div>
      </div>
    </div>
  </section>

  <!-- HOW TO APPLY -->
  <section class="section" style="background: var(--off-white);">
    <div class="container">
      <div class="section-header fade-up">
        <div class="section-label">Next Steps</div>
        <h2 class="section-title">How to Apply</h2>
        <p class="section-subtitle">Submit scholarship application forms along with your CV and a personal statement outlining your career goals within one week of receiving your admission offer.</p>
      </div>

      <div class="fade-up" style="text-align: center;">
        <a href="apply.php" class="btn btn-primary" style="font-size: 1.1rem; padding: 16px 40px;">Apply Now</a>
      </div>
    </div>
  </section>

  <!-- CTA -->
  <section class="cta-section section-sm">
    <div class="container">
      <div class="cta-content fade-up">
        <h2>Questions About Financial Aid?</h2>
        <p>Our admissions team is ready to help you explore funding options for your studies at TIBST.</p>
        <div style="display:flex; gap:16px; justify-content:center; flex-wrap:wrap;">
          <a href="contact.php" class="btn btn-white">Contact Us</a>
          <a href="apply.php" class="btn btn-outline">Apply Now</a>
        </div>
      </div>
    </div>
  </section>

<?php require_once 'includes/footer.php'; ?>
