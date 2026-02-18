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
if (!$input) {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid JSON']);
    exit;
}

$required = ['nama_pasien', 'no_rm', 'tanggal', 'penilai'];
foreach ($required as $field) {
    if (empty($input[$field])) {
        http_response_code(400);
        echo json_encode(['error' => "Field '$field' wajib diisi"]);
        exit;
    }
}

$skriningId = !empty($input['skrining_id']) ? (int)$input['skrining_id'] : null;
$scores = $input['scores'] ?? [];
$totalSkor = (int)($input['total_skor'] ?? 0);
$skorMaksimal = (int)($input['skor_maksimal'] ?? 72);
$persentase = (int)($input['persentase'] ?? 0);

try {
    $db = getDB();
    $sql = "INSERT INTO checklist_resusitasi 
            (skrining_id, nama_pasien, no_rm, tanggal, penilai, scores, total_skor, skor_maksimal, persentase, catatan, created_by)
            VALUES (:skrining_id, :nama_pasien, :no_rm, :tanggal, :penilai, :scores, :total_skor, :skor_maksimal, :persentase, :catatan, :created_by)
            RETURNING id, created_at";

    $stmt = $db->prepare($sql);
    $stmt->execute([
        ':skrining_id' => $skriningId,
        ':nama_pasien' => trim($input['nama_pasien']),
        ':no_rm' => trim($input['no_rm']),
        ':tanggal' => $input['tanggal'],
        ':penilai' => trim($input['penilai']),
        ':scores' => json_encode($scores),
        ':total_skor' => $totalSkor,
        ':skor_maksimal' => $skorMaksimal,
        ':persentase' => $persentase,
        ':catatan' => $input['catatan'] ?? null,
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
