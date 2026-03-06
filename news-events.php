<?php
$pageTitle = 'News & Events - TIBST';
$activePage = 'news-events';
require_once 'includes/header.php';

// ── Single article view ────────────────────────────────────────────
$slug = isset($_GET['slug']) ? trim($_GET['slug']) : '';
$singleArticle = null;
if ($slug !== '') {
    $singleArticle = getNewsBySlug($slug);
}

// ── List view data ─────────────────────────────────────────────────
$allNews = getPublishedNews(50);
?>

<?php if ($singleArticle): ?>
  <!-- SINGLE ARTICLE VIEW -->
  <section class="page-hero" style="background-image: url('<?= $singleArticle['image'] ? escape($singleArticle['image']) : 'https://images.unsplash.com/photo-1504711434969-e33886168d6c?w=1920&q=80' ?>');">
    <div class="hero-overlay"></div>
    <div class="container" style="position:relative; z-index:1;">
      <div class="breadcrumb fade-up">
        <a href="index.php">Home</a>
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9 18 15 12 9 6"></polyline></svg>
        <a href="news-events.php">News & Events</a>
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9 18 15 12 9 6"></polyline></svg>
        <span>Article</span>
      </div>
      <h1 class="fade-up"><?= escape($singleArticle['title']) ?></h1>
      <?php $artDate = new DateTime($singleArticle['publish_date']); ?>
      <p class="fade-up"><?= $artDate->format('F j, Y') ?></p>
    </div>
  </section>

  <section class="section" style="background: var(--off-white);">
    <div class="container">
      <div style="max-width:800px; margin:0 auto;">
        <div class="fade-up" style="font-size:1.05rem; line-height:1.9; color:var(--gray-700);">
          <?= $singleArticle['body'] ?>
        </div>
        <div style="margin-top:48px; text-align:center;">
          <a href="news-events.php" class="btn btn-outline-dark">Back to All News <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg></a>
        </div>
      </div>
    </div>
  </section>

<?php else: ?>
  <!-- PAGE HERO -->
  <section class="page-hero" style="background-image: url('https://images.unsplash.com/photo-1504711434969-e33886168d6c?w=1920&q=80');">
    <div class="hero-overlay"></div>
    <div class="container" style="position:relative; z-index:1;">
      <div class="breadcrumb fade-up">
        <a href="index.php">Home</a>
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9 18 15 12 9 6"></polyline></svg>
        <span>News & Events</span>
      </div>
      <h1 class="fade-up">News & Events</h1>
      <p class="fade-up">Stay informed about the latest happenings, research breakthroughs, and upcoming events at TIBST.</p>
    </div>
  </section>

  <!-- NEWS ARTICLES -->
  <section class="section" style="background: var(--off-white);">
    <div class="container">
      <div class="section-header fade-up">
        <div class="section-label">Latest Updates</div>
        <h2 class="section-title">News Articles</h2>
        <p class="section-subtitle">Explore the latest developments in biomedical research, academic achievements, and institutional milestones.</p>
      </div>

<?php if (!empty($allNews)): ?>
      <div class="news-grid" style="display:grid; grid-template-columns: repeat(auto-fill, minmax(340px, 1fr)); gap:32px;">
        <?php foreach ($allNews as $i => $news): ?>
        <a href="news-events.php?slug=<?= escape($news['slug']) ?>" style="text-decoration:none; color:inherit;">
          <div class="news-card fade-up <?= $i % 3 === 1 ? 'fade-up-delay-1' : ($i % 3 === 2 ? 'fade-up-delay-2' : '') ?>">
            <div class="news-card-img" style="background-image: url('<?= $news['image'] ? escape($news['image']) : 'https://images.unsplash.com/photo-1532187863486-abf9dbad1b69?w=800&q=80' ?>');"></div>
            <div class="news-card-body">
              <?php $nDate = new DateTime($news['publish_date']); ?>
              <div class="news-card-date"><?= $nDate->format('F j, Y') ?></div>
              <h3 class="news-card-title"><?= escape($news['title']) ?></h3>
              <p class="news-card-excerpt"><?= escape($news['excerpt']) ?></p>
            </div>
          </div>
        </a>
        <?php endforeach; ?>
      </div>
<?php else: ?>
      <div class="news-grid" style="display:grid; grid-template-columns: repeat(auto-fill, minmax(340px, 1fr)); gap:32px;">
        <div class="news-card fade-up">
          <div class="news-card-img" style="background-image: url('https://images.unsplash.com/photo-1532187863486-abf9dbad1b69?w=800&q=80');"></div>
          <div class="news-card-body">
            <div class="news-card-date">March 1, 2026</div>
            <h3 class="news-card-title">2026/2027 Admissions Now Open</h3>
            <p class="news-card-excerpt">Applications are now being accepted for the upcoming academic year. Apply early to secure your place in our prestigious MPhil and PhD programmes in Gene Therapy and Human Embryology.</p>
          </div>
        </div>

        <div class="news-card fade-up fade-up-delay-1">
          <div class="news-card-img" style="background-image: url('https://images.unsplash.com/photo-1559757175-5700dde675bc?w=800&q=80');"></div>
          <div class="news-card-body">
            <div class="news-card-date">February 15, 2026</div>
            <h3 class="news-card-title">Breakthrough in Gene Therapy Research</h3>
            <p class="news-card-excerpt">TIBST researchers make significant progress in developing novel gene therapy approaches for inherited diseases, publishing findings in a leading international journal.</p>
          </div>
        </div>

        <div class="news-card fade-up fade-up-delay-2">
          <div class="news-card-img" style="background-image: url('https://images.unsplash.com/photo-1576086213369-97a306d36557?w=800&q=80');"></div>
          <div class="news-card-body">
            <div class="news-card-date">February 5, 2026</div>
            <h3 class="news-card-title">New Embryology Lab Facility Inaugurated</h3>
            <p class="news-card-excerpt">TIBST unveils a state-of-the-art human embryology laboratory equipped with the latest microscopy and cell culture technologies for advanced research.</p>
          </div>
        </div>

        <div class="news-card fade-up">
          <div class="news-card-img" style="background-image: url('https://images.unsplash.com/photo-1582719471384-894fbb16e074?w=800&q=80');"></div>
          <div class="news-card-body">
            <div class="news-card-date">January 20, 2026</div>
            <h3 class="news-card-title">TIBST Partners with International Research Consortium</h3>
            <p class="news-card-excerpt">A new partnership with the Global Biomedical Research Consortium opens doors for collaborative research and student exchange opportunities across three continents.</p>
          </div>
        </div>

        <div class="news-card fade-up fade-up-delay-1">
          <div class="news-card-img" style="background-image: url('https://images.unsplash.com/photo-1579154204601-01588f351e67?w=800&q=80');"></div>
          <div class="news-card-body">
            <div class="news-card-date">January 10, 2026</div>
            <h3 class="news-card-title">PhD Candidate Wins National Science Award</h3>
            <p class="news-card-excerpt">TIBST doctoral candidate Dr. Abena Osei receives the Ghana National Science Award for her groundbreaking research in CRISPR-based gene editing therapies.</p>
          </div>
        </div>

        <div class="news-card fade-up fade-up-delay-2">
          <div class="news-card-img" style="background-image: url('https://images.unsplash.com/photo-1530026405186-ed1f139313f8?w=800&q=80');"></div>
          <div class="news-card-body">
            <div class="news-card-date">December 18, 2025</div>
            <h3 class="news-card-title">Annual Biomedical Sciences Symposium Highlights</h3>
            <p class="news-card-excerpt">The 2025 TIBST Biomedical Sciences Symposium brought together over 200 researchers, clinicians, and students to discuss the future of translational medicine in Africa.</p>
          </div>
        </div>
      </div>
<?php endif; ?>
    </div>
  </section>

  <!-- UPCOMING EVENTS -->
  <section class="section" style="background: var(--white);">
    <div class="container">
      <div class="section-header fade-up">
        <div class="section-label">Mark Your Calendar</div>
        <h2 class="section-title">Upcoming Events</h2>
        <p class="section-subtitle">Join us for lectures, workshops, conferences, and community events throughout the year.</p>
      </div>

      <div style="display:flex; flex-direction:column; gap:24px; max-width:900px; margin:0 auto;">
        <div class="feature-card fade-up" style="display:flex; gap:24px; align-items:flex-start; flex-wrap:wrap;">
          <div style="min-width:80px; text-align:center; background:#4E9B17; color:white; border-radius:12px; padding:12px 16px;">
            <div style="font-size:28px; font-weight:700; line-height:1;">15</div>
            <div style="font-size:13px; text-transform:uppercase; letter-spacing:1px;">Mar</div>
          </div>
          <div style="flex:1; min-width:250px;">
            <h3 style="margin-bottom:4px;">Special Lecture Series: Future of Biomedical Sciences</h3>
            <p style="color:#666; font-size:14px; margin-bottom:8px;">
              <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="vertical-align:middle;"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
              TIBST Main Auditorium, Lashibi Campus
            </p>
            <p>Join us for a series of lectures by internationally renowned scientists discussing emerging trends in gene therapy, regenerative medicine, and biomedical engineering.</p>
          </div>
        </div>

        <div class="feature-card fade-up fade-up-delay-1" style="display:flex; gap:24px; align-items:flex-start; flex-wrap:wrap;">
          <div style="min-width:80px; text-align:center; background:#4E9B17; color:white; border-radius:12px; padding:12px 16px;">
            <div style="font-size:28px; font-weight:700; line-height:1;">28</div>
            <div style="font-size:13px; text-transform:uppercase; letter-spacing:1px;">Mar</div>
          </div>
          <div style="flex:1; min-width:250px;">
            <h3 style="margin-bottom:4px;">Research Methodology Workshop</h3>
            <p style="color:#666; font-size:14px; margin-bottom:8px;">
              <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="vertical-align:middle;"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
              Research Lab Complex, Room 201
            </p>
            <p>A hands-on workshop covering advanced research methodologies, statistical analysis, and scientific writing for postgraduate students and early-career researchers.</p>
          </div>
        </div>

        <div class="feature-card fade-up fade-up-delay-2" style="display:flex; gap:24px; align-items:flex-start; flex-wrap:wrap;">
          <div style="min-width:80px; text-align:center; background:#4E9B17; color:white; border-radius:12px; padding:12px 16px;">
            <div style="font-size:28px; font-weight:700; line-height:1;">10</div>
            <div style="font-size:13px; text-transform:uppercase; letter-spacing:1px;">Apr</div>
          </div>
          <div style="flex:1; min-width:250px;">
            <h3 style="margin-bottom:4px;">Open Day and Campus Tour</h3>
            <p style="color:#666; font-size:14px; margin-bottom:8px;">
              <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="vertical-align:middle;"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
              TIBST Main Campus, Lashibi, Accra
            </p>
            <p>Prospective students and their families are invited to tour our campus, meet faculty, explore our laboratories, and learn about our admission process and programmes.</p>
          </div>
        </div>

        <div class="feature-card fade-up" style="display:flex; gap:24px; align-items:flex-start; flex-wrap:wrap;">
          <div style="min-width:80px; text-align:center; background:#4E9B17; color:white; border-radius:12px; padding:12px 16px;">
            <div style="font-size:28px; font-weight:700; line-height:1;">25</div>
            <div style="font-size:13px; text-transform:uppercase; letter-spacing:1px;">Apr</div>
          </div>
          <div style="flex:1; min-width:250px;">
            <h3 style="margin-bottom:4px;">International Conference on Translational Medicine</h3>
            <p style="color:#666; font-size:14px; margin-bottom:8px;">
              <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="vertical-align:middle;"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
              TIBST Conference Centre, Lashibi Campus
            </p>
            <p>A two-day conference bringing together leading researchers, clinicians, and industry experts to discuss breakthroughs in translating biomedical research into clinical practice.</p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- ANNOUNCEMENTS -->
  <section class="section" style="background: var(--off-white);">
    <div class="container">
      <div class="section-header fade-up">
        <div class="section-label">Important Notices</div>
        <h2 class="section-title">Announcements</h2>
      </div>

      <div style="max-width:900px; margin:0 auto; display:flex; flex-direction:column; gap:20px;">
        <div class="feature-card fade-up" style="border-left:4px solid #4E9B17;">
          <h3 style="margin-bottom:8px;">2026/2027 Admission Deadline Approaching</h3>
          <p style="color:#666; font-size:13px; margin-bottom:8px;">Posted: March 1, 2026</p>
          <p>The deadline for applications to our MPhil and PhD programmes for the 2026/2027 academic year is April 30, 2026. Ensure all supporting documents are submitted before the deadline.</p>
        </div>

        <div class="feature-card fade-up fade-up-delay-1" style="border-left:4px solid #4E9B17;">
          <h3 style="margin-bottom:8px;">Library Extended Hours During Examination Period</h3>
          <p style="color:#666; font-size:13px; margin-bottom:8px;">Posted: February 20, 2026</p>
          <p>The TIBST library will operate extended hours from March 10 to April 5 to support students during the examination and thesis submission period. The library will be open from 7:00 AM to 10:00 PM on weekdays.</p>
        </div>

        <div class="feature-card fade-up fade-up-delay-2" style="border-left:4px solid #4E9B17;">
          <h3 style="margin-bottom:8px;">Scholarship Applications Open for International Students</h3>
          <p style="color:#666; font-size:13px; margin-bottom:8px;">Posted: February 10, 2026</p>
          <p>TIBST is pleased to announce scholarship opportunities for qualified international students. Partial and full tuition scholarships are available for the 2026/2027 academic year. Visit the Admissions office or apply online.</p>
        </div>

        <div class="feature-card fade-up" style="border-left:4px solid #4E9B17;">
          <h3 style="margin-bottom:8px;">Campus Wi-Fi Upgrade Complete</h3>
          <p style="color:#666; font-size:13px; margin-bottom:8px;">Posted: January 28, 2026</p>
          <p>The campus-wide Wi-Fi infrastructure upgrade is now complete. Students and staff can enjoy faster and more reliable internet connectivity across all buildings and common areas.</p>
        </div>
      </div>
    </div>
  </section>

<?php endif; ?>

<?php require_once 'includes/footer.php'; ?>
