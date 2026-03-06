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
$tables = ['hero_slides', 'programmes', 'news', 'testimonials', 'staff', 'applications'];
foreach ($tables as $t) {
    try {
        $counts[$t] = (int) $pdo->query("SELECT COUNT(*) FROM {$t}")->fetchColumn();
    } catch (PDOException $e) {
        $counts[$t] = 0;
    }
}
$pendingApps = 0;
try {
    $pendingApps = (int) $pdo->query("SELECT COUNT(*) FROM applications WHERE status = 'pending'")->fetchColumn();
} catch (PDOException $e) {}
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
    <a href="/admin/applications.php" class="stat-card" style="text-decoration:none; color:inherit;">
        <div class="stat-card-icon amber">&#9993;</div>
        <div class="stat-card-info">
            <div class="stat-card-number"><?= $counts['applications'] ?></div>
            <div class="stat-card-label">Applications<?php if ($pendingApps): ?> <span style="font-size:0.75rem; color:#f59e0b;">(<?= $pendingApps ?> pending)</span><?php endif; ?></div>
        </div>
    </a>
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
        <a href="/admin/applications.php?status=pending" class="quick-action-card">
            <div class="quick-action-icon">&#9993;</div>
            <div>
                <div class="quick-action-label">Review Apps</div>
                <div class="quick-action-sublabel"><?= $pendingApps ?> Pending</div>
            </div>
        </a>
    </div>
</div>

<?php require_once __DIR__ . '/includes/admin-footer.php'; ?>
