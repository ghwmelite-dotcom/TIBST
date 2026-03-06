<?php
/**
 * Admin — Page Content list.
 */

$adminPageTitle  = 'Page Content';
$adminActivePage = 'pages';

require_once __DIR__ . '/includes/admin-header.php';

$pages = [
    'about'        => ['name' => 'About',        'blocks' => ['mission', 'vision', 'history']],
    'admissions'   => ['name' => 'Admissions',    'blocks' => ['requirements', 'fees', 'financial-aid']],
    'research'     => ['name' => 'Research',      'blocks' => ['overview', 'units']],
    'student-life' => ['name' => 'Student Life',  'blocks' => ['overview']],
    'library'      => ['name' => 'Library',       'blocks' => ['overview', 'policies']],
];
?>

<div class="content-header">
    <h2>Page Content</h2>
</div>

<div class="admin-card-grid">
    <?php foreach ($pages as $slug => $page): ?>
    <a href="/admin/page-edit.php?page=<?= escape($slug) ?>" class="admin-card admin-card-link">
        <h3><?= escape($page['name']) ?></h3>
        <p style="color:var(--admin-text-light)"><?= count($page['blocks']) ?> content block<?= count($page['blocks']) !== 1 ? 's' : '' ?></p>
    </a>
    <?php endforeach; ?>
</div>

<?php require_once __DIR__ . '/includes/admin-footer.php'; ?>
