<?php
/**
 * Admin Dashboard — overview stats and quick actions.
 */

$adminPageTitle  = 'Dashboard';
$adminActivePage = 'dashboard';

require_once __DIR__ . '/includes/admin-header.php';

$pdo = getDB();

// Gather counts
$counts = [];
$tables = ['hero_slides', 'programmes', 'news', 'testimonials', 'staff'];
foreach ($tables as $t) {
    $counts[$t] = (int) $pdo->query("SELECT COUNT(*) FROM {$t}")->fetchColumn();
}
if (isAdmin()) {
    $counts['users'] = (int) $pdo->query("SELECT COUNT(*) FROM users")->fetchColumn();
}
?>

<div class="stat-cards">
    <div class="stat-card">
        <div class="stat-card-icon green">&#9655;</div>
        <div class="stat-card-info">
            <div class="stat-card-number"><?= $counts['hero_slides'] ?></div>
            <div class="stat-card-label">Hero Slides</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-card-icon blue">&#9733;</div>
        <div class="stat-card-info">
            <div class="stat-card-number"><?= $counts['programmes'] ?></div>
            <div class="stat-card-label">Programmes</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-card-icon amber">&#9998;</div>
        <div class="stat-card-info">
            <div class="stat-card-number"><?= $counts['news'] ?></div>
            <div class="stat-card-label">News &amp; Events</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-card-icon purple">&#10077;</div>
        <div class="stat-card-info">
            <div class="stat-card-number"><?= $counts['testimonials'] ?></div>
            <div class="stat-card-label">Testimonials</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-card-icon teal">&#9823;</div>
        <div class="stat-card-info">
            <div class="stat-card-number"><?= $counts['staff'] ?></div>
            <div class="stat-card-label">Staff Members</div>
        </div>
    </div>
    <?php if (isAdmin()): ?>
    <div class="stat-card">
        <div class="stat-card-icon rose">&#9731;</div>
        <div class="stat-card-info">
            <div class="stat-card-number"><?= $counts['users'] ?></div>
            <div class="stat-card-label">Users</div>
        </div>
    </div>
    <?php endif; ?>
</div>

<div class="admin-card">
    <div class="admin-card-header">
        <h3>Quick Actions</h3>
    </div>
    <div class="quick-actions">
        <a href="/admin/slides.php?action=add" class="quick-action-card">
            <div class="quick-action-icon">&#9655;</div>
            <div>
                <div class="quick-action-label">Add Slide</div>
                <div class="quick-action-sublabel">Hero Carousel</div>
            </div>
        </a>
        <a href="/admin/news.php?action=add" class="quick-action-card">
            <div class="quick-action-icon">&#9998;</div>
            <div>
                <div class="quick-action-label">Write Article</div>
                <div class="quick-action-sublabel">News &amp; Events</div>
            </div>
        </a>
        <a href="/admin/programmes.php?action=add" class="quick-action-card">
            <div class="quick-action-icon">&#9733;</div>
            <div>
                <div class="quick-action-label">Add Programme</div>
                <div class="quick-action-sublabel">Academic Offerings</div>
            </div>
        </a>
    </div>
</div>

<?php require_once __DIR__ . '/includes/admin-footer.php'; ?>
