<?php
$pageTitle = 'Library - TIBST';
$activePage = 'library';
require_once 'includes/header.php';

// ── Fetch dynamic content ──────────────────────────────────────────
$libraryOverview  = getPageBlock('library', 'overview');
$libraryResources = getPageBlock('library', 'resources');
$libraryHours     = getPageBlock('library', 'hours');
?>

  <!-- PAGE HERO -->
  <section class="page-hero" style="background-image: url('https://images.unsplash.com/photo-1507842217343-583bb7270b66?w=1920&q=80');">
    <div class="hero-overlay"></div>
    <div class="container" style="position:relative; z-index:1;">
      <div class="breadcrumb fade-up">
        <a href="index.php">Home</a>
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9 18 15 12 9 6"></polyline></svg>
        <span>Library</span>
      </div>
      <h1 class="fade-up">TIBST Library</h1>
      <p class="fade-up">Your gateway to knowledge -- explore our extensive collection of biomedical resources, journals, and digital databases.</p>
    </div>
  </section>

  <!-- LIBRARY OVERVIEW -->
  <section class="section" style="background: var(--off-white);">
    <div class="container">
      <?php if (!empty($libraryOverview)): ?>
      <div class="fade-up"><?= $libraryOverview ?></div>
      <?php else: ?>
      <div style="display:grid; grid-template-columns: 1fr 1fr; gap:48px; align-items:center;">
        <div class="fade-up">
          <div class="section-label">About the Library</div>
          <h2 class="section-title" style="text-align:left;">A Hub for Biomedical Research</h2>
          <p style="margin-bottom:16px;">The TIBST Library is a modern academic resource centre dedicated to supporting the research and learning needs of our postgraduate students and faculty. Our collection spans the full spectrum of biomedical sciences, with particular strength in gene therapy, human embryology, and translational medicine.</p>
          <p style="margin-bottom:16px;">With both physical and digital collections, our library provides 24/7 access to thousands of peer-reviewed journals, electronic databases, and specialised reference materials. Our knowledgeable library staff are always available to assist with research queries and literature searches.</p>
          <p>Whether you are beginning your literature review or deep into your thesis research, the TIBST Library has the resources you need to succeed.</p>
        </div>
        <div class="fade-up fade-up-delay-1" style="border-radius:16px; overflow:hidden; box-shadow:0 4px 24px rgba(0,0,0,0.1);">
          <img src="https://images.unsplash.com/photo-1521587760476-6c12a4b040da?w=800&q=80" alt="TIBST Library interior" style="width:100%; height:400px; object-fit:cover; display:block;">
        </div>
      </div>
      <?php endif; ?>
    </div>
  </section>

  <!-- SEARCH CATALOG -->
  <section class="section" style="background: var(--white);">
    <div class="container">
      <div class="section-header fade-up">
        <div class="section-label">Find Resources</div>
        <h2 class="section-title">Search the Catalogue</h2>
        <p class="section-subtitle">Search our entire collection of books, journals, e-resources, and research papers.</p>
      </div>

      <div class="fade-up" style="max-width:700px; margin:0 auto;">
        <form action="#" method="GET" style="display:flex; gap:12px; flex-wrap:wrap;">
          <div style="flex:1; min-width:280px;">
            <input class="form-input" type="text" name="query" placeholder="Search by title, author, subject, or keyword..." style="height:52px; font-size:16px;">
          </div>
          <button type="submit" class="btn btn-primary" style="height:52px; padding:0 32px;">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="margin-right:8px;"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
            Search
          </button>
        </form>
      </div>
    </div>
  </section>

  <!-- DIGITAL RESOURCES -->
  <section class="section" style="background: var(--off-white);">
    <div class="container">
      <div class="section-header fade-up">
        <div class="section-label">Online Access</div>
        <h2 class="section-title">Digital Resources</h2>
        <p class="section-subtitle">Access a wealth of electronic resources to support your academic work and research.</p>
      </div>

      <div class="features-grid">
        <div class="feature-card fade-up">
          <div class="feature-icon">
            <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"></path><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"></path></svg>
          </div>
          <h3>E-Journals</h3>
          <p>Access thousands of peer-reviewed biomedical journals from publishers including Elsevier, Springer Nature, Wiley, and Oxford University Press.</p>
        </div>

        <div class="feature-card fade-up fade-up-delay-1">
          <div class="feature-icon">
            <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><ellipse cx="12" cy="5" rx="9" ry="3"></ellipse><path d="M21 12c0 1.66-4 3-9 3s-9-1.34-9-3"></path><path d="M3 5v14c0 1.66 4 3 9 3s9-1.34 9-3V5"></path></svg>
          </div>
          <h3>Databases</h3>
          <p>Search PubMed, Scopus, Web of Science, MEDLINE, and other specialised biomedical databases for comprehensive literature reviews.</p>
        </div>

        <div class="feature-card fade-up fade-up-delay-2">
          <div class="feature-icon">
            <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"></path><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"></path></svg>
          </div>
          <h3>E-Books</h3>
          <p>Browse our growing collection of electronic textbooks and reference books covering gene therapy, embryology, molecular biology, and more.</p>
        </div>

        <div class="feature-card fade-up">
          <div class="feature-icon">
            <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
          </div>
          <h3>Research Papers</h3>
          <p>Access published research papers from TIBST faculty and students, as well as papers from collaborating institutions worldwide.</p>
        </div>

        <div class="feature-card fade-up fade-up-delay-1">
          <div class="feature-icon">
            <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"></path></svg>
          </div>
          <h3>Thesis Repository</h3>
          <p>Browse completed MPhil and PhD theses from TIBST graduates. A valuable resource for understanding research standards and methodologies.</p>
        </div>

        <div class="feature-card fade-up fade-up-delay-2">
          <div class="feature-icon">
            <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><line x1="2" y1="12" x2="22" y2="12"></line><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"></path></svg>
          </div>
          <h3>Open Access</h3>
          <p>Discover freely available open-access journals and repositories including PubMed Central, DOAJ, and BioMed Central resources.</p>
        </div>
      </div>
    </div>
  </section>

  <!-- LIBRARY HOURS -->
  <section class="section" style="background: var(--white);">
    <div class="container">
      <div style="display:grid; grid-template-columns: 1fr 1fr; gap:48px; max-width:900px; margin:0 auto;">

        <!-- Hours -->
        <div class="fade-up">
          <div class="section-label">Plan Your Visit</div>
          <h2 style="margin-bottom:24px;">Library Hours</h2>

          <div class="feature-card">
            <div style="display:flex; flex-direction:column; gap:16px;">
              <div style="display:flex; justify-content:space-between; padding-bottom:16px; border-bottom:1px solid #eee;">
                <span style="font-weight:600;">Monday - Friday</span>
                <span style="color:#4E9B17; font-weight:600;">8:00 AM - 8:00 PM</span>
              </div>
              <div style="display:flex; justify-content:space-between; padding-bottom:16px; border-bottom:1px solid #eee;">
                <span style="font-weight:600;">Saturday</span>
                <span style="color:#4E9B17; font-weight:600;">9:00 AM - 5:00 PM</span>
              </div>
              <div style="display:flex; justify-content:space-between; padding-bottom:16px; border-bottom:1px solid #eee;">
                <span style="font-weight:600;">Sunday</span>
                <span style="color:#4E9B17; font-weight:600;">12:00 PM - 5:00 PM</span>
              </div>
              <div style="display:flex; justify-content:space-between;">
                <span style="font-weight:600;">Public Holidays</span>
                <span style="color:#666;">Closed</span>
              </div>
            </div>
            <p style="margin-top:16px; font-size:14px; color:#666;">* Extended hours during examination periods. Check announcements for updates.</p>
          </div>
        </div>

        <!-- Borrowing Policies -->
        <div class="fade-up fade-up-delay-1">
          <div class="section-label">Regulations</div>
          <h2 style="margin-bottom:24px;">Borrowing Policies</h2>

          <div class="feature-card">
            <div style="display:flex; flex-direction:column; gap:16px;">
              <div style="padding-bottom:16px; border-bottom:1px solid #eee;">
                <h4 style="margin-bottom:4px;">Students</h4>
                <p style="font-size:14px; color:#666;">Up to 5 books for 14 days. Renewable once if not reserved by another user.</p>
              </div>
              <div style="padding-bottom:16px; border-bottom:1px solid #eee;">
                <h4 style="margin-bottom:4px;">Faculty & Staff</h4>
                <p style="font-size:14px; color:#666;">Up to 10 books for 30 days. Renewable twice if not reserved by another user.</p>
              </div>
              <div style="padding-bottom:16px; border-bottom:1px solid #eee;">
                <h4 style="margin-bottom:4px;">Reference Materials</h4>
                <p style="font-size:14px; color:#666;">For in-library use only. Cannot be checked out but may be photocopied.</p>
              </div>
              <div>
                <h4 style="margin-bottom:4px;">Overdue Fines</h4>
                <p style="font-size:14px; color:#666;">GHS 2.00 per day for overdue items. Borrowing privileges suspended after 3 overdue items.</p>
              </div>
            </div>
          </div>
        </div>

      </div>
    </div>
  </section>

  <!-- CONTACT LIBRARIAN -->
  <section class="section" style="background: var(--off-white);">
    <div class="container">
      <div class="section-header fade-up">
        <div class="section-label">Need Help?</div>
        <h2 class="section-title">Contact the Librarian</h2>
        <p class="section-subtitle">Our library staff are here to help you find the resources you need for your research and studies.</p>
      </div>

      <div style="max-width:600px; margin:0 auto;">
        <div class="feature-card fade-up" style="text-align:center;">
          <div style="width:72px; height:72px; background:#4E9B17; border-radius:50%; display:flex; align-items:center; justify-content:center; margin:0 auto 20px;">
            <svg width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
          </div>
          <h3 style="margin-bottom:8px;">Library Information Desk</h3>
          <p style="color:#666; margin-bottom:20px;">For enquiries about library services, resource access, research support, or interlibrary loans.</p>
          <div style="display:flex; flex-direction:column; gap:12px; align-items:center;">
            <a href="mailto:library@thrivusinstitute.edu.gh" style="display:flex; align-items:center; gap:8px; color:#4E9B17;">
              <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>
              library@thrivusinstitute.edu.gh
            </a>
            <a href="tel:+233302957663" style="display:flex; align-items:center; gap:8px; color:#4E9B17;">
              <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z"></path></svg>
              +233 302 957 663 (ext. Library)
            </a>
          </div>
          <div style="margin-top:24px;">
            <a href="contact.php" class="btn btn-outline-dark">Visit Contact Page <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg></a>
          </div>
        </div>
      </div>
    </div>
  </section>

<?php require_once 'includes/footer.php'; ?>
