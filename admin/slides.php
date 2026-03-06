<?php
/**
 * Admin — Hero Slides list with sortable drag-and-drop.
 */

$adminPageTitle  = 'Hero Slides';
$adminActivePage = 'slides';

require_once __DIR__ . '/includes/admin-header.php';

$pdo    = getDB();
$slides = $pdo->query('SELECT * FROM hero_slides ORDER BY sort_order ASC')->fetchAll();
?>

<div class="content-header">
    <h2>Hero Slides</h2>
    <a href="/admin/slide-form.php" class="btn-admin btn-admin-primary">+ Add New Slide</a>
</div>

<?php if (empty($slides)): ?>
    <div class="admin-card">
        <div class="empty-state">
            <div class="empty-state-icon">&#9655;</div>
            <div class="empty-state-text">No hero slides yet. Add your first slide to get started.</div>
            <a href="/admin/slide-form.php" class="btn-admin btn-admin-primary">+ Add New Slide</a>
        </div>
    </div>
<?php else: ?>
    <div class="admin-card">
        <div class="table-wrapper">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th></th>
                        <th>Image</th>
                        <th>Headline</th>
                        <th>Status</th>
                        <th>Order</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody data-sortable="hero_slides">
                    <?php foreach ($slides as $slide): ?>
                    <tr data-id="<?= (int) $slide['id'] ?>">
                        <td><span class="sort-handle">&#9776;</span></td>
                        <td>
                            <?php if ($slide['image']): ?>
                                <img src="<?= escape($slide['image']) ?>" alt="" class="table-img">
                            <?php else: ?>
                                <span style="color:var(--admin-text-light)">—</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <strong><?= escape($slide['headline_1']) ?></strong>
                            <?= escape($slide['headline_2']) ?>
                            <?= escape($slide['headline_3']) ?>
                        </td>
                        <td>
                            <?php if ($slide['is_active']): ?>
                                <span class="badge badge-success">Active</span>
                            <?php else: ?>
                                <span class="badge badge-neutral">Inactive</span>
                            <?php endif; ?>
                        </td>
                        <td><?= (int) $slide['sort_order'] ?></td>
                        <td>
                            <div class="actions">
                                <a href="/admin/slide-form.php?id=<?= (int) $slide['id'] ?>" class="btn-admin btn-admin-secondary btn-admin-xs">Edit</a>
                                <form method="POST" action="/admin/slide-delete.php" style="display:inline">
                                    <input type="hidden" name="id" value="<?= (int) $slide['id'] ?>">
                                    <?= csrfField() ?>
                                    <button type="submit" class="btn-admin btn-admin-danger btn-admin-xs" data-confirm="Delete this slide?">Delete</button>
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
