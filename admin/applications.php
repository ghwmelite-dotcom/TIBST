<?php
/**
 * Admin Applications — list all submitted applications with status filtering.
 */

$adminPageTitle  = 'Applications';
$adminActivePage = 'applications';

require_once __DIR__ . '/includes/admin-header.php';

$pdo = getDB();

// Status filter
$statusFilter = $_GET['status'] ?? '';
$validStatuses = ['pending', 'reviewed', 'accepted', 'rejected'];

$where = '';
$params = [];
if ($statusFilter && in_array($statusFilter, $validStatuses)) {
    $where = 'WHERE status = ?';
    $params[] = $statusFilter;
}

$stmt = $pdo->prepare("SELECT id, first_name, last_name, email, phone, programme_type, programme_choice, status, submitted_at FROM applications {$where} ORDER BY submitted_at DESC");
$stmt->execute($params);
$applications = $stmt->fetchAll();

// Count by status
$countStmt = $pdo->query("SELECT status, COUNT(*) as cnt FROM applications GROUP BY status");
$statusCounts = ['pending' => 0, 'reviewed' => 0, 'accepted' => 0, 'rejected' => 0, 'total' => 0];
while ($row = $countStmt->fetch()) {
    $statusCounts[$row['status']] = (int) $row['cnt'];
    $statusCounts['total'] += (int) $row['cnt'];
}
?>

<div class="stat-cards" style="margin-bottom: 1.5rem;">
    <a href="/admin/applications.php" class="stat-card" style="text-decoration:none; color:inherit; <?= $statusFilter === '' ? 'border: 2px solid var(--admin-primary);' : '' ?>">
        <div class="stat-card-info">
            <div class="stat-card-number"><?= $statusCounts['total'] ?></div>
            <div class="stat-card-label">All</div>
        </div>
    </a>
    <a href="/admin/applications.php?status=pending" class="stat-card" style="text-decoration:none; color:inherit; <?= $statusFilter === 'pending' ? 'border: 2px solid #f59e0b;' : '' ?>">
        <div class="stat-card-icon amber">&#9203;</div>
        <div class="stat-card-info">
            <div class="stat-card-number"><?= $statusCounts['pending'] ?></div>
            <div class="stat-card-label">Pending</div>
        </div>
    </a>
    <a href="/admin/applications.php?status=reviewed" class="stat-card" style="text-decoration:none; color:inherit; <?= $statusFilter === 'reviewed' ? 'border: 2px solid #3b82f6;' : '' ?>">
        <div class="stat-card-icon blue">&#9998;</div>
        <div class="stat-card-info">
            <div class="stat-card-number"><?= $statusCounts['reviewed'] ?></div>
            <div class="stat-card-label">Reviewed</div>
        </div>
    </a>
    <a href="/admin/applications.php?status=accepted" class="stat-card" style="text-decoration:none; color:inherit; <?= $statusFilter === 'accepted' ? 'border: 2px solid #22c55e;' : '' ?>">
        <div class="stat-card-icon green">&#10003;</div>
        <div class="stat-card-info">
            <div class="stat-card-number"><?= $statusCounts['accepted'] ?></div>
            <div class="stat-card-label">Accepted</div>
        </div>
    </a>
    <a href="/admin/applications.php?status=rejected" class="stat-card" style="text-decoration:none; color:inherit; <?= $statusFilter === 'rejected' ? 'border: 2px solid #ef4444;' : '' ?>">
        <div class="stat-card-icon rose">&#10007;</div>
        <div class="stat-card-info">
            <div class="stat-card-number"><?= $statusCounts['rejected'] ?></div>
            <div class="stat-card-label">Rejected</div>
        </div>
    </a>
</div>

<div class="admin-card">
    <div class="admin-card-header">
        <h3>Applications<?= $statusFilter ? ' (' . ucfirst($statusFilter) . ')' : '' ?></h3>
    </div>

    <?php if (empty($applications)): ?>
        <div style="padding: 2rem; text-align: center; color: #6b7280;">
            No applications found<?= $statusFilter ? ' with status "' . escape($statusFilter) . '"' : '' ?>.
        </div>
    <?php else: ?>
        <div class="admin-table-wrap">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Applicant</th>
                        <th>Email</th>
                        <th>Programme</th>
                        <th>Status</th>
                        <th>Submitted</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($applications as $app): ?>
                    <tr>
                        <td>#<?= $app['id'] ?></td>
                        <td><strong><?= escape($app['first_name'] . ' ' . $app['last_name']) ?></strong></td>
                        <td><?= escape($app['email']) ?></td>
                        <td><?= escape($app['programme_choice']) ?></td>
                        <td>
                            <?php
                            $badgeColors = [
                                'pending'  => 'background:#fef3c7; color:#92400e;',
                                'reviewed' => 'background:#dbeafe; color:#1e40af;',
                                'accepted' => 'background:#dcfce7; color:#166534;',
                                'rejected' => 'background:#fef2f2; color:#991b1b;',
                            ];
                            $color = $badgeColors[$app['status']] ?? '';
                            ?>
                            <span style="display:inline-block; padding:0.2rem 0.6rem; border-radius:20px; font-size:0.8rem; font-weight:600; <?= $color ?>"><?= ucfirst(escape($app['status'])) ?></span>
                        </td>
                        <td><?= date('M j, Y', strtotime($app['submitted_at'])) ?></td>
                        <td>
                            <a href="/admin/application-view.php?id=<?= $app['id'] ?>" class="btn-action" title="View">&#128065;</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>

<?php require_once __DIR__ . '/includes/admin-footer.php'; ?>
