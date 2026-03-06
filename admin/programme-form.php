<?php
/**
 * Admin — Create / Edit a Programme.
 */

$adminActivePage = 'programmes';

require_once __DIR__ . '/includes/admin-header.php';

$pdo     = getDB();
$editing = false;
$prog    = [
    'id'          => '',
    'title'       => '',
    'degree_type' => '',
    'description' => '',
    'duration'    => '',
    'image'       => '',
    'is_featured' => 0,
];

// Load existing programme for editing
if (isset($_GET['id'])) {
    $stmt = $pdo->prepare('SELECT * FROM programmes WHERE id = ?');
    $stmt->execute([(int) $_GET['id']]);
    $row = $stmt->fetch();

    if (!$row) {
        flashMessage('Programme not found.', 'error');
        header('Location: /admin/programmes.php');
        exit;
    }

    $prog    = $row;
    $editing = true;
}

$adminPageTitle = $editing ? 'Edit Programme' : 'Add Programme';
$errors = [];

// ─── POST Handler ────────────────────────────────────────────────────
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    validateCsrf();

    $prog['title']       = trim($_POST['title'] ?? '');
    $prog['degree_type'] = trim($_POST['degree_type'] ?? '');
    $prog['description'] = trim($_POST['description'] ?? '');
    $prog['duration']    = trim($_POST['duration'] ?? '');
    $prog['is_featured'] = isset($_POST['is_featured']) ? 1 : 0;

    // Validation
    if ($prog['title'] === '')       $errors[] = 'Title is required.';
    if ($prog['degree_type'] === '') $errors[] = 'Degree type is required.';

    // Handle image upload
    $newImage = uploadImage('image');
    if ($newImage) {
        if ($editing && $prog['image']) {
            deleteImage($prog['image']);
        }
        $prog['image'] = $newImage;
    }

    if (empty($errors)) {
        if ($editing) {
            $stmt = $pdo->prepare('UPDATE programmes SET title = ?, degree_type = ?, description = ?, duration = ?, image = ?, is_featured = ? WHERE id = ?');
            $stmt->execute([
                $prog['title'],
                $prog['degree_type'],
                $prog['description'],
                $prog['duration'],
                $prog['image'],
                $prog['is_featured'],
                (int) $prog['id'],
            ]);
        } else {
            $maxSort = (int) $pdo->query('SELECT COALESCE(MAX(sort_order), 0) FROM programmes')->fetchColumn();

            $stmt = $pdo->prepare('INSERT INTO programmes (title, degree_type, description, duration, image, is_featured, sort_order) VALUES (?, ?, ?, ?, ?, ?, ?)');
            $stmt->execute([
                $prog['title'],
                $prog['degree_type'],
                $prog['description'],
                $prog['duration'],
                $prog['image'] ?: null,
                $prog['is_featured'],
                $maxSort + 1,
            ]);
        }

        flashMessage('Programme saved successfully.');
        header('Location: /admin/programmes.php');
        exit;
    }
}

$degreeTypes = ['MPhil', 'PhD', 'Certificate'];
?>

<div class="content-header">
    <h2><?= escape($adminPageTitle) ?></h2>
    <a href="/admin/programmes.php" class="btn-admin btn-admin-secondary">Back to Programmes</a>
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
            <input type="text" name="title" class="form-input" value="<?= escape($prog['title']) ?>" placeholder="e.g. Gene Therapy" required>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label class="form-label">Degree Type <span class="required">*</span></label>
                <select name="degree_type" class="form-select" required>
                    <option value="">Select degree type</option>
                    <?php foreach ($degreeTypes as $type): ?>
                        <option value="<?= escape($type) ?>" <?= $prog['degree_type'] === $type ? 'selected' : '' ?>><?= escape($type) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label class="form-label">Duration</label>
                <input type="text" name="duration" class="form-input" value="<?= escape($prog['duration']) ?>" placeholder="e.g. 2-3 Years">
            </div>
        </div>

        <div class="form-group">
            <label class="form-label">Description</label>
            <textarea name="description" class="form-textarea"><?= escape($prog['description']) ?></textarea>
        </div>

        <div class="form-group">
            <label class="form-label">Image</label>
            <?php if ($editing && $prog['image']): ?>
                <div class="mb-1">
                    <img src="<?= escape($prog['image']) ?>" alt="Current programme image" class="image-preview" id="image-preview">
                </div>
            <?php else: ?>
                <img src="" alt="" class="image-preview" id="image-preview" style="display:none">
            <?php endif; ?>
            <input type="file" name="image" class="form-input" accept="image/*" data-preview="image-preview">
            <span class="form-hint">Recommended: 800x600px. Max 5 MB. JPG, PNG, GIF, WEBP.</span>
        </div>

        <div class="form-group">
            <div class="form-checkbox-group">
                <input type="checkbox" name="is_featured" id="is_featured" class="form-checkbox" value="1" <?= $prog['is_featured'] ? 'checked' : '' ?>>
                <label for="is_featured">Featured (show on homepage)</label>
            </div>
        </div>

        <div class="btn-group mt-2">
            <button type="submit" class="btn-admin btn-admin-primary"><?= $editing ? 'Update Programme' : 'Create Programme' ?></button>
            <a href="/admin/programmes.php" class="btn-admin btn-admin-secondary">Cancel</a>
        </div>
    </form>
</div>

<?php require_once __DIR__ . '/includes/admin-footer.php'; ?>
