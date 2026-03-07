<?php
$pageTitle = 'Academics - TIBST | Thrivus Institute of Biomedical Sciences & Technology';
$activePage = 'academics';
require_once 'includes/header.php';

// ── Fetch dynamic content ──────────────────────────────────────────
$allProgrammes = getAllProgrammes();
?>

  <!-- PAGE HERO -->
  <section class="page-hero" style="background-image: url('https://images.unsplash.com/photo-1532094349884-543bc11b234d?w=1920&q=80');">
    <div class="hero-overlay"></div>
    <div class="container" style="position:relative; z-index:2;">
      <div class="page-hero-content fade-up">
        <nav class="breadcrumb">
          <a href="index.php">Home</a>
          <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9 18 15 12 9 6"></polyline></svg>
          <span>Academics</span>
        </nav>
        <h1>Academic Programmes</h1>
        <p>Discover our world-class postgraduate and certificate programmes designed to advance the frontiers of biomedical science and technology.</p>
      </div>
    </div>
  </section>

  <!-- PROGRAMS OVERVIEW INTRO -->
  <section class="section" style="background: var(--white);">
    <div class="container">
      <div class="section-header fade-up">
        <div class="section-label">Academic Excellence</div>
        <h2 class="section-title">Programmes Built for Impact</h2>
        <p class="section-subtitle">At TIBST, our academic programmes are designed to bridge the gap between theoretical knowledge and practical application. Whether you are pursuing a postgraduate degree or a professional certificate, you will benefit from rigorous curricula, expert mentorship, and cutting-edge research facilities that prepare you to lead in the biomedical sciences.</p>
      </div>

      <div class="features-grid" style="margin-top:48px;">
        <div class="feature-card fade-up">
          <div class="feature-icon">
            <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 10v6M2 10l10-5 10 5-10 5z"></path><path d="M6 12v5c3 3 6 3 6 3s3 0 6-3v-5"></path></svg>
          </div>
          <h3>Research-Driven Curriculum</h3>
          <p>Every programme integrates original research, ensuring graduates contribute meaningfully to scientific knowledge from day one.</p>
        </div>

        <div class="feature-card fade-up fade-up-delay-1">
          <div class="feature-icon">
            <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94l-3.76 3.76z"></path></svg>
          </div>
          <h3>Hands-On Laboratory Training</h3>
          <p>Gain practical experience in our state-of-the-art translational research units, working alongside leading biomedical scientists.</p>
        </div>

        <div class="feature-card fade-up fade-up-delay-2">
          <div class="feature-icon">
            <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><line x1="2" y1="12" x2="22" y2="12"></line><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"></path></svg>
          </div>
          <h3>Globally Recognised Qualifications</h3>
          <p>Our degrees and certificates are recognised internationally, opening doors to careers and further studies across the globe.</p>
        </div>
      </div>
    </div>
  </section>

  <!-- POSTGRADUATE DEGREES -->
  <section class="section" id="postgraduate" style="background: var(--off-white);">
    <div class="container">
      <div class="section-header fade-up">
        <div class="section-label">Postgraduate Degrees</div>
        <h2 class="section-title">MPhil & PhD Programmes</h2>
        <p class="section-subtitle">Our postgraduate degree programmes combine advanced coursework with original research, preparing graduates to become leaders in gene therapy and human embryology.</p>
      </div>

<?php
// Filter postgraduate programmes from DB
$postgraduateProgs = array_filter($allProgrammes, function($p) {
    $dt = strtolower($p['degree_type']);
    return $dt === 'mphil' || $dt === 'phd';
});
?>

<?php if (!empty($postgraduateProgs)): ?>
      <div class="programs-grid" style="margin-top:48px;">
        <?php foreach ($postgraduateProgs as $i => $prog): ?>
        <div class="program-card fade-up <?= $i % 2 === 1 ? 'fade-up-delay-1' : '' ?>">
          <div class="program-card-img" style="background-image: url('<?= $prog['image'] ? escape($prog['image']) : 'https://images.unsplash.com/photo-1579154204601-01588f351e67?w=800&q=80' ?>');">
            <span class="program-card-badge"><?= escape($prog['degree_type']) ?></span>
          </div>
          <div class="program-card-body">
            <h3 class="program-card-title"><?= escape($prog['title']) ?></h3>
            <p class="program-card-desc"><?= escape($prog['description']) ?></p>
            <div class="program-card-meta">
              <span><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg> <?= escape($prog['duration']) ?></span>
              <span><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 10v6M2 10l10-5 10 5-10 5z"></path><path d="M6 12v5c3 3 6 3 6 3s3 0 6-3v-5"></path></svg> <?= strtolower($prog['degree_type']) === 'phd' ? 'Doctoral' : 'Postgraduate' ?></span>
            </div>
          </div>
        </div>
        <?php endforeach; ?>
      </div>
<?php else: ?>
      <div class="programs-grid" style="margin-top:48px;">

        <!-- MPhil Gene Therapy -->
        <div class="program-card fade-up">
          <div class="program-card-img" style="background-image: url('https://images.unsplash.com/photo-1579154204601-01588f351e67?w=800&q=80');">
            <span class="program-card-badge">MPhil</span>
          </div>
          <div class="program-card-body">
            <h3 class="program-card-title">Gene Therapy</h3>
            <p class="program-card-desc">Explore the frontier of genetic medicine with our comprehensive MPhil programme. Students gain deep expertise in vector design, gene editing technologies, and therapeutic applications for inherited and acquired diseases.</p>
            <div class="program-card-meta">
              <span><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg> 2-3 Years</span>
              <span><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 10v6M2 10l10-5 10 5-10 5z"></path><path d="M6 12v5c3 3 6 3 6 3s3 0 6-3v-5"></path></svg> Postgraduate</span>
            </div>
            <div style="margin-top:16px; padding-top:16px; border-top:1px solid var(--gray-200);">
              <h4 style="font-size:0.85rem; font-weight:600; margin-bottom:8px; color:var(--primary);">Entry Requirements</h4>
              <ul style="font-size:0.85rem; color:var(--gray-600); line-height:1.7; padding-left:16px;">
                <li>Bachelor's degree in Biological Sciences, Biochemistry, Molecular Biology, or a related field</li>
                <li>Minimum Second Class Upper Division or equivalent</li>
                <li>Two academic references</li>
              </ul>
              <h4 style="font-size:0.85rem; font-weight:600; margin-top:12px; margin-bottom:8px; color:var(--primary);">Career Prospects</h4>
              <p style="font-size:0.85rem; color:var(--gray-600); line-height:1.7;">Graduates pursue careers in biomedical research, pharmaceutical development, clinical gene therapy, genetic counselling, and academic research positions worldwide.</p>
            </div>
          </div>
        </div>

        <!-- PhD Gene Therapy -->
        <div class="program-card fade-up fade-up-delay-1">
          <div class="program-card-img" style="background-image: url('https://images.unsplash.com/photo-1530026405186-ed1f139313f8?w=800&q=80');">
            <span class="program-card-badge">PhD</span>
          </div>
          <div class="program-card-body">
            <h3 class="program-card-title">Gene Therapy</h3>
            <p class="program-card-desc">Advance the frontiers of gene therapy research with our doctoral programme. Conduct original, independent research focusing on innovative therapeutic approaches, translational science, and next-generation gene delivery systems.</p>
            <div class="program-card-meta">
              <span><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg> 2-3 Years</span>
              <span><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 10v6M2 10l10-5 10 5-10 5z"></path><path d="M6 12v5c3 3 6 3 6 3s3 0 6-3v-5"></path></svg> Doctoral</span>
            </div>
            <div style="margin-top:16px; padding-top:16px; border-top:1px solid var(--gray-200);">
              <h4 style="font-size:0.85rem; font-weight:600; margin-bottom:8px; color:var(--primary);">Entry Requirements</h4>
              <ul style="font-size:0.85rem; color:var(--gray-600); line-height:1.7; padding-left:16px;">
                <li>MPhil or Master's degree in Gene Therapy, Molecular Biology, Genetics, or a related discipline</li>
                <li>Demonstrated research experience and a viable research proposal</li>
                <li>Two academic references and evidence of publications (preferred)</li>
              </ul>
              <h4 style="font-size:0.85rem; font-weight:600; margin-top:12px; margin-bottom:8px; color:var(--primary);">Career Prospects</h4>
              <p style="font-size:0.85rem; color:var(--gray-600); line-height:1.7;">PhD graduates lead research groups, head laboratory teams in pharmaceutical and biotech companies, take up faculty positions at universities, and drive policy in gene therapy regulation and ethics.</p>
            </div>
          </div>
        </div>

        <!-- MPhil Human Embryology -->
        <div class="program-card fade-up">
          <div class="program-card-img" style="background-image: url('https://images.unsplash.com/photo-1576086213369-97a306d36557?w=800&q=80');">
            <span class="program-card-badge">MPhil</span>
          </div>
          <div class="program-card-body">
            <h3 class="program-card-title">Human Embryology</h3>
            <p class="program-card-desc">Study the complex processes of human development with our MPhil programme. Integrate classical embryology with modern reproductive sciences, assisted reproduction technologies, and developmental biology research.</p>
            <div class="program-card-meta">
              <span><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg> 2-3 Years</span>
              <span><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 10v6M2 10l10-5 10 5-10 5z"></path><path d="M6 12v5c3 3 6 3 6 3s3 0 6-3v-5"></path></svg> Postgraduate</span>
            </div>
            <div style="margin-top:16px; padding-top:16px; border-top:1px solid var(--gray-200);">
              <h4 style="font-size:0.85rem; font-weight:600; margin-bottom:8px; color:var(--primary);">Entry Requirements</h4>
              <ul style="font-size:0.85rem; color:var(--gray-600); line-height:1.7; padding-left:16px;">
                <li>Bachelor's degree in Biomedical Sciences, Anatomy, Medicine, or a related field</li>
                <li>Minimum Second Class Upper Division or equivalent</li>
                <li>Two academic references</li>
              </ul>
              <h4 style="font-size:0.85rem; font-weight:600; margin-top:12px; margin-bottom:8px; color:var(--primary);">Career Prospects</h4>
              <p style="font-size:0.85rem; color:var(--gray-600); line-height:1.7;">Graduates enter careers in fertility clinics, reproductive medicine centres, developmental biology research, IVF laboratories, and academic teaching positions in anatomy and embryology.</p>
            </div>
          </div>
        </div>

        <!-- PhD Human Embryology -->
        <div class="program-card fade-up fade-up-delay-1">
          <div class="program-card-img" style="background-image: url('https://images.unsplash.com/photo-1532187863486-abf9dbad1b69?w=800&q=80');">
            <span class="program-card-badge">PhD</span>
          </div>
          <div class="program-card-body">
            <h3 class="program-card-title">Human Embryology</h3>
            <p class="program-card-desc">Pursue doctoral-level research in human embryology, investigating fundamental mechanisms of embryonic development, stem cell biology, congenital abnormalities, and advanced reproductive technologies.</p>
            <div class="program-card-meta">
              <span><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg> 2-3 Years</span>
              <span><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 10v6M2 10l10-5 10 5-10 5z"></path><path d="M6 12v5c3 3 6 3 6 3s3 0 6-3v-5"></path></svg> Doctoral</span>
            </div>
            <div style="margin-top:16px; padding-top:16px; border-top:1px solid var(--gray-200);">
              <h4 style="font-size:0.85rem; font-weight:600; margin-bottom:8px; color:var(--primary);">Entry Requirements</h4>
              <ul style="font-size:0.85rem; color:var(--gray-600); line-height:1.7; padding-left:16px;">
                <li>MPhil or Master's degree in Human Embryology, Reproductive Biology, Anatomy, or a related discipline</li>
                <li>Demonstrated research experience and a viable research proposal</li>
                <li>Two academic references and evidence of publications (preferred)</li>
              </ul>
              <h4 style="font-size:0.85rem; font-weight:600; margin-top:12px; margin-bottom:8px; color:var(--primary);">Career Prospects</h4>
              <p style="font-size:0.85rem; color:var(--gray-600); line-height:1.7;">PhD graduates lead reproductive science research, direct IVF and embryology laboratories, hold senior academic and clinical positions, and contribute to national and international reproductive health policy.</p>
            </div>
          </div>
        </div>

      </div>
<?php endif; ?>
    </div>
  </section>

  <!-- CERTIFICATE PROGRAMMES -->
  <section class="section" id="certificate" style="background: var(--white);">
    <div class="container">
      <div class="section-header fade-up">
        <div class="section-label">Professional Development</div>
        <h2 class="section-title">Certificate Programmes</h2>
        <p class="section-subtitle">Short-term, intensive certificate programmes designed for working professionals and recent graduates seeking specialised training in biomedical sciences.</p>
      </div>

<?php
// Filter certificate programmes from DB
$certProgs = array_filter($allProgrammes, function($p) {
    return strtolower($p['degree_type']) === 'certificate';
});
?>

<?php if (!empty($certProgs)): ?>
      <div class="programs-grid" style="margin-top:48px;">
        <?php foreach ($certProgs as $i => $prog): ?>
        <div class="program-card fade-up <?= $i % 3 === 1 ? 'fade-up-delay-1' : ($i % 3 === 2 ? 'fade-up-delay-2' : '') ?>">
          <div class="program-card-img" style="background-image: url('<?= $prog['image'] ? escape($prog['image']) : 'https://images.unsplash.com/photo-1581093588401-fbb62a02f120?w=800&q=80' ?>');">
            <span class="program-card-badge">Certificate</span>
          </div>
          <div class="program-card-body">
            <h3 class="program-card-title"><?= escape($prog['title']) ?></h3>
            <p class="program-card-desc"><?= escape($prog['description']) ?></p>
            <div class="program-card-meta">
              <span><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg> <?= escape($prog['duration']) ?></span>
              <span><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 10v6M2 10l10-5 10 5-10 5z"></path><path d="M6 12v5c3 3 6 3 6 3s3 0 6-3v-5"></path></svg> Professional</span>
            </div>
          </div>
        </div>
        <?php endforeach; ?>
      </div>
<?php else: ?>
      <div class="programs-grid" style="margin-top:48px;">

        <div class="program-card fade-up">
          <div class="program-card-img" style="background-image: url('https://images.unsplash.com/photo-1581093588401-fbb62a02f120?w=800&q=80');">
            <span class="program-card-badge">Certificate</span>
          </div>
          <div class="program-card-body">
            <h3 class="program-card-title">Assisted Reproductive Technology</h3>
            <p class="program-card-desc">A practical certificate programme covering IVF procedures, embryo culture, cryopreservation techniques, and quality management in reproductive laboratories.</p>
            <div class="program-card-meta">
              <span><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg> 6-12 Months</span>
              <span><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 10v6M2 10l10-5 10 5-10 5z"></path><path d="M6 12v5c3 3 6 3 6 3s3 0 6-3v-5"></path></svg> Professional</span>
            </div>
          </div>
        </div>

        <div class="program-card fade-up fade-up-delay-1">
          <div class="program-card-img" style="background-image: url('https://images.unsplash.com/photo-1614935151651-0bea6508db6b?w=800&q=80');">
            <span class="program-card-badge">Certificate</span>
          </div>
          <div class="program-card-body">
            <h3 class="program-card-title">Molecular Diagnostics</h3>
            <p class="program-card-desc">Gain expertise in PCR, genetic sequencing, biomarker analysis, and molecular diagnostic techniques used in clinical and research settings.</p>
            <div class="program-card-meta">
              <span><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg> 6-12 Months</span>
              <span><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 10v6M2 10l10-5 10 5-10 5z"></path><path d="M6 12v5c3 3 6 3 6 3s3 0 6-3v-5"></path></svg> Professional</span>
            </div>
          </div>
        </div>

        <div class="program-card fade-up fade-up-delay-2">
          <div class="program-card-img" style="background-image: url('https://images.unsplash.com/photo-1559757175-5700dde675bc?w=800&q=80');">
            <span class="program-card-badge">Certificate</span>
          </div>
          <div class="program-card-body">
            <h3 class="program-card-title">Biomedical Research Methods</h3>
            <p class="program-card-desc">An introductory certificate covering research design, biostatistics, laboratory safety, ethical considerations, and scientific writing for aspiring biomedical researchers.</p>
            <div class="program-card-meta">
              <span><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg> 6-12 Months</span>
              <span><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 10v6M2 10l10-5 10 5-10 5z"></path><path d="M6 12v5c3 3 6 3 6 3s3 0 6-3v-5"></path></svg> Professional</span>
            </div>
          </div>
        </div>

      </div>
<?php endif; ?>
    </div>
  </section>

  <!-- PROGRAMME COMPARISON TOOL -->
  <section class="section" style="background: var(--white);">
    <div class="container">
      <div class="section-header fade-up">
        <div class="section-label">Compare</div>
        <h2 class="section-title">Compare Programmes</h2>
        <p class="section-subtitle">Not sure which programme is right for you? Compare our offerings side by side to find the perfect fit for your career goals.</p>
      </div>
      <div id="programme-compare" class="fade-up"></div>
    </div>
  </section>

  <!-- DEPARTMENT INFORMATION -->
  <section class="section" style="background: var(--off-white);">
    <div class="container">
      <div class="section-header fade-up">
        <div class="section-label">Our Departments</div>
        <h2 class="section-title">Academic Departments</h2>
        <p class="section-subtitle">Our programmes are delivered through two specialised departments, each staffed by expert faculty committed to advancing knowledge and training the next generation of biomedical scientists.</p>
      </div>

      <div style="display:grid; grid-template-columns: repeat(auto-fit, minmax(min(100%, 400px), 1fr)); gap:32px; margin-top:48px;">

        <div class="feature-card fade-up" style="padding:40px;">
          <div class="feature-icon">
            <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2L2 7l10 5 10-5-10-5z"></path><path d="M2 17l10 5 10-5"></path><path d="M2 12l10 5 10-5"></path></svg>
          </div>
          <h3>Department of Gene Therapy</h3>
          <p>Focused on advancing gene-based therapeutic strategies for inherited and acquired diseases. The department houses the Gene Therapy Translational Research Unit, equipped with advanced molecular biology and virology laboratories.</p>
          <ul style="font-size:0.9rem; color:var(--gray-600); line-height:1.8; padding-left:16px; margin-top:12px;">
            <li>MPhil Gene Therapy</li>
            <li>PhD Gene Therapy</li>
            <li>Certificate in Molecular Diagnostics</li>
          </ul>
        </div>

        <div class="feature-card fade-up fade-up-delay-1" style="padding:40px;">
          <div class="feature-icon">
            <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2L2 7l10 5 10-5-10-5z"></path><path d="M2 17l10 5 10-5"></path><path d="M2 12l10 5 10-5"></path></svg>
          </div>
          <h3>Department of Human Embryology</h3>
          <p>Dedicated to the study of human developmental biology, reproductive sciences, and assisted reproductive technologies. The department operates the Embryology and Reproductive Science Research Unit with specialised tissue culture and imaging facilities.</p>
          <ul style="font-size:0.9rem; color:var(--gray-600); line-height:1.8; padding-left:16px; margin-top:12px;">
            <li>MPhil Human Embryology</li>
            <li>PhD Human Embryology</li>
            <li>Certificate in Assisted Reproductive Technology</li>
          </ul>
        </div>

      </div>
    </div>
  </section>

  <!-- CTA -->
  <section class="cta-section section-sm">
    <div class="container">
      <div class="cta-content fade-up">
        <h2>Ready to Begin Your Journey?</h2>
        <p>Applications for the 2026/2027 academic year are now open. Take the next step toward a career in biomedical science.</p>
        <div style="display:flex; gap:16px; justify-content:center; flex-wrap:wrap;">
          <a href="admissions.php" class="btn btn-white">Apply Now</a>
          <a href="contact.php" class="btn btn-outline">Contact Us</a>
        </div>
      </div>
    </div>
  </section>

<?php require_once 'includes/footer.php'; ?>
