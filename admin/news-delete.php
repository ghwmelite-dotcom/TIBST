<?php
/**
 * Admin — Delete a News Article.
 * Requires POST with CSRF token.
 */

require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/csrf.php';
require_once __DIR__ . '/../includes/functions.php';

startSession();
requireAuth();

// Only accept POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: /admin/news.php');
    exit;
}

validateCsrf();

$id  = (int) ($_POST['id'] ?? 0);
$pdo = getDB();

// Load article to get image path
$stmt = $pdo->prepare('SELECT * FROM news WHERE id = ?');
$stmt->execute([$id]);
$article = $stmt->fetch();

if ($article) {
    // Delete from database
    $stmt = $pdo->prepare('DELETE FROM news WHERE id = ?');
    $stmt->execute([$id]);

    // Delete image file if it exists
    if ($article['image']) {
        deleteImage($article['image']);
    }

    flashMessage('Article deleted.');
} else {
    flashMessage('Article not found.', 'error');
}

header('Location: /admin/news.php');
exit;
