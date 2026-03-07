<?php
/**
 * Admin — Delete a Staff Member.
 * Requires POST with CSRF token.
 */

require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/csrf.php';
require_once __DIR__ . '/../includes/functions.php';

startSession();
requireAuth();

// Only accept POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: /admin/staff.php');
    exit;
}

validateCsrf();

$id  = (int) ($_POST['id'] ?? 0);
$pdo = getDB();

// Load staff member to get photo path
$stmt = $pdo->prepare('SELECT * FROM staff WHERE id = ?');
$stmt->execute([$id]);
$member = $stmt->fetch();

if ($member) {
    // Delete from database
    $stmt = $pdo->prepare('DELETE FROM staff WHERE id = ?');
    $stmt->execute([$id]);

    // Delete photo file if it exists
    if ($member['photo']) {
        deleteImage($member['photo']);
    }

    flashMessage('Staff member deleted.');
} else {
    flashMessage('Staff member not found.', 'error');
}

header('Location: /admin/staff.php');
exit;
