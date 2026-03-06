<?php
/**
 * Admin — Testimonials list with sortable drag-and-drop.
 */

$adminPageTitle  = 'Testimonials';
$adminActivePage = 'testimonials';

require_once __DIR__ . '/includes/admin-header.php';

$pdo          = getDB();
$testimonials = $pdo->query('SELECT * FROM testimonials ORDER BY sort_order ASC')->fetchAll();
?>

<div class="content-header">
    <h2>Testimonials</h2>
    <a href="/admin/testimonial-form.php" class="btn-admin btn-admin-primary">+ Add Testimonial</a>
</div>

<?php if (empty($testimonials)): ?>
    <div class="admin-card">
        <div class="empty-state">
            <div class="empty-state-icon">&#10077;</div>
            <div class="empty-state-text">No testimonials yet. Add your first testimonial to get started.</div>
            <a href="/admin/testimonial-form.php" class="btn-admin btn-admin-primary">+ Add Testimonial</a>
        </div>
    </div>
<?php else: ?>
    <div class="admin-card">
        <div class="table-wrapper">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th></th>
                        <th>Person</th>
                        <th>Role</th>
                        <th>Status</th>
                        <th>Order</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody data-sortable="testimonials">
                    <?php foreach ($testimonials as $testimonial): ?>
                    <tr data-id="<?= (int) $testimonial['id'] ?>">
                        <td><span class="sort-handle">&#9776;</span></td>
                        <td>
                            <div style="display:flex;align-items:center;gap:0.5rem;">
                                <span class="initials-avatar"><?= escape($testimonial['initials'] ?: mb_strtoupper(mb_substr($testimonial['name'], 0, 2))) ?></span>
                                <strong><?= escape($testimonial['name']) ?></strong>
                            </div>
                        </td>
                        <td><?= escape($testimonial['role']) ?></td>
                        <td>
                            <?php if ($testimonial['is_active']): ?>
                                <span class="badge badge-success">Active</span>
                            <?php else: ?>
                                <span class="badge badge-neutral">Inactive</span>
                            <?php endif; ?>
                        </td>
                        <td><?= (int) $testimonial['sort_order'] ?></td>
                        <td>
                            <div class="actions">
                                <a href="/admin/testimonial-form.php?id=<?= (int) $testimonial['id'] ?>" class="btn-admin btn-admin-secondary btn-admin-xs">Edit</a>
                                <form method="POST" action="/admin/testimonial-delete.php" style="display:inline">
                                    <input type="hidden" name="id" value="<?= (int) $testimonial['id'] ?>">
                                    <?= csrfField() ?>
                                    <button type="submit" class="btn-admin btn-admin-danger btn-admin-xs" data-confirm="Delete this testimonial?">Delete</button>
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
