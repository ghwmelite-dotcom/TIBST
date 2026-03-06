<?php
$pageTitle = 'Admissions - TIBST | Thrivus Institute of Biomedical Sciences & Technology';
$activePage = 'admissions';
require_once 'includes/header.php';

// ── Fetch dynamic content ──────────────────────────────────────────
$admissionsIntro   = getPageBlock('admissions', 'intro');
$admissionsProcess = getPageBlock('admissions', 'process');
$admissionsFees    = getPageBlock('admissions', 'fees');
$admissionsAid     = getPageBlock('admissions', 'financial_aid');
?>

  <!-- PAGE HERO -->
  <section class="page-hero">
    <div class="hero-bg" style="background-image: url('https://images.unsplash.com/photo-1523050854058-8df90110c9f1?w=1920&q=80');"></div>
    <div class="hero-overlay"></div>
    <div class="hero-pattern"></div>

    <div class="page-hero-content">
      <div class="breadcrumb">
        <a href="index.php">Home</a>
        <span class="separator">/</span>
        <span>Admissions</span>
      </div>
      <div class="hero-badge">2026/2027 Admissions Open</div>
      <h1>Admissions</h1>
      <p>Begin your journey at TIBST. Explore our application process, entry requirements, fees, and financial support options for the upcoming academic year.</p>
    </div>
  </section>

  <!-- HOW TO APPLY -->
  <section class="section" style="background: var(--off-white);">
    <div class="container">
      <div class="section-header fade-up">
        <div class="section-label">Application Process</div>
        <h2 class="section-title">How to Apply</h2>
        <p class="section-subtitle">Follow these steps to submit your application for admission to any of our postgraduate or certificate programmes.</p>
      </div>

      <?php if (!empty($admissionsProcess)): ?>
      <div class="fade-up"><?= $admissionsProcess ?></div>
      <?php else: ?>
      <div class="timeline fade-up">
        <div class="timeline-item">
          <div class="timeline-year">Step 1</div>
          <h3 style="font-size:1.1rem; margin-bottom:8px;">Review Programme Requirements</h3>
          <p style="font-size:0.9rem; color:var(--gray-600); line-height:1.7;">Browse our <a href="academics.php" style="color:var(--primary); text-decoration:underline;">academic programmes</a> and confirm you meet the entry requirements for your chosen programme. Check the entry requirements section below for specific details.</p>
        </div>

        <div class="timeline-item">
          <div class="timeline-year">Step 2</div>
          <h3 style="font-size:1.1rem; margin-bottom:8px;">Create a Portal Account</h3>
          <p style="font-size:0.9rem; color:var(--gray-600); line-height:1.7;">Visit the <a href="portal.php" style="color:var(--primary); text-decoration:underline;">TIBST Student Portal</a> and create an applicant account. You will use this account to complete and track your application.</p>
        </div>

        <div class="timeline-item">
          <div class="timeline-year">Step 3</div>
          <h3 style="font-size:1.1rem; margin-bottom:8px;">Complete the Application Form</h3>
          <p style="font-size:0.9rem; color:var(--gray-600); line-height:1.7;">Fill out the online application form with your personal details, academic history, and programme preference. Upload required documents including transcripts, certificates, and a personal statement.</p>
        </div>

        <div class="timeline-item">
          <div class="timeline-year">Step 4</div>
          <h3 style="font-size:1.1rem; margin-bottom:8px;">Pay Application Fee</h3>
          <p style="font-size:0.9rem; color:var(--gray-600); line-height:1.7;">Submit a non-refundable application fee of GHS 250 via the online payment portal. Payment can be made using mobile money, bank transfer, or debit/credit card.</p>
        </div>

        <div class="timeline-item">
          <div class="timeline-year">Step 5</div>
          <h3 style="font-size:1.1rem; margin-bottom:8px;">Submit & Await Decision</h3>
          <p style="font-size:0.9rem; color:var(--gray-600); line-height:1.7;">Review your application and submit it. The admissions committee will review your application and notify you of the decision via email within 4-6 weeks. Successful applicants will receive an offer letter with enrolment instructions.</p>
        </div>
      </div>
      <?php endif; ?>
    </div>
  </section>

  <!-- ENTRY REQUIREMENTS -->
  <section class="section" style="background: var(--white);">
    <div class="container">
      <div class="section-header fade-up">
        <div class="section-label">Eligibility</div>
        <h2 class="section-title">Entry Requirements</h2>
        <p class="section-subtitle">Each programme has specific academic and professional prerequisites. Click on a programme below to view its requirements.</p>
      </div>

      <div class="fade-up">
        <div class="accordion-item">
          <div class="accordion-header" onclick="toggleAccordion(this)">
            <span>MPhil Gene Therapy</span>
            <span class="accordion-icon">+</span>
          </div>
          <div class="accordion-body">
            <div class="accordion-body-inner">
              <ul style="padding-left:20px; margin-bottom:12px;">
                <li>A good first degree (Bachelor's) in Biomedical Sciences, Molecular Biology, Biochemistry, Medicine, or a related field from a recognised institution.</li>
                <li>Minimum second-class upper division or equivalent GPA (3.0/4.0).</li>
                <li>Two academic reference letters from qualified referees.</li>
                <li>A personal statement outlining research interests and career goals (500-1000 words).</li>
                <li>Proficiency in English (IELTS 6.5 or TOEFL 80 for international applicants whose first language is not English).</li>
              </ul>
              <p><strong>Duration:</strong> 2-3 Years | <strong>Mode:</strong> Full-time</p>
            </div>
          </div>
        </div>

        <div class="accordion-item">
          <div class="accordion-header" onclick="toggleAccordion(this)">
            <span>PhD Gene Therapy</span>
            <span class="accordion-icon">+</span>
          </div>
          <div class="accordion-body">
            <div class="accordion-body-inner">
              <ul style="padding-left:20px; margin-bottom:12px;">
                <li>A Master's degree (MPhil or MSc) in Gene Therapy, Molecular Biology, Biomedical Sciences, or a closely related field.</li>
                <li>Evidence of research capability, such as a published thesis or research paper.</li>
                <li>A detailed research proposal (2000-3000 words) aligned with TIBST's research focus areas.</li>
                <li>Two academic reference letters, at least one from a previous research supervisor.</li>
                <li>Proficiency in English (IELTS 6.5 or TOEFL 80 for international applicants).</li>
              </ul>
              <p><strong>Duration:</strong> 2-3 Years | <strong>Mode:</strong> Full-time</p>
            </div>
          </div>
        </div>

        <div class="accordion-item">
          <div class="accordion-header" onclick="toggleAccordion(this)">
            <span>MPhil Human Embryology</span>
            <span class="accordion-icon">+</span>
          </div>
          <div class="accordion-body">
            <div class="accordion-body-inner">
              <ul style="padding-left:20px; margin-bottom:12px;">
                <li>A good first degree (Bachelor's) in Human Biology, Medicine, Anatomy, Reproductive Sciences, or a related field.</li>
                <li>Minimum second-class upper division or equivalent GPA (3.0/4.0).</li>
                <li>Two academic reference letters from qualified referees.</li>
                <li>A personal statement outlining research interests in embryology and developmental biology (500-1000 words).</li>
                <li>Proficiency in English (IELTS 6.5 or TOEFL 80 for international applicants).</li>
              </ul>
              <p><strong>Duration:</strong> 2-3 Years | <strong>Mode:</strong> Full-time</p>
            </div>
          </div>
        </div>

        <div class="accordion-item">
          <div class="accordion-header" onclick="toggleAccordion(this)">
            <span>Certificate Programmes</span>
            <span class="accordion-icon">+</span>
          </div>
          <div class="accordion-body">
            <div class="accordion-body-inner">
              <ul style="padding-left:20px; margin-bottom:12px;">
                <li>A Bachelor's degree in any science-related field from a recognised institution, or equivalent professional experience.</li>
                <li>Healthcare professionals with relevant clinical experience are encouraged to apply.</li>
                <li>A brief statement of purpose explaining why you wish to enrol in the certificate programme (300-500 words).</li>
                <li>One professional or academic reference letter.</li>
              </ul>
              <p><strong>Duration:</strong> 6-12 Months | <strong>Mode:</strong> Full-time or Part-time</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- FEES STRUCTURE -->
  <section id="fees" class="section" style="background: var(--off-white);">
    <div class="container">
      <div class="section-header fade-up">
        <div class="section-label">Tuition & Costs</div>
        <h2 class="section-title">Fees Structure</h2>
        <p class="section-subtitle">Below is the fee schedule for the 2026/2027 academic year. All amounts are quoted in Ghana Cedis (GHS).</p>
      </div>

      <?php if (!empty($admissionsFees)): ?>
      <div class="fade-up"><?= $admissionsFees ?></div>
      <?php else: ?>
      <div class="table-wrapper fade-up">
        <table class="styled-table">
          <thead>
            <tr>
              <th>Programme</th>
              <th>Tuition (Per Year)</th>
              <th>Application Fee</th>
              <th>Registration Fee</th>
              <th>Total Year 1</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td><strong>MPhil Gene Therapy</strong></td>
              <td>GHS 18,500</td>
              <td>GHS 250</td>
              <td>GHS 1,200</td>
              <td><strong>GHS 19,950</strong></td>
            </tr>
            <tr>
              <td><strong>PhD Gene Therapy</strong></td>
              <td>GHS 22,000</td>
              <td>GHS 250</td>
              <td>GHS 1,500</td>
              <td><strong>GHS 23,750</strong></td>
            </tr>
            <tr>
              <td><strong>MPhil Human Embryology</strong></td>
              <td>GHS 18,500</td>
              <td>GHS 250</td>
              <td>GHS 1,200</td>
              <td><strong>GHS 19,950</strong></td>
            </tr>
            <tr>
              <td><strong>Certificate Programmes</strong></td>
              <td>GHS 8,000</td>
              <td>GHS 150</td>
              <td>GHS 500</td>
              <td><strong>GHS 8,650</strong></td>
            </tr>
          </tbody>
        </table>
      </div>

      <div class="fade-up" style="margin-top:24px;">
        <p style="font-size:0.88rem; color:var(--gray-500); line-height:1.8;">
          <strong style="color:var(--gray-700);">Note:</strong> Fees are subject to review annually. International students may be subject to additional administrative fees. Laboratory and research materials fees may apply for certain programmes. Payment plans are available upon request.
        </p>
      </div>
      <?php endif; ?>
    </div>
  </section>

  <!-- FINANCIAL AID & SPONSORSHIP -->
  <section id="financial-aid" class="section" style="background: var(--white);">
    <div class="container">
      <div style="display:grid; grid-template-columns: 1fr 1fr; gap:60px; align-items:center;">
        <div class="fade-up">
          <div class="section-label">Support Your Studies</div>
          <h2 class="section-title">Financial Aid & Sponsorship</h2>
          <p style="color:var(--gray-600); line-height:1.8; margin-bottom:24px;">At TIBST, we believe financial constraints should not prevent talented individuals from pursuing advanced education in biomedical sciences. We offer a range of financial support options to help you fund your studies.</p>

          <div style="margin-bottom:20px;">
            <h3 style="font-size:1.1rem; margin-bottom:8px; color:var(--secondary);">Merit-Based Scholarships</h3>
            <p style="font-size:0.9rem; color:var(--gray-600); line-height:1.7;">Available to applicants who demonstrate outstanding academic achievement. Covers up to 50% of tuition fees for the duration of the programme.</p>
          </div>

          <div style="margin-bottom:20px;">
            <h3 style="font-size:1.1rem; margin-bottom:8px; color:var(--secondary);">Research Assistantships</h3>
            <p style="font-size:0.9rem; color:var(--gray-600); line-height:1.7;">PhD students may be offered funded research assistantship positions within our translational research units, providing a monthly stipend and tuition waiver.</p>
          </div>

          <div style="margin-bottom:20px;">
            <h3 style="font-size:1.1rem; margin-bottom:8px; color:var(--secondary);">Need-Based Financial Aid</h3>
            <p style="font-size:0.9rem; color:var(--gray-600); line-height:1.7;">Students who can demonstrate financial need may apply for partial fee waivers or flexible payment arrangements. Supporting documentation is required.</p>
          </div>

          <div>
            <h3 style="font-size:1.1rem; margin-bottom:8px; color:var(--secondary);">External Sponsorship</h3>
            <p style="font-size:0.9rem; color:var(--gray-600); line-height:1.7;">TIBST partners with organisations and government bodies that sponsor students in biomedical fields. Contact the admissions office for a list of current sponsorship opportunities.</p>
          </div>
        </div>

        <div class="fade-up fade-up-delay-1">
          <div style="border-radius:16px; overflow:hidden; position:relative;">
            <img src="https://images.unsplash.com/photo-1434030216411-0b793f4b4173?w=800&q=80" alt="Student studying at TIBST" style="width:100%; height:400px; object-fit:cover; border-radius:16px;">
          </div>
          <div style="background:var(--primary-light); border-radius:12px; padding:24px; margin-top:20px;">
            <h4 style="font-size:1rem; color:var(--primary-dark); margin-bottom:8px;">Eligibility for Financial Aid</h4>
            <ul style="font-size:0.88rem; color:var(--gray-600); line-height:1.8; padding-left:18px;">
              <li>Must have received an offer of admission from TIBST</li>
              <li>Must maintain a satisfactory academic standing</li>
              <li>Must submit a financial aid application by the stated deadline</li>
              <li>Merit scholarships require a minimum GPA of 3.5/4.0 or equivalent</li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- IMPORTANT DATES -->
  <section class="section" style="background: var(--off-white);">
    <div class="container">
      <div class="section-header fade-up">
        <div class="section-label">Mark Your Calendar</div>
        <h2 class="section-title">Important Dates</h2>
        <p class="section-subtitle">Key dates and deadlines for the 2026/2027 admissions cycle. We encourage early application.</p>
      </div>

      <div style="display:grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap:24px;">
        <div class="feature-card fade-up">
          <div class="feature-icon">
            <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
          </div>
          <h3>Applications Open</h3>
          <p style="color:var(--primary); font-weight:600; font-size:1rem; margin-bottom:4px;">March 1, 2026</p>
          <p>Online application portal opens for all programmes for the 2026/2027 academic year.</p>
        </div>

        <div class="feature-card fade-up fade-up-delay-1">
          <div class="feature-icon">
            <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
          </div>
          <h3>Early Application Deadline</h3>
          <p style="color:var(--primary); font-weight:600; font-size:1rem; margin-bottom:4px;">June 30, 2026</p>
          <p>Submit your application early for priority consideration and early decision notification.</p>
        </div>

        <div class="feature-card fade-up fade-up-delay-2">
          <div class="feature-icon">
            <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
          </div>
          <h3>Final Application Deadline</h3>
          <p style="color:var(--primary); font-weight:600; font-size:1rem; margin-bottom:4px;">August 31, 2026</p>
          <p>Last date to submit applications. Late applications will only be considered if spaces remain.</p>
        </div>

        <div class="feature-card fade-up">
          <div class="feature-icon">
            <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
          </div>
          <h3>Financial Aid Deadline</h3>
          <p style="color:var(--primary); font-weight:600; font-size:1rem; margin-bottom:4px;">July 15, 2026</p>
          <p>Deadline to submit financial aid and scholarship applications for the upcoming academic year.</p>
        </div>

        <div class="feature-card fade-up fade-up-delay-1">
          <div class="feature-icon">
            <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
          </div>
          <h3>Orientation Week</h3>
          <p style="color:var(--primary); font-weight:600; font-size:1rem; margin-bottom:4px;">September 21-25, 2026</p>
          <p>New student orientation, campus tours, and registration for the first semester.</p>
        </div>

        <div class="feature-card fade-up fade-up-delay-2">
          <div class="feature-icon">
            <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
          </div>
          <h3>Lectures Begin</h3>
          <p style="color:var(--primary); font-weight:600; font-size:1rem; margin-bottom:4px;">October 1, 2026</p>
          <p>First day of lectures and academic activities for the 2026/2027 academic year.</p>
        </div>
      </div>
    </div>
  </section>

  <!-- APPLY NOW CTA -->
  <section class="cta-section section-sm">
    <div class="container">
      <div class="cta-content fade-up">
        <h2>Ready to Begin Your Journey?</h2>
        <p>Take the first step towards a career in biomedical science. Apply now for the 2026/2027 academic year and join the TIBST community.</p>
        <div style="display:flex; gap:16px; justify-content:center; flex-wrap:wrap;">
          <a href="portal.php" class="btn btn-white">Apply Now</a>
          <a href="contact.php" class="btn btn-outline">Contact Admissions</a>
        </div>
      </div>
    </div>
  </section>

<?php require_once 'includes/footer.php'; ?>
