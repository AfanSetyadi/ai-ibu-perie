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
if (!is_array($input)) {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid JSON body']);
    exit;
}

$id = filter_var($input['id'] ?? null, FILTER_VALIDATE_INT);
$kesimpulan = trim($input['kesimpulan'] ?? '');

if (!$id || empty($kesimpulan)) {
    http_response_code(400);
    echo json_encode(['error' => 'Field id dan kesimpulan wajib diisi']);
    exit;
}

try {
    $db = getDB();
    $stmt = $db->prepare("
        UPDATE skrining_admisi 
        SET kesimpulan = :kesimpulan, updated_at = CURRENT_TIMESTAMP 
        WHERE id = :id
    ");
    $stmt->execute([
        ':kesimpulan' => $kesimpulan,
        ':id' => $id,
    ]);

    if ($stmt->rowCount() === 0) {
        http_response_code(404);
        echo json_encode(['error' => 'Data skrining tidak ditemukan']);
        exit;
    }

    echo json_encode(['success' => true, 'id' => $id]);

} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Gagal update kesimpulan: ' . $e->getMessage()]);
}
