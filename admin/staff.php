<?php
/**
 * Admin — Staff list with sortable drag-and-drop and department filter.
 */

$adminPageTitle  = 'Staff';
$adminActivePage = 'staff';

require_once __DIR__ . '/includes/admin-header.php';

$pdo = getDB();

$departments = ['Governing Council', 'Executive Team', 'Academic Staff', 'Administration'];
$filterDept  = isset($_GET['department']) && in_array($_GET['department'], $departments) ? $_GET['department'] : '';

if ($filterDept) {
    $stmt = $pdo->prepare('SELECT * FROM staff WHERE department = ? ORDER BY sort_order ASC');
    $stmt->execute([$filterDept]);
    $staffMembers = $stmt->fetchAll();
} else {
    $staffMembers = $pdo->query('SELECT * FROM staff ORDER BY sort_order ASC')->fetchAll();
}
?>

<div class="content-header">
    <h2>Staff</h2>
    <a href="/admin/staff-form.php" class="btn-admin btn-admin-primary">+ Add Staff Member</a>
</div>

<div class="admin-card" style="margin-bottom: 1rem; padding: 0.75rem 1rem;">
    <div style="display:flex;flex-wrap:wrap;gap:0.5rem;align-items:center;">
        <span style="font-weight:600;margin-right:0.5rem;">Filter:</span>
        <a href="/admin/staff.php" class="btn-admin <?= $filterDept === '' ? 'btn-admin-primary' : 'btn-admin-secondary' ?> btn-admin-xs">All</a>
        <?php foreach ($departments as $dept): ?>
            <a href="/admin/staff.php?department=<?= urlencode($dept) ?>" class="btn-admin <?= $filterDept === $dept ? 'btn-admin-primary' : 'btn-admin-secondary' ?> btn-admin-xs"><?= escape($dept) ?></a>
        <?php endforeach; ?>
    </div>
</div>

<?php if (empty($staffMembers)): ?>
    <div class="admin-card">
        <div class="empty-state">
            <div class="empty-state-icon">&#9823;</div>
            <div class="empty-state-text">No staff members found. Add your first staff member to get started.</div>
            <a href="/admin/staff-form.php" class="btn-admin btn-admin-primary">+ Add Staff Member</a>
        </div>
    </div>
<?php else: ?>
    <div class="admin-card">
        <div class="table-wrapper">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th></th>
                        <th>Photo</th>
                        <th>Name</th>
                        <th>Role</th>
                        <th>Department</th>
                        <th>Order</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody data-sortable="staff">
                    <?php foreach ($staffMembers as $member): ?>
                    <tr data-id="<?= (int) $member['id'] ?>">
                        <td><span class="sort-handle">&#9776;</span></td>
                        <td>
                            <?php if ($member['photo']): ?>
                                <img src="<?= escape($member['photo']) ?>" alt="" class="table-img">
                            <?php else: ?>
                                <?php
                                    $words = explode(' ', $member['name']);
                                    $memberInitials = implode('', array_map(fn($w) => mb_strtoupper(mb_substr($w, 0, 1)), $words));
                                ?>
                                <span class="initials-avatar"><?= escape($memberInitials) ?></span>
                            <?php endif; ?>
                        </td>
                        <td><strong><?= escape($member['name']) ?></strong></td>
                        <td><?= escape($member['role']) ?></td>
                        <td>
                            <?php if ($member['department']): ?>
                                <span class="badge badge-neutral"><?= escape($member['department']) ?></span>
                            <?php else: ?>
                                <span style="color:var(--admin-text-light)">—</span>
                            <?php endif; ?>
                        </td>
                        <td><?= (int) $member['sort_order'] ?></td>
                        <td>
                            <div class="actions">
                                <a href="/admin/staff-form.php?id=<?= (int) $member['id'] ?>" class="btn-admin btn-admin-secondary btn-admin-xs">Edit</a>
                                <form method="POST" action="/admin/staff-delete.php" style="display:inline">
                                    <input type="hidden" name="id" value="<?= (int) $member['id'] ?>">
                                    <?= csrfField() ?>
                                    <button type="submit" class="btn-admin btn-admin-danger btn-admin-xs" data-confirm="Delete this staff member?">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
<?php endif; ?>

<?php require_once __DIR__ . '/includes/admin-footer.php'; ?>
