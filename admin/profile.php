<?php
/**
 * Admin — My Profile (any logged-in user).
 */

$adminPageTitle  = 'My Profile';
$adminActivePage = 'profile';

// Load dependencies BEFORE any HTML output so redirects work
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/csrf.php';
require_once __DIR__ . '/../includes/functions.php';

startSession();
requireAuth();

$pdo           = getDB();
$currentUserId = currentUser()['id'];

// Load fresh user data from database
$stmt = $pdo->prepare('SELECT id, name, email, role FROM users WHERE id = ?');
$stmt->execute([$currentUserId]);
$profile = $stmt->fetch();

if (!$profile) {
    flashMessage('User not found.', 'error');
    header('Location: /admin/dashboard.php');
    exit;
}

$errors = [];

// ─── POST Handler (must run before admin-header outputs HTML) ────────
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    validateCsrf();

    $name            = trim($_POST['name'] ?? '');
    $email           = trim($_POST['email'] ?? '');
    $currentPassword = $_POST['current_password'] ?? '';
    $newPassword     = $_POST['new_password'] ?? '';

    // Validation
    if ($name === '') {
        $errors[] = 'Name is required.';
    }
    if ($email === '') {
        $errors[] = 'Email is required.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Please enter a valid email address.';
    }

    // Current password is required to make any changes
    if ($currentPassword === '') {
        $errors[] = 'Current password is required to save changes.';
    } else {
        // Verify current password
        $stmt = $pdo->prepare('SELECT password_hash FROM users WHERE id = ?');
        $stmt->execute([$currentUserId]);
        $row = $stmt->fetch();

        if (!password_verify($currentPassword, $row['password_hash'])) {
            $errors[] = 'Current password is incorrect.';
        }
    }

    // Check email uniqueness (exclude self)
    if ($email !== '') {
        $stmt = $pdo->prepare('SELECT id FROM users WHERE email = ? AND id != ?');
        $stmt->execute([$email, $currentUserId]);

        if ($stmt->fetch()) {
            $errors[] = 'This email is already in use.';
        }
    }

    // New password validation (optional)
    if ($newPassword !== '' && strlen($newPassword) < 8) {
        $errors[] = 'New password must be at least 8 characters.';
    }

    if (empty($errors)) {
        if ($newPassword !== '') {
            $stmt = $pdo->prepare('UPDATE users SET name = ?, email = ?, password_hash = ? WHERE id = ?');
            $stmt->execute([$name, $email, password_hash($newPassword, PASSWORD_DEFAULT), $currentUserId]);
        } else {
            $stmt = $pdo->prepare('UPDATE users SET name = ?, email = ? WHERE id = ?');
            $stmt->execute([$name, $email, $currentUserId]);
        }

        // Update session values
        $_SESSION['user_name']  = $name;
        $_SESSION['user_email'] = $email;

        flashMessage('Profile updated.');
        header('Location: /admin/profile.php');
        exit;
    }

    // Preserve submitted values on error
    $profile['name']  = $name;
    $profile['email'] = $email;
}

require_once __DIR__ . '/includes/admin-header.php';
?>

<div class="content-header">
    <h2>My Profile</h2>
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

        <div class="form-group">
            <label class="form-label">Name <span class="required">*</span></label>
            <input type="text" name="name" class="form-input" value="<?= escape($profile['name']) ?>" required>
        </div>

        <div class="form-group">
            <label class="form-label">Email <span class="required">*</span></label>
            <input type="email" name="email" class="form-input" value="<?= escape($profile['email']) ?>" required>
        </div>

        <div class="form-group">
            <label class="form-label">Role</label>
            <input type="text" class="form-input" value="<?= escape(ucfirst($profile['role'])) ?>" disabled>
            <span class="form-hint">Contact an administrator to change your role.</span>
        </div>

        <h3 class="form-section-title">Change Password</h3>

        <div class="form-group">
            <label class="form-label">Current Password <span class="required">*</span></label>
            <input type="password" name="current_password" class="form-input" required>
            <span class="form-hint">Required to save any changes.</span>
        </div>

        <div class="form-group">
            <label class="form-label">New Password</label>
            <input type="password" name="new_password" class="form-input" minlength="8">
            <span class="form-hint">Leave blank to keep current password. Minimum 8 characters if provided.</span>
        </div>

        <div class="btn-group mt-2">
            <button type="submit" class="btn-admin btn-admin-primary">Update Profile</button>
        </div>
    </form>
</div>

<?php require_once __DIR__ . '/includes/admin-footer.php'; ?>
