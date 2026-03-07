<?php
$pageTitle = 'TIBST - Thrivus Institute of Biomedical Sciences & Technology';
$activePage = 'home';
require_once 'includes/header.php';

// ── Fetch dynamic content ──────────────────────────────────────────
$slides       = getActiveSlides();
$programmes   = getFeaturedProgrammes();
$testimonials = getActiveTestimonials();
$latestNews   = getPublishedNews(3);
?>

  <!-- HERO — Cinematic Split -->
<?php if (!empty($slides)): ?>
<section class="hero-cinematic hero-slider">
    <?php foreach ($slides as $i => $slide): ?>
    <div class="hero-slide <?= $i === 0 ? 'active' : '' ?>">
        <div class="hero-cinematic-bg" style="background-image: url('<?= escape($slide['image']) ?>');"></div>
        <div class="hero-cinematic-overlay"></div>
        <div class="hero-cinematic-grain"></div>

        <!-- DNA Helix CSS Art -->
        <div class="dna-helix" aria-hidden="true">
          <div class="dna-strand">
            <span></span><span></span><span></span><span></span><span></span>
            <span></span><span></span><span></span><span></span><span></span>
            <span></span><span></span><span></span><span></span><span></span>
          </div>
        </div>

        <div class="hero-cinematic-content">
          <div class="hero-cinematic-left">
            <div class="hero-badge-v2">
              <span class="hero-badge-dot"></span>
              2026/2027 Admissions Open
            </div>
            <h1 class="hero-headline">
              <span class="hero-headline-line hero-anim-1"><?= escape($slide['headline_1']) ?></span>
              <span class="hero-headline-line hero-anim-2"><?= escape($slide['headline_2']) ?></span>
              <span class="hero-headline-line hero-headline-accent hero-anim-3"><?= escape($slide['headline_3']) ?></span>
            </h1>
            <p class="hero-cinematic-sub hero-anim-4"><?= escape($slide['subtitle']) ?></p>
            <div class="hero-cinematic-actions hero-anim-5">
              <a href="<?= escape($slide['cta_link']) ?>" class="btn btn-primary btn-lg">
                <?= escape($slide['cta_text']) ?>
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
              </a>
              <a href="academics.php" class="btn btn-outline-glass">Explore Programmes</a>
            </div>
          </div>

          <?php if ($i === 0): ?>
          <div class="hero-cinematic-right hero-anim-6" style="--delay: 0.6s">
            <div class="hero-stat-card">
              <div class="hero-stat-number" data-count="5" data-suffix="+">0</div>
              <div class="hero-stat-label">Programmes</div>
            </div>
            <div class="hero-stat-card">
              <div class="hero-stat-number" data-count="50" data-suffix="+">0</div>
              <div class="hero-stat-label">Researchers</div>
            </div>
            <div class="hero-stat-card">
              <div class="hero-stat-number" data-count="3">0</div>
              <div class="hero-stat-label">Research Units</div>
            </div>
            <div class="hero-stat-card hero-stat-accent">
              <div class="hero-stat-number" data-count="100" data-suffix="%">0</div>
              <div class="hero-stat-label">Dedication</div>
            </div>
          </div>
          <?php endif; ?>
        </div>
    </div>
    <?php endforeach; ?>

    <?php if (count($slides) > 1): ?>
    <button class="slider-prev" aria-label="Previous slide"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="15 18 9 12 15 6"></polyline></svg></button>
    <button class="slider-next" aria-label="Next slide"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9 18 15 12 9 6"></polyline></svg></button>
    <div class="slider-dots">
        <?php foreach ($slides as $i => $s): ?>
        <button class="slider-dot <?= $i === 0 ? 'active' : '' ?>" aria-label="Slide <?= $i + 1 ?>"></button>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>

    <div class="scroll-indicator-v2">
      <span>Scroll to explore</span>
      <div class="scroll-indicator-line"></div>
    </div>
</section>
<?php else: ?>
  <!-- Static fallback hero -->
  <section class="hero-cinematic">
    <div class="hero-cinematic-bg" style="background-image: url('https://images.unsplash.com/photo-1581093458791-9f3c3900df4b?w=1920&q=80');"></div>
    <div class="hero-cinematic-overlay"></div>
    <div class="hero-cinematic-grain"></div>

    <!-- DNA Helix CSS Art -->
    <div class="dna-helix" aria-hidden="true">
      <div class="dna-strand">
        <span></span><span></span><span></span><span></span><span></span>
        <span></span><span></span><span></span><span></span><span></span>
        <span></span><span></span><span></span><span></span><span></span>
      </div>
    </div>

    <div class="hero-cinematic-content">
      <div class="hero-cinematic-left">
        <div class="hero-badge-v2">
          <span class="hero-badge-dot"></span>
          2026/2027 Admissions Open
        </div>
        <h1 class="hero-headline">
          <span class="hero-headline-line hero-anim-1">Shaping the</span>
          <span class="hero-headline-line hero-anim-2">Future of</span>
          <span class="hero-headline-line hero-headline-accent hero-anim-3">Biomedical Science</span>
        </h1>
        <p class="hero-cinematic-sub hero-anim-4">Prepare to be challenged. At TIBST, we cultivate the next generation of biomedical scientists through world-class research and innovative postgraduate programmes.</p>
        <div class="hero-cinematic-actions hero-anim-5">
          <a href="admissions.php" class="btn btn-primary btn-lg">
            Apply Now
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
          </a>
          <a href="academics.php" class="btn btn-outline-glass">Explore Programmes</a>
        </div>
      </div>

      <div class="hero-cinematic-right hero-anim-6" style="--delay: 0.6s">
        <div class="hero-stat-card">
          <div class="hero-stat-number" data-count="5" data-suffix="+">0</div>
          <div class="hero-stat-label">Programmes</div>
        </div>
        <div class="hero-stat-card">
          <div class="hero-stat-number" data-count="50" data-suffix="+">0</div>
          <div class="hero-stat-label">Researchers</div>
        </div>
        <div class="hero-stat-card">
          <div class="hero-stat-number" data-count="3">0</div>
          <div class="hero-stat-label">Research Units</div>
        </div>
        <div class="hero-stat-card hero-stat-accent">
          <div class="hero-stat-number" data-count="100" data-suffix="%">0</div>
          <div class="hero-stat-label">Dedication</div>
        </div>
      </div>
    </div>

    <div class="scroll-indicator-v2">
      <span>Scroll to explore</span>
      <div class="scroll-indicator-line"></div>
    </div>
  </section>
<?php endif; ?>

  <!-- PROGRAMMES — Asymmetric Showcase -->
  <section class="section" style="background: var(--off-white);">
    <div class="container">
      <div class="section-header fade-up">
        <div class="section-label">Academic Excellence</div>
        <h2 class="section-title">Our Programmes</h2>
        <p class="section-subtitle">Cutting-edge postgraduate programmes designed to push the boundaries of biomedical science and technology.</p>
      </div>

<?php if (!empty($programmes)): ?>
      <div class="programs-showcase">
        <!-- Featured large card (first programme) -->
        <?php $featured = $programmes[0]; ?>
        <div class="program-feature-card fade-up">
          <div class="program-feature-img" style="background-image: url('<?= $featured['image'] ? escape($featured['image']) : 'https://images.unsplash.com/photo-1579154204601-01588f351e67?w=1200&q=80' ?>');">
            <div class="program-feature-img-overlay"></div>
            <span class="program-card-badge"><?= escape($featured['degree_type']) ?></span>
          </div>
          <div class="program-feature-body">
            <h3 class="program-feature-title"><?= escape($featured['title']) ?></h3>
            <p class="program-feature-desc"><?= escape($featured['description']) ?></p>
            <div class="program-feature-meta">
              <span><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg> <?= escape($featured['duration']) ?></span>
              <span><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 10v6M2 10l10-5 10 5-10 5z"></path><path d="M6 12v5c3 3 6 3 6 3s3 0 6-3v-5"></path></svg> Postgraduate</span>
            </div>
            <a href="admissions.php" class="btn btn-primary" style="margin-top: 24px;">Apply for This Programme <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg></a>
          </div>
        </div>

        <!-- Stacked smaller cards (remaining programmes) -->
        <?php if (count($programmes) > 1): ?>
        <div class="programs-stack">
          <?php foreach (array_slice($programmes, 1) as $j => $prog): ?>
          <div class="program-stack-card fade-up fade-up-delay-<?= $j + 1 ?>">
            <div class="program-stack-img" style="background-image: url('<?= $prog['image'] ? escape($prog['image']) : 'https://images.unsplash.com/photo-1530026405186-ed1f139313f8?w=800&q=80' ?>');">
              <span class="program-card-badge"><?= escape($prog['degree_type']) ?></span>
            </div>
            <div class="program-stack-body">
              <h3><?= escape($prog['title']) ?></h3>
              <p><?= escape($prog['description']) ?></p>
              <div class="program-stack-meta">
                <span><?= escape($prog['duration']) ?></span>
                <span><?= escape($prog['degree_type']) ?></span>
              </div>
            </div>
          </div>
          <?php endforeach; ?>
        </div>
        <?php endif; ?>
      </div>
<?php else: ?>
      <div class="programs-showcase">
        <!-- Featured large card -->
        <div class="program-feature-card fade-up">
          <div class="program-feature-img" style="background-image: url('https://images.unsplash.com/photo-1579154204601-01588f351e67?w=1200&q=80');">
            <div class="program-feature-img-overlay"></div>
            <span class="program-card-badge">MPhil</span>
          </div>
          <div class="program-feature-body">
            <h3 class="program-feature-title">Gene Therapy</h3>
            <p class="program-feature-desc">Explore the frontier of genetic medicine with our comprehensive MPhil programme in Gene Therapy, combining theoretical foundations with hands-on laboratory research.</p>
            <div class="program-feature-meta">
              <span><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg> 2-3 Years</span>
              <span><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 10v6M2 10l10-5 10 5-10 5z"></path><path d="M6 12v5c3 3 6 3 6 3s3 0 6-3v-5"></path></svg> Postgraduate</span>
            </div>
            <a href="admissions.php" class="btn btn-primary" style="margin-top: 24px;">Apply for This Programme <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg></a>
          </div>
        </div>

        <!-- Stacked smaller cards -->
        <div class="programs-stack">
          <div class="program-stack-card fade-up fade-up-delay-1">
            <div class="program-stack-img" style="background-image: url('https://images.unsplash.com/photo-1530026405186-ed1f139313f8?w=800&q=80');">
              <span class="program-card-badge">PhD</span>
            </div>
            <div class="program-stack-body">
              <h3>Gene Therapy</h3>
              <p>Advance the frontiers of gene therapy research with our doctoral programme, focusing on innovative therapeutic approaches.</p>
              <div class="program-stack-meta">
                <span>2-3 Years</span>
                <span>Doctoral</span>
              </div>
            </div>
          </div>

          <div class="program-stack-card fade-up fade-up-delay-2">
            <div class="program-stack-img" style="background-image: url('https://images.unsplash.com/photo-1576086213369-97a306d36557?w=800&q=80');">
              <span class="program-card-badge">MPhil</span>
            </div>
            <div class="program-stack-body">
              <h3>Human Embryology</h3>
              <p>Study human development with our MPhil programme, integrating embryology with modern reproductive sciences.</p>
              <div class="program-stack-meta">
                <span>2-3 Years</span>
                <span>Postgraduate</span>
              </div>
            </div>
          </div>
        </div>
      </div>
<?php endif; ?>

      <div style="text-align:center; margin-top:56px;" class="fade-up">
        <a href="academics.php" class="btn btn-outline-dark">View All Programmes <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg></a>
      </div>
    </div>
  </section>

  <!-- WHY TIBST — Bento Grid -->
  <section class="section" style="background: var(--white);">
    <div class="container">
      <div class="section-header fade-up">
        <div class="section-label">Why TIBST</div>
        <h2 class="section-title">Your Career Starts With Us</h2>
        <p class="section-subtitle">No matter which career path you choose, your experience at TIBST will give you a basis for success.</p>
      </div>

      <div class="bento-grid">
        <div class="bento-item bento-hero-item fade-up">
          <div class="bento-item-bg"></div>
          <div class="bento-item-content">
            <div class="feature-icon">
              <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2L2 7l10 5 10-5-10-5z"></path><path d="M2 17l10 5 10-5"></path><path d="M2 12l10 5 10-5"></path></svg>
            </div>
            <h3>World-Class Research</h3>
            <p>Access cutting-edge research facilities and collaborate with leading scientists in gene therapy and human embryology.</p>
          </div>
        </div>

        <div class="bento-item fade-up fade-up-delay-1">
          <div class="feature-icon">
            <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
          </div>
          <h3>Expert Faculty</h3>
          <p>Learn from distinguished academics who are leaders in their respective biomedical fields.</p>
        </div>

        <div class="bento-item fade-up fade-up-delay-2">
          <div class="feature-icon">
            <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><line x1="2" y1="12" x2="22" y2="12"></line><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"></path></svg>
          </div>
          <h3>Global Impact</h3>
          <p>Our research and graduates contribute to advancing healthcare solutions across Africa and the world.</p>
        </div>

        <div class="bento-item fade-up">
          <div class="feature-icon">
            <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94l-3.76 3.76z"></path></svg>
          </div>
          <h3>Hands-On Training</h3>
          <p>Gain practical laboratory experience through our translational research units and state-of-the-art facilities.</p>
        </div>

        <div class="bento-item fade-up fade-up-delay-1">
          <div class="feature-icon">
            <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"></path><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"></path></svg>
          </div>
          <h3>Rich Library Resources</h3>
          <p>Access an extensive collection of biomedical journals, databases, and digital resources to support your research.</p>
        </div>

        <div class="bento-item bento-accent-item fade-up fade-up-delay-2">
          <div class="feature-icon">
            <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path></svg>
          </div>
          <h3>Financial Support</h3>
          <p>Benefit from our financial aid and sponsorship programmes designed to make quality education accessible.</p>
        </div>
      </div>
    </div>
  </section>

  <!-- TESTIMONIALS — Marquee -->
  <section class="testimonials-marquee-section">
    <div class="hero-pattern"></div>
    <div class="container" style="position:relative; z-index:1;">
      <div class="section-header fade-up">
        <div class="section-label" style="color: var(--accent);">Testimonials</div>
        <h2 class="section-title" style="color: var(--white);">What Our Students Say</h2>
      </div>
    </div>

    <div class="testimonial-marquee-track">
      <div class="testimonial-marquee-inner">
<?php if (!empty($testimonials)): ?>
        <!-- Dynamic testimonials — Set 1 -->
        <?php foreach ($testimonials as $t): ?>
        <div class="testimonial-marquee-card">
          <div class="testimonial-quote-icon">"</div>
          <div class="testimonial-quote-text"><?= escape($t['quote']) ?></div>
          <div class="testimonial-author">
            <div class="testimonial-avatar"><?= escape($t['initials']) ?></div>
            <div>
              <div class="testimonial-name"><?= escape($t['name']) ?></div>
              <div class="testimonial-role"><?= escape($t['role']) ?></div>
            </div>
          </div>
        </div>
        <?php endforeach; ?>
        <!-- Duplicate set for seamless loop -->
        <?php foreach ($testimonials as $t): ?>
        <div class="testimonial-marquee-card">
          <div class="testimonial-quote-icon">"</div>
          <div class="testimonial-quote-text"><?= escape($t['quote']) ?></div>
          <div class="testimonial-author">
            <div class="testimonial-avatar"><?= escape($t['initials']) ?></div>
            <div>
              <div class="testimonial-name"><?= escape($t['name']) ?></div>
              <div class="testimonial-role"><?= escape($t['role']) ?></div>
            </div>
          </div>
        </div>
        <?php endforeach; ?>
<?php else: ?>
        <!-- Static fallback — Set 1 -->
        <div class="testimonial-marquee-card">
          <div class="testimonial-quote-icon">"</div>
          <div class="testimonial-quote-text">TIBST provided me with the rigorous training and mentorship I needed to pursue my passion in gene therapy. The research opportunities are unparalleled.</div>
          <div class="testimonial-author">
            <div class="testimonial-avatar">AK</div>
            <div>
              <div class="testimonial-name">Dr. Ama Kusi</div>
              <div class="testimonial-role">PhD Gene Therapy, Class of 2025</div>
            </div>
          </div>
        </div>

        <div class="testimonial-marquee-card">
          <div class="testimonial-quote-icon">"</div>
          <div class="testimonial-quote-text">The faculty at TIBST are world-class. Their dedication to student success and advancing biomedical science is truly inspiring.</div>
          <div class="testimonial-author">
            <div class="testimonial-avatar">KM</div>
            <div>
              <div class="testimonial-name">Kwame Mensah</div>
              <div class="testimonial-role">MPhil Human Embryology, Current Student</div>
            </div>
          </div>
        </div>

        <div class="testimonial-marquee-card">
          <div class="testimonial-quote-icon">"</div>
          <div class="testimonial-quote-text">TIBST's translational research approach bridges the gap between laboratory discoveries and real-world medical applications. It's the future of healthcare.</div>
          <div class="testimonial-author">
            <div class="testimonial-avatar">EA</div>
            <div>
              <div class="testimonial-name">Dr. Efua Aidoo</div>
              <div class="testimonial-role">MPhil Gene Therapy, Class of 2024</div>
            </div>
          </div>
        </div>

        <!-- Duplicate set for seamless loop -->
        <div class="testimonial-marquee-card">
          <div class="testimonial-quote-icon">"</div>
          <div class="testimonial-quote-text">TIBST provided me with the rigorous training and mentorship I needed to pursue my passion in gene therapy. The research opportunities are unparalleled.</div>
          <div class="testimonial-author">
            <div class="testimonial-avatar">AK</div>
            <div>
              <div class="testimonial-name">Dr. Ama Kusi</div>
              <div class="testimonial-role">PhD Gene Therapy, Class of 2025</div>
            </div>
          </div>
        </div>

        <div class="testimonial-marquee-card">
          <div class="testimonial-quote-icon">"</div>
          <div class="testimonial-quote-text">The faculty at TIBST are world-class. Their dedication to student success and advancing biomedical science is truly inspiring.</div>
          <div class="testimonial-author">
            <div class="testimonial-avatar">KM</div>
            <div>
              <div class="testimonial-name">Kwame Mensah</div>
              <div class="testimonial-role">MPhil Human Embryology, Current Student</div>
            </div>
          </div>
        </div>

        <div class="testimonial-marquee-card">
          <div class="testimonial-quote-icon">"</div>
          <div class="testimonial-quote-text">TIBST's translational research approach bridges the gap between laboratory discoveries and real-world medical applications. It's the future of healthcare.</div>
          <div class="testimonial-author">
            <div class="testimonial-avatar">EA</div>
            <div>
              <div class="testimonial-name">Dr. Efua Aidoo</div>
              <div class="testimonial-role">MPhil Gene Therapy, Class of 2024</div>
            </div>
          </div>
        </div>
<?php endif; ?>
      </div>
    </div>
  </section>

  <!-- NEWS — Editorial Layout -->
  <section class="section" style="background: var(--gray-50);">
    <div class="container">
      <div style="display:flex; justify-content:space-between; align-items:flex-end; flex-wrap:wrap; gap:16px; margin-bottom:48px;">
        <div class="fade-up">
          <div class="section-label">Stay Updated</div>
          <h2 class="section-title">Latest News & Events</h2>
        </div>
        <a href="news-events.php" class="btn btn-outline-dark btn-sm fade-up">View All News <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg></a>
      </div>

<?php if (!empty($latestNews)): ?>
      <div class="news-editorial">
        <!-- Featured article (first news item) -->
        <?php $featuredNews = $latestNews[0]; ?>
        <div class="news-editorial-feature fade-up">
          <div class="news-editorial-feature-img" style="background-image: url('<?= $featuredNews['image'] ? escape($featuredNews['image']) : 'https://images.unsplash.com/photo-1532187863486-abf9dbad1b69?w=1200&q=80' ?>');">
            <div class="news-editorial-feature-overlay"></div>
            <div class="news-editorial-feature-content">
              <?php $fDate = new DateTime($featuredNews['publish_date']); ?>
              <div class="news-editorial-date-big"><?= strtoupper($fDate->format('M')) ?><br><span><?= $fDate->format('d') ?></span></div>
              <div>
                <h3><?= escape($featuredNews['title']) ?></h3>
                <p><?= escape($featuredNews['excerpt']) ?></p>
              </div>
            </div>
          </div>
        </div>

        <!-- Side articles (remaining news items) -->
        <?php if (count($latestNews) > 1): ?>
        <div class="news-editorial-stack">
          <?php foreach (array_slice($latestNews, 1) as $k => $news): ?>
          <div class="news-editorial-item fade-up fade-up-delay-<?= $k + 1 ?>">
            <div class="news-editorial-item-img" style="background-image: url('<?= $news['image'] ? escape($news['image']) : 'https://images.unsplash.com/photo-1559757175-5700dde675bc?w=600&q=80' ?>');"></div>
            <div class="news-editorial-item-body">
              <?php $nDate = new DateTime($news['publish_date']); ?>
              <div class="news-card-date"><?= $nDate->format('F j, Y') ?></div>
              <h3 class="news-card-title"><?= escape($news['title']) ?></h3>
              <p class="news-card-excerpt"><?= escape($news['excerpt']) ?></p>
            </div>
          </div>
          <?php endforeach; ?>
        </div>
        <?php endif; ?>
      </div>
<?php else: ?>
      <div class="news-editorial">
        <!-- Static fallback — Featured article -->
        <div class="news-editorial-feature fade-up">
          <div class="news-editorial-feature-img" style="background-image: url('https://images.unsplash.com/photo-1532187863486-abf9dbad1b69?w=1200&q=80');">
            <div class="news-editorial-feature-overlay"></div>
            <div class="news-editorial-feature-content">
              <div class="news-editorial-date-big">MAR<br><span>01</span></div>
              <div>
                <h3>2026/2027 Admissions Now Open</h3>
                <p>Applications are now being accepted for the upcoming academic year. Apply early to secure your place in our prestigious programmes.</p>
              </div>
            </div>
          </div>
        </div>

        <!-- Static fallback — Side articles -->
        <div class="news-editorial-stack">
          <div class="news-editorial-item fade-up fade-up-delay-1">
            <div class="news-editorial-item-img" style="background-image: url('https://images.unsplash.com/photo-1559757175-5700dde675bc?w=600&q=80');"></div>
            <div class="news-editorial-item-body">
              <div class="news-card-date">February 15, 2026</div>
              <h3 class="news-card-title">Breakthrough in Gene Therapy Research</h3>
              <p class="news-card-excerpt">TIBST researchers make significant progress in developing novel gene therapy approaches for inherited diseases.</p>
            </div>
          </div>

          <div class="news-editorial-item fade-up fade-up-delay-2">
            <div class="news-editorial-item-img" style="background-image: url('https://images.unsplash.com/photo-1540575467063-178a50c2df87?w=600&q=80');"></div>
            <div class="news-editorial-item-body">
              <div class="news-card-date">February 5, 2026</div>
              <h3 class="news-card-title">Special Lecture Series: Future of Biomedical Sciences</h3>
              <p class="news-card-excerpt">Join us for our upcoming special lecture series featuring renowned international scientists.</p>
            </div>
          </div>
        </div>
      </div>
<?php endif; ?>
    </div>
  </section>

  <!-- CTA — Full Bleed -->
  <section class="cta-cinematic">
    <div class="cta-cinematic-pattern"></div>
    <div class="container" style="position:relative; z-index:1;">
      <div class="cta-cinematic-content fade-up">
        <h2>Ready to Shape<br>the Future?</h2>
        <p>Join TIBST and become part of a community dedicated to advancing biomedical science and technology.</p>
        <div class="cta-cinematic-actions">
          <a href="admissions.php" class="btn btn-white btn-lg">Apply Now</a>
          <a href="contact.php" class="btn btn-outline">Contact Us</a>
        </div>
      </div>
    </div>
  </section>

<?php require_once 'includes/footer.php'; ?>
