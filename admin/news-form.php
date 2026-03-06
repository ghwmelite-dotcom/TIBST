<?php
/**
 * Admin — Create / Edit a News Article.
 */

$adminActivePage = 'news';

require_once __DIR__ . '/includes/admin-header.php';

$pdo     = getDB();
$editing = false;
$article = [
    'id'           => '',
    'title'        => '',
    'slug'         => '',
    'publish_date' => date('Y-m-d'),
    'excerpt'      => '',
    'body'         => '',
    'image'        => '',
    'is_published' => 0,
];

// Load existing article for editing
if (isset($_GET['id'])) {
    $stmt = $pdo->prepare('SELECT * FROM news WHERE id = ?');
    $stmt->execute([(int) $_GET['id']]);
    $row = $stmt->fetch();

    if (!$row) {
        flashMessage('Article not found.', 'error');
        header('Location: /admin/news.php');
        exit;
    }

    $article = $row;
    $editing = true;
}

$adminPageTitle = $editing ? 'Edit Article' : 'Write Article';
$errors = [];

// ─── POST Handler ────────────────────────────────────────────────────
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    validateCsrf();

    $article['title']        = trim($_POST['title'] ?? '');
    $article['slug']         = trim($_POST['slug'] ?? '');
    $article['publish_date'] = trim($_POST['publish_date'] ?? '');
    $article['excerpt']      = trim($_POST['excerpt'] ?? '');
    $article['body']         = $_POST['body'] ?? '';
    $article['is_published'] = isset($_POST['is_published']) ? 1 : 0;

    // Auto-generate slug from title if empty
    if ($article['slug'] === '' && $article['title'] !== '') {
        $article['slug'] = slugify($article['title']);
    }

    // Validation
    if ($article['title'] === '')        $errors[] = 'Title is required.';
    if ($article['slug'] === '')         $errors[] = 'Slug is required.';
    if ($article['publish_date'] === '') $errors[] = 'Publish date is required.';

    // Check slug uniqueness
    if ($article['slug'] !== '' && empty($errors)) {
        $slugCheck = $pdo->prepare('SELECT id FROM news WHERE slug = ? AND id != ?');
        $slugCheck->execute([$article['slug'], (int) ($article['id'] ?: 0)]);
        if ($slugCheck->fetch()) {
            // Append a number to make slug unique
            $base = $article['slug'];
            $counter = 2;
            do {
                $article['slug'] = $base . '-' . $counter;
                $slugCheck->execute([$article['slug'], (int) ($article['id'] ?: 0)]);
                $counter++;
            } while ($slugCheck->fetch());
        }
    }

    // Handle image upload
    $newImage = uploadImage('image');
    if ($newImage) {
        if ($editing && $article['image']) {
            deleteImage($article['image']);
        }
        $article['image'] = $newImage;
    }

    if (empty($errors)) {
        if ($editing) {
            $stmt = $pdo->prepare('UPDATE news SET title = ?, slug = ?, publish_date = ?, excerpt = ?, body = ?, image = ?, is_published = ? WHERE id = ?');
            $stmt->execute([
                $article['title'],
                $article['slug'],
                $article['publish_date'],
                $article['excerpt'],
                $article['body'],
                $article['image'],
                $article['is_published'],
                (int) $article['id'],
            ]);
        } else {
            $stmt = $pdo->prepare('INSERT INTO news (title, slug, publish_date, excerpt, body, image, is_published) VALUES (?, ?, ?, ?, ?, ?, ?)');
            $stmt->execute([
                $article['title'],
                $article['slug'],
                $article['publish_date'],
                $article['excerpt'],
                $article['body'],
                $article['image'] ?: null,
                $article['is_published'],
            ]);
        }

        flashMessage('Article saved successfully.');
        header('Location: /admin/news.php');
        exit;
    }
}
?>

<div class="content-header">
    <h2><?= escape($adminPageTitle) ?></h2>
    <a href="/admin/news.php" class="btn-admin btn-admin-secondary">Back to News</a>
</div>

<?php if (!empty($errors)): ?>
<div class="alert alert-error">
    <span><?= escape(implode(' ', $errors)) ?></span>
    <button class="alert-dismiss" type="button">&times;</button>
</div>
<?php endif; ?>

<div class="admin-card">
    <form method="POST" enctype="multipart/form-data">
        <?= csrfField() ?>

        <div class="form-group">
            <label class="form-label">Title <span class="required">*</span></label>
            <input type="text" name="title" id="title" class="form-input" value="<?= escape($article['title']) ?>" placeholder="e.g. New Research Partnership Announced" required>
        </div>

        <div class="form-group">
            <label class="form-label">Slug <span class="required">*</span></label>
            <input type="text" name="slug" id="slug" class="form-input" value="<?= escape($article['slug']) ?>" placeholder="auto-generated-from-title">
            <span class="form-hint">URL-friendly identifier. Auto-generated from the title if left empty.</span>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label class="form-label">Publish Date <span class="required">*</span></label>
                <input type="date" name="publish_date" class="form-input" value="<?= escape($article['publish_date']) ?>" required>
            </div>
            <div class="form-group">
                <div class="form-checkbox-group" style="margin-top: 2rem;">
                    <input type="checkbox" name="is_published" id="is_published" class="form-checkbox" value="1" <?= $article['is_published'] ? 'checked' : '' ?>>
                    <label for="is_published">Published (visible on site)</label>
                </div>
            </div>
        </div>

        <div class="form-group">
            <label class="form-label">Excerpt</label>
            <textarea name="excerpt" class="form-textarea" placeholder="Short preview text for listings..."><?= escape($article['excerpt']) ?></textarea>
            <span class="form-hint">Brief summary shown in news listings. If left empty, an excerpt will be auto-generated from the body.</span>
        </div>

        <div class="form-group">
            <label class="form-label">Body</label>
            <textarea name="body" class="form-textarea rich-editor"><?= escape($article['body']) ?></textarea>
        </div>

        <div class="form-group">
            <label class="form-label">Image</label>
            <?php if ($editing && $article['image']): ?>
                <div class="mb-1">
                    <img src="<?= escape($article['image']) ?>" alt="Current article image" class="image-preview" id="image-preview">
                </div>
            <?php else: ?>
                <img src="" alt="" class="image-preview" id="image-preview" style="display:none">
            <?php endif; ?>
            <input type="file" name="image" class="form-input" accept="image/*" data-preview="image-preview">
            <span class="form-hint">Recommended: 1200x630px. Max 5 MB. JPG, PNG, GIF, WEBP.</span>
        </div>

        <div class="btn-group mt-2">
            <button type="submit" class="btn-admin btn-admin-primary"><?= $editing ? 'Update Article' : 'Publish Article' ?></button>
            <a href="/admin/news.php" class="btn-admin btn-admin-secondary">Cancel</a>
        </div>
    </form>
</div>

<?php require_once __DIR__ . '/includes/admin-footer.php'; ?>
