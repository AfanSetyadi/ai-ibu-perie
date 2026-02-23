<?php
require_once '../includes/config.php';
requireLogin();

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed']);
    exit();
}

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
$klasifikasi = $input['klasifikasi_risiko'] ?? '';
$faktorRendah = $input['faktor_rendah'] ?? [];
$faktorMedium = $input['faktor_medium'] ?? [];
$faktorTinggi = $input['faktor_tinggi'] ?? [];

if (empty($namaIbu) || empty($klasifikasi)) {
    http_response_code(400);
    echo json_encode(['error' => 'Data tidak lengkap']);
    exit();
}

$apiKey = OPENAI_API_KEY;
$model = OPENAI_MODEL;

$rendahStr = !empty($faktorRendah) ? implode(', ', $faktorRendah) : 'Tidak ada';
$mediumStr = !empty($faktorMedium) ? implode(', ', $faktorMedium) : 'Tidak ada';
$tinggiStr = !empty($faktorTinggi) ? implode(', ', $faktorTinggi) : 'Tidak ada';

$rekomendasiProtokol = '';
if ($klasifikasi === 'RENDAH') {
    $rekomendasiProtokol = "
REKOMENDASI WAJIB untuk RISIKO RENDAH:
• Pemantauan proses persalinan secara rutin
• Awasi perdarahan dengan perawatan kebidanan rutin";
} elseif ($klasifikasi === 'SEDANG') {
    $rekomendasiProtokol = "
REKOMENDASI WAJIB untuk RISIKO SEDANG:
• Pemantauan proses persalinan secara ketat
• Lakukan pengambilan sampel darah untuk persiapan tranfusi
• Notifikasi Tim Respon Awal Emergensi — PPA yang terlibat dalam penanganan lanjut perdarahan harus bersiap siaga";
} elseif ($klasifikasi === 'TINGGI') {
    $rekomendasiProtokol = "
REKOMENDASI WAJIB untuk RISIKO TINGGI:
• Pemantauan proses persalinan secara intensif
• Lakukan pengambilan sampel darah untuk persiapan tranfusi
• Notifikasi DAN Aktifasi Tim Respon Awal Emergensi
• Siapkan tim dan fasilitas untuk penanganan darurat perdarahan";
}

$prompt = "Kamu adalah seorang asisten medis ahli di bidang obstetri di RSUD RTN Sidoarjo. Berdasarkan data skrining HPP (Hemorrhage Post Partum) berikut, buatkan rekomendasi klinis yang komprehensif dan profesional dalam Bahasa Indonesia.

DATA SKRINING HPP:
- Nama Ibu: {$namaIbu}
- No. Rekam Medis: {$noRM}
- Hari/Tanggal: {$tanggal}
- Diagnosa Ibu: {$diagnosaIbu}
- Klasifikasi Risiko: {$klasifikasi}
- Faktor Risiko Rendah: {$rendahStr}
- Faktor Risiko Medium: {$mediumStr}
- Faktor Risiko Tinggi: {$tinggiStr}
{$rekomendasiProtokol}

Buatkan rekomendasi yang mencakup:
1. Ringkasan faktor risiko yang teridentifikasi
2. Klasifikasi risiko HPP dan penjelasannya
3. Rekomendasi penanganan dan tindak lanjut — WAJIB mencantumkan semua poin rekomendasi sesuai tingkat risiko di atas
4. Hal-hal yang perlu diwaspadai terkait risiko perdarahan post partum

Format output sebagai teks naratif profesional medis (bukan dalam format markdown/bullet point). Tulis langsung rekomendasinya tanpa pembuka seperti 'Berikut rekomendasi...' dll.";

$postData = [
    'model' => $model,
    'messages' => [
        [
            'role' => 'system',
            'content' => 'Kamu adalah asisten medis ahli obstetri yang memberikan rekomendasi skrining HPP (Hemorrhage Post Partum) secara profesional, akurat, dan komprehensif dalam Bahasa Indonesia.'
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
$rekomendasi = $responseData['choices'][0]['message']['content'] ?? '';

if (empty($rekomendasi)) {
    http_response_code(500);
    echo json_encode(['error' => 'AI tidak menghasilkan rekomendasi']);
    exit();
}

echo json_encode([
    'success' => true,
    'rekomendasi' => trim($rekomendasi)
]);
?>
