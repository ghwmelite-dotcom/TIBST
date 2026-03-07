<?php
/**
 * One-time migration: Replace hero slides with 3 new slides.
 * Run once, then delete this file.
 *
 * Visit: https://yoursite.com/update-slides.php
 */

require_once __DIR__ . '/includes/db.php';

$pdo = getDB();

// Clear existing slides
$pdo->exec('DELETE FROM hero_slides');

// Insert 3 new slides
$stmt = $pdo->prepare('INSERT INTO hero_slides (image, headline_1, headline_2, headline_3, subtitle, cta_text, cta_link, sort_order, is_active) VALUES (?, ?, ?, ?, ?, ?, ?, ?, 1)');

$stmt->execute([
    'https://images.unsplash.com/photo-1532094349884-543bc11b234d?w=1920&q=80',
    'Shaping the Future of',
    '',
    'Biomedical Science',
    'TIBST is a premier institution dedicated to advancing biomedical science education and research in Ghana and beyond.',
    'Apply Now',
    'admissions.php',
    1
]);

$stmt->execute([
    'https://images.unsplash.com/photo-1576086213369-97a306d36557?w=1920&q=80',
    'World-Class Research in',
    '',
    'Gene Therapy',
    'Our cutting-edge programmes equip the next generation of scientists with the skills to revolutionise genetic medicine.',
    'Explore Programmes',
    'academics.php',
    2
]);

$stmt->execute([
    'https://images.unsplash.com/photo-1559757175-5700dde675bc?w=1920&q=80',
    'Admissions Open for',
    '',
    '2026/2027',
    'Join a vibrant community of researchers and scholars pushing the boundaries of biomedical science and technology.',
    'Apply Now',
    'apply.php',
    3
]);

echo "Done! 3 hero slides inserted. Now delete this file.";
