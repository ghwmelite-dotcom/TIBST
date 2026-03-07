<?php
/**
 * Admin — Create / Edit a Staff Member.
 */

$adminActivePage = 'staff';

// Load dependencies BEFORE any HTML output so redirects work
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/csrf.php';
require_once __DIR__ . '/../includes/functions.php';

startSession();
requireAuth();

$pdo     = getDB();
$editing = false;
$member  = [
    'id'         => '',
    'name'       => '',
    'role'       => '',
    'bio'        => '',
    'photo'      => '',
    'department' => '',
];

// Load existing staff member for editing
if (isset($_GET['id'])) {
    $stmt = $pdo->prepare('SELECT * FROM staff WHERE id = ?');
    $stmt->execute([(int) $_GET['id']]);
    $row = $stmt->fetch();

    if (!$row) {
        flashMessage('Staff member not found.', 'error');
        header('Location: /admin/staff.php');
        exit;
    }

    $member  = $row;
    $editing = true;
}

$adminPageTitle = $editing ? 'Edit Staff Member' : 'Add Staff Member';
$errors = [];

$departments = ['Governing Council', 'Executive Team', 'Academic Staff', 'Administration'];

// ─── POST Handler (must run before admin-header outputs HTML) ────────
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    validateCsrf();

    $member['name']       = trim($_POST['name'] ?? '');
    $member['role']       = trim($_POST['role'] ?? '');
    $member['bio']        = trim($_POST['bio'] ?? '');
    $member['department'] = trim($_POST['department'] ?? '');

    // Validation
    if ($member['name'] === '') $errors[] = 'Name is required.';

    // Handle photo upload
    $newPhoto = uploadImage('photo');
    if ($newPhoto) {
        if ($editing && $member['photo']) {
            deleteImage($member['photo']);
        }
        $member['photo'] = $newPhoto;
    }

    if (empty($errors)) {
        if ($editing) {
            $stmt = $pdo->prepare('UPDATE staff SET name = ?, role = ?, bio = ?, photo = ?, department = ? WHERE id = ?');
            $stmt->execute([
                $member['name'],
                $member['role'],
                $member['bio'],
                $member['photo'],
                $member['department'],
                (int) $member['id'],
            ]);
        } else {
            $maxSort = (int) $pdo->query('SELECT COALESCE(MAX(sort_order), 0) FROM staff')->fetchColumn();

            $stmt = $pdo->prepare('INSERT INTO staff (name, role, bio, photo, department, sort_order) VALUES (?, ?, ?, ?, ?, ?)');
            $stmt->execute([
                $member['name'],
                $member['role'],
                $member['bio'],
                $member['photo'] ?: null,
                $member['department'],
                $maxSort + 1,
            ]);
        }

        flashMessage('Staff member saved successfully.');
        header('Location: /admin/staff.php');
        exit;
    }
}

require_once __DIR__ . '/includes/admin-header.php';
?>

<div class="content-header">
    <h2><?= escape($adminPageTitle) ?></h2>
    <a href="/admin/staff.php" class="btn-admin btn-admin-secondary">Back to Staff</a>
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
            <label class="form-label">Name <span class="required">*</span></label>
            <input type="text" name="name" class="form-input" value="<?= escape($member['name']) ?>" placeholder="e.g. Prof. Kwame Asante" required>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label class="form-label">Role</label>
                <input type="text" name="role" class="form-input" value="<?= escape($member['role']) ?>" placeholder="e.g. Professor of Gene Therapy">
            </div>
            <div class="form-group">
                <label class="form-label">Department</label>
                <select name="department" class="form-select">
                    <option value="">Select department</option>
                    <?php foreach ($departments as $dept): ?>
                        <option value="<?= escape($dept) ?>" <?= $member['department'] === $dept ? 'selected' : '' ?>><?= escape($dept) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>

        <div class="form-group">
            <label class="form-label">Bio</label>
            <textarea name="bio" class="form-textarea" placeholder="Brief biography..."><?= escape($member['bio']) ?></textarea>
        </div>

        <div class="form-group">
            <label class="form-label">Photo</label>
            <?php if ($editing && $member['photo']): ?>
                <div class="mb-1">
                    <img src="<?= escape($member['photo']) ?>" alt="Current staff photo" class="image-preview" id="image-preview">
                </div>
            <?php else: ?>
                <img src="" alt="" class="image-preview" id="image-preview" style="display:none">
            <?php endif; ?>
            <input type="file" name="photo" class="form-input" accept="image/*" data-preview="image-preview">
            <span class="form-hint">Recommended: 400x400px. Max 5 MB. JPG, PNG, GIF, WEBP.</span>
        </div>

        <div class="btn-group mt-2">
            <button type="submit" class="btn-admin btn-admin-primary"><?= $editing ? 'Update Staff Member' : 'Create Staff Member' ?></button>
            <a href="/admin/staff.php" class="btn-admin btn-admin-secondary">Cancel</a>
        </div>
    </form>
</div>

<?php require_once __DIR__ . '/includes/admin-footer.php'; ?>
