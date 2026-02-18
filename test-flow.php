<?php
/**
 * Test script for login, API list, and data page flow.
 * Run: php test-flow.php
 * Or visit: http://localhost/ai-ibu-perie/test-flow.php
 */

$baseUrl = 'http://localhost/ai-ibu-perie';
$username = 'admin';
$password = 'rsudsda2026';

$results = [
    'login' => null,
    'api_list' => null,
    'data_page' => null,
];

// Use stream context for session-like cookie handling
$cookieFile = sys_get_temp_dir() . '/ai-ibu-perie-test-cookies.txt';
if (file_exists($cookieFile)) @unlink($cookieFile);

$ch = curl_init();
curl_setopt_array($ch, [
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_COOKIEJAR => $cookieFile,
    CURLOPT_COOKIEFILE => $cookieFile,
    CURLOPT_TIMEOUT => 30,
]);

// Step 1 & 2: Get login page
curl_setopt($ch, CURLOPT_URL, $baseUrl . '/login.php');
$loginPage = curl_exec($ch);
$loginHttpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

$results['login'] = [
    'http_code' => $loginHttpCode,
    'has_form' => (strpos($loginPage, 'name="username"') !== false && strpos($loginPage, 'name="password"') !== false),
    'page_length' => strlen($loginPage),
];

// Step 3: Login POST
curl_setopt($ch, CURLOPT_URL, $baseUrl . '/login_process.php');
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query([
    'username' => $username,
    'password' => $password,
]));
$loginResponse = curl_exec($ch);
$loginResponseCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$redirectUrl = curl_getinfo($ch, CURLINFO_REDIRECT_URL);

$results['login']['post_code'] = $loginResponseCode;
$results['login']['redirect_to'] = $redirectUrl ?: 'dashboard.php (from Location header)';
$results['login']['success'] = ($loginResponseCode === 200 || $loginResponseCode === 302) && 
    (strpos($loginResponse, 'dashboard') !== false || $redirectUrl !== '');

// Step 4 & 5: Call API list
curl_setopt($ch, CURLOPT_URL, $baseUrl . '/api/skrining/list.php?tipe_faskes=rs');
curl_setopt($ch, CURLOPT_POST, false);
curl_setopt($ch, CURLOPT_HTTPGET, true);
$apiResponse = curl_exec($ch);
$apiHttpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

$results['api_list'] = [
    'http_code' => $apiHttpCode,
    'raw_response' => $apiResponse,
];

$apiJson = json_decode($apiResponse, true);
if (json_last_error() === JSON_ERROR_NONE) {
    $results['api_list']['parsed'] = $apiJson;
} else {
    $results['api_list']['parse_error'] = json_last_error_msg();
}

// Step 6 & 7: Get data page
curl_setopt($ch, CURLOPT_URL, $baseUrl . '/data-skrining-admisi-rs.php');
$dataPageResponse = curl_exec($ch);
$dataPageHttpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

$results['data_page'] = [
    'http_code' => $dataPageHttpCode,
    'redirected_to_login' => (strpos($dataPageResponse, 'login.php') !== false && strpos($dataPageResponse, 'Masuk ke Sistem') !== false),
    'has_table' => (strpos($dataPageResponse, 'id="tableSkrining"') !== false),
    'has_memuat' => (strpos($dataPageResponse, 'Memuat data') !== false),
    'has_error' => (strpos($dataPageResponse, 'Gagal memuat') !== false || strpos($dataPageResponse, 'error') !== false),
    'page_preview' => substr(strip_tags($dataPageResponse), 0, 500),
];

curl_close($ch);
@unlink($cookieFile);

// Output as JSON for easy parsing
header('Content-Type: application/json; charset=utf-8');
echo json_encode($results, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
