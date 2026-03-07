<?php
$pageTitle = 'TIBST - Thrivus Institute of Biomedical Sciences & Technology';
$activePage = 'home';
require_once 'includes/header.php';

$slides       = getActiveSlides();
$programmes   = getAllProgrammes();
$testimonials = getActiveTestimonials();
$latestNews   = getPublishedNews(3);
?>

  <!-- ========== HERO SLIDER ========== -->
<?php if (!empty($slides)): ?>
  <section class="uni-hero hero-slider">
    <?php foreach ($slides as $i => $slide): ?>
    <div class="hero-slide <?= $i === 0 ? 'active' : '' ?>">
      <div class="uni-hero-bg" style="background-image: url('<?= escape($slide['image']) ?>');"></div>
      <div class="uni-hero-overlay"></div>
      <div class="container uni-hero-content">
        <span class="uni-hero-tag <?= $i === 0 ? 'hero-anim-1' : '' ?>">Admissions Open &mdash; 2026/2027</span>
        <h1 class="uni-hero-h1">
          <span <?= $i === 0 ? 'class="hero-anim-2"' : '' ?>><?= escape($slide['headline_1']) ?> <?= escape($slide['headline_2']) ?></span>
          <em <?= $i === 0 ? 'class="hero-anim-3"' : '' ?>><?= escape($slide['headline_3']) ?></em>
        </h1>
        <p class="uni-hero-sub <?= $i === 0 ? 'hero-anim-4' : '' ?>"><?= escape($slide['subtitle']) ?></p>
        <div class="uni-hero-btns <?= $i === 0 ? 'hero-anim-5' : '' ?>">
          <a href="<?= escape($slide['cta_link']) ?>" class="btn btn-primary btn-hero"><?= escape($slide['cta_text']) ?> <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg></a>
          <a href="academics.php" class="btn btn-hero-outline">Explore Programmes</a>
        </div>
      </div>
    </div>
    <?php endforeach; ?>

    <?php if (count($slides) > 1): ?>
    <button class="slider-prev" aria-label="Previous slide"><svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="15 18 9 12 15 6"/></svg></button>
    <button class="slider-next" aria-label="Next slide"><svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9 18 15 12 9 6"/></svg></button>
    <div class="slider-dots">
      <?php foreach ($slides as $i => $s): ?>
      <button class="slider-dot <?= $i === 0 ? 'active' : '' ?>" aria-label="Slide <?= $i + 1 ?>"></button>
      <?php endforeach; ?>
    </div>
    <?php endif; ?>
  </section>

<?php else: ?>
  <section class="uni-hero">
    <div class="uni-hero-bg" style="background-image: url('https://images.unsplash.com/photo-1581093458791-9f3c3900df4b?w=1920&q=80');"></div>
    <div class="uni-hero-overlay"></div>
    <div class="container uni-hero-content">
      <span class="uni-hero-tag hero-anim-1">Admissions Open &mdash; 2026/2027</span>
      <h1 class="uni-hero-h1">
        <span class="hero-anim-2">Shaping the Future of</span>
        <em class="hero-anim-3">Biomedical Science</em>
      </h1>
      <p class="uni-hero-sub hero-anim-4">TIBST is a premier institution dedicated to advancing biomedical science education and research in Ghana and beyond.</p>
      <div class="uni-hero-btns hero-anim-5">
        <a href="admissions.php" class="btn btn-primary btn-hero">Apply Now <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg></a>
        <a href="academics.php" class="btn btn-hero-outline">Explore Programmes</a>
      </div>
    </div>
  </section>
<?php endif; ?>

  <!-- ========== QUICK LINKS BAR ========== -->
  <section class="quick-bar">
    <div class="container">
      <div class="quick-bar-grid">
        <a href="apply.php" class="quick-bar-item">
          <div class="quick-bar-icon">
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="12" y1="18" x2="12" y2="12"/><line x1="9" y1="15" x2="15" y2="15"/></svg>
          </div>
          <div>
            <strong>Apply Online</strong>
            <span>Start your application</span>
          </div>
        </a>
        <a href="academics.php" class="quick-bar-item">
          <div class="quick-bar-icon">
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M22 10v6M2 10l10-5 10 5-10 5z"/><path d="M6 12v5c3 3 6 3 6 3s3 0 6-3v-5"/></svg>
          </div>
          <div>
            <strong>Our Programmes</strong>
            <span>MPhil &amp; PhD degrees</span>
          </div>
        </a>
        <a href="research.php" class="quick-bar-item">
          <div class="quick-bar-icon">
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/></svg>
          </div>
          <div>
            <strong>Research</strong>
            <span>Innovation &amp; discovery</span>
          </div>
        </a>
        <a href="student-life.php" class="quick-bar-item">
          <div class="quick-bar-icon">
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
          </div>
          <div>
            <strong>Campus Life</strong>
            <span>Experience TIBST</span>
          </div>
        </a>
        <a href="contact.php" class="quick-bar-item">
          <div class="quick-bar-icon">
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"/></svg>
          </div>
          <div>
            <strong>Contact Us</strong>
            <span>Get in touch</span>
          </div>
        </a>
      </div>
    </div>
  </section>

  <!-- ========== PROGRAMMES ========== -->
  <section class="section programmes-section">
    <div class="container">
      <div class="section-header fade-up">
        <div class="section-label">Academic Excellence</div>
        <h2 class="section-title">Our Programmes</h2>
        <p class="section-subtitle">Cutting-edge postgraduate programmes designed to push the boundaries of biomedical science and technology.</p>
      </div>

      <div class="prog-grid-v6">
<?php
$defaultImages = [
  'https://images.unsplash.com/photo-1579154204601-01588f351e67?w=900&q=80',
  'https://images.unsplash.com/photo-1530026405186-ed1f139313f8?w=900&q=80',
  'https://images.unsplash.com/photo-1576086213369-97a306d36557?w=900&q=80',
  'https://images.unsplash.com/photo-1532187863486-abf9dbad1b69?w=900&q=80',
];
$list = !empty($programmes) ? $programmes : [];
if (empty($list)):
  $list = [
    ['degree_type'=>'MPhil','title'=>'Gene Therapy','duration'=>'2 years','image'=>null],
    ['degree_type'=>'PhD','title'=>'Gene Therapy','duration'=>'3-4 years','image'=>null],
    ['degree_type'=>'MPhil','title'=>'Human Embryology','duration'=>'2 years','image'=>null],
    ['degree_type'=>'PhD','title'=>'Human Embryology','duration'=>'3-4 years','image'=>null],
  ];
endif;
foreach ($list as $i => $prog):
  $img = !empty($prog['image']) ? escape($prog['image']) : ($defaultImages[$i % count($defaultImages)]);
  $dur = escape($prog['duration']);
  // Parse duration for display: "2 years" → "MIN 2YRS", "3-4 years" → "MIN 3YRS – MAX 4YRS"
  if (preg_match('/^(\d+)\s*-\s*(\d+)/', $dur, $m)) {
    $durLabel = "MIN {$m[1]}YRS &ndash; MAX {$m[2]}YRS";
  } elseif (preg_match('/^(\d+)/', $dur, $m)) {
    $durLabel = "MIN {$m[1]}YRS &ndash; MAX " . ($m[1]+1) . "YRS";
  } else {
    $durLabel = escape($dur);
  }
?>
        <article class="prog-card-v6 fade-up fade-up-delay-<?= min($i, 3) ?>">
          <div class="prog-card-v6-img" style="background-image: url('<?= $img ?>');"></div>
          <div class="prog-card-v6-overlay">
            <span class="prog-card-v6-duration"><?= $durLabel ?></span>
            <h3 class="prog-card-v6-title"><?= escape($prog['degree_type']) ?> <?= escape($prog['title']) ?></h3>
            <a href="academics.php" class="prog-card-v6-link">MORE INFO</a>
          </div>
        </article>
<?php endforeach; ?>
      </div>

      <div style="text-align:center; margin-top:48px;">
        <a href="academics.php" class="btn btn-outline-dark fade-up">View All Programmes <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg></a>
      </div>
    </div>
  </section>

  <!-- ========== WHY TIBST ========== -->
  <section class="section" style="background: var(--white);">
    <div class="container">
      <div class="section-header fade-up">
        <div class="section-label">Why TIBST</div>
        <h2 class="section-title">Your Career Starts With Us</h2>
        <p class="section-subtitle">No matter which career path you choose, your experience at TIBST will give you a basis for success.</p>
      </div>

      <div class="features-grid-v4">
        <div class="feature-card-v4 fade-up">
          <div class="feature-card-v4-icon">
            <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M12 2L2 7l10 5 10-5-10-5z"/><path d="M2 17l10 5 10-5"/><path d="M2 12l10 5 10-5"/></svg>
          </div>
          <h3>World-Class Research</h3>
          <p>Access cutting-edge research facilities and collaborate with leading scientists in gene therapy and human embryology.</p>
        </div>
        <div class="feature-card-v4 fade-up fade-up-delay-1">
          <div class="feature-card-v4-icon">
            <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
          </div>
          <h3>Expert Faculty</h3>
          <p>Learn from distinguished academics who are leaders in their respective biomedical fields.</p>
        </div>
        <div class="feature-card-v4 fade-up fade-up-delay-2">
          <div class="feature-card-v4-icon">
            <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><circle cx="12" cy="12" r="10"/><line x1="2" y1="12" x2="22" y2="12"/><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/></svg>
          </div>
          <h3>Global Impact</h3>
          <p>Our research and graduates contribute to advancing healthcare solutions across Africa and the world.</p>
        </div>
        <div class="feature-card-v4 fade-up">
          <div class="feature-card-v4-icon">
            <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94l-3.76 3.76z"/></svg>
          </div>
          <h3>Hands-On Training</h3>
          <p>Gain practical laboratory experience through our translational research units and state-of-the-art facilities.</p>
        </div>
        <div class="feature-card-v4 fade-up fade-up-delay-1">
          <div class="feature-card-v4-icon">
            <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/></svg>
          </div>
          <h3>Rich Library Resources</h3>
          <p>Access an extensive collection of biomedical journals, databases, and digital resources to support your research.</p>
        </div>
        <div class="feature-card-v4 fade-up fade-up-delay-2">
          <div class="feature-card-v4-icon">
            <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
          </div>
          <h3>Financial Support</h3>
          <p>Benefit from our financial aid and sponsorship programmes designed to make quality education accessible.</p>
        </div>
      </div>
    </div>
  </section>

  <!-- ========== STATS BAND ========== -->
  <section class="stats-band">
    <div class="stats-band-bg" style="background-image: url('https://images.unsplash.com/photo-1532094349884-543bc11b234d?w=1920&q=80');"></div>
    <div class="stats-band-overlay"></div>
    <div class="container" style="position:relative; z-index:2;">
      <div class="stats-band-grid">
        <div class="stats-band-item fade-up">
          <div class="stats-band-num" data-count="5" data-suffix="+">0</div>
          <div class="stats-band-label">Programmes Offered</div>
        </div>
        <div class="stats-band-item fade-up fade-up-delay-1">
          <div class="stats-band-num" data-count="50" data-suffix="+">0</div>
          <div class="stats-band-label">Researchers</div>
        </div>
        <div class="stats-band-item fade-up fade-up-delay-2">
          <div class="stats-band-num" data-count="3">0</div>
          <div class="stats-band-label">Research Units</div>
        </div>
        <div class="stats-band-item fade-up fade-up-delay-3">
          <div class="stats-band-num" data-count="100" data-suffix="%">0</div>
          <div class="stats-band-label">Dedication</div>
        </div>
      </div>
    </div>
  </section>

  <!-- ========== TESTIMONIALS ========== -->
  <section class="testimonials-section-v4">
    <div class="container">
      <div class="section-header fade-up">
        <div class="section-label">Testimonials</div>
        <h2 class="section-title">What Our Students Say</h2>
      </div>
    </div>
    <div class="testimonial-marquee-track">
      <div class="testimonial-marquee-inner">
<?php if (!empty($testimonials)): ?>
        <?php foreach ($testimonials as $t): ?>
        <div class="testimonial-card-v4">
          <div class="testimonial-card-v4-quote">&ldquo;</div>
          <p class="testimonial-card-v4-text"><?= escape($t['quote']) ?></p>
          <div class="testimonial-card-v4-author">
            <div class="testimonial-card-v4-avatar"><?= escape($t['initials']) ?></div>
            <div>
              <strong><?= escape($t['name']) ?></strong>
              <span><?= escape($t['role']) ?></span>
            </div>
          </div>
        </div>
        <?php endforeach; ?>
        <?php foreach ($testimonials as $t): ?>
        <div class="testimonial-card-v4">
          <div class="testimonial-card-v4-quote">&ldquo;</div>
          <p class="testimonial-card-v4-text"><?= escape($t['quote']) ?></p>
          <div class="testimonial-card-v4-author">
            <div class="testimonial-card-v4-avatar"><?= escape($t['initials']) ?></div>
            <div>
              <strong><?= escape($t['name']) ?></strong>
              <span><?= escape($t['role']) ?></span>
            </div>
          </div>
        </div>
        <?php endforeach; ?>
<?php else: ?>
        <div class="testimonial-card-v4">
          <div class="testimonial-card-v4-quote">&ldquo;</div>
          <p class="testimonial-card-v4-text">TIBST provided me with the rigorous training and mentorship I needed to pursue my passion in gene therapy. The research opportunities are unparalleled.</p>
          <div class="testimonial-card-v4-author">
            <div class="testimonial-card-v4-avatar">AK</div>
            <div><strong>Dr. Ama Kusi</strong><span>PhD Gene Therapy, Class of 2025</span></div>
          </div>
        </div>
        <div class="testimonial-card-v4">
          <div class="testimonial-card-v4-quote">&ldquo;</div>
          <p class="testimonial-card-v4-text">The faculty at TIBST are world-class. Their dedication to student success and advancing biomedical science is truly inspiring.</p>
          <div class="testimonial-card-v4-author">
            <div class="testimonial-card-v4-avatar">KM</div>
            <div><strong>Kwame Mensah</strong><span>MPhil Human Embryology, Current Student</span></div>
          </div>
        </div>
        <div class="testimonial-card-v4">
          <div class="testimonial-card-v4-quote">&ldquo;</div>
          <p class="testimonial-card-v4-text">TIBST's translational research approach bridges the gap between laboratory discoveries and real-world medical applications.</p>
          <div class="testimonial-card-v4-author">
            <div class="testimonial-card-v4-avatar">EA</div>
            <div><strong>Dr. Efua Aidoo</strong><span>MPhil Gene Therapy, Class of 2024</span></div>
          </div>
        </div>
        <div class="testimonial-card-v4">
          <div class="testimonial-card-v4-quote">&ldquo;</div>
          <p class="testimonial-card-v4-text">TIBST provided me with the rigorous training and mentorship I needed to pursue my passion in gene therapy. The research opportunities are unparalleled.</p>
          <div class="testimonial-card-v4-author">
            <div class="testimonial-card-v4-avatar">AK</div>
            <div><strong>Dr. Ama Kusi</strong><span>PhD Gene Therapy, Class of 2025</span></div>
          </div>
        </div>
        <div class="testimonial-card-v4">
          <div class="testimonial-card-v4-quote">&ldquo;</div>
          <p class="testimonial-card-v4-text">The faculty at TIBST are world-class. Their dedication to student success and advancing biomedical science is truly inspiring.</p>
          <div class="testimonial-card-v4-author">
            <div class="testimonial-card-v4-avatar">KM</div>
            <div><strong>Kwame Mensah</strong><span>MPhil Human Embryology, Current Student</span></div>
          </div>
        </div>
        <div class="testimonial-card-v4">
          <div class="testimonial-card-v4-quote">&ldquo;</div>
          <p class="testimonial-card-v4-text">TIBST's translational research approach bridges the gap between laboratory discoveries and real-world medical applications.</p>
          <div class="testimonial-card-v4-author">
            <div class="testimonial-card-v4-avatar">EA</div>
            <div><strong>Dr. Efua Aidoo</strong><span>MPhil Gene Therapy, Class of 2024</span></div>
          </div>
        </div>
<?php endif; ?>
      </div>
    </div>
  </section>

  <!-- ========== NEWS ========== -->
  <section class="section" style="background: var(--gray-50);">
    <div class="container">
      <div style="display:flex; justify-content:space-between; align-items:flex-end; flex-wrap:wrap; gap:16px; margin-bottom:48px;">
        <div class="fade-up">
          <div class="section-label">Stay Updated</div>
          <h2 class="section-title">Latest News &amp; Events</h2>
        </div>
        <a href="news-events.php" class="btn btn-outline-dark btn-sm fade-up">View All News <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg></a>
      </div>

      <div class="news-cards-v4">
<?php if (!empty($latestNews)): ?>
        <?php foreach ($latestNews as $k => $news): ?>
        <article class="news-card-v4 fade-up fade-up-delay-<?= min($k, 3) ?>">
          <div class="news-card-v4-img" style="background-image: url('<?= $news['image'] ? escape($news['image']) : 'https://images.unsplash.com/photo-1532187863486-abf9dbad1b69?w=800&q=80' ?>');"></div>
          <div class="news-card-v4-body">
            <?php $nDate = new DateTime($news['publish_date']); ?>
            <div class="news-card-v4-date">
              <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
              <?= $nDate->format('F j, Y') ?>
            </div>
            <h3 class="news-card-v4-title"><?= escape($news['title']) ?></h3>
            <p class="news-card-v4-excerpt"><?= escape($news['excerpt']) ?></p>
            <a href="news-events.php?slug=<?= escape($news['slug']) ?>" class="news-card-v4-link">Read More &rarr;</a>
          </div>
        </article>
        <?php endforeach; ?>
<?php else: ?>
        <article class="news-card-v4 fade-up">
          <div class="news-card-v4-img" style="background-image: url('https://images.unsplash.com/photo-1532187863486-abf9dbad1b69?w=800&q=80');"></div>
          <div class="news-card-v4-body">
            <div class="news-card-v4-date"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg> March 1, 2026</div>
            <h3 class="news-card-v4-title">2026/2027 Admissions Now Open</h3>
            <p class="news-card-v4-excerpt">Applications are now being accepted for the upcoming academic year. Apply early to secure your place.</p>
            <a href="news-events.php" class="news-card-v4-link">Read More &rarr;</a>
          </div>
        </article>
        <article class="news-card-v4 fade-up fade-up-delay-1">
          <div class="news-card-v4-img" style="background-image: url('https://images.unsplash.com/photo-1559757175-5700dde675bc?w=800&q=80');"></div>
          <div class="news-card-v4-body">
            <div class="news-card-v4-date"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg> February 15, 2026</div>
            <h3 class="news-card-v4-title">Breakthrough in Gene Therapy Research</h3>
            <p class="news-card-v4-excerpt">TIBST researchers make significant progress in developing novel gene therapy approaches for inherited diseases.</p>
            <a href="news-events.php" class="news-card-v4-link">Read More &rarr;</a>
          </div>
        </article>
        <article class="news-card-v4 fade-up fade-up-delay-2">
          <div class="news-card-v4-img" style="background-image: url('https://images.unsplash.com/photo-1540575467063-178a50c2df87?w=800&q=80');"></div>
          <div class="news-card-v4-body">
            <div class="news-card-v4-date"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg> February 5, 2026</div>
            <h3 class="news-card-v4-title">Guest Lecture Series: Future of Biomedical Sciences</h3>
            <p class="news-card-v4-excerpt">Join us for our upcoming special lecture series featuring renowned international scientists.</p>
            <a href="news-events.php" class="news-card-v4-link">Read More &rarr;</a>
          </div>
        </article>
<?php endif; ?>
      </div>
    </div>
  </section>

  <!-- ========== CTA ========== -->
  <section class="cta-band">
    <div class="cta-band-pattern"></div>
    <div class="container" style="position:relative; z-index:1;">
      <div class="cta-band-content fade-up">
        <h2>Ready to Shape the Future?</h2>
        <p>Join TIBST and become part of a community dedicated to advancing biomedical science and technology in Ghana and beyond.</p>
        <div class="cta-band-btns">
          <a href="admissions.php" class="btn btn-white btn-lg">Apply Now</a>
          <a href="contact.php" class="btn btn-outline-white btn-lg">Contact Us</a>
        </div>
      </div>
    </div>
  </section>

<?php require_once 'includes/footer.php'; ?>
