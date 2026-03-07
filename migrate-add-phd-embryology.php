<?php
/**
 * One-time migration: add PhD Human Embryology programme if missing.
 * Run once, then delete this file.
 */
require_once __DIR__ . '/includes/functions.php';

$pdo = getDB();

// Check if it already exists
$stmt = $pdo->prepare("SELECT COUNT(*) FROM programmes WHERE title = 'Human Embryology' AND degree_type = 'PhD'");
$stmt->execute();

if ($stmt->fetchColumn() == 0) {
    $ins = $pdo->prepare("INSERT INTO programmes (title, degree_type, description, duration, image, is_featured, sort_order) VALUES (?, ?, ?, ?, NULL, 0, 4)");
    $ins->execute([
        'Human Embryology',
        'PhD',
        'Conduct advanced doctoral research in human embryonic development, reproductive biology, and assisted reproduction technologies. This programme prepares candidates to lead innovation in developmental science.',
        '3-4 years',
    ]);
    echo "Added PhD Human Embryology programme.\n";
} else {
    echo "PhD Human Embryology already exists.\n";
}
