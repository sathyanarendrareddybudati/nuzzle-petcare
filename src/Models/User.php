<?php
namespace App\Models;

use App\Core\Model;
use PDO;

class User extends Model
{
    // Updated to join with roles table
    public function verifyCredentials(string $email, string $password): ?array
    {
        $sql = "SELECT u.*, r.name as role_name 
                FROM users u 
                LEFT JOIN roles r ON u.role_id = r.id 
                WHERE u.email = :email";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['email' => $email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            return $user;
        }
        return null;
    }

    // Renamed from getById for consistency
    public function findById(int $id): ?array
    {
        $sql = "SELECT u.*, r.name as role_name
                FROM users u
                LEFT JOIN roles r ON u.role_id = r.id
                WHERE u.id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['id' => $id]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        return $user ?: null;
    }

    public function emailExists(string $email): bool
    {
        $stmt = $this->db->prepare("SELECT id FROM users WHERE email = :email");
        $stmt->execute(['email' => $email]);
        return $stmt->fetch() !== false;
    }

    public function create(array $data): ?int
    {
        $hashedPassword = password_hash($data['password'], PASSWORD_DEFAULT);

        $sql = "INSERT INTO users (name, email, password, role_id) VALUES (:name, :email, :password, :role_id)";
        $stmt = $this->db->prepare($sql);
        $success = $stmt->execute([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => $hashedPassword,
            'role_id' => $data['role_id'],
        ]);

        return $success ? (int)$this->db->lastInsertId() : null;
    }

    public function getAllUsersWithRoles(): array
    {
        $sql = "SELECT u.id, u.name, u.email, r.name as role_name
                FROM users u
                LEFT JOIN roles r ON u.role_id = r.id
                ORDER BY u.id ASC";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
