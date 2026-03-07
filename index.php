<?php
$pageTitle = 'TIBST - Thrivus Institute of Biomedical Sciences & Technology';
$activePage = 'home';
require_once 'includes/header.php';

$slides       = getActiveSlides();
$programmes   = getFeaturedProgrammes();
$testimonials = getActiveTestimonials();
$latestNews   = getPublishedNews(3);
?>

  <!-- HERO — Cinematic Image Slider -->
<?php if (!empty($slides)): ?>
  <section class="hero-v3 hero-slider">
    <!-- Slides -->
    <?php foreach ($slides as $i => $slide): ?>
    <div class="hero-slide <?= $i === 0 ? 'active' : '' ?>">
      <div class="hero-v3-bg" style="background-image: url('<?= escape($slide['image']) ?>');"></div>
      <div class="hero-v3-overlay"></div>

      <div class="container hero-v3-wrap">
        <div class="hero-v3-main">
          <div class="hero-v3-badge <?= $i === 0 ? 'hero-anim-1' : '' ?>">
            <span class="hero-v3-pulse"></span>
            Admissions Open &mdash; 2026/2027
          </div>
          <h1 class="hero-v3-h1">
            <span class="hero-v3-line <?= $i === 0 ? 'hero-anim-1' : '' ?>"><?= escape($slide['headline_1']) ?></span>
            <span class="hero-v3-line <?= $i === 0 ? 'hero-anim-2' : '' ?>"><?= escape($slide['headline_2']) ?></span>
            <span class="hero-v3-line hero-v3-stroke <?= $i === 0 ? 'hero-anim-3' : '' ?>"><?= escape($slide['headline_3']) ?></span>
          </h1>
          <p class="hero-v3-p <?= $i === 0 ? 'hero-anim-4' : '' ?>"><?= escape($slide['subtitle']) ?></p>
          <div class="hero-v3-actions <?= $i === 0 ? 'hero-anim-5' : '' ?>">
            <a href="<?= escape($slide['cta_link']) ?>" class="btn btn-primary btn-lg">
              <?= escape($slide['cta_text']) ?>
              <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
            </a>
            <a href="academics.php" class="btn btn-outline-glass">Explore Programmes</a>
          </div>
        </div>
      </div>
    </div>
    <?php endforeach; ?>

    <!-- Persistent layers (always visible above slides) -->
    <div class="hero-v3-glow" aria-hidden="true"></div>
    <div class="hero-v3-grid" aria-hidden="true"></div>
    <div class="hero-v3-grain" aria-hidden="true"></div>
    <div class="hero-v3-shapes" aria-hidden="true">
      <svg class="float-shape fs-1" viewBox="0 0 120 120" fill="none"><polygon points="60,4 114,32 114,88 60,116 6,88 6,32" stroke="currentColor" stroke-width="0.6"/></svg>
      <svg class="float-shape fs-2" viewBox="0 0 120 120" fill="none"><polygon points="60,4 114,32 114,88 60,116 6,88 6,32" stroke="currentColor" stroke-width="0.4"/></svg>
      <svg class="float-shape fs-3" viewBox="0 0 100 100" fill="none"><circle cx="50" cy="50" r="45" stroke="currentColor" stroke-width="0.5"/><circle cx="50" cy="50" r="22" stroke="currentColor" stroke-width="0.3"/></svg>
    </div>

    <!-- Stats bar (persistent) -->
    <div class="hero-v3-stats-float">
      <div class="container">
        <div class="hero-v3-stats hero-anim-6">
          <div class="hero-v3-stat">
            <div class="hero-v3-stat-num" data-count="5" data-suffix="+">0</div>
            <div class="hero-v3-stat-label">Programmes</div>
          </div>
          <div class="hero-v3-stat">
            <div class="hero-v3-stat-num" data-count="50" data-suffix="+">0</div>
            <div class="hero-v3-stat-label">Researchers</div>
          </div>
          <div class="hero-v3-stat">
            <div class="hero-v3-stat-num" data-count="3">0</div>
            <div class="hero-v3-stat-label">Research Units</div>
          </div>
          <div class="hero-v3-stat hero-v3-stat-accent">
            <div class="hero-v3-stat-num" data-count="100" data-suffix="%">0</div>
            <div class="hero-v3-stat-label">Dedication</div>
          </div>
        </div>
      </div>
    </div>

    <!-- Slider navigation -->
    <?php if (count($slides) > 1): ?>
    <button class="slider-prev" aria-label="Previous slide"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="15 18 9 12 15 6"/></svg></button>
    <button class="slider-next" aria-label="Next slide"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9 18 15 12 9 6"/></svg></button>
    <div class="slider-dots">
      <?php foreach ($slides as $i => $s): ?>
      <button class="slider-dot <?= $i === 0 ? 'active' : '' ?>" aria-label="Slide <?= $i + 1 ?>"></button>
      <?php endforeach; ?>
    </div>
    <?php endif; ?>

    <div class="hero-v3-scroll">
      <span>Scroll to explore</span>
      <div class="hero-v3-scroll-bar"></div>
    </div>
  </section>

<?php else: ?>
  <!-- Static fallback — Aurora gradient (no slides in DB) -->
  <section class="hero-v3">
    <div class="hero-v3-glow" aria-hidden="true"></div>
    <div class="hero-v3-grid" aria-hidden="true"></div>
    <div class="hero-v3-grain" aria-hidden="true"></div>
    <div class="hero-v3-shapes" aria-hidden="true">
      <svg class="float-shape fs-1" viewBox="0 0 120 120" fill="none"><polygon points="60,4 114,32 114,88 60,116 6,88 6,32" stroke="currentColor" stroke-width="0.6"/></svg>
      <svg class="float-shape fs-2" viewBox="0 0 120 120" fill="none"><polygon points="60,4 114,32 114,88 60,116 6,88 6,32" stroke="currentColor" stroke-width="0.4"/></svg>
      <svg class="float-shape fs-3" viewBox="0 0 100 100" fill="none"><circle cx="50" cy="50" r="45" stroke="currentColor" stroke-width="0.5"/><circle cx="50" cy="50" r="22" stroke="currentColor" stroke-width="0.3"/></svg>
    </div>

    <div class="container hero-v3-wrap">
      <div class="hero-v3-main">
        <div class="hero-v3-badge hero-anim-1">
          <span class="hero-v3-pulse"></span>
          Admissions Open &mdash; 2026/2027
        </div>
        <h1 class="hero-v3-h1">
          <span class="hero-v3-line hero-anim-1">Shaping the</span>
          <span class="hero-v3-line hero-anim-2">Future of</span>
          <span class="hero-v3-line hero-v3-stroke hero-anim-3">Biomedical Science</span>
        </h1>
        <p class="hero-v3-p hero-anim-4">TIBST is a premier institution dedicated to advancing biomedical science education and research in Ghana and beyond.</p>
        <div class="hero-v3-actions hero-anim-5">
          <a href="admissions.php" class="btn btn-primary btn-lg">
            Apply Now
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
          </a>
          <a href="academics.php" class="btn btn-outline-glass">Explore Programmes</a>
        </div>
      </div>

      <div class="hero-v3-stats hero-anim-6">
        <div class="hero-v3-stat">
          <div class="hero-v3-stat-num" data-count="5" data-suffix="+">0</div>
          <div class="hero-v3-stat-label">Programmes</div>
        </div>
        <div class="hero-v3-stat">
          <div class="hero-v3-stat-num" data-count="50" data-suffix="+">0</div>
          <div class="hero-v3-stat-label">Researchers</div>
        </div>
        <div class="hero-v3-stat">
          <div class="hero-v3-stat-num" data-count="3">0</div>
          <div class="hero-v3-stat-label">Research Units</div>
        </div>
        <div class="hero-v3-stat hero-v3-stat-accent">
          <div class="hero-v3-stat-num" data-count="100" data-suffix="%">0</div>
          <div class="hero-v3-stat-label">Dedication</div>
        </div>
      </div>
    </div>

    <div class="hero-v3-scroll">
      <span>Scroll to explore</span>
      <div class="hero-v3-scroll-bar"></div>
    </div>
  </section>
<?php endif; ?>

  <!-- PROGRAMMES — Editorial Showcase -->
  <section class="section programmes-section">
    <div class="container">
      <div class="section-header fade-up">
        <div class="section-label">Academic Excellence</div>
        <h2 class="section-title">Our Programmes</h2>
        <p class="section-subtitle">Cutting-edge postgraduate programmes designed to push the boundaries of biomedical science and technology.</p>
      </div>

<?php if (!empty($programmes)): ?>
      <?php $featured = $programmes[0]; ?>
      <!-- Featured Programme -->
      <div class="prog-featured fade-up">
        <div class="prog-featured-img" style="background-image: url('<?= $featured['image'] ? escape($featured['image']) : 'https://images.unsplash.com/photo-1579154204601-01588f351e67?w=1200&q=80' ?>');">
          <div class="prog-featured-img-overlay"></div>
          <span class="prog-featured-index">01</span>
        </div>
        <div class="prog-featured-content">
          <span class="prog-featured-badge"><?= escape($featured['degree_type']) ?></span>
          <h3 class="prog-featured-title"><?= escape($featured['title']) ?></h3>
          <p class="prog-featured-desc"><?= escape($featured['description']) ?></p>
          <div class="prog-featured-details">
            <div class="prog-featured-detail">
              <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
              <span><?= escape($featured['duration']) ?></span>
            </div>
            <div class="prog-featured-detail">
              <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 10v6M2 10l10-5 10 5-10 5z"/><path d="M6 12v5c3 3 6 3 6 3s3 0 6-3v-5"/></svg>
              <span>Postgraduate</span>
            </div>
          </div>
          <a href="admissions.php" class="btn btn-primary" style="margin-top:28px;">Apply for This Programme <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg></a>
        </div>
      </div>

      <!-- Remaining Programmes -->
      <?php if (count($programmes) > 1): ?>
      <div class="prog-grid">
        <?php foreach (array_slice($programmes, 1) as $i => $prog): ?>
        <article class="prog-card fade-up fade-up-delay-<?= min($i, 3) ?>">
          <div class="prog-card-visual">
            <div class="prog-card-img" style="background-image: url('<?= $prog['image'] ? escape($prog['image']) : 'https://images.unsplash.com/photo-1530026405186-ed1f139313f8?w=800&q=80' ?>');">
              <div class="prog-card-img-overlay"></div>
            </div>
            <span class="prog-card-badge"><?= escape($prog['degree_type']) ?></span>
            <span class="prog-card-index"><?= str_pad($i + 2, 2, '0', STR_PAD_LEFT) ?></span>
          </div>
          <div class="prog-card-body">
            <h3 class="prog-card-title"><?= escape($prog['title']) ?></h3>
            <p class="prog-card-desc"><?= escape($prog['description']) ?></p>
            <div class="prog-card-meta">
              <span class="prog-card-duration">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                <?= escape($prog['duration']) ?>
              </span>
              <a href="admissions.php" class="prog-card-apply">Apply &rarr;</a>
            </div>
          </div>
        </article>
        <?php endforeach; ?>
      </div>
      <?php endif; ?>

<?php else: ?>
      <!-- Static Fallback — Featured -->
      <div class="prog-featured fade-up">
        <div class="prog-featured-img" style="background-image: url('https://images.unsplash.com/photo-1579154204601-01588f351e67?w=1200&q=80');">
          <div class="prog-featured-img-overlay"></div>
          <span class="prog-featured-index">01</span>
        </div>
        <div class="prog-featured-content">
          <span class="prog-featured-badge">MPhil</span>
          <h3 class="prog-featured-title">Gene Therapy</h3>
          <p class="prog-featured-desc">Explore the frontier of genetic medicine with our comprehensive MPhil programme in Gene Therapy, combining theoretical foundations with hands-on laboratory research.</p>
          <div class="prog-featured-details">
            <div class="prog-featured-detail">
              <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
              <span>2-3 Years</span>
            </div>
            <div class="prog-featured-detail">
              <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 10v6M2 10l10-5 10 5-10 5z"/><path d="M6 12v5c3 3 6 3 6 3s3 0 6-3v-5"/></svg>
              <span>Postgraduate</span>
            </div>
          </div>
          <a href="admissions.php" class="btn btn-primary" style="margin-top:28px;">Apply for This Programme <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg></a>
        </div>
      </div>

      <!-- Static Fallback — Grid -->
      <div class="prog-grid">
        <article class="prog-card fade-up">
          <div class="prog-card-visual">
            <div class="prog-card-img" style="background-image: url('https://images.unsplash.com/photo-1530026405186-ed1f139313f8?w=800&q=80');">
              <div class="prog-card-img-overlay"></div>
            </div>
            <span class="prog-card-badge">PhD</span>
            <span class="prog-card-index">02</span>
          </div>
          <div class="prog-card-body">
            <h3 class="prog-card-title">Gene Therapy</h3>
            <p class="prog-card-desc">Advance the frontiers of gene therapy research with our doctoral programme, focusing on innovative therapeutic approaches and clinical translation.</p>
            <div class="prog-card-meta">
              <span class="prog-card-duration">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                2-3 Years
              </span>
              <a href="admissions.php" class="prog-card-apply">Apply &rarr;</a>
            </div>
          </div>
        </article>
        <article class="prog-card fade-up fade-up-delay-1">
          <div class="prog-card-visual">
            <div class="prog-card-img" style="background-image: url('https://images.unsplash.com/photo-1576086213369-97a306d36557?w=800&q=80');">
              <div class="prog-card-img-overlay"></div>
            </div>
            <span class="prog-card-badge">MPhil</span>
            <span class="prog-card-index">03</span>
          </div>
          <div class="prog-card-body">
            <h3 class="prog-card-title">Human Embryology</h3>
            <p class="prog-card-desc">Study human development with our MPhil programme, integrating embryology with modern reproductive sciences and clinical practice.</p>
            <div class="prog-card-meta">
              <span class="prog-card-duration">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                2-3 Years
              </span>
              <a href="admissions.php" class="prog-card-apply">Apply &rarr;</a>
            </div>
          </div>
        </article>
      </div>
<?php endif; ?>

      <div style="text-align:center; margin-top:56px;">
        <a href="academics.php" class="btn btn-outline-dark fade-up">View All Programmes <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg></a>
      </div>
    </div>
  </section>

  <!-- WHY TIBST — Feature Grid -->
  <section class="section" style="background: var(--white);">
    <div class="container">
      <div class="section-header fade-up">
        <div class="section-label">Why TIBST</div>
        <h2 class="section-title">Your Career Starts With Us</h2>
        <p class="section-subtitle">No matter which career path you choose, your experience at TIBST will give you a basis for success.</p>
      </div>

      <div class="features-v3">
        <div class="feature-v3 feature-v3-lg fade-up">
          <div class="feature-v3-glow"></div>
          <div class="feature-v3-inner">
            <div class="feature-v3-icon">
              <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M12 2L2 7l10 5 10-5-10-5z"/><path d="M2 17l10 5 10-5"/><path d="M2 12l10 5 10-5"/></svg>
            </div>
            <h3>World-Class Research</h3>
            <p>Access cutting-edge research facilities and collaborate with leading scientists in gene therapy and human embryology.</p>
          </div>
        </div>

        <div class="feature-v3 fade-up fade-up-delay-1">
          <div class="feature-v3-icon">
            <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
          </div>
          <h3>Expert Faculty</h3>
          <p>Learn from distinguished academics who are leaders in their respective biomedical fields.</p>
        </div>

        <div class="feature-v3 fade-up fade-up-delay-2">
          <div class="feature-v3-icon">
            <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><circle cx="12" cy="12" r="10"/><line x1="2" y1="12" x2="22" y2="12"/><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/></svg>
          </div>
          <h3>Global Impact</h3>
          <p>Our research and graduates contribute to advancing healthcare solutions across Africa and the world.</p>
        </div>

        <div class="feature-v3 fade-up">
          <div class="feature-v3-icon">
            <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94l-3.76 3.76z"/></svg>
          </div>
          <h3>Hands-On Training</h3>
          <p>Gain practical laboratory experience through our translational research units and state-of-the-art facilities.</p>
        </div>

        <div class="feature-v3 fade-up fade-up-delay-1">
          <div class="feature-v3-icon">
            <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/></svg>
          </div>
          <h3>Rich Library Resources</h3>
          <p>Access an extensive collection of biomedical journals, databases, and digital resources to support your research.</p>
        </div>

        <div class="feature-v3 feature-v3-accent fade-up fade-up-delay-2">
          <div class="feature-v3-icon">
            <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
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
        <?php foreach ($testimonials as $t): ?>
        <div class="testimonial-marquee-card">
          <div class="testimonial-quote-icon">&ldquo;</div>
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
        <?php foreach ($testimonials as $t): ?>
        <div class="testimonial-marquee-card">
          <div class="testimonial-quote-icon">&ldquo;</div>
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
        <div class="testimonial-marquee-card">
          <div class="testimonial-quote-icon">&ldquo;</div>
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
          <div class="testimonial-quote-icon">&ldquo;</div>
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
          <div class="testimonial-quote-icon">&ldquo;</div>
          <div class="testimonial-quote-text">TIBST's translational research approach bridges the gap between laboratory discoveries and real-world medical applications. It's the future of healthcare.</div>
          <div class="testimonial-author">
            <div class="testimonial-avatar">EA</div>
            <div>
              <div class="testimonial-name">Dr. Efua Aidoo</div>
              <div class="testimonial-role">MPhil Gene Therapy, Class of 2024</div>
            </div>
          </div>
        </div>
        <div class="testimonial-marquee-card">
          <div class="testimonial-quote-icon">&ldquo;</div>
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
          <div class="testimonial-quote-icon">&ldquo;</div>
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
          <div class="testimonial-quote-icon">&ldquo;</div>
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
          <h2 class="section-title">Latest News &amp; Events</h2>
        </div>
        <a href="news-events.php" class="btn btn-outline-dark btn-sm fade-up">View All News <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg></a>
      </div>

<?php if (!empty($latestNews)): ?>
      <div class="news-editorial">
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
