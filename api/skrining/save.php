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
    echo json_encode(['error' => 'Unauthorized — sesi login tidak ditemukan']);
    exit;
}

$rawBody = file_get_contents('php://input');
$input = json_decode($rawBody, true);
if (!is_array($input) || empty($input)) {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid JSON body']);
    exit;
}

$required = ['nama_ibu', 'no_rm', 'tanggal', 'diagnosa_ibu', 'aspek_maternal', 'aspek_janin', 'aspek_penyulit', 'tipe_faskes'];
foreach ($required as $field) {
    if (empty($input[$field])) {
        http_response_code(400);
        echo json_encode(['error' => "Field '$field' wajib diisi"]);
        exit;
    }
}

$validRisiko = ['RENDAH', 'SEDANG', 'TINGGI'];
foreach (['aspek_maternal', 'aspek_janin', 'aspek_penyulit'] as $field) {
    if (!in_array($input[$field], $validRisiko, true)) {
        http_response_code(400);
        echo json_encode(['error' => "Nilai '$field' tidak valid"]);
        exit;
    }
}

if (!in_array($input['tipe_faskes'], ['rs', 'puskesmas'], true)) {
    http_response_code(400);
    echo json_encode(['error' => 'tipe_faskes tidak valid']);
    exit;
}

try {
    $db = getDB();
    $sql = "INSERT INTO skrining_admisi 
            (nama_ibu, no_rm, tanggal, diagnosa_ibu, aspek_maternal, aspek_janin, aspek_penyulit, kesimpulan, tipe_faskes, created_by)
            VALUES (:nama_ibu, :no_rm, :tanggal, :diagnosa_ibu, :aspek_maternal, :aspek_janin, :aspek_penyulit, :kesimpulan, :tipe_faskes, :created_by)
            RETURNING id, created_at";

    $stmt = $db->prepare($sql);
    $stmt->execute([
        ':nama_ibu' => trim($input['nama_ibu']),
        ':no_rm' => trim($input['no_rm']),
        ':tanggal' => $input['tanggal'],
        ':diagnosa_ibu' => trim($input['diagnosa_ibu']),
        ':aspek_maternal' => $input['aspek_maternal'],
        ':aspek_janin' => $input['aspek_janin'],
        ':aspek_penyulit' => $input['aspek_penyulit'],
        ':kesimpulan' => $input['kesimpulan'] ?? null,
        ':tipe_faskes' => $input['tipe_faskes'],
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
