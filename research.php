<?php
$pageTitle = 'Research & Innovation - TIBST';
$activePage = 'research';
require_once 'includes/header.php';

// ── Fetch dynamic content ──────────────────────────────────────────
$researchOverview = getPageBlock('research', 'overview');
$researchUnits    = getPageBlock('research', 'units');
$researchPubs     = getPageBlock('research', 'publications');
?>

  <!-- PAGE HERO -->
  <section class="page-hero">
    <div class="hero-pattern"></div>
    <div class="page-hero-content">
      <div class="breadcrumb">
        <a href="index.php">Home</a>
        <span class="separator">/</span>
        <span>Research & Innovation</span>
      </div>
      <h1>Research & <span style="color: var(--accent); font-style: italic;">Innovation</span></h1>
      <p>Driving breakthroughs in biomedical science through world-class translational research, innovative technology, and collaborative partnerships.</p>
    </div>
  </section>

  <!-- RESEARCH OVERVIEW -->
  <section class="section" style="background: var(--white);">
    <div class="container">
      <?php if (!empty($researchOverview)): ?>
      <div class="fade-up"><?= $researchOverview ?></div>
      <?php else: ?>
      <div style="display:grid; grid-template-columns: 1fr 1fr; gap:60px; align-items:center;">
        <div class="fade-up">
          <div class="section-label">Our Mission</div>
          <h2 class="section-title">Advancing Biomedical Knowledge</h2>
          <p style="color: var(--gray-500); font-size: 0.95rem; line-height: 1.8; margin-bottom: 20px;">At TIBST, research is at the heart of everything we do. Our institute is dedicated to advancing the frontiers of biomedical science through rigorous inquiry, innovative methodologies, and translational approaches that bridge the gap between laboratory discoveries and real-world clinical applications.</p>
          <p style="color: var(--gray-500); font-size: 0.95rem; line-height: 1.8; margin-bottom: 28px;">Our research programmes span gene therapy, human embryology, molecular biology, and biomedical engineering -- areas with the potential to transform healthcare outcomes across Africa and beyond.</p>
          <div style="display:flex; gap:32px; flex-wrap:wrap;">
            <div>
              <div style="font-family: var(--font-display); font-size: 2.5rem; font-weight: 700; color: var(--primary); line-height:1;">50+</div>
              <div style="font-size: 0.85rem; color: var(--gray-500); margin-top:4px;">Active Researchers</div>
            </div>
            <div>
              <div style="font-family: var(--font-display); font-size: 2.5rem; font-weight: 700; color: var(--primary); line-height:1;">3</div>
              <div style="font-size: 0.85rem; color: var(--gray-500); margin-top:4px;">Research Units</div>
            </div>
            <div>
              <div style="font-family: var(--font-display); font-size: 2.5rem; font-weight: 700; color: var(--primary); line-height:1;">30+</div>
              <div style="font-size: 0.85rem; color: var(--gray-500); margin-top:4px;">Publications</div>
            </div>
          </div>
        </div>
        <div class="fade-up fade-up-delay-1" style="border-radius: 16px; overflow: hidden; height: 420px;">
          <img src="https://images.unsplash.com/photo-1532094349884-543bc11b234d?w=800&q=80" alt="Research laboratory at TIBST" style="width:100%; height:100%; object-fit:cover; border-radius:16px;">
        </div>
      </div>
      <?php endif; ?>
    </div>
  </section>

  <!-- RESEARCH UNITS -->
  <section class="section" id="research-units" style="background: var(--off-white);">
    <div class="container">
      <div class="section-header fade-up">
        <div class="section-label">Research Units</div>
        <h2 class="section-title">Centres of Excellence</h2>
        <p class="section-subtitle">Our dedicated research units drive innovation and discovery across key areas of biomedical science and technology.</p>
      </div>

      <div class="features-grid">
        <!-- Translational Research Unit -->
        <div class="feature-card fade-up" style="padding:0; overflow:hidden;">
          <div style="height:200px; background: url('https://images.unsplash.com/photo-1579154204601-01588f351e67?w=800&q=80') center/cover;"></div>
          <div style="padding:32px;">
            <div class="feature-icon" style="margin-top:-52px; position:relative; border: 4px solid var(--off-white);">
              <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 3H5a2 2 0 0 0-2 2v4m6-6h10a2 2 0 0 1 2 2v4M9 3v18m0 0h10a2 2 0 0 0 2-2V9M9 21H5a2 2 0 0 1-2-2V9m0 0h18"></path></svg>
            </div>
            <h3 style="font-size:1.2rem; margin-bottom:12px; color: var(--secondary);">Translational Research Unit</h3>
            <p style="font-size:0.9rem; color: var(--gray-500); line-height:1.7;">Bridging the gap between bench science and bedside applications. Our translational research unit focuses on converting laboratory findings into therapeutic solutions for genetic disorders and inherited diseases prevalent in Sub-Saharan Africa.</p>
          </div>
        </div>

        <!-- Research Support Units -->
        <div class="feature-card fade-up fade-up-delay-1" style="padding:0; overflow:hidden;">
          <div style="height:200px; background: url('https://images.unsplash.com/photo-1582719471384-894fbb16e074?w=800&q=80') center/cover;"></div>
          <div style="padding:32px;">
            <div class="feature-icon" style="margin-top:-52px; position:relative; border: 4px solid var(--off-white);">
              <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
            </div>
            <h3 style="font-size:1.2rem; margin-bottom:12px; color: var(--secondary);">Research Support Units</h3>
            <p style="font-size:0.9rem; color: var(--gray-500); line-height:1.7;">Providing essential infrastructure, training, and administrative support for all research activities at TIBST. Our support units include biostatistics, ethics review, grant writing assistance, and research methodology training.</p>
          </div>
        </div>

        <!-- Biomedical Innovation Lab -->
        <div class="feature-card fade-up fade-up-delay-2" style="padding:0; overflow:hidden;">
          <div style="height:200px; background: url('https://images.unsplash.com/photo-1530026405186-ed1f139313f8?w=800&q=80') center/cover;"></div>
          <div style="padding:32px;">
            <div class="feature-icon" style="margin-top:-52px; position:relative; border: 4px solid var(--off-white);">
              <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94l-3.76 3.76z"></path></svg>
            </div>
            <h3 style="font-size:1.2rem; margin-bottom:12px; color: var(--secondary);">Biomedical Innovation Lab</h3>
            <p style="font-size:0.9rem; color: var(--gray-500); line-height:1.7;">A state-of-the-art facility dedicated to developing novel biomedical technologies and diagnostic tools. The Innovation Lab fosters interdisciplinary collaboration between molecular biologists, engineers, and clinicians to accelerate healthcare innovation.</p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- RESEARCH RESOURCES -->
  <section class="section" style="background: var(--white);">
    <div class="container">
      <div class="section-header fade-up">
        <div class="section-label">Facilities & Tools</div>
        <h2 class="section-title">Research Resources</h2>
        <p class="section-subtitle">TIBST provides researchers with access to cutting-edge facilities and comprehensive support services.</p>
      </div>

      <div class="features-grid">
        <div class="feature-card fade-up">
          <div class="feature-icon">
            <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2L2 7l10 5 10-5-10-5z"></path><path d="M2 17l10 5 10-5"></path><path d="M2 12l10 5 10-5"></path></svg>
          </div>
          <h3>Advanced Molecular Biology Lab</h3>
          <p>Equipped with PCR machines, gel electrophoresis systems, spectrophotometers, and gene sequencing technology for cutting-edge genetic research.</p>
        </div>

        <div class="feature-card fade-up fade-up-delay-1">
          <div class="feature-icon">
            <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="3" width="20" height="14" rx="2" ry="2"></rect><line x1="8" y1="21" x2="16" y2="21"></line><line x1="12" y1="17" x2="12" y2="21"></line></svg>
          </div>
          <h3>Bioinformatics Suite</h3>
          <p>High-performance computing resources and specialised software for genomic data analysis, protein modelling, and computational biology research.</p>
        </div>

        <div class="feature-card fade-up fade-up-delay-2">
          <div class="feature-icon">
            <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"></path><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"></path></svg>
          </div>
          <h3>Digital Library Access</h3>
          <p>Comprehensive access to biomedical journals, research databases including PubMed, Scopus, and Web of Science, plus an extensive physical collection.</p>
        </div>

        <div class="feature-card fade-up">
          <div class="feature-icon">
            <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><path d="M8 14s1.5 2 4 2 4-2 4-2"></path><line x1="9" y1="9" x2="9.01" y2="9"></line><line x1="15" y1="9" x2="15.01" y2="9"></line></svg>
          </div>
          <h3>Cell Culture & Tissue Engineering</h3>
          <p>Sterile cell culture facilities with laminar flow hoods, CO2 incubators, and cryopreservation systems for in vitro experimentation.</p>
        </div>

        <div class="feature-card fade-up fade-up-delay-1">
          <div class="feature-icon">
            <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path></svg>
          </div>
          <h3>Ethics & Compliance Office</h3>
          <p>Dedicated institutional review board and ethics committee ensuring all research meets the highest standards of ethical conduct and regulatory compliance.</p>
        </div>

        <div class="feature-card fade-up fade-up-delay-2">
          <div class="feature-icon">
            <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><line x1="2" y1="12" x2="22" y2="12"></line><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"></path></svg>
          </div>
          <h3>Grant & Funding Support</h3>
          <p>Dedicated team to assist researchers with identifying funding opportunities, preparing grant proposals, and managing research budgets.</p>
        </div>
      </div>
    </div>
  </section>

  <!-- PUBLICATIONS -->
  <section class="section" id="publications" style="background: var(--gray-50);">
    <div class="container">
      <div class="section-header fade-up">
        <div class="section-label">Scholarly Output</div>
        <h2 class="section-title">Recent Publications</h2>
        <p class="section-subtitle">Our researchers contribute to the global body of biomedical knowledge through peer-reviewed publications in leading journals.</p>
      </div>

      <div style="display:flex; flex-direction:column; gap:16px;">
        <!-- Publication 1 -->
        <div class="fade-up" style="background: var(--white); border:1px solid var(--gray-100); border-radius:16px; padding:28px 32px; transition: all 0.3s ease;">
          <div style="display:flex; justify-content:space-between; align-items:flex-start; gap:20px; flex-wrap:wrap;">
            <div style="flex:1; min-width:280px;">
              <div style="display:flex; gap:8px; align-items:center; margin-bottom:8px;">
                <span style="background: var(--primary-light); color: var(--primary-dark); padding:3px 12px; border-radius:100px; font-size:0.75rem; font-weight:600;">Gene Therapy</span>
                <span style="font-size:0.8rem; color: var(--gray-400);">2026</span>
              </div>
              <h3 style="font-size:1.1rem; color: var(--secondary); margin-bottom:6px; font-family: var(--font-display);">Novel CRISPR-Cas9 Approaches for Sickle Cell Disease Gene Correction in West African Populations</h3>
              <p style="font-size:0.85rem; color: var(--gray-500);">Mensah, K.A., Aidoo, E.F., & Osei-Bonsu, R.T.</p>
              <p style="font-size:0.82rem; color: var(--gray-400); font-style:italic; margin-top:4px;">Journal of Gene Medicine, Vol. 28(3), pp. 142-158</p>
            </div>
            <a href="#" style="display:inline-flex; align-items:center; gap:6px; color: var(--primary); font-size:0.85rem; font-weight:600; white-space:nowrap;">Read Paper <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="7" y1="17" x2="17" y2="7"></line><polyline points="7 7 17 7 17 17"></polyline></svg></a>
          </div>
        </div>

        <!-- Publication 2 -->
        <div class="fade-up fade-up-delay-1" style="background: var(--white); border:1px solid var(--gray-100); border-radius:16px; padding:28px 32px; transition: all 0.3s ease;">
          <div style="display:flex; justify-content:space-between; align-items:flex-start; gap:20px; flex-wrap:wrap;">
            <div style="flex:1; min-width:280px;">
              <div style="display:flex; gap:8px; align-items:center; margin-bottom:8px;">
                <span style="background: var(--primary-light); color: var(--primary-dark); padding:3px 12px; border-radius:100px; font-size:0.75rem; font-weight:600;">Embryology</span>
                <span style="font-size:0.8rem; color: var(--gray-400);">2025</span>
              </div>
              <h3 style="font-size:1.1rem; color: var(--secondary); margin-bottom:6px; font-family: var(--font-display);">Epigenetic Markers in Early Human Embryonic Development: A Systematic Review</h3>
              <p style="font-size:0.85rem; color: var(--gray-500);">Kusi, A.B., Danso, P.K., & Asante, M.L.</p>
              <p style="font-size:0.82rem; color: var(--gray-400); font-style:italic; margin-top:4px;">Human Reproduction Update, Vol. 31(1), pp. 45-72</p>
            </div>
            <a href="#" style="display:inline-flex; align-items:center; gap:6px; color: var(--primary); font-size:0.85rem; font-weight:600; white-space:nowrap;">Read Paper <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="7" y1="17" x2="17" y2="7"></line><polyline points="7 7 17 7 17 17"></polyline></svg></a>
          </div>
        </div>

        <!-- Publication 3 -->
        <div class="fade-up fade-up-delay-2" style="background: var(--white); border:1px solid var(--gray-100); border-radius:16px; padding:28px 32px; transition: all 0.3s ease;">
          <div style="display:flex; justify-content:space-between; align-items:flex-start; gap:20px; flex-wrap:wrap;">
            <div style="flex:1; min-width:280px;">
              <div style="display:flex; gap:8px; align-items:center; margin-bottom:8px;">
                <span style="background: var(--primary-light); color: var(--primary-dark); padding:3px 12px; border-radius:100px; font-size:0.75rem; font-weight:600;">Molecular Biology</span>
                <span style="font-size:0.8rem; color: var(--gray-400);">2025</span>
              </div>
              <h3 style="font-size:1.1rem; color: var(--secondary); margin-bottom:6px; font-family: var(--font-display);">Adeno-Associated Viral Vectors for Targeted Gene Delivery: Optimisation Strategies and Clinical Implications</h3>
              <p style="font-size:0.85rem; color: var(--gray-500);">Osei-Bonsu, R.T., Boateng, S.N., & Mensah, K.A.</p>
              <p style="font-size:0.82rem; color: var(--gray-400); font-style:italic; margin-top:4px;">Molecular Therapy Methods & Clinical Development, Vol. 19(2), pp. 210-229</p>
            </div>
            <a href="#" style="display:inline-flex; align-items:center; gap:6px; color: var(--primary); font-size:0.85rem; font-weight:600; white-space:nowrap;">Read Paper <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="7" y1="17" x2="17" y2="7"></line><polyline points="7 7 17 7 17 17"></polyline></svg></a>
          </div>
        </div>

        <!-- Publication 4 -->
        <div class="fade-up" style="background: var(--white); border:1px solid var(--gray-100); border-radius:16px; padding:28px 32px; transition: all 0.3s ease;">
          <div style="display:flex; justify-content:space-between; align-items:flex-start; gap:20px; flex-wrap:wrap;">
            <div style="flex:1; min-width:280px;">
              <div style="display:flex; gap:8px; align-items:center; margin-bottom:8px;">
                <span style="background: var(--primary-light); color: var(--primary-dark); padding:3px 12px; border-radius:100px; font-size:0.75rem; font-weight:600;">Biomedical Innovation</span>
                <span style="font-size:0.8rem; color: var(--gray-400);">2025</span>
              </div>
              <h3 style="font-size:1.1rem; color: var(--secondary); margin-bottom:6px; font-family: var(--font-display);">Point-of-Care Diagnostic Tools for Hereditary Blood Disorders in Resource-Limited Settings</h3>
              <p style="font-size:0.85rem; color: var(--gray-500);">Asante, M.L., Aidoo, E.F., & Appiah, J.K.</p>
              <p style="font-size:0.82rem; color: var(--gray-400); font-style:italic; margin-top:4px;">BMC Biomedical Engineering, Vol. 7(4), pp. 88-103</p>
            </div>
            <a href="#" style="display:inline-flex; align-items:center; gap:6px; color: var(--primary); font-size:0.85rem; font-weight:600; white-space:nowrap;">Read Paper <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="7" y1="17" x2="17" y2="7"></line><polyline points="7 7 17 7 17 17"></polyline></svg></a>
          </div>
        </div>

        <!-- Publication 5 -->
        <div class="fade-up fade-up-delay-1" style="background: var(--white); border:1px solid var(--gray-100); border-radius:16px; padding:28px 32px; transition: all 0.3s ease;">
          <div style="display:flex; justify-content:space-between; align-items:flex-start; gap:20px; flex-wrap:wrap;">
            <div style="flex:1; min-width:280px;">
              <div style="display:flex; gap:8px; align-items:center; margin-bottom:8px;">
                <span style="background: var(--primary-light); color: var(--primary-dark); padding:3px 12px; border-radius:100px; font-size:0.75rem; font-weight:600;">Gene Therapy</span>
                <span style="font-size:0.8rem; color: var(--gray-400);">2024</span>
              </div>
              <h3 style="font-size:1.1rem; color: var(--secondary); margin-bottom:6px; font-family: var(--font-display);">Lentiviral Vector Safety Profiles in Pre-Clinical Gene Therapy Trials: A Multi-Centre African Study</h3>
              <p style="font-size:0.85rem; color: var(--gray-500);">Danso, P.K., Mensah, K.A., & Owusu, B.A.</p>
              <p style="font-size:0.82rem; color: var(--gray-400); font-style:italic; margin-top:4px;">Gene Therapy, Vol. 31(6), pp. 401-418</p>
            </div>
            <a href="#" style="display:inline-flex; align-items:center; gap:6px; color: var(--primary); font-size:0.85rem; font-weight:600; white-space:nowrap;">Read Paper <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="7" y1="17" x2="17" y2="7"></line><polyline points="7 7 17 7 17 17"></polyline></svg></a>
          </div>
        </div>
      </div>

      <div style="text-align:center; margin-top:48px;" class="fade-up">
        <a href="library.php" class="btn btn-outline-dark">Browse All Publications <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg></a>
      </div>
    </div>
  </section>

  <!-- PARTNERSHIPS & COLLABORATIONS -->
  <section class="section" id="partnerships" style="background: var(--white);">
    <div class="container">
      <div class="section-header fade-up">
        <div class="section-label">Global Network</div>
        <h2 class="section-title">Partnerships & Collaborations</h2>
        <p class="section-subtitle">We collaborate with leading institutions, hospitals, and organisations worldwide to amplify the impact of our research.</p>
      </div>

      <div style="display:grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap:24px;">
        <!-- Partner 1 -->
        <div class="feature-card fade-up" style="text-align:center;">
          <div style="width:80px; height:80px; border-radius:50%; background: var(--primary-light); display:flex; align-items:center; justify-content:center; margin:0 auto 20px;">
            <svg width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="var(--primary)" stroke-width="1.5"><path d="M12 2L2 7l10 5 10-5-10-5z"></path><path d="M2 17l10 5 10-5"></path><path d="M2 12l10 5 10-5"></path></svg>
          </div>
          <h3>University of Ghana Medical School</h3>
          <p>Joint research programmes in gene therapy and clinical trials, with shared faculty exchanges and collaborative postgraduate supervision.</p>
        </div>

        <!-- Partner 2 -->
        <div class="feature-card fade-up fade-up-delay-1" style="text-align:center;">
          <div style="width:80px; height:80px; border-radius:50%; background: var(--primary-light); display:flex; align-items:center; justify-content:center; margin:0 auto 20px;">
            <svg width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="var(--primary)" stroke-width="1.5"><circle cx="12" cy="12" r="10"></circle><line x1="2" y1="12" x2="22" y2="12"></line><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"></path></svg>
          </div>
          <h3>World Health Organization (WHO)</h3>
          <p>Collaboration on public health research initiatives, disease surveillance programmes, and capacity-building for biomedical research in Africa.</p>
        </div>

        <!-- Partner 3 -->
        <div class="feature-card fade-up fade-up-delay-2" style="text-align:center;">
          <div style="width:80px; height:80px; border-radius:50%; background: var(--primary-light); display:flex; align-items:center; justify-content:center; margin:0 auto 20px;">
            <svg width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="var(--primary)" stroke-width="1.5"><path d="M22 10v6M2 10l10-5 10 5-10 5z"></path><path d="M6 12v5c3 3 6 3 6 3s3 0 6-3v-5"></path></svg>
          </div>
          <h3>Karolinska Institute, Sweden</h3>
          <p>Partnership in embryology research, student exchange programmes, and joint workshops on reproductive medicine and developmental biology.</p>
        </div>

        <!-- Partner 4 -->
        <div class="feature-card fade-up" style="text-align:center;">
          <div style="width:80px; height:80px; border-radius:50%; background: var(--primary-light); display:flex; align-items:center; justify-content:center; margin:0 auto 20px;">
            <svg width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="var(--primary)" stroke-width="1.5"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>
          </div>
          <h3>Korle Bu Teaching Hospital</h3>
          <p>Clinical research partnerships providing TIBST researchers with access to patient populations, clinical data, and translational research opportunities.</p>
        </div>

        <!-- Partner 5 -->
        <div class="feature-card fade-up fade-up-delay-1" style="text-align:center;">
          <div style="width:80px; height:80px; border-radius:50%; background: var(--primary-light); display:flex; align-items:center; justify-content:center; margin:0 auto 20px;">
            <svg width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="var(--primary)" stroke-width="1.5"><rect x="2" y="7" width="20" height="14" rx="2" ry="2"></rect><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"></path></svg>
          </div>
          <h3>National Institutes of Health (NIH)</h3>
          <p>Funded collaborative research projects in gene therapy and genomics, with access to NIH databases and shared research infrastructure.</p>
        </div>

        <!-- Partner 6 -->
        <div class="feature-card fade-up fade-up-delay-2" style="text-align:center;">
          <div style="width:80px; height:80px; border-radius:50%; background: var(--primary-light); display:flex; align-items:center; justify-content:center; margin:0 auto 20px;">
            <svg width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="var(--primary)" stroke-width="1.5"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
          </div>
          <h3>African Academy of Sciences</h3>
          <p>Strategic partnership for promoting scientific excellence in Africa, including joint conferences, mentorship programmes, and research fellowships.</p>
        </div>
      </div>
    </div>
  </section>

  <!-- CTA -->
  <section class="cta-section section-sm">
    <div class="container">
      <div class="cta-content fade-up">
        <h2>Join Our Research Community</h2>
        <p>Whether you are a prospective student, an established researcher, or an industry partner, there is a place for you at TIBST.</p>
        <div style="display:flex; gap:16px; justify-content:center; flex-wrap:wrap;">
          <a href="admissions.php" class="btn btn-white">Apply Now</a>
          <a href="contact.php" class="btn btn-outline">Contact Us</a>
        </div>
      </div>
    </div>
  </section>

<?php require_once 'includes/footer.php'; ?>
