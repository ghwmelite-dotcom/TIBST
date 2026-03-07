<?php
require_once __DIR__ . '/includes/db.php';
$pdo = getDB();
$stmt = $pdo->prepare('UPDATE settings SET setting_value = ? WHERE setting_key = ?');
$stmt->execute(['AIzaSyCPczYjxqfrqlsUUokLQhsU1rBDqJglfJk', 'gdrive_api_key']);
echo 'Google Drive API key set. DELETE THIS FILE NOW.';
