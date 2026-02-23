<?php
ob_start();
require_once __DIR__ . '/../../includes/db.php';
ob_end_clean();

header('Content-Type: application/json; charset=utf-8');

if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed']);
    exit;
}

if (!isset($_SESSION['isLoggedIn']) || !$_SESSION['isLoggedIn']) {
    http_response_code(401);
    echo json_encode(['error' => 'Unauthorized']);
    exit;
}

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($id <= 0) {
    http_response_code(400);
    echo json_encode(['error' => 'ID tidak valid']);
    exit;
}

try {
    $db = getDB();
    $stmt = $db->prepare("
        SELECT id, nama_ibu, no_rm, tanggal, diagnosa_ibu,
               faktor_rendah, faktor_medium, faktor_tinggi,
               klasifikasi_risiko, rekomendasi, created_by, created_at
        FROM skrining_hpp
        WHERE id = :id
    ");
    $stmt->execute([':id' => $id]);
    $row = $stmt->fetch();

    if (!$row) {
        http_response_code(404);
        echo json_encode(['error' => 'Data tidak ditemukan']);
        exit;
    }

    $row['faktor_rendah'] = json_decode($row['faktor_rendah'], true) ?: [];
    $row['faktor_medium'] = json_decode($row['faktor_medium'], true) ?: [];
    $row['faktor_tinggi'] = json_decode($row['faktor_tinggi'], true) ?: [];

    echo json_encode([
        'success' => true,
        'data' => $row,
    ]);

} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Gagal memuat data: ' . $e->getMessage()]);
}
