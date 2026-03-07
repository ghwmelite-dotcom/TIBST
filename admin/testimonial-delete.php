<?php
/**
 * Admin — Delete a Testimonial.
 * Requires POST with CSRF token.
 */

require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/csrf.php';
require_once __DIR__ . '/../includes/functions.php';

startSession();
requireAuth();

// Only accept POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: /admin/testimonials.php');
    exit;
}

validateCsrf();

$id  = (int) ($_POST['id'] ?? 0);
$pdo = getDB();

// Load testimonial
$stmt = $pdo->prepare('SELECT * FROM testimonials WHERE id = ?');
$stmt->execute([$id]);
$testimonial = $stmt->fetch();

if ($testimonial) {
    // Delete from database
    $stmt = $pdo->prepare('DELETE FROM testimonials WHERE id = ?');
    $stmt->execute([$id]);

    flashMessage('Testimonial deleted.');
} else {
    flashMessage('Testimonial not found.', 'error');
}

header('Location: /admin/testimonials.php');
exit;
