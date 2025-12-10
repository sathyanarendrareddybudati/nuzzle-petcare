<?php
// Load bootstrap file
require_once __DIR__ . '/../bootstrap/app.php';

class Database {
    private $host;
    private $db_name;
    private $username;
    private $password;
    private $conn;
    private static $instance = null;

    private function __construct() {
        $this->host = $_ENV['MASTER_DB_HOST'] ?? 'localhost';
        $this->db_name = $_ENV['MASTER_DB_NAME'] ?? 'sys';
        $this->username = $_ENV['MASTER_DB_USER'] ?? 'root';
        $this->password = $_ENV['MASTER_DB_PASSWORD'] ?? 'Reddy.anshul011';
        $this->connect();
    }

    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function connect() {
    $this->conn = null;

    $required = [
        'MASTER_DB_HOST', 
        'MASTER_DB_NAME', 
        'MASTER_DB_USER', 
        'MASTER_DB_PASSWORD',
        'MASTER_DB_PORT'
    ];
    
    $missing = [];
    foreach ($required as $var) {
        if (!isset($_ENV[$var]) || $_ENV[$var] === '') {
            $missing[] = $var;
        }
    }
    
    if (!empty($missing)) {
        throw new Exception("Missing required database configuration in .env: " . implode(', ', $missing));
    }

    try {
        // MySQL connection string
        $dsn = "mysql:host={$this->host};port={$_ENV['MASTER_DB_PORT']};dbname={$this->db_name};charset=utf8mb4";
        
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
            PDO::ATTR_STRINGIFY_FETCHES => false,
            PDO::ATTR_TIMEOUT => 10,
        ];

        // Add SSL options if enabled
        if (isset($_ENV['DB_SSL']) && $_ENV['DB_SSL'] === 'true') {
            $options[PDO::MYSQL_ATTR_SSL_CA] = true;
            $options[PDO::MYSQL_ATTR_SSL_VERIFY_SERVER_CERT] = $_ENV['DB_SSL_VERIFY'] === 'true';
        }

        $this->conn = new PDO($dsn, $this->username, $this->password, $options);
        
        // Test the connection
        $this->conn->query("SELECT 1")->fetch(PDO::FETCH_ASSOC);
        
    } catch(PDOException $e) {
        $error = "MySQL connection failed: " . $e->getMessage() . "\n";
        $error .= "Connection details: " . 
                 "mysql:host={$this->host};port={$_ENV['MASTER_DB_PORT']};dbname={$this->db_name}" . "\n";
        $error .= "Username: {$this->username}" . "\n";
        $error .= "Password: " . (!empty($this->password) ? "[set]" : "[not set]") . "\n";
        
        error_log($error);
        
        // For development, include more details in the exception
        if (($_ENV['APP_ENV'] ?? '') === 'development') {
            throw new Exception("Database connection failed: " . $e->getMessage() . ". Check the error log for details.");
        } else {
            throw new Exception("Database connection failed. Please check your database configuration and credentials.");
        }
    }
}

    public function getConnection() {
        if ($this->conn === null) {
            $this->connect();
        }
        return $this->conn;
    }

    // Prevent cloning of the instance
    private function __clone() {}

    // Prevent unserializing of the instance
    public function __wakeup() {
        throw new Exception("Cannot unserialize a singleton.");
    }
}

// Helper function to get database connection
function getDbConnection() {
    return Database::getInstance()->getConnection();
}

// Example usage:
// $db = getDbConnection();
// $stmt = $db->query("SELECT * FROM users");
// $users = $stmt->fetchAll();
