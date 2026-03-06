<?php $pageTitle = 'Portal - TIBST'; $activePage = 'portal'; require_once 'includes/header.php'; ?>

  <!-- PAGE HERO -->
  <section class="page-hero" style="background-image: url('https://images.unsplash.com/photo-1516321318423-f06f85e504b3?w=1920&q=80');">
    <div class="hero-overlay"></div>
    <div class="container" style="position:relative; z-index:1;">
      <div class="breadcrumb fade-up">
        <a href="index.php">Home</a>
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9 18 15 12 9 6"></polyline></svg>
        <span>Portal</span>
      </div>
      <h1 class="fade-up">Student & Staff Portal</h1>
      <p class="fade-up">Access your academic dashboard, course materials, grades, and institutional resources securely.</p>
    </div>
  </section>

  <!-- LOGIN PORTALS -->
  <section class="section" style="background: var(--off-white);">
    <div class="container">
      <div style="display:grid; grid-template-columns: 1fr 1fr; gap:48px; max-width:900px; margin:0 auto;">

        <!-- Student Portal -->
        <div class="login-card fade-up">
          <div class="login-icon" style="width:72px; height:72px; background:#4E9B17; border-radius:50%; display:flex; align-items:center; justify-content:center; margin:0 auto 24px;">
            <svg width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2"><path d="M22 10v6M2 10l10-5 10 5-10 5z"></path><path d="M6 12v5c3 3 6 3 6 3s3 0 6-3v-5"></path></svg>
          </div>
          <h2 style="text-align:center; margin-bottom:8px;">Student Portal</h2>
          <p style="text-align:center; color:#666; margin-bottom:28px;">Access your courses, grades, timetable, and academic resources.</p>

          <form action="#" method="POST">
            <div class="form-group">
              <label class="form-label" for="student-username">Student ID / Username</label>
              <input class="form-input" type="text" id="student-username" name="username" placeholder="Enter your student ID" required>
            </div>

            <div class="form-group">
              <label class="form-label" for="student-password">Password</label>
              <input class="form-input" type="password" id="student-password" name="password" placeholder="Enter your password" required>
            </div>

            <button type="submit" class="btn btn-primary" style="width:100%; margin-bottom:16px;">Login to Student Portal</button>

            <p style="text-align:center;"><a href="#" style="color:#4E9B17; font-size:14px;">Forgot your password?</a></p>
          </form>
        </div>

        <!-- Staff Portal -->
        <div class="login-card fade-up fade-up-delay-1">
          <div class="login-icon" style="width:72px; height:72px; background:#000000; border-radius:50%; display:flex; align-items:center; justify-content:center; margin:0 auto 24px;">
            <svg width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
          </div>
          <h2 style="text-align:center; margin-bottom:8px;">Staff Portal</h2>
          <p style="text-align:center; color:#666; margin-bottom:28px;">Access administrative tools, HR resources, and teaching dashboards.</p>

          <form action="#" method="POST">
            <div class="form-group">
              <label class="form-label" for="staff-username">Staff ID / Username</label>
              <input class="form-input" type="text" id="staff-username" name="username" placeholder="Enter your staff ID" required>
            </div>

            <div class="form-group">
              <label class="form-label" for="staff-password">Password</label>
              <input class="form-input" type="password" id="staff-password" name="password" placeholder="Enter your password" required>
            </div>

            <button type="submit" class="btn btn-primary" style="width:100%; margin-bottom:16px; background:#000000; border-color:#000000;">Login to Staff Portal</button>

            <p style="text-align:center;"><a href="#" style="color:#4E9B17; font-size:14px;">Forgot your password?</a></p>
          </form>
        </div>

      </div>
    </div>
  </section>

  <!-- QUICK LINKS -->
  <section class="section" style="background: var(--white);">
    <div class="container">
      <div class="section-header fade-up">
        <div class="section-label">Resources</div>
        <h2 class="section-title">Quick Links</h2>
        <p class="section-subtitle">Access commonly used tools and resources directly.</p>
      </div>

      <div class="features-grid" style="display:grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap:24px; max-width:900px; margin:0 auto;">
        <a href="#" class="feature-card fade-up" style="text-align:center; text-decoration:none; color:inherit; transition: transform 0.3s, box-shadow 0.3s;">
          <div class="feature-icon" style="margin:0 auto 12px;">
            <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>
          </div>
          <h3 style="font-size:16px;">Email</h3>
          <p style="font-size:13px; color:#666;">Access your institutional email account</p>
        </a>

        <a href="#" class="feature-card fade-up fade-up-delay-1" style="text-align:center; text-decoration:none; color:inherit; transition: transform 0.3s, box-shadow 0.3s;">
          <div class="feature-icon" style="margin:0 auto 12px;">
            <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"></path><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"></path></svg>
          </div>
          <h3 style="font-size:16px;">LMS</h3>
          <p style="font-size:13px; color:#666;">Learning Management System</p>
        </a>

        <a href="library.php" class="feature-card fade-up fade-up-delay-2" style="text-align:center; text-decoration:none; color:inherit; transition: transform 0.3s, box-shadow 0.3s;">
          <div class="feature-icon" style="margin:0 auto 12px;">
            <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"></path><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"></path></svg>
          </div>
          <h3 style="font-size:16px;">Library</h3>
          <p style="font-size:13px; color:#666;">Digital library and catalogue</p>
        </a>

        <a href="#" class="feature-card fade-up" style="text-align:center; text-decoration:none; color:inherit; transition: transform 0.3s, box-shadow 0.3s;">
          <div class="feature-icon" style="margin:0 auto 12px;">
            <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
          </div>
          <h3 style="font-size:16px;">Timetable</h3>
          <p style="font-size:13px; color:#666;">View class and exam schedules</p>
        </a>

        <a href="#" class="feature-card fade-up fade-up-delay-1" style="text-align:center; text-decoration:none; color:inherit; transition: transform 0.3s, box-shadow 0.3s;">
          <div class="feature-icon" style="margin:0 auto 12px;">
            <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"></path><line x1="12" y1="17" x2="12.01" y2="17"></line></svg>
          </div>
          <h3 style="font-size:16px;">IT Support</h3>
          <p style="font-size:13px; color:#666;">Technical help and support tickets</p>
        </a>
      </div>
    </div>
  </section>

<?php require_once 'includes/footer.php'; ?>
