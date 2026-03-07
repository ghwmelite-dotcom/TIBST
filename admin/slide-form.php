<?php
/**
 * Admin — Create / Edit a Hero Slide.
 */

$adminActivePage = 'slides';

// Load dependencies BEFORE any HTML output so redirects work
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/csrf.php';
require_once __DIR__ . '/../includes/functions.php';

startSession();
requireAuth();

$pdo     = getDB();
$editing = false;
$slide   = [
    'id'         => '',
    'image'      => '',
    'headline_1' => '',
    'headline_2' => '',
    'headline_3' => '',
    'subtitle'   => '',
    'cta_text'   => 'Apply Now',
    'cta_link'   => 'admissions.php',
    'is_active'  => 1,
];

// Load existing slide for editing
if (isset($_GET['id'])) {
    $stmt = $pdo->prepare('SELECT * FROM hero_slides WHERE id = ?');
    $stmt->execute([(int) $_GET['id']]);
    $row = $stmt->fetch();

    if (!$row) {
        flashMessage('Slide not found.', 'error');
        header('Location: /admin/slides.php');
        exit;
    }

    $slide   = $row;
    $editing = true;
}

$adminPageTitle = $editing ? 'Edit Slide' : 'Add Slide';
$errors = [];

// ─── POST Handler (must run before admin-header outputs HTML) ────────
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    validateCsrf();

    $slide['headline_1'] = trim($_POST['headline_1'] ?? '');
    $slide['headline_2'] = trim($_POST['headline_2'] ?? '');
    $slide['headline_3'] = trim($_POST['headline_3'] ?? '');
    $slide['subtitle']   = trim($_POST['subtitle'] ?? '');
    $slide['cta_text']   = trim($_POST['cta_text'] ?? 'Apply Now');
    $slide['cta_link']   = trim($_POST['cta_link'] ?? 'admissions.php');
    $slide['is_active']  = isset($_POST['is_active']) ? 1 : 0;

    // Validation
    if ($slide['headline_1'] === '') $errors[] = 'Headline 1 is required.';
    if ($slide['headline_2'] === '') $errors[] = 'Headline 2 is required.';
    if ($slide['headline_3'] === '') $errors[] = 'Headline 3 is required.';

    // Handle image upload
    $newImage = uploadImage('image');
    if ($newImage) {
        // Delete old image if editing
        if ($editing && $slide['image']) {
            deleteImage($slide['image']);
        }
        $slide['image'] = $newImage;
    } elseif (!$editing && !$slide['image']) {
        // New slide requires an image unless one already exists (shouldn't happen for new)
        // Image is optional — external URLs are also stored in seed data
    }

    if (empty($errors)) {
        if ($editing) {
            $stmt = $pdo->prepare('UPDATE hero_slides SET image = ?, headline_1 = ?, headline_2 = ?, headline_3 = ?, subtitle = ?, cta_text = ?, cta_link = ?, is_active = ? WHERE id = ?');
            $stmt->execute([
                $slide['image'],
                $slide['headline_1'],
                $slide['headline_2'],
                $slide['headline_3'],
                $slide['subtitle'],
                $slide['cta_text'],
                $slide['cta_link'],
                $slide['is_active'],
                (int) $slide['id'],
            ]);
        } else {
            // Get next sort_order
            $maxSort = (int) $pdo->query('SELECT COALESCE(MAX(sort_order), 0) FROM hero_slides')->fetchColumn();

            $stmt = $pdo->prepare('INSERT INTO hero_slides (image, headline_1, headline_2, headline_3, subtitle, cta_text, cta_link, is_active, sort_order) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)');
            $stmt->execute([
                $slide['image'] ?: '',
                $slide['headline_1'],
                $slide['headline_2'],
                $slide['headline_3'],
                $slide['subtitle'],
                $slide['cta_text'],
                $slide['cta_link'],
                $slide['is_active'],
                $maxSort + 1,
            ]);
        }

        flashMessage('Slide saved successfully.');
        header('Location: /admin/slides.php');
        exit;
    }
}

require_once __DIR__ . '/includes/admin-header.php';
?>

<div class="content-header">
    <h2><?= escape($adminPageTitle) ?></h2>
    <a href="/admin/slides.php" class="btn-admin btn-admin-secondary">Back to Slides</a>
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
            <label class="form-label">Image</label>
            <?php if ($editing && $slide['image']): ?>
                <div class="mb-1">
                    <img src="<?= escape($slide['image']) ?>" alt="Current slide image" class="image-preview" id="image-preview">
                </div>
            <?php else: ?>
                <img src="" alt="" class="image-preview" id="image-preview" style="display:none">
            <?php endif; ?>
            <input type="file" name="image" class="form-input" accept="image/*" data-preview="image-preview">
            <span class="form-hint">Recommended: 1920x1080px. Max 5 MB. JPG, PNG, GIF, WEBP.</span>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label class="form-label">Headline 1 <span class="required">*</span></label>
                <input type="text" name="headline_1" class="form-input" value="<?= escape($slide['headline_1']) ?>" placeholder="e.g. Shaping the" required>
            </div>
            <div class="form-group">
                <label class="form-label">Headline 2 <span class="required">*</span></label>
                <input type="text" name="headline_2" class="form-input" value="<?= escape($slide['headline_2']) ?>" placeholder="e.g. Future of" required>
            </div>
        </div>

        <div class="form-group">
            <label class="form-label">Headline 3 <span class="required">*</span></label>
            <input type="text" name="headline_3" class="form-input" value="<?= escape($slide['headline_3']) ?>" placeholder="e.g. Biomedical Science" required>
        </div>

        <div class="form-group">
            <label class="form-label">Subtitle</label>
            <textarea name="subtitle" class="form-textarea"><?= escape($slide['subtitle']) ?></textarea>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label class="form-label">CTA Text</label>
                <input type="text" name="cta_text" class="form-input" value="<?= escape($slide['cta_text']) ?>" placeholder="Apply Now">
            </div>
            <div class="form-group">
                <label class="form-label">CTA Link</label>
                <input type="text" name="cta_link" class="form-input" value="<?= escape($slide['cta_link']) ?>" placeholder="admissions.php">
            </div>
        </div>

        <div class="form-group">
            <div class="form-checkbox-group">
                <input type="checkbox" name="is_active" id="is_active" class="form-checkbox" value="1" <?= $slide['is_active'] ? 'checked' : '' ?>>
                <label for="is_active">Active (visible on site)</label>
            </div>
        </div>

        <div class="btn-group mt-2">
            <button type="submit" class="btn-admin btn-admin-primary"><?= $editing ? 'Update Slide' : 'Create Slide' ?></button>
            <a href="/admin/slides.php" class="btn-admin btn-admin-secondary">Cancel</a>
        </div>
    </form>
</div>

<?php require_once __DIR__ . '/includes/admin-footer.php'; ?>
