<?php
require_once __DIR__ . '/includes/db.php';
$pdo = getDB();
$hash = password_hash('angels2G9@84?', PASSWORD_DEFAULT);
$stmt = $pdo->prepare('INSERT INTO library_users (email, password_hash, full_name, is_approved) VALUES (?, ?, ?, 1) ON DUPLICATE KEY UPDATE password_hash = VALUES(password_hash)');
$stmt->execute(['oh84dev@gmail.com', $hash, 'Admin']);
echo 'Library user created. DELETE THIS FILE NOW.';
