<?php
require_once __DIR__ . '/../../includes/db.php';

header('Content-Type: application/json');

if (!isset($_SESSION['isLoggedIn']) || !$_SESSION['isLoggedIn']) {
    http_response_code(401);
    echo json_encode(['error' => 'Unauthorized']);
    exit;
}

$id = (int)($_GET['id'] ?? 0);
if ($id <= 0) {
    http_response_code(400);
    echo json_encode(['error' => 'ID tidak valid']);
    exit;
}

try {
    $db = getDB();
    $stmt = $db->prepare("SELECT * FROM skrining_admisi WHERE id = :id");
    $stmt->execute([':id' => $id]);
    $row = $stmt->fetch();

    if (!$row) {
        http_response_code(404);
        echo json_encode(['error' => 'Data tidak ditemukan']);
        exit;
    }

    echo json_encode(['success' => true, 'data' => $row]);

} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Gagal memuat data: ' . $e->getMessage()]);
}
