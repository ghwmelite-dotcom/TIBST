<?php
/**
 * Admin — Create / Edit a User (admin only).
 */

$adminActivePage = 'users';

require_once __DIR__ . '/includes/admin-header.php';

requireAdmin();

$pdo     = getDB();
$editing = false;
$user    = [
    'id'    => '',
    'name'  => '',
    'email' => '',
    'role'  => 'editor',
];

// Load existing user for editing
if (isset($_GET['id'])) {
    $stmt = $pdo->prepare('SELECT id, name, email, role FROM users WHERE id = ?');
    $stmt->execute([(int) $_GET['id']]);
    $row = $stmt->fetch();

    if (!$row) {
        flashMessage('User not found.', 'error');
        header('Location: /admin/users.php');
        exit;
    }

    $user    = $row;
    $editing = true;
}

$adminPageTitle = $editing ? 'Edit User' : 'Add User';
$errors = [];

// ─── POST Handler ────────────────────────────────────────────────────
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    validateCsrf();

    $user['name']  = trim($_POST['name'] ?? '');
    $user['email'] = trim($_POST['email'] ?? '');
    $user['role']  = in_array($_POST['role'] ?? '', ['admin', 'editor']) ? $_POST['role'] : 'editor';
    $password      = $_POST['password'] ?? '';

    // Validation
    if ($user['name'] === '') {
        $errors[] = 'Name is required.';
    }
    if ($user['email'] === '') {
        $errors[] = 'Email is required.';
    } elseif (!filter_var($user['email'], FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Please enter a valid email address.';
    }

    // Check email uniqueness
    if ($user['email'] !== '') {
        $emailCheckSql = 'SELECT id FROM users WHERE email = ?';
        $emailParams   = [$user['email']];

        if ($editing) {
            $emailCheckSql .= ' AND id != ?';
            $emailParams[]  = (int) $user['id'];
        }

        $stmt = $pdo->prepare($emailCheckSql);
        $stmt->execute($emailParams);

        if ($stmt->fetch()) {
            $errors[] = 'This email is already in use.';
        }
    }

    // Password validation
    if (!$editing && $password === '') {
        $errors[] = 'Password is required.';
    }
    if ($password !== '' && strlen($password) < 8) {
        $errors[] = 'Password must be at least 8 characters.';
    }

    if (empty($errors)) {
        if ($editing) {
            if ($password !== '') {
                $stmt = $pdo->prepare('UPDATE users SET name = ?, email = ?, role = ?, password_hash = ? WHERE id = ?');
                $stmt->execute([
                    $user['name'],
                    $user['email'],
                    $user['role'],
                    password_hash($password, PASSWORD_DEFAULT),
                    (int) $user['id'],
                ]);
            } else {
                $stmt = $pdo->prepare('UPDATE users SET name = ?, email = ?, role = ? WHERE id = ?');
                $stmt->execute([
                    $user['name'],
                    $user['email'],
                    $user['role'],
                    (int) $user['id'],
                ]);
            }
        } else {
            $stmt = $pdo->prepare('INSERT INTO users (name, email, password_hash, role) VALUES (?, ?, ?, ?)');
            $stmt->execute([
                $user['name'],
                $user['email'],
                password_hash($password, PASSWORD_DEFAULT),
                $user['role'],
            ]);
        }

        flashMessage('User saved successfully.');
        header('Location: /admin/users.php');
        exit;
    }
}
?>

<div class="content-header">
    <h2><?= escape($adminPageTitle) ?></h2>
    <a href="/admin/users.php" class="btn-admin btn-admin-secondary">Back to Users</a>
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
            <input type="text" name="name" class="form-input" value="<?= escape($user['name']) ?>" required>
        </div>

        <div class="form-group">
            <label class="form-label">Email <span class="required">*</span></label>
            <input type="email" name="email" class="form-input" value="<?= escape($user['email']) ?>" required>
        </div>

        <div class="form-group">
            <label class="form-label">Password <?= $editing ? '' : '<span class="required">*</span>' ?></label>
            <input type="password" name="password" class="form-input" <?= $editing ? '' : 'required' ?> minlength="8">
            <?php if ($editing): ?>
                <span class="form-hint">Leave blank to keep current password.</span>
            <?php else: ?>
                <span class="form-hint">Minimum 8 characters.</span>
            <?php endif; ?>
        </div>

        <div class="form-group">
            <label class="form-label">Role</label>
            <select name="role" class="form-input">
                <option value="admin" <?= $user['role'] === 'admin' ? 'selected' : '' ?>>Admin</option>
                <option value="editor" <?= $user['role'] === 'editor' ? 'selected' : '' ?>>Editor</option>
            </select>
        </div>

        <div class="btn-group mt-2">
            <button type="submit" class="btn-admin btn-admin-primary"><?= $editing ? 'Update User' : 'Create User' ?></button>
            <a href="/admin/users.php" class="btn-admin btn-admin-secondary">Cancel</a>
        </div>
    </form>
</div>

<?php require_once __DIR__ . '/includes/admin-footer.php'; ?>
