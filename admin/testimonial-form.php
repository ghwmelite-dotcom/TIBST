<?php
/**
 * Admin — Create / Edit a Testimonial.
 */

$adminActivePage = 'testimonials';

// Load dependencies BEFORE any HTML output so redirects work
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/csrf.php';
require_once __DIR__ . '/../includes/functions.php';

startSession();
requireAuth();

$pdo     = getDB();
$editing = false;
$testimonial = [
    'id'        => '',
    'name'      => '',
    'initials'  => '',
    'role'      => '',
    'quote'     => '',
    'is_active' => 1,
];

// Load existing testimonial for editing
if (isset($_GET['id'])) {
    $stmt = $pdo->prepare('SELECT * FROM testimonials WHERE id = ?');
    $stmt->execute([(int) $_GET['id']]);
    $row = $stmt->fetch();

    if (!$row) {
        flashMessage('Testimonial not found.', 'error');
        header('Location: /admin/testimonials.php');
        exit;
    }

    $testimonial = $row;
    $editing     = true;
}

$adminPageTitle = $editing ? 'Edit Testimonial' : 'Add Testimonial';
$errors = [];

// ─── POST Handler (must run before admin-header outputs HTML) ────────
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    validateCsrf();

    $testimonial['name']      = trim($_POST['name'] ?? '');
    $testimonial['initials']  = trim($_POST['initials'] ?? '');
    $testimonial['role']      = trim($_POST['role'] ?? '');
    $testimonial['quote']     = trim($_POST['quote'] ?? '');
    $testimonial['is_active'] = isset($_POST['is_active']) ? 1 : 0;

    // Auto-generate initials from name if empty
    if ($testimonial['initials'] === '' && $testimonial['name'] !== '') {
        $words = explode(' ', $testimonial['name']);
        $testimonial['initials'] = implode('', array_map(fn($w) => mb_strtoupper(mb_substr($w, 0, 1)), $words));
    }

    // Validation
    if ($testimonial['name'] === '')  $errors[] = 'Name is required.';
    if ($testimonial['quote'] === '') $errors[] = 'Quote is required.';

    if (empty($errors)) {
        if ($editing) {
            $stmt = $pdo->prepare('UPDATE testimonials SET name = ?, initials = ?, role = ?, quote = ?, is_active = ? WHERE id = ?');
            $stmt->execute([
                $testimonial['name'],
                $testimonial['initials'],
                $testimonial['role'],
                $testimonial['quote'],
                $testimonial['is_active'],
                (int) $testimonial['id'],
            ]);
        } else {
            $maxSort = (int) $pdo->query('SELECT COALESCE(MAX(sort_order), 0) FROM testimonials')->fetchColumn();

            $stmt = $pdo->prepare('INSERT INTO testimonials (name, initials, role, quote, is_active, sort_order) VALUES (?, ?, ?, ?, ?, ?)');
            $stmt->execute([
                $testimonial['name'],
                $testimonial['initials'],
                $testimonial['role'],
                $testimonial['quote'],
                $testimonial['is_active'],
                $maxSort + 1,
            ]);
        }

        flashMessage('Testimonial saved successfully.');
        header('Location: /admin/testimonials.php');
        exit;
    }
}

require_once __DIR__ . '/includes/admin-header.php';
?>

<div class="content-header">
    <h2><?= escape($adminPageTitle) ?></h2>
    <a href="/admin/testimonials.php" class="btn-admin btn-admin-secondary">Back to Testimonials</a>
</div>

<?php if (!empty($errors)): ?>
<div class="alert alert-error">
    <span><?= escape(implode(' ', $errors)) ?></span>
    <button class="alert-dismiss" type="button">&times;</button>
</div>
<?php endif; ?>

<div class="admin-card">
    <form method="POST">
        <?= csrfField() ?>

        <div class="form-row">
            <div class="form-group">
                <label class="form-label">Name <span class="required">*</span></label>
                <input type="text" name="name" id="author-name" class="form-input" value="<?= escape($testimonial['name']) ?>" placeholder="e.g. Dr. Ama Kusi" required>
            </div>
            <div class="form-group">
                <label class="form-label">Initials</label>
                <input type="text" name="initials" id="initials" class="form-input" value="<?= escape($testimonial['initials']) ?>" placeholder="e.g. AK" maxlength="5">
                <span class="form-hint">Auto-generated from name if left empty. Max 5 characters.</span>
            </div>
        </div>

        <div class="form-group">
            <label class="form-label">Role</label>
            <input type="text" name="role" class="form-input" value="<?= escape($testimonial['role']) ?>" placeholder="e.g. PhD Gene Therapy, Class of 2025">
        </div>

        <div class="form-group">
            <label class="form-label">Quote <span class="required">*</span></label>
            <textarea name="quote" class="form-textarea" required placeholder="What did they say about TIBST?"><?= escape($testimonial['quote']) ?></textarea>
        </div>

        <div class="form-group">
            <div class="form-checkbox-group">
                <input type="checkbox" name="is_active" id="is_active" class="form-checkbox" value="1" <?= $testimonial['is_active'] ? 'checked' : '' ?>>
                <label for="is_active">Active (visible on site)</label>
            </div>
        </div>

        <div class="btn-group mt-2">
            <button type="submit" class="btn-admin btn-admin-primary"><?= $editing ? 'Update Testimonial' : 'Create Testimonial' ?></button>
            <a href="/admin/testimonials.php" class="btn-admin btn-admin-secondary">Cancel</a>
        </div>
    </form>
</div>

<?php require_once __DIR__ . '/includes/admin-footer.php'; ?>
