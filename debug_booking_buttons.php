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
    $sql = "SELECT b.id, b.pet_ad_id, b.provider_id, b.client_id, b.status, pa.ad_type 
            FROM bookings b 
            LEFT JOIN pet_ads pa ON b.pet_ad_id = pa.id 
            ORDER BY b.id DESC LIMIT 5";
    $stmt = $pdo->query($sql);
    print_r($stmt->fetchAll(PDO::FETCH_ASSOC));
} catch (Exception $e) {
    echo $e->getMessage();
}
