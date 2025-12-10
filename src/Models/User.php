<?php
namespace App\Models;

use App\Core\Database;
use PDO;
use Exception;

class User
{
    private PDO $db;
    private string $table = 'users';

    public function __construct()
    {
        $this->db = Database::pdo();
    }

    public function create(array $data)
    {
        $roleId = (int)($data['role_id'] ?? 0);
        if (!in_array($roleId, [2, 3], true)) {
            throw new Exception('Invalid role_id provided');
        }

        $sql = "INSERT INTO {$this->table} (role_id, name, email, password, phone_number, location_id)
                VALUES (:role_id, :name, :email, :password, :phone_number, :location_id)";
        $stmt = $this->db->prepare($sql);

        $hashed = password_hash($data['password'], PASSWORD_BCRYPT);

        $stmt->execute([
            ':role_id' => $roleId,
            ':name' => $data['name'],
            ':email' => $data['email'],
            ':password' => $hashed,
            ':phone_number' => $data['phone'] ?? null,
            ':location_id' => $data['location_id'] ?? 1,
        ]);

        return (int)$this->db->lastInsertId();
    }

    public function getByEmail(string $email): ?array
    {
        $sql = "SELECT u.*, r.name as role_name
                FROM {$this->table} u
                LEFT JOIN roles r ON u.role_id = r.id
                WHERE u.email = ?
                LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$email]);
        $row = $stmt->fetch();
        return $row ?: null;
    }

    public function getById(int $id): ?array
    {
        $sql = "SELECT u.*, r.name as role_name
                FROM {$this->table} u
                LEFT JOIN roles r ON u.role_id = r.id
                WHERE u.id = ?
                LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);
        $row = $stmt->fetch();
        return $row ?: null;
    }

    public function verifyCredentials(string $email, string $password)
    {
        $user = $this->getByEmail($email);
        if ($user && password_verify($password, $user['password'])) {
            unset($user['password']);
            return $user;
        }
        return false;
    }

    public function emailExists(string $email): bool
    {
        $stmt = $this->db->prepare("SELECT id FROM {$this->table} WHERE email = ? LIMIT 1");
        $stmt->execute([$email]);
        return (bool)$stmt->fetchColumn();
    }
}
