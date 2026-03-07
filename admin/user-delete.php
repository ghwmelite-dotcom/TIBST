<?php
/**
 * Admin — Delete a User (admin only).
 * Requires POST with CSRF token.
 */

require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/csrf.php';
require_once __DIR__ . '/../includes/functions.php';

startSession();
requireAuth();
requireAdmin();

// Only accept POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: /admin/users.php');
    exit;
}

validateCsrf();

$id            = (int) ($_POST['id'] ?? 0);
$currentUserId = currentUser()['id'];
$pdo           = getDB();

// Cannot delete yourself
if ($id === $currentUserId) {
    flashMessage('You cannot delete your own account.', 'error');
    header('Location: /admin/users.php');
    exit;
}

// Load user to check role
$stmt = $pdo->prepare('SELECT * FROM users WHERE id = ?');
$stmt->execute([$id]);
$user = $stmt->fetch();

if (!$user) {
    flashMessage('User not found.', 'error');
    header('Location: /admin/users.php');
    exit;
}

// Cannot delete if it's the last admin
if ($user['role'] === 'admin') {
    $adminCount = (int) $pdo->query("SELECT COUNT(*) FROM users WHERE role = 'admin'")->fetchColumn();

    if ($adminCount <= 1) {
        flashMessage('Cannot delete the last admin user.', 'error');
        header('Location: /admin/users.php');
        exit;
    }
}

// Delete the user
$stmt = $pdo->prepare('DELETE FROM users WHERE id = ?');
$stmt->execute([$id]);

flashMessage('User deleted.');
header('Location: /admin/users.php');
exit;
