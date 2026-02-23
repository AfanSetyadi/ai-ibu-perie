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
if (!is_array($input) || empty($input)) {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid JSON body']);
    exit;
}

$required = ['nama_ibu', 'no_rm', 'tanggal', 'diagnosa_ibu', 'klasifikasi_risiko'];
foreach ($required as $field) {
    if (empty($input[$field])) {
        http_response_code(400);
        echo json_encode(['error' => "Field '$field' wajib diisi"]);
        exit;
    }
}

$validRisiko = ['RENDAH', 'SEDANG', 'TINGGI'];
if (!in_array($input['klasifikasi_risiko'], $validRisiko, true)) {
    http_response_code(400);
    echo json_encode(['error' => 'Klasifikasi risiko tidak valid']);
    exit;
}

try {
    $db = getDB();
    $sql = "INSERT INTO skrining_hpp
            (nama_ibu, no_rm, tanggal, diagnosa_ibu, faktor_rendah, faktor_medium, faktor_tinggi, klasifikasi_risiko, rekomendasi, created_by)
            VALUES (:nama_ibu, :no_rm, :tanggal, :diagnosa_ibu, :faktor_rendah, :faktor_medium, :faktor_tinggi, :klasifikasi_risiko, :rekomendasi, :created_by)
            RETURNING id, created_at";

    $stmt = $db->prepare($sql);
    $stmt->execute([
        ':nama_ibu' => trim($input['nama_ibu']),
        ':no_rm' => trim($input['no_rm']),
        ':tanggal' => $input['tanggal'],
        ':diagnosa_ibu' => trim($input['diagnosa_ibu']),
        ':faktor_rendah' => json_encode($input['faktor_rendah'] ?? []),
        ':faktor_medium' => json_encode($input['faktor_medium'] ?? []),
        ':faktor_tinggi' => json_encode($input['faktor_tinggi'] ?? []),
        ':klasifikasi_risiko' => $input['klasifikasi_risiko'],
        ':rekomendasi' => $input['rekomendasi'] ?? null,
        ':created_by' => $_SESSION['username'] ?? null,
    ]);

    $row = $stmt->fetch();

    echo json_encode([
        'success' => true,
        'id' => (int)$row['id'],
        'created_at' => $row['created_at'],
    ]);

} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Gagal menyimpan: ' . $e->getMessage()]);
}
