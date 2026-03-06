<?php
/**
 * AJAX endpoint — reorder sortable items.
 *
 * Expects JSON POST: { "table": "hero_slides", "order": [{"id":1,"sort_order":0}, ...] }
 */

require_once __DIR__ . '/../../includes/auth.php';
require_once __DIR__ . '/../../includes/db.php';

startSession();

header('Content-Type: application/json');

// Must be logged in
if (!isLoggedIn()) {
    http_response_code(401);
    echo json_encode(['error' => 'Unauthorized']);
    exit;
}

// Only accept POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed']);
    exit;
}

$data = json_decode(file_get_contents('php://input'), true);

if (!$data || empty($data['table']) || empty($data['order']) || !is_array($data['order'])) {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid request body']);
    exit;
}

// Whitelist of allowed tables
$allowed = ['hero_slides', 'programmes', 'testimonials', 'staff'];

$table = $data['table'];

if (!in_array($table, $allowed, true)) {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid table name']);
    exit;
}

try {
    $pdo  = getDB();
    $stmt = $pdo->prepare("UPDATE {$table} SET sort_order = ? WHERE id = ?");

    $pdo->beginTransaction();
    foreach ($data['order'] as $item) {
        $id   = (int) ($item['id'] ?? 0);
        $sort = (int) ($item['sort_order'] ?? 0);
        if ($id > 0) {
            $stmt->execute([$sort, $id]);
        }
    }
    $pdo->commit();

    echo json_encode(['success' => true]);
} catch (Exception $e) {
    if ($pdo->inTransaction()) {
        $pdo->rollBack();
    }
    http_response_code(500);
    echo json_encode(['error' => 'Database error']);
}
