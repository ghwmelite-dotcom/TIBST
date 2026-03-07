<?php
/**
 * One-time migration: Add site_logo and site_favicon settings.
 * Run via browser, then delete this file.
 */

require_once __DIR__ . '/includes/db.php';

$pdo = getDB();

$keys = ['site_logo', 'site_favicon'];

foreach ($keys as $key) {
    $stmt = $pdo->prepare('SELECT COUNT(*) FROM settings WHERE setting_key = ?');
    $stmt->execute([$key]);
    if ((int) $stmt->fetchColumn() === 0) {
        $pdo->prepare('INSERT INTO settings (setting_key, setting_value) VALUES (?, ?)')->execute([$key, '']);
        echo "Added setting: {$key}<br>";
    } else {
        echo "Setting already exists: {$key}<br>";
    }
}

echo "<br>Done. Delete this file now.";
