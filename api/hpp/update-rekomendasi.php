<?php
ob_start();
require_once __DIR__ . '/../../includes/db.php';
ob_end_clean();

header('Content-Type: application/json; charset=utf-8');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed']);
    exit;
}

if (!isset($_SESSION['isLoggedIn']) || !$_SESSION['isLoggedIn']) {
    http_response_code(401);
    echo json_encode(['error' => 'Unauthorized']);
    exit;
}

$input = json_decode(file_get_contents('php://input'), true);
$id = isset($input['id']) ? (int)$input['id'] : 0;
$rekomendasi = $input['rekomendasi'] ?? '';

if ($id <= 0 || empty($rekomendasi)) {
    http_response_code(400);
    echo json_encode(['error' => 'ID dan rekomendasi wajib diisi']);
    exit;
}

try {
    $db = getDB();
    $stmt = $db->prepare("UPDATE skrining_hpp SET rekomendasi = :rekomendasi, updated_at = CURRENT_TIMESTAMP WHERE id = :id");
    $stmt->execute([':rekomendasi' => $rekomendasi, ':id' => $id]);

    echo json_encode(['success' => true]);

} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Gagal menyimpan: ' . $e->getMessage()]);
}
