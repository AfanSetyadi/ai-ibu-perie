<?php
/**
 * Creates the database if it doesn't exist.
 * Run once before migrate.php
 */
require_once __DIR__ . '/../includes/config.php';

$dsn = sprintf('pgsql:host=%s;port=%s;dbname=postgres', DB_HOST, DB_PORT);

try {
    $pdo = new PDO($dsn, DB_USER, DB_PASS, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    ]);

    $stmt = $pdo->prepare("SELECT 1 FROM pg_database WHERE datname = :dbname");
    $stmt->execute([':dbname' => DB_NAME]);

    if ($stmt->fetchColumn()) {
        echo "Database '" . DB_NAME . "' already exists.\n";
    } else {
        $pdo->exec("CREATE DATABASE " . DB_NAME);
        echo "Database '" . DB_NAME . "' created successfully.\n";
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage() . "\n";
    exit(1);
}
