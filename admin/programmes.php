<?php
/**
 * Admin — Programmes list with sortable drag-and-drop.
 */

$adminPageTitle  = 'Programmes';
$adminActivePage = 'programmes';

require_once __DIR__ . '/includes/admin-header.php';

$pdo        = getDB();
$programmes = $pdo->query('SELECT * FROM programmes ORDER BY sort_order ASC')->fetchAll();
?>

<div class="content-header">
    <h2>Programmes</h2>
    <a href="/admin/programme-form.php" class="btn-admin btn-admin-primary">+ Add Programme</a>
</div>

<?php if (empty($programmes)): ?>
    <div class="admin-card">
        <div class="empty-state">
            <div class="empty-state-icon">&#9733;</div>
            <div class="empty-state-text">No programmes yet. Add your first programme to get started.</div>
            <a href="/admin/programme-form.php" class="btn-admin btn-admin-primary">+ Add Programme</a>
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
                        <th>Title</th>
                        <th>Degree</th>
                        <th>Duration</th>
                        <th>Featured</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody data-sortable="programmes">
                    <?php foreach ($programmes as $prog): ?>
                    <tr data-id="<?= (int) $prog['id'] ?>">
                        <td><span class="sort-handle">&#9776;</span></td>
                        <td>
                            <?php if ($prog['image']): ?>
                                <img src="<?= escape($prog['image']) ?>" alt="" class="table-img">
                            <?php else: ?>
                                <span style="color:var(--admin-text-light)">—</span>
                            <?php endif; ?>
                        </td>
                        <td><strong><?= escape($prog['title']) ?></strong></td>
                        <td><span class="badge badge-info"><?= escape($prog['degree_type']) ?></span></td>
                        <td><?= escape($prog['duration']) ?></td>
                        <td>
                            <?php if ($prog['is_featured']): ?>
                                <span class="badge badge-success">Featured</span>
                            <?php else: ?>
                                <span class="badge badge-neutral">No</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <div class="actions">
                                <a href="/admin/programme-form.php?id=<?= (int) $prog['id'] ?>" class="btn-admin btn-admin-secondary btn-admin-xs">Edit</a>
                                <form method="POST" action="/admin/programme-delete.php" style="display:inline">
                                    <input type="hidden" name="id" value="<?= (int) $prog['id'] ?>">
                                    <?= csrfField() ?>
                                    <button type="submit" class="btn-admin btn-admin-danger btn-admin-xs" data-confirm="Delete this programme?">Delete</button>
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
