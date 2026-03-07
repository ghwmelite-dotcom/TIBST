<?php
/**
 * One-time migration: Create library_users table and add Google Drive settings.
 * Run once via browser, then DELETE this file.
 */

require_once __DIR__ . '/includes/db.php';

$pdo = getDB();

// Create library_users table
$pdo->exec("
    CREATE TABLE IF NOT EXISTS library_users (
        id INT AUTO_INCREMENT PRIMARY KEY,
        email VARCHAR(255) NOT NULL UNIQUE,
        password_hash VARCHAR(255) NOT NULL,
        full_name VARCHAR(150) NOT NULL,
        is_approved TINYINT(1) DEFAULT 1,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
");

// Add Google Drive settings (ignore if already exist)
$stmt = $pdo->prepare("INSERT IGNORE INTO settings (setting_key, setting_value) VALUES (?, ?)");
$stmt->execute(['gdrive_api_key', '']);
$stmt->execute(['gdrive_folder_id', '11FR2Wo7SDOhI30H59agJK-qBE41cYcx3']);

echo "Migration complete. library_users table created, Google Drive settings added.\n";
echo "IMPORTANT: Delete this file now!";
