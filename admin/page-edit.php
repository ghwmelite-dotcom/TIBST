<?php
/**
 * Admin — Edit Page Content Blocks.
 */

$adminActivePage = 'pages';

// Load dependencies BEFORE any HTML output so redirects work
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/csrf.php';
require_once __DIR__ . '/../includes/functions.php';

startSession();
requireAuth();

$pageBlocks = [
    'about'        => ['mission' => 'Mission & Vision', 'vision' => 'Our Vision', 'history' => 'Our History'],
    'admissions'   => ['requirements' => 'Entry Requirements', 'fees' => 'Tuition & Fees', 'financial-aid' => 'Financial Aid'],
    'research'     => ['overview' => 'Research Overview', 'units' => 'Research Units'],
    'student-life' => ['overview' => 'Campus Life Overview'],
    'library'      => ['overview' => 'Library Overview', 'policies' => 'Library Policies'],
];

$page = $_GET['page'] ?? '';

if (!isset($pageBlocks[$page])) {
    flashMessage('Invalid page.', 'error');
    header('Location: /admin/pages.php');
    exit;
}

$adminPageTitle = 'Edit: ' . ucfirst(str_replace('-', ' ', $page));
$blocks         = $pageBlocks[$page];
$pdo            = getDB();

// ─── POST Handler (must run before admin-header outputs HTML) ────────
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    validateCsrf();

    $submitted = $_POST['blocks'] ?? [];

    foreach ($submitted as $blockId => $content) {
        // Only save blocks that belong to this page
        if (!isset($blocks[$blockId])) {
            continue;
        }

        $stmt = $pdo->prepare(
            'INSERT INTO page_blocks (page, block_id, content) VALUES (?, ?, ?)
             ON DUPLICATE KEY UPDATE content = VALUES(content)'
        );
        $stmt->execute([$page, $blockId, $content]);
    }

    flashMessage('Page content updated.');
    header('Location: /admin/page-edit.php?page=' . urlencode($page));
    exit;
}

require_once __DIR__ . '/includes/admin-header.php';

// Load existing content for each block
$blockContents = [];
foreach ($blocks as $blockId => $label) {
    $blockContents[$blockId] = getPageBlock($page, $blockId);
}
?>

<div class="content-header">
    <h2><?= escape($adminPageTitle) ?></h2>
    <a href="/admin/pages.php" class="btn-admin btn-admin-secondary">Back to Pages</a>
</div>

<div class="admin-card">
    <form method="POST">
        <?= csrfField() ?>

        <?php foreach ($blocks as $blockId => $label): ?>
        <div class="form-group">
            <label class="form-label"><?= escape($label) ?></label>
            <textarea name="blocks[<?= escape($blockId) ?>]" class="rich-editor"><?= escape($blockContents[$blockId]) ?></textarea>
        </div>
        <?php endforeach; ?>

        <div class="btn-group mt-2">
            <button type="submit" class="btn-admin btn-admin-primary">Save Changes</button>
            <a href="/admin/pages.php" class="btn-admin btn-admin-secondary">Cancel</a>
        </div>
    </form>
</div>

<?php require_once __DIR__ . '/includes/admin-footer.php'; ?>
