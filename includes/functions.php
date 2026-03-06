<?php
/**
 * Query helpers and utility functions for the TIBST CMS.
 */

require_once __DIR__ . '/db.php';

// Provide sensible defaults for upload constants if not defined in config.php
if (!defined('UPLOAD_DIR')) {
    define('UPLOAD_DIR', dirname(__DIR__) . '/uploads/');
}
if (!defined('UPLOAD_URL')) {
    define('UPLOAD_URL', '/uploads/');
}
if (!defined('MAX_UPLOAD_SIZE')) {
    define('MAX_UPLOAD_SIZE', 5 * 1024 * 1024); // 5 MB
}

// ─── Settings ────────────────────────────────────────────────────────

/**
 * Get a single setting value by key.
 */
function getSetting(string $key): string
{
    $pdo  = getDB();
    $stmt = $pdo->prepare('SELECT setting_value FROM settings WHERE setting_key = ?');
    $stmt->execute([$key]);
    $row = $stmt->fetch();
    return $row ? (string) $row['setting_value'] : '';
}

/**
 * Get all settings as an associative array [key => value].
 */
function getSettings(): array
{
    $pdo  = getDB();
    $stmt = $pdo->query('SELECT setting_key, setting_value FROM settings');
    $settings = [];
    while ($row = $stmt->fetch()) {
        $settings[$row['setting_key']] = $row['setting_value'];
    }
    return $settings;
}

// ─── Hero Slides ─────────────────────────────────────────────────────

/**
 * Get all active hero slides ordered by sort_order.
 */
function getActiveSlides(): array
{
    $pdo  = getDB();
    $stmt = $pdo->query('SELECT * FROM hero_slides WHERE is_active = 1 ORDER BY sort_order ASC');
    return $stmt->fetchAll();
}

// ─── Programmes ──────────────────────────────────────────────────────

/**
 * Get featured programmes ordered by sort_order.
 */
function getFeaturedProgrammes(): array
{
    $pdo  = getDB();
    $stmt = $pdo->query('SELECT * FROM programmes WHERE is_featured = 1 ORDER BY sort_order');
    return $stmt->fetchAll();
}

/**
 * Get all programmes ordered by sort_order.
 */
function getAllProgrammes(): array
{
    $pdo  = getDB();
    $stmt = $pdo->query('SELECT * FROM programmes ORDER BY sort_order');
    return $stmt->fetchAll();
}

// ─── News ────────────────────────────────────────────────────────────

/**
 * Get published news articles, most recent first.
 */
function getPublishedNews(int $limit = 10): array
{
    $pdo  = getDB();
    $stmt = $pdo->prepare('SELECT * FROM news WHERE is_published = 1 ORDER BY publish_date DESC LIMIT ?');
    $stmt->execute([$limit]);
    return $stmt->fetchAll();
}

/**
 * Get a single published news article by its slug.
 */
function getNewsBySlug(string $slug): ?array
{
    $pdo  = getDB();
    $stmt = $pdo->prepare('SELECT * FROM news WHERE slug = ? AND is_published = 1');
    $stmt->execute([$slug]);
    $row = $stmt->fetch();
    return $row ?: null;
}

// ─── Testimonials ────────────────────────────────────────────────────

/**
 * Get active testimonials ordered by sort_order.
 */
function getActiveTestimonials(): array
{
    $pdo  = getDB();
    $stmt = $pdo->query('SELECT * FROM testimonials WHERE is_active = 1 ORDER BY sort_order');
    return $stmt->fetchAll();
}

// ─── Staff ───────────────────────────────────────────────────────────

/**
 * Get staff members by department.
 */
function getStaffByDepartment(string $dept): array
{
    $pdo  = getDB();
    $stmt = $pdo->prepare('SELECT * FROM staff WHERE department = ? ORDER BY sort_order');
    $stmt->execute([$dept]);
    return $stmt->fetchAll();
}

/**
 * Get all staff members ordered by sort_order.
 */
function getAllStaff(): array
{
    $pdo  = getDB();
    $stmt = $pdo->query('SELECT * FROM staff ORDER BY sort_order');
    return $stmt->fetchAll();
}

// ─── Page Blocks ─────────────────────────────────────────────────────

/**
 * Get the content of a specific page block.
 */
function getPageBlock(string $page, string $blockId): string
{
    $pdo  = getDB();
    $stmt = $pdo->prepare('SELECT content FROM page_blocks WHERE page = ? AND block_id = ?');
    $stmt->execute([$page, $blockId]);
    $row = $stmt->fetch();
    return $row ? (string) $row['content'] : '';
}

// ─── Utilities ───────────────────────────────────────────────────────

/**
 * Upload an image from a form file input.
 *
 * @param  string       $fileInputName  The name attribute of the file input.
 * @return string|false Relative URL path on success, false on failure.
 */
function uploadImage(string $fileInputName): string|false
{
    if (!isset($_FILES[$fileInputName]) || $_FILES[$fileInputName]['error'] !== UPLOAD_ERR_OK) {
        return false;
    }

    $file     = $_FILES[$fileInputName];
    $tmpPath  = $file['tmp_name'];
    $origName = $file['name'];
    $size     = $file['size'];

    // Check file size
    if ($size > MAX_UPLOAD_SIZE) {
        return false;
    }

    // Allowed extensions
    $allowedExts = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
    $ext = strtolower(pathinfo($origName, PATHINFO_EXTENSION));
    if (!in_array($ext, $allowedExts, true)) {
        return false;
    }

    // MIME type check
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $mime  = finfo_file($finfo, $tmpPath);
    finfo_close($finfo);

    $allowedMimes = [
        'image/jpeg',
        'image/png',
        'image/gif',
        'image/webp',
    ];
    if (!in_array($mime, $allowedMimes, true)) {
        return false;
    }

    // Create upload directory if needed
    if (!is_dir(UPLOAD_DIR)) {
        mkdir(UPLOAD_DIR, 0755, true);
    }

    // Generate a unique filename
    $newName  = uniqid('img_', true) . '.' . $ext;
    $destPath = rtrim(UPLOAD_DIR, '/\\') . '/' . $newName;

    if (!move_uploaded_file($tmpPath, $destPath)) {
        return false;
    }

    return UPLOAD_URL . $newName;
}

/**
 * Delete an uploaded image file.
 *
 * Prevents directory traversal by ensuring the path starts with UPLOAD_URL.
 */
function deleteImage(string $path): void
{
    // Guard against directory traversal
    if (strpos($path, UPLOAD_URL) !== 0) {
        return;
    }

    $filename = basename($path);
    $fullPath = rtrim(UPLOAD_DIR, '/\\') . '/' . $filename;

    if (is_file($fullPath)) {
        unlink($fullPath);
    }
}

/**
 * Convert a string into a URL-friendly slug.
 */
function slugify(string $text): string
{
    $text = mb_strtolower($text, 'UTF-8');
    $text = preg_replace('/[^a-z0-9]+/', '-', $text);
    $text = trim($text, '-');
    return substr($text, 0, 255);
}

/**
 * Create a plain-text excerpt from HTML content, truncated at a word boundary.
 */
function excerpt(string $text, int $length = 150): string
{
    $text = strip_tags($text);

    if (mb_strlen($text, 'UTF-8') <= $length) {
        return $text;
    }

    $truncated = mb_substr($text, 0, $length, 'UTF-8');
    $lastSpace = mb_strrpos($truncated, ' ', 0, 'UTF-8');

    if ($lastSpace !== false) {
        $truncated = mb_substr($truncated, 0, $lastSpace, 'UTF-8');
    }

    return $truncated . '...';
}

/**
 * Escape a string for safe HTML output.
 */
function escape(?string $str): string
{
    return htmlspecialchars((string) $str, ENT_QUOTES, 'UTF-8');
}

/**
 * Store a flash message in the session.
 */
function flashMessage(string $message, string $type = 'success'): void
{
    $_SESSION['flash'] = [
        'message' => $message,
        'type'    => $type,
    ];
}

/**
 * Retrieve and clear the flash message from the session.
 *
 * @return array{message: string, type: string}|null
 */
function getFlashMessage(): ?array
{
    if (!isset($_SESSION['flash'])) {
        return null;
    }

    $flash = $_SESSION['flash'];
    unset($_SESSION['flash']);
    return $flash;
}
