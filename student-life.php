<?php
$pageTitle = 'Student Life - TIBST | Thrivus Institute of Biomedical Sciences & Technology';
$activePage = 'student-life';
require_once 'includes/header.php';

// ── Fetch dynamic content ──────────────────────────────────────────
$campusLifeBlock = getPageBlock('student-life', 'campus');
$clubsBlock      = getPageBlock('student-life', 'clubs');
$galleryBlock    = getPageBlock('student-life', 'gallery');
?>

  <!-- PAGE HERO -->
  <section class="page-hero">
    <div class="hero-bg" style="background-image: url('https://images.unsplash.com/photo-1523050854058-8df90110c9f1?w=1920&q=80');"></div>
    <div class="hero-overlay"></div>
    <div class="hero-pattern"></div>
    <div class="hero-content">
      <div class="breadcrumb">
        <a href="index.php">Home</a>
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9 18 15 12 9 6"></polyline></svg>
        <span>Student Life</span>
      </div>
      <h1>Life at <span class="highlight">TIBST</span></h1>
      <p class="hero-subtitle">Experience a vibrant campus community where academic excellence meets personal growth. At TIBST, every day brings new opportunities to learn, connect, and thrive.</p>
    </div>
  </section>

  <!-- CAMPUS LIFE OVERVIEW -->
  <section class="section" style="background: var(--off-white);">
    <div class="container">
      <div class="section-header fade-up">
        <div class="section-label">Campus Life</div>
        <h2 class="section-title">World-Class Facilities</h2>
        <p class="section-subtitle">Our campus is designed to provide an exceptional environment for learning, research, and personal development.</p>
      </div>

      <?php if (!empty($campusLifeBlock)): ?>
      <div class="fade-up"><?= $campusLifeBlock ?></div>
      <?php else: ?>
      <div class="features-grid">
        <div class="feature-card fade-up">
          <div class="feature-icon">
            <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94l-3.76 3.76z"></path></svg>
          </div>
          <h3>Modern Labs</h3>
          <p>State-of-the-art laboratories equipped with cutting-edge instruments for gene therapy and embryology research, providing hands-on experience with the latest technologies.</p>
        </div>

        <div class="feature-card fade-up fade-up-delay-1">
          <div class="feature-icon">
            <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"></path><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"></path></svg>
          </div>
          <h3>Library</h3>
          <p>A comprehensive biomedical library with extensive collections of journals, e-resources, and digital databases to support your academic research and coursework.</p>
        </div>

        <div class="feature-card fade-up fade-up-delay-2">
          <div class="feature-icon">
            <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
          </div>
          <h3>Student Lounge</h3>
          <p>Comfortable common areas where students can relax, socialize, and collaborate on projects between classes and research sessions.</p>
        </div>

        <div class="feature-card fade-up">
          <div class="feature-icon">
            <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 8h1a4 4 0 0 1 0 8h-1"></path><path d="M2 8h16v9a4 4 0 0 1-4 4H6a4 4 0 0 1-4-4V8z"></path><line x1="6" y1="1" x2="6" y2="4"></line><line x1="10" y1="1" x2="10" y2="4"></line><line x1="14" y1="1" x2="14" y2="4"></line></svg>
          </div>
          <h3>Cafeteria</h3>
          <p>A welcoming dining space serving nutritious meals and refreshments, providing the perfect spot to refuel and catch up with fellow students and faculty.</p>
        </div>

        <div class="feature-card fade-up fade-up-delay-1">
          <div class="feature-icon">
            <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><polygon points="16.24 7.76 14.12 14.12 7.76 16.24 9.88 9.88 16.24 7.76"></polygon></svg>
          </div>
          <h3>Sports</h3>
          <p>Recreational and sports facilities to keep you active and healthy, including fitness areas and open spaces for team activities and wellness programmes.</p>
        </div>

        <div class="feature-card fade-up fade-up-delay-2">
          <div class="feature-icon">
            <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="3" width="20" height="14" rx="2" ry="2"></rect><line x1="8" y1="21" x2="16" y2="21"></line><line x1="12" y1="17" x2="12" y2="21"></line></svg>
          </div>
          <h3>Study Areas</h3>
          <p>Dedicated quiet zones and collaborative study spaces equipped with high-speed internet and power outlets, ideal for focused academic work and group discussions.</p>
        </div>
      </div>
      <?php endif; ?>
    </div>
  </section>

  <!-- CLUBS & ORGANIZATIONS -->
  <section class="section" style="background: var(--white);">
    <div class="container">
      <div class="section-header fade-up">
        <div class="section-label">Get Involved</div>
        <h2 class="section-title">Clubs & Organizations</h2>
        <p class="section-subtitle">Join student-led organizations that enhance your academic journey and help you build lasting connections.</p>
      </div>

      <div class="features-grid">
        <div class="feature-card fade-up">
          <div class="feature-icon">
            <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2L2 7l10 5 10-5-10-5z"></path><path d="M2 17l10 5 10-5"></path><path d="M2 12l10 5 10-5"></path></svg>
          </div>
          <h3>Biomedical Research Society</h3>
          <p>A student-driven community that organizes journal clubs, research seminars, and collaborative projects to deepen scientific understanding and foster innovation.</p>
        </div>

        <div class="feature-card fade-up fade-up-delay-1">
          <div class="feature-icon">
            <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><line x1="2" y1="12" x2="22" y2="12"></line><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"></path></svg>
          </div>
          <h3>Global Health Initiative</h3>
          <p>Dedicated to exploring healthcare challenges in Africa and beyond, this group organizes outreach programmes, health campaigns, and international collaborations.</p>
        </div>

        <div class="feature-card fade-up fade-up-delay-2">
          <div class="feature-icon">
            <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path></svg>
          </div>
          <h3>Science Communication Club</h3>
          <p>Develop your skills in communicating complex scientific ideas to diverse audiences through workshops, writing sessions, and public speaking events.</p>
        </div>

        <div class="feature-card fade-up">
          <div class="feature-icon">
            <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path></svg>
          </div>
          <h3>Student Welfare Association</h3>
          <p>Advocating for student interests, this association provides support services, mentorship programmes, and organizes social events to build campus community.</p>
        </div>

        <div class="feature-card fade-up fade-up-delay-1">
          <div class="feature-icon">
            <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg>
          </div>
          <h3>Innovation & Entrepreneurship Hub</h3>
          <p>Bridging science and business, this hub helps students transform research ideas into real-world solutions through mentorship, pitch competitions, and startup support.</p>
        </div>

        <div class="feature-card fade-up fade-up-delay-2">
          <div class="feature-icon">
            <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
          </div>
          <h3>Cultural & Events Committee</h3>
          <p>Celebrating diversity and talent through cultural festivals, talent shows, and social gatherings that bring the TIBST community together throughout the year.</p>
        </div>
      </div>
    </div>
  </section>

  <!-- PHOTO GALLERY -->
  <section class="section" style="background: var(--off-white);">
    <div class="container">
      <div class="section-header fade-up">
        <div class="section-label">Gallery</div>
        <h2 class="section-title">Campus Moments</h2>
        <p class="section-subtitle">A glimpse into the vibrant everyday life at TIBST -- from the lab bench to the lecture hall.</p>
      </div>

      <div class="gallery-grid fade-up">
        <div class="gallery-item" style="background-image: url('https://images.unsplash.com/photo-1532094349884-543bc11b234d?w=800&q=80');">
          <div class="gallery-item-overlay">
            <span>Research Laboratory</span>
          </div>
        </div>
        <div class="gallery-item" style="background-image: url('https://images.unsplash.com/photo-1541339907198-e08756dedf3f?w=800&q=80');">
          <div class="gallery-item-overlay">
            <span>Graduation Day</span>
          </div>
        </div>
        <div class="gallery-item" style="background-image: url('https://images.unsplash.com/photo-1562774053-701939374585?w=800&q=80');">
          <div class="gallery-item-overlay">
            <span>Campus Grounds</span>
          </div>
        </div>
        <div class="gallery-item" style="background-image: url('https://images.unsplash.com/photo-1579154204601-01588f351e67?w=800&q=80');">
          <div class="gallery-item-overlay">
            <span>Lab Sessions</span>
          </div>
        </div>
        <div class="gallery-item" style="background-image: url('https://images.unsplash.com/photo-1497633762265-9d179a990aa6?w=800&q=80');">
          <div class="gallery-item-overlay">
            <span>Library Resources</span>
          </div>
        </div>
        <div class="gallery-item" style="background-image: url('https://images.unsplash.com/photo-1524178232363-1fb2b075b655?w=800&q=80');">
          <div class="gallery-item-overlay">
            <span>Lecture Hall</span>
          </div>
        </div>
        <div class="gallery-item" style="background-image: url('https://images.unsplash.com/photo-1581093458791-9f3c3900df4b?w=800&q=80');">
          <div class="gallery-item-overlay">
            <span>Biomedical Equipment</span>
          </div>
        </div>
        <div class="gallery-item" style="background-image: url('https://images.unsplash.com/photo-1523240795612-9a054b0db644?w=800&q=80');">
          <div class="gallery-item-overlay">
            <span>Student Collaboration</span>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- STUDENT TESTIMONIALS -->
  <section class="testimonials-section section">
    <div class="hero-pattern"></div>
    <div class="container" style="position:relative; z-index:1;">
      <div class="section-header fade-up">
        <div class="section-label" style="color: var(--accent);">Testimonials</div>
        <h2 class="section-title" style="color: var(--white);">What Our Students Say</h2>
      </div>

      <div class="testimonial-grid">
        <div class="testimonial-card fade-up">
          <div class="testimonial-quote">"Life at TIBST goes far beyond the classroom. The sense of community here is incredible -- from study groups in the library to weekend outings with coursemates. I've made lifelong friends."</div>
          <div class="testimonial-author">
            <div class="testimonial-avatar">NO</div>
            <div>
              <div class="testimonial-name">Nana Osei</div>
              <div class="testimonial-role">MPhil Gene Therapy, Current Student</div>
            </div>
          </div>
        </div>

        <div class="testimonial-card fade-up fade-up-delay-1">
          <div class="testimonial-quote">"The modern laboratory facilities at TIBST gave me hands-on experience that truly set me apart. The campus environment is designed to help you focus and succeed in your research."</div>
          <div class="testimonial-author">
            <div class="testimonial-avatar">FA</div>
            <div>
              <div class="testimonial-name">Fatima Alhassan</div>
              <div class="testimonial-role">PhD Gene Therapy, Class of 2025</div>
            </div>
          </div>
        </div>

        <div class="testimonial-card fade-up fade-up-delay-2">
          <div class="testimonial-quote">"Joining the Biomedical Research Society was a turning point for me. The clubs and organizations at TIBST provide amazing opportunities for personal and professional growth outside the lab."</div>
          <div class="testimonial-author">
            <div class="testimonial-avatar">SB</div>
            <div>
              <div class="testimonial-name">Samuel Boateng</div>
              <div class="testimonial-role">MPhil Human Embryology, Current Student</div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- CTA -->
  <section class="cta-section section-sm">
    <div class="container">
      <div class="cta-content fade-up">
        <h2>Ready to Experience Life at TIBST?</h2>
        <p>Join a vibrant community of scholars and researchers dedicated to advancing biomedical science. Your journey starts here.</p>
        <div style="display:flex; gap:16px; justify-content:center; flex-wrap:wrap;">
          <a href="admissions.php" class="btn btn-white">Apply Now</a>
          <a href="contact.php" class="btn btn-outline">Contact Us</a>
        </div>
      </div>
    </div>
  </section>

<?php require_once 'includes/footer.php'; ?>
