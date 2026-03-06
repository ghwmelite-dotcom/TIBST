<?php
/**
 * Admin — Delete a Programme.
 * Requires POST with CSRF token.
 */

require_once __DIR__ . '/includes/admin-header.php';

// Only accept POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: /admin/programmes.php');
    exit;
}

validateCsrf();

$id  = (int) ($_POST['id'] ?? 0);
$pdo = getDB();

// Load programme to get image path
$stmt = $pdo->prepare('SELECT * FROM programmes WHERE id = ?');
$stmt->execute([$id]);
$prog = $stmt->fetch();

if ($prog) {
    // Delete from database
    $stmt = $pdo->prepare('DELETE FROM programmes WHERE id = ?');
    $stmt->execute([$id]);

    // Delete image file if it exists
    if ($prog['image']) {
        deleteImage($prog['image']);
    }

    flashMessage('Programme deleted.');
} else {
    flashMessage('Programme not found.', 'error');
}

header('Location: /admin/programmes.php');
exit;
