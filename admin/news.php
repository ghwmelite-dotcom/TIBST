<?php
/**
 * Admin — News & Events list.
 */

$adminPageTitle  = 'News & Events';
$adminActivePage = 'news';

require_once __DIR__ . '/includes/admin-header.php';

$pdo     = getDB();
$articles = $pdo->query('SELECT * FROM news ORDER BY publish_date DESC')->fetchAll();
?>

<div class="content-header">
    <h2>News &amp; Events</h2>
    <a href="/admin/news-form.php" class="btn-admin btn-admin-primary">+ Write Article</a>
</div>

<?php if (empty($articles)): ?>
    <div class="admin-card">
        <div class="empty-state">
            <div class="empty-state-icon">&#9998;</div>
            <div class="empty-state-text">No news articles yet. Write your first article to get started.</div>
            <a href="/admin/news-form.php" class="btn-admin btn-admin-primary">+ Write Article</a>
        </div>
    </div>
<?php else: ?>
    <div class="admin-card">
        <div class="table-wrapper">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Image</th>
                        <th>Title</th>
                        <th>Date</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($articles as $article): ?>
                    <tr>
                        <td>
                            <?php if ($article['image']): ?>
                                <img src="<?= escape($article['image']) ?>" alt="" class="table-img">
                            <?php else: ?>
                                <span style="color:var(--admin-text-light)">—</span>
                            <?php endif; ?>
                        </td>
                        <td><strong><?= escape($article['title']) ?></strong></td>
                        <td><?= escape($article['publish_date']) ?></td>
                        <td>
                            <?php if ($article['is_published']): ?>
                                <span class="badge badge-success">Published</span>
                            <?php else: ?>
                                <span class="badge badge-neutral">Draft</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <div class="actions">
                                <a href="/admin/news-form.php?id=<?= (int) $article['id'] ?>" class="btn-admin btn-admin-secondary btn-admin-xs">Edit</a>
                                <form method="POST" action="/admin/news-delete.php" style="display:inline">
                                    <input type="hidden" name="id" value="<?= (int) $article['id'] ?>">
                                    <?= csrfField() ?>
                                    <button type="submit" class="btn-admin btn-admin-danger btn-admin-xs" data-confirm="Delete this article?">Delete</button>
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
