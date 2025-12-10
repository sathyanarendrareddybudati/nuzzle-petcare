<?php
namespace App\Core;

use PDO;
use PDOException;
use Exception;

class Database
{
    private static ?Database $instance = null;
    private ?PDO $pdo = null;

    private function __construct()
    {
        $host = $_ENV['MASTER_DB_HOST'] ?? 'localhost';
        $port = $_ENV['MASTER_DB_PORT'] ?? '3306';
        $db   = $_ENV['MASTER_DB_NAME'] ?? 'petcare';
        $user = $_ENV['MASTER_DB_USER'] ?? 'root';
        $pass = $_ENV['MASTER_DB_PASSWORD'] ?? '';

        $dsn = "mysql:host={$host};port={$port};dbname={$db};charset=utf8mb4";
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ];
        try {
            $this->pdo = new PDO($dsn, $user, $pass, $options);
        } catch (PDOException $e) {
            if (($_ENV['APP_ENV'] ?? '') === 'development') {
                throw new Exception('DB connection failed: ' . $e->getMessage());
            }
            throw new Exception('Database connection failed.');
        }
    }

    public static function pdo(): PDO
    {
        if (!self::$instance) {
            self::$instance = new self();
        }
        return self::$instance->pdo;
    }
}
