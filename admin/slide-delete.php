<?php
/**
 * Admin — Delete a Hero Slide.
 * Requires POST with CSRF token.
 */

require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/csrf.php';
require_once __DIR__ . '/../includes/functions.php';

startSession();
requireAuth();

// Only accept POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: /admin/slides.php');
    exit;
}

validateCsrf();

$id  = (int) ($_POST['id'] ?? 0);
$pdo = getDB();

// Load slide to get image path
$stmt = $pdo->prepare('SELECT * FROM hero_slides WHERE id = ?');
$stmt->execute([$id]);
$slide = $stmt->fetch();

if ($slide) {
    // Delete from database
    $stmt = $pdo->prepare('DELETE FROM hero_slides WHERE id = ?');
    $stmt->execute([$id]);

    // Delete image file if it exists
    if ($slide['image']) {
        deleteImage($slide['image']);
    }

    flashMessage('Slide deleted.');
} else {
    flashMessage('Slide not found.', 'error');
}

header('Location: /admin/slides.php');
exit;
