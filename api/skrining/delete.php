<?php
require_once __DIR__ . '/../../includes/db.php';

header('Content-Type: application/json');

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
$id = (int)($input['id'] ?? 0);

if ($id <= 0) {
    http_response_code(400);
    echo json_encode(['error' => 'ID tidak valid']);
    exit;
}

try {
    $db = getDB();
    $stmt = $db->prepare("DELETE FROM skrining_admisi WHERE id = :id");
    $stmt->execute([':id' => $id]);

    if ($stmt->rowCount() === 0) {
        http_response_code(404);
        echo json_encode(['error' => 'Data tidak ditemukan']);
        exit;
    }

    echo json_encode(['success' => true]);

} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Gagal menghapus: ' . $e->getMessage()]);
}
