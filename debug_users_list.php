<?php
require __DIR__ . '/vendor/autoload.php';
use Dotenv\Dotenv;
use App\Core\Database;

if (file_exists(__DIR__ . '/.env')) {
    $dotenv = Dotenv::createImmutable(__DIR__);
    $dotenv->load();
}

try {
    $pdo = Database::pdo();
    $stmt = $pdo->query("SELECT id, name, email FROM users");
    print_r($stmt->fetchAll(PDO::FETCH_ASSOC));
} catch (Exception $e) {
    echo $e->getMessage();
}
