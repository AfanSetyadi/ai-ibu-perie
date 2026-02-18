<?php
require_once __DIR__ . '/../../includes/db.php';

header('Content-Type: application/json');

if (!isset($_SESSION['isLoggedIn']) || !$_SESSION['isLoggedIn']) {
    http_response_code(401);
    echo json_encode(['error' => 'Unauthorized']);
    exit;
}

$tipeFaskes = $_GET['tipe_faskes'] ?? 'rs';
if (!in_array($tipeFaskes, ['rs', 'puskesmas'], true)) {
    $tipeFaskes = 'rs';
}

$search = trim($_GET['search'] ?? '');
$filterMaternal = $_GET['maternal'] ?? '';
$filterJanin = $_GET['janin'] ?? '';
$page = max(1, (int)($_GET['page'] ?? 1));
$limit = min(100, max(10, (int)($_GET['limit'] ?? 50)));
$offset = ($page - 1) * $limit;

try {
    $db = getDB();

    $where = ["tipe_faskes = :tipe_faskes"];
    $params = [':tipe_faskes' => $tipeFaskes];

    if ($search !== '') {
        $where[] = "(LOWER(nama_ibu) LIKE :search OR no_rm LIKE :search_rm OR LOWER(diagnosa_ibu) LIKE :search_diag)";
        $params[':search'] = '%' . strtolower($search) . '%';
        $params[':search_rm'] = '%' . $search . '%';
        $params[':search_diag'] = '%' . strtolower($search) . '%';
    }

    $validRisiko = ['RENDAH', 'SEDANG', 'TINGGI'];
    if ($filterMaternal && in_array($filterMaternal, $validRisiko, true)) {
        $where[] = "aspek_maternal = :maternal";
        $params[':maternal'] = $filterMaternal;
    }
    if ($filterJanin && in_array($filterJanin, $validRisiko, true)) {
        $where[] = "aspek_janin = :janin";
        $params[':janin'] = $filterJanin;
    }

    $whereClause = implode(' AND ', $where);

    $countStmt = $db->prepare("SELECT COUNT(*) FROM skrining_admisi WHERE $whereClause");
    $countStmt->execute($params);
    $total = (int)$countStmt->fetchColumn();

    $sql = "SELECT id, nama_ibu, no_rm, tanggal, diagnosa_ibu, aspek_maternal, aspek_janin, aspek_penyulit, kesimpulan, created_at
            FROM skrining_admisi 
            WHERE $whereClause
            ORDER BY created_at DESC
            LIMIT :limit OFFSET :offset";

    $stmt = $db->prepare($sql);
    foreach ($params as $key => $val) {
        $stmt->bindValue($key, $val);
    }
    $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
    $stmt->execute();

    $data = $stmt->fetchAll();

    // Summary counts (unfiltered for this tipe_faskes)
    $summaryStmt = $db->prepare("
        SELECT 
            COUNT(*) as total,
            COUNT(*) FILTER (WHERE aspek_maternal = 'RENDAH') as rendah,
            COUNT(*) FILTER (WHERE aspek_maternal = 'SEDANG') as sedang,
            COUNT(*) FILTER (WHERE aspek_maternal = 'TINGGI') as tinggi
        FROM skrining_admisi 
        WHERE tipe_faskes = :tipe_faskes
    ");
    $summaryStmt->execute([':tipe_faskes' => $tipeFaskes]);
    $summary = $summaryStmt->fetch();

    echo json_encode([
        'success' => true,
        'data' => $data,
        'total' => $total,
        'page' => $page,
        'limit' => $limit,
        'summary' => $summary,
    ]);

} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Gagal memuat data: ' . $e->getMessage()]);
}
