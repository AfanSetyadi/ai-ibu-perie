<?php
require_once '../includes/config.php';
requireLogin();

// Set response header
header('Content-Type: application/json');

// Only accept POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed']);
    exit();
}

// Get POST data
$input = json_decode(file_get_contents('php://input'), true);

if (!$input) {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid JSON input']);
    exit();
}

$namaIbu = $input['nama_ibu'] ?? '';
$noRM = $input['no_rm'] ?? '';
$tanggal = $input['tanggal'] ?? '';
$diagnosaIbu = $input['diagnosa_ibu'] ?? '';
$aspekMaternal = $input['aspek_maternal'] ?? '';
$aspekJanin = $input['aspek_janin'] ?? '';
$aspekPenyulit = $input['aspek_penyulit'] ?? '';
$tipeFaskes = $input['tipe_faskes'] ?? 'rs';

// Validate
if (empty($namaIbu) || empty($noRM) || empty($tanggal) || empty($diagnosaIbu) || empty($aspekMaternal) || empty($aspekJanin) || empty($aspekPenyulit)) {
    http_response_code(400);
    echo json_encode(['error' => 'Semua field harus diisi']);
    exit();
}

// Determine facility context based on tipe_faskes
if ($tipeFaskes === 'puskesmas') {
    $namaFaskes = 'Puskesmas';
    $konteksFaskes = 'di Puskesmas';
    $roleDesc = 'seorang asisten medis ahli di bidang obstetri dan perinatologi di Puskesmas';
} else {
    $namaFaskes = 'RSUD RTN Sidoarjo';
    $konteksFaskes = 'di RSUD RTN Sidoarjo';
    $roleDesc = 'seorang asisten medis ahli di bidang obstetri dan perinatologi di RSUD RTN Sidoarjo';
}

// OpenAI API Configuration (loaded from .env via config.php)
$apiKey = OPENAI_API_KEY;
$model = OPENAI_MODEL;

$prompt = "Kamu adalah {$roleDesc}. Berdasarkan data skrining admisi berikut, buatkan kesimpulan klinis yang komprehensif dan profesional dalam Bahasa Indonesia.

DATA SKRINING ADMISI ({$namaFaskes}):
- Nama Ibu: {$namaIbu}
- No. Rekam Medis: {$noRM}
- Hari/Tanggal: {$tanggal}
- Diagnosa Ibu: {$diagnosaIbu}
- Aspek Maternal: Risiko {$aspekMaternal}
- Aspek Janin: Risiko {$aspekJanin}
- Aspek Penyulit: Risiko {$aspekPenyulit}

Buatkan kesimpulan yang mencakup:
1. Ringkasan kondisi pasien
2. Analisis tingkat risiko keseluruhan berdasarkan ketiga aspek (maternal, janin, penyulit)
3. Rekomendasi penanganan dan tindak lanjut yang sesuai
4. Hal-hal yang perlu diwaspadai

Format output sebagai teks naratif profesional medis (bukan dalam format markdown/bullet point). Tulis langsung kesimpulannya tanpa pembuka seperti 'Berikut kesimpulan...' dll.";

// Call OpenAI API
$postData = [
    'model' => $model,
    'messages' => [
        [
            'role' => 'system',
            'content' => 'Kamu adalah asisten medis ahli perinatologi yang memberikan kesimpulan skrining admisi secara profesional, akurat, dan komprehensif dalam Bahasa Indonesia.'
        ],
        [
            'role' => 'user',
            'content' => $prompt
        ]
    ],
    'temperature' => 0.7,
    'max_tokens' => 1000
];

$ch = curl_init('https://api.openai.com/v1/chat/completions');
curl_setopt_array($ch, [
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_POST => true,
    CURLOPT_HTTPHEADER => [
        'Content-Type: application/json',
        'Authorization: Bearer ' . $apiKey
    ],
    CURLOPT_POSTFIELDS => json_encode($postData),
    CURLOPT_TIMEOUT => 60,
    CURLOPT_SSL_VERIFYPEER => false
]);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$curlError = curl_error($ch);
curl_close($ch);

if ($curlError) {
    http_response_code(500);
    echo json_encode(['error' => 'Gagal menghubungi server AI: ' . $curlError]);
    exit();
}

if ($httpCode !== 200) {
    $errorData = json_decode($response, true);
    $errorMsg = $errorData['error']['message'] ?? 'Unknown error from OpenAI API';
    http_response_code(500);
    echo json_encode(['error' => 'Error dari AI: ' . $errorMsg]);
    exit();
}

$responseData = json_decode($response, true);
$kesimpulan = $responseData['choices'][0]['message']['content'] ?? '';

if (empty($kesimpulan)) {
    http_response_code(500);
    echo json_encode(['error' => 'AI tidak menghasilkan kesimpulan']);
    exit();
}

echo json_encode([
    'success' => true,
    'kesimpulan' => trim($kesimpulan)
]);
?>
