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

try {
    $db = getDB();

    $where = [];
    $params = [];

    if (!empty($_GET['search'])) {
        $search = '%' . trim($_GET['search']) . '%';
        $where[] = "(nama_ibu ILIKE :search OR no_rm ILIKE :search2 OR diagnosa_ibu ILIKE :search3)";
        $params[':search'] = $search;
        $params[':search2'] = $search;
        $params[':search3'] = $search;
    }

    if (!empty($_GET['risiko']) && in_array($_GET['risiko'], ['RENDAH', 'SEDANG', 'TINGGI'], true)) {
        $where[] = "klasifikasi_risiko = :risiko";
        $params[':risiko'] = $_GET['risiko'];
    }

    $whereClause = $where ? 'WHERE ' . implode(' AND ', $where) : '';

    $sql = "SELECT id, nama_ibu, no_rm, tanggal, diagnosa_ibu, klasifikasi_risiko, created_at
            FROM skrining_hpp
            $whereClause
            ORDER BY created_at DESC";

    $stmt = $db->prepare($sql);
    $stmt->execute($params);
    $data = $stmt->fetchAll();

    $summaryStmt = $db->query("
        SELECT
            COUNT(*) AS total,
            COUNT(*) FILTER (WHERE klasifikasi_risiko = 'RENDAH') AS rendah,
            COUNT(*) FILTER (WHERE klasifikasi_risiko = 'SEDANG') AS sedang,
            COUNT(*) FILTER (WHERE klasifikasi_risiko = 'TINGGI') AS tinggi
        FROM skrining_hpp
    ");
    $summary = $summaryStmt->fetch();

    echo json_encode([
        'success' => true,
        'data' => $data,
        'summary' => $summary,
    ]);

} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Gagal memuat data: ' . $e->getMessage()]);
}
