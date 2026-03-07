<?php
/**
 * E-Library Document Viewer — embeds Google Drive preview (no download).
 */

require_once 'includes/auth.php';
require_once 'includes/functions.php';
require_once 'includes/library-auth.php';
require_once 'includes/gdrive.php';

startSession();

// Must be logged in
if (!isLibraryLoggedIn()) {
    header('Location: library.php');
    exit;
}

$fileId   = $_GET['id']   ?? '';
$mimeType = $_GET['type'] ?? '';
$fileName = $_GET['name'] ?? 'Document';

if (!$fileId || !preg_match('/^[a-zA-Z0-9_-]+$/', $fileId)) {
    header('Location: library.php');
    exit;
}

$previewUrl = getGDrivePreviewUrl($fileId, $mimeType);

$pageTitle  = escape($fileName) . ' — TIBST E-Library';
$activePage = 'library';

require_once 'includes/header.php';
?>

<section class="lib-viewer-bar">
  <div class="container">
    <div class="lib-viewer-nav">
      <a href="library.php" class="lib-back-btn">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>
        Back to Library
      </a>
      <h2 class="lib-viewer-title"><?= escape($fileName) ?></h2>
      <span class="lib-viewer-badge"><?= escape(getFileTypeLabel($mimeType)) ?></span>
    </div>
  </div>
</section>

<section class="lib-viewer-frame-wrap">
  <iframe
    src="<?= escape($previewUrl) ?>"
    class="lib-viewer-frame"
    allow="autoplay"
    sandbox="allow-scripts allow-same-origin allow-popups"
    loading="lazy"
    title="<?= escape($fileName) ?>"
  ></iframe>
</section>

<style>
.lib-viewer-bar {
  background: var(--white);
  border-bottom: 1px solid var(--gray-200);
  padding: 16px 0;
}

.lib-viewer-nav {
  display: flex;
  align-items: center;
  gap: 20px;
  flex-wrap: wrap;
}

.lib-back-btn {
  display: inline-flex;
  align-items: center;
  gap: 8px;
  font-size: 14px;
  font-weight: 600;
  color: var(--primary);
  transition: all 0.2s;
  flex-shrink: 0;
}

.lib-back-btn:hover {
  color: var(--primary-dark);
  gap: 10px;
}

.lib-viewer-title {
  font-family: var(--font-display);
  font-size: 18px;
  font-weight: 700;
  color: var(--dark);
  letter-spacing: -0.02em;
  flex: 1;
  min-width: 0;
  overflow: hidden;
  text-overflow: ellipsis;
  white-space: nowrap;
}

.lib-viewer-badge {
  font-family: var(--font-mono);
  font-size: 10px;
  font-weight: 600;
  text-transform: uppercase;
  letter-spacing: 0.06em;
  padding: 4px 12px;
  border-radius: 30px;
  background: var(--primary-light);
  color: var(--primary);
  flex-shrink: 0;
}

.lib-viewer-frame-wrap {
  background: var(--gray-100);
  min-height: calc(100vh - 200px);
  display: flex;
}

.lib-viewer-frame {
  flex: 1;
  width: 100%;
  min-height: calc(100vh - 200px);
  border: none;
  display: block;
}

@media (max-width: 640px) {
  .lib-viewer-title {
    font-size: 14px;
    order: 3;
    flex-basis: 100%;
  }
  .lib-viewer-frame {
    min-height: calc(100vh - 250px);
  }
}
</style>

<?php require_once 'includes/footer.php'; ?>
