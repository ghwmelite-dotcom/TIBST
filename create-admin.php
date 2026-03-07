<?php
/**
 * One-time script: Create super admin user.
 * Delete this file immediately after running.
 */

require_once __DIR__ . '/includes/db.php';

$pdo = getDB();

$name  = 'Super Admin';
$email = 'oh84dev@gmail.com';
$pass  = password_hash('angels2G9@84?', PASSWORD_DEFAULT);

// Remove existing user with this email if any
$pdo->prepare('DELETE FROM users WHERE email = ?')->execute([$email]);

// Insert admin
$stmt = $pdo->prepare('INSERT INTO users (name, email, password_hash, role) VALUES (?, ?, ?, ?)');
$stmt->execute([$name, $email, $pass, 'admin']);

echo "Admin created. Delete this file now.";
