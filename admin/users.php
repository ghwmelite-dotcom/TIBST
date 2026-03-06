<?php
/**
 * Admin — User Management list (admin only).
 */

$adminPageTitle  = 'User Management';
$adminActivePage = 'users';

require_once __DIR__ . '/includes/admin-header.php';

requireAdmin();

$pdo   = getDB();
$users = $pdo->query('SELECT id, name, email, role, created_at FROM users ORDER BY created_at ASC')->fetchAll();
$currentUserId = currentUser()['id'];
?>

<div class="content-header">
    <h2>User Management</h2>
    <a href="/admin/user-form.php" class="btn-admin btn-admin-primary">+ Add User</a>
</div>

<?php if (empty($users)): ?>
    <div class="admin-card">
        <div class="empty-state">
            <div class="empty-state-icon">&#9731;</div>
            <div class="empty-state-text">No users found.</div>
        </div>
    </div>
<?php else: ?>
    <div class="admin-card">
        <div class="table-wrapper">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Created</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $u): ?>
                    <tr>
                        <td><strong><?= escape($u['name']) ?></strong></td>
                        <td><?= escape($u['email']) ?></td>
                        <td>
                            <?php if ($u['role'] === 'admin'): ?>
                                <span class="badge badge-success">Admin</span>
                            <?php else: ?>
                                <span class="badge badge-info">Editor</span>
                            <?php endif; ?>
                        </td>
                        <td><?= date('M j, Y', strtotime($u['created_at'])) ?></td>
                        <td>
                            <div class="actions">
                                <a href="/admin/user-form.php?id=<?= (int) $u['id'] ?>" class="btn-admin btn-admin-secondary btn-admin-xs">Edit</a>
                                <?php if ((int) $u['id'] !== $currentUserId): ?>
                                <form method="POST" action="/admin/user-delete.php" style="display:inline">
                                    <input type="hidden" name="id" value="<?= (int) $u['id'] ?>">
                                    <?= csrfField() ?>
                                    <button type="submit" class="btn-admin btn-admin-danger btn-admin-xs" data-confirm="Delete this user?">Delete</button>
                                </form>
                                <?php endif; ?>
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
