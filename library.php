<?php
$pageTitle  = 'E-Library — TIBST';
$activePage = 'library';

require_once 'includes/auth.php';
require_once 'includes/functions.php';
require_once 'includes/library-auth.php';
require_once 'includes/gdrive.php';

startSession();

// Handle logout
if (isset($_GET['logout'])) {
    unset($_SESSION['library_user']);
    header('Location: library.php');
    exit;
}

// Handle login / register
$authError = '';
$authTab   = $_POST['auth_tab'] ?? ($_GET['tab'] ?? 'login');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['auth_action'] ?? '';

    if ($action === 'register') {
        $authTab  = 'register';
        $email    = trim($_POST['reg_email'] ?? '');
        $password = $_POST['reg_password'] ?? '';
        $name     = trim($_POST['reg_name'] ?? '');

        if ($email === '' || $password === '' || $name === '') {
            $authError = 'All fields are required.';
        } else {
            $result = libraryRegister($email, $password, $name);
            if ($result === true) {
                libraryLogin($email, $password);
                header('Location: library.php');
                exit;
            } else {
                $authError = $result;
            }
        }
    } elseif ($action === 'login') {
        $authTab  = 'login';
        $email    = trim($_POST['login_email'] ?? '');
        $password = $_POST['login_password'] ?? '';

        if ($email === '' || $password === '') {
            $authError = 'Please enter your email and password.';
        } elseif (!libraryLogin($email, $password)) {
            $authError = 'Invalid email or password.';
        } else {
            header('Location: library.php');
            exit;
        }
    }
}

require_once 'includes/header.php';

// Fetch documents if logged in
$files      = [];
$driveError = '';
if (isLibraryLoggedIn()) {
    $settings = getSettings();
    $apiKey   = $settings['gdrive_api_key'] ?? '';
    $folderId = $settings['gdrive_folder_id'] ?? '';

    if ($apiKey && $folderId) {
        $files = getGDriveFiles($folderId, $apiKey);
        if (empty($files)) {
            $driveError = 'No documents available at this time. Please check back later.';
        }
    } else {
        $driveError = 'The library is being configured. Please check back soon.';
    }
}
?>

<?php if (!isLibraryLoggedIn()): ?>
<!-- ===== AUTH GATE ===== -->
<section class="lib-gate">
  <div class="lib-gate-bg">
    <div class="lib-gate-shape-1"></div>
    <div class="lib-gate-shape-2"></div>
  </div>
  <div class="container">
    <div class="lib-gate-grid">

      <!-- Info Side -->
      <div class="lib-gate-info fade-up">
        <span class="section-label">TIBST E-Library</span>
        <h1 class="lib-gate-title">Access Our Digital<br><em>Collection</em></h1>
        <p class="lib-gate-desc">Browse research papers, textbooks, journals, and academic resources from the Thrivus Institute. Sign in with your institutional email to get started.</p>
        <div class="lib-gate-features">
          <div class="lib-gate-feat">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/></svg>
            <span>Research Papers & Journals</span>
          </div>
          <div class="lib-gate-feat">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
            <span>Textbooks & Course Materials</span>
          </div>
          <div class="lib-gate-feat">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
            <span>Searchable Digital Archive</span>
          </div>
          <div class="lib-gate-feat">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
            <span>Secure, View-Only Access</span>
          </div>
        </div>
        <p class="lib-gate-note">Access requires a valid <strong>.edu.gov.gh</strong> email address.</p>
      </div>

      <!-- Auth Card -->
      <div class="lib-gate-card fade-up fade-up-delay-1">
        <div class="lib-gate-tabs">
          <button class="lib-tab <?= $authTab === 'login' ? 'active' : '' ?>" data-tab="login">Sign In</button>
          <button class="lib-tab <?= $authTab === 'register' ? 'active' : '' ?>" data-tab="register">Register</button>
        </div>

        <?php if ($authError): ?>
        <div class="lib-gate-error"><?= escape($authError) ?></div>
        <?php endif; ?>

        <!-- Login -->
        <form method="POST" class="lib-gate-form <?= $authTab === 'login' ? 'active' : '' ?>" id="form-login">
          <input type="hidden" name="auth_action" value="login">
          <input type="hidden" name="auth_tab" value="login">
          <div class="lib-fg">
            <label for="login_email">Email Address</label>
            <input type="email" id="login_email" name="login_email" placeholder="you@university.edu.gov.gh" value="<?= escape($_POST['login_email'] ?? '') ?>" required>
          </div>
          <div class="lib-fg">
            <label for="login_password">Password</label>
            <input type="password" id="login_password" name="login_password" placeholder="Enter your password" required>
          </div>
          <button type="submit" class="btn btn-primary" style="width:100%; height:48px; border-radius:50px; font-size:15px;">Sign In</button>
        </form>

        <!-- Register -->
        <form method="POST" class="lib-gate-form <?= $authTab === 'register' ? 'active' : '' ?>" id="form-register">
          <input type="hidden" name="auth_action" value="register">
          <input type="hidden" name="auth_tab" value="register">
          <div class="lib-fg">
            <label for="reg_name">Full Name</label>
            <input type="text" id="reg_name" name="reg_name" placeholder="Your full name" value="<?= escape($_POST['reg_name'] ?? '') ?>" required>
          </div>
          <div class="lib-fg">
            <label for="reg_email">Institutional Email</label>
            <input type="email" id="reg_email" name="reg_email" placeholder="you@university.edu.gov.gh" value="<?= escape($_POST['reg_email'] ?? '') ?>" required>
            <small>Must be a .edu.gov.gh email address</small>
          </div>
          <div class="lib-fg">
            <label for="reg_password">Create Password</label>
            <input type="password" id="reg_password" name="reg_password" placeholder="Minimum 6 characters" required minlength="6">
          </div>
          <button type="submit" class="btn btn-primary" style="width:100%; height:48px; border-radius:50px; font-size:15px;">Create Account</button>
        </form>
      </div>
    </div>
  </div>
</section>

<?php else: ?>
<!-- ===== LIBRARY HEADER ===== -->
<section class="lib-header">
  <div class="container">
    <div class="lib-header-row">
      <div>
        <h1 class="lib-title">E-Library</h1>
        <p class="lib-sub">Welcome, <strong><?= escape(getLibraryUser()['name']) ?></strong> &mdash; <?= count($files) ?> document<?= count($files) !== 1 ? 's' : '' ?> available</p>
      </div>
      <a href="library.php?logout=1" class="btn btn-outline-dark btn-sm">Sign Out</a>
    </div>

    <!-- Search & Filters -->
    <div class="lib-toolbar">
      <div class="lib-search-wrap">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
        <input type="text" id="lib-search" class="lib-search" placeholder="Search documents by title...">
      </div>
      <div class="lib-filters" id="lib-filters">
        <button class="lib-filter active" data-filter="all">All</button>
        <button class="lib-filter" data-filter="pdf">PDF</button>
        <button class="lib-filter" data-filter="word">Word</button>
        <button class="lib-filter" data-filter="excel">Excel</button>
        <button class="lib-filter" data-filter="ppt">Slides</button>
        <button class="lib-filter" data-filter="other">Other</button>
      </div>
    </div>
  </div>
</section>

<!-- ===== DOCUMENT GRID ===== -->
<section class="lib-docs">
  <div class="container">
    <?php if ($driveError): ?>
    <div class="lib-empty">
      <svg width="56" height="56" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/></svg>
      <h3><?= escape($driveError) ?></h3>
    </div>

    <?php else: ?>
    <div class="lib-count" id="lib-count"><?= count($files) ?> document<?= count($files) !== 1 ? 's' : '' ?></div>
    <div class="lib-grid" id="lib-grid">
      <?php foreach ($files as $i => $file):
        $fileType   = getFileTypeLabel($file['mimeType'] ?? '');
        $badgeClass = getFileTypeBadgeClass($file['mimeType'] ?? '');
        $fileSize   = isset($file['size']) ? formatFileSize((int) $file['size']) : '';
        $modified   = isset($file['modifiedTime']) ? date('M j, Y', strtotime($file['modifiedTime'])) : '';
        $previewUrl = getGDrivePreviewUrl($file['id'], $file['mimeType'] ?? '');
        $fileName   = pathinfo($file['name'], PATHINFO_FILENAME);
      ?>
      <a href="library-viewer.php?id=<?= urlencode($file['id']) ?>&type=<?= urlencode($file['mimeType'] ?? '') ?>&name=<?= urlencode($fileName) ?>"
         class="lib-card fade-up<?= $i < 3 ? ' fade-up-delay-' . $i : '' ?>"
         data-type="<?= $badgeClass ?>"
         data-name="<?= escape(strtolower($file['name'])) ?>">
        <div class="lib-card-icon lib-icon-<?= $badgeClass ?>">
          <?php if ($badgeClass === 'pdf'): ?>
          <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>
          <?php elseif ($badgeClass === 'word'): ?>
          <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
          <?php elseif ($badgeClass === 'excel'): ?>
          <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><rect x="3" y="3" width="18" height="18" rx="2"/><line x1="3" y1="9" x2="21" y2="9"/><line x1="3" y1="15" x2="21" y2="15"/><line x1="9" y1="3" x2="9" y2="21"/><line x1="15" y1="3" x2="15" y2="21"/></svg>
          <?php elseif ($badgeClass === 'ppt'): ?>
          <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><rect x="2" y="6" width="20" height="12" rx="2"/><polyline points="8 20 16 20"/><line x1="12" y1="18" x2="12" y2="20"/></svg>
          <?php else: ?>
          <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M13 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V9z"/><polyline points="13 2 13 9 20 9"/></svg>
          <?php endif; ?>
        </div>
        <div class="lib-card-body">
          <h3 class="lib-card-title"><?= escape($fileName) ?></h3>
          <div class="lib-card-meta">
            <span class="lib-badge lib-badge-<?= $badgeClass ?>"><?= $fileType ?></span>
            <?php if ($fileSize): ?><span><?= $fileSize ?></span><?php endif; ?>
            <?php if ($modified): ?><span><?= $modified ?></span><?php endif; ?>
          </div>
        </div>
        <span class="lib-card-action">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
          Read
        </span>
      </a>
      <?php endforeach; ?>
    </div>

    <div class="lib-no-results" id="lib-no-results" style="display:none;">
      <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
      <h3>No documents match your search</h3>
      <p>Try adjusting your search terms or filters.</p>
    </div>
    <?php endif; ?>
  </div>
</section>
<?php endif; ?>

<script>
document.addEventListener('DOMContentLoaded', () => {
  // Auth tab switching
  document.querySelectorAll('.lib-tab').forEach(tab => {
    tab.addEventListener('click', () => {
      document.querySelectorAll('.lib-tab').forEach(t => t.classList.remove('active'));
      document.querySelectorAll('.lib-gate-form').forEach(f => f.classList.remove('active'));
      tab.classList.add('active');
      document.getElementById('form-' + tab.dataset.tab)?.classList.add('active');
    });
  });

  // Search & filter
  const search    = document.getElementById('lib-search');
  const grid      = document.getElementById('lib-grid');
  const countEl   = document.getElementById('lib-count');
  const noResults = document.getElementById('lib-no-results');
  if (!search || !grid) return;

  let activeFilter = 'all';

  function filterDocs() {
    const q     = search.value.toLowerCase().trim();
    const cards = grid.querySelectorAll('.lib-card');
    let vis     = 0;

    cards.forEach(card => {
      const name = card.dataset.name || '';
      const type = card.dataset.type || '';
      const ok   = (!q || name.includes(q)) && (activeFilter === 'all' || type === activeFilter);
      card.style.display = ok ? '' : 'none';
      if (ok) vis++;
    });

    if (countEl) countEl.textContent = vis + ' document' + (vis !== 1 ? 's' : '') + (q ? ' found' : '');
    if (noResults) noResults.style.display = vis === 0 ? '' : 'none';
  }

  search.addEventListener('input', filterDocs);

  document.querySelectorAll('.lib-filter').forEach(btn => {
    btn.addEventListener('click', () => {
      document.querySelectorAll('.lib-filter').forEach(b => b.classList.remove('active'));
      btn.classList.add('active');
      activeFilter = btn.dataset.filter;
      filterDocs();
    });
  });
});
</script>

<?php require_once 'includes/footer.php'; ?>
