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
    $sql = "
        SELECT
            s.id,
            s.nama_ibu,
            s.no_rm,
            s.tanggal,
            s.diagnosa_ibu,
            s.aspek_maternal,
            s.aspek_janin,
            s.aspek_penyulit,
            s.kesimpulan,
            s.tipe_faskes,
            s.created_by,
            s.created_at,
            s.updated_at,
            c.id AS checklist_id,
            c.penilai AS checklist_penilai,
            c.scores AS checklist_scores,
            c.total_skor AS checklist_total_skor,
            c.skor_maksimal AS checklist_skor_maksimal,
            c.persentase AS checklist_persentase,
            c.catatan AS checklist_catatan,
            c.created_at AS checklist_created_at
        FROM skrining_admisi s
        LEFT JOIN LATERAL (
            SELECT
                id,
                penilai,
                scores,
                total_skor,
                skor_maksimal,
                persentase,
                catatan,
                created_at
            FROM checklist_resusitasi
            WHERE skrining_id = s.id
            ORDER BY created_at DESC
            LIMIT 1
        ) c ON true
        WHERE s.id = :id
    ";

    $stmt = $db->prepare($sql);
    $stmt->execute([':id' => $id]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$row) {
        http_response_code(404);
        echo json_encode(['error' => 'Data tidak ditemukan']);
        exit;
    }

    $checklist = null;
    if (!empty($row['checklist_id'])) {
        $scores = [];
        if (!empty($row['checklist_scores'])) {
            $decoded = json_decode($row['checklist_scores'], true);
            if (is_array($decoded)) {
                $scores = $decoded;
            }
        }

        $checklist = [
            'id' => (int)$row['checklist_id'],
            'penilai' => (string)($row['checklist_penilai'] ?? ''),
            'scores' => $scores,
            'total_skor' => (int)($row['checklist_total_skor'] ?? 0),
            'skor_maksimal' => (int)($row['checklist_skor_maksimal'] ?? 72),
            'persentase' => (int)($row['checklist_persentase'] ?? 0),
            'catatan' => $row['checklist_catatan'],
            'created_at' => $row['checklist_created_at'],
        ];
    }

    $data = [
        'id' => (int)$row['id'],
        'nama_ibu' => $row['nama_ibu'],
        'no_rm' => $row['no_rm'],
        'tanggal' => $row['tanggal'],
        'diagnosa_ibu' => $row['diagnosa_ibu'],
        'aspek_maternal' => $row['aspek_maternal'],
        'aspek_janin' => $row['aspek_janin'],
        'aspek_penyulit' => $row['aspek_penyulit'],
        'kesimpulan' => $row['kesimpulan'],
        'tipe_faskes' => $row['tipe_faskes'],
        'created_by' => $row['created_by'],
        'created_at' => $row['created_at'],
        'updated_at' => $row['updated_at'],
        'checklist' => $checklist,
    ];

    echo json_encode(['success' => true, 'data' => $data]);

} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Gagal memuat data: ' . $e->getMessage()]);
}
