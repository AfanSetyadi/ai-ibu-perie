<?php
require_once __DIR__ . '/includes/db.php';

header('Content-Type: application/json');

$result = [
    'status'    => 'error',
    'host'      => DB_HOST,
    'port'      => DB_PORT,
    'database'  => DB_NAME,
    'user'      => DB_USER,
    'message'   => '',
    'version'   => '',
    'timestamp' => date('Y-m-d H:i:s'),
];

try {
    $pdo = getDB();
    $version = $pdo->query('SELECT version()')->fetchColumn();

    $result['status']  = 'ok';
    $result['message'] = 'Connection successful';
    $result['version'] = $version;
} catch (PDOException $e) {
    http_response_code(500);
    $result['message'] = $e->getMessage();
}

echo json_encode($result, JSON_PRETTY_PRINT);
