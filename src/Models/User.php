<?php
namespace App\Models;

use App\Core\Model;
use PDO;

class User extends Model
{
    // Updated to join with roles table
    public function verifyCredentials(string $email, string $password): ?array
    {
        $sql = "SELECT u.*, r.name as role 
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

    public function find(int $id): ?array
    {
        $sql = "SELECT u.*, r.name as role
                FROM users u
                LEFT JOIN roles r ON u.role_id = r.id
                WHERE u.id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['id' => $id]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        return $user ?: null;
    }

    // Renamed from getById for consistency
    public function findById(int $id): ?array
    {
        return $this->find($id);
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
        $sql = "SELECT u.id, u.name, u.email, r.name as role, u.created_at
                FROM users u
                LEFT JOIN roles r ON u.role_id = r.id
                ORDER BY u.id ASC";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function update(int $id, array $data): bool
    {
        $roleId = null;
        if (!empty($data['role'])) {
            $stmt = $this->db->prepare("SELECT id FROM roles WHERE name = :name");
            $stmt->execute(['name' => $data['role']]);
            $roleId = $stmt->fetchColumn();
        }

        $sql = "UPDATE users SET name = :name, email = :email";
        $params = [
            ':id' => $id,
            ':name' => $data['name'],
            ':email' => $data['email'],
        ];

        if ($roleId) {
            $sql .= ", role_id = :role_id";
            $params[':role_id'] = $roleId;
        }

        $sql .= " WHERE id = :id";

        $stmt = $this->db->prepare($sql);
        return $stmt->execute($params);
    }

    public function delete(int $id): bool
    {
        $stmt = $this->db->prepare('DELETE FROM users WHERE id = ?');
        return $stmt->execute([$id]);
    }

    public function getUserByEmail(string $email): ?array
    {
        $sql = "SELECT u.*, r.name as role 
                FROM users u 
                LEFT JOIN roles r ON u.role_id = r.id 
                WHERE u.email = :email";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['email' => $email]);
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }

    public function generatePasswordResetToken(string $email): string
    {
        // Generate token: hash of email + timestamp + secret
        $secret = $_ENV['APP_KEY'] ?? 'default-secret-key';
        $timestamp = time();
        $token = hash('sha256', $email . '|' . $timestamp . '|' . $secret);

        return $token . '_' . $timestamp;
    }

    public function verifyPasswordResetToken(string $token): ?array
    {
        // Extract timestamp from token
        $parts = explode('_', $token);
        if (count($parts) !== 2 || !is_numeric($parts[1])) {
            return null;
        }

        $timestamp = (int)$parts[1];
        $expiryTime = 60 * 60; // 60 minutes

        // Check if token has expired
        if (time() - $timestamp > $expiryTime) {
            return null;
        }

        // Find user by email (we need to validate from request)
        return ['token_valid' => true, 'timestamp' => $timestamp];
    }

    public function updatePasswordByEmail(string $email, string $newPassword): bool
    {
        try {
            $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
            $sql = "UPDATE users SET password = :password WHERE email = :email";
            $stmt = $this->db->prepare($sql);
            return $stmt->execute([
                'password' => $hashedPassword,
                'email' => $email
            ]);
        } catch (\Exception $e) {
            error_log("Password update error: " . $e->getMessage());
            return false;
        }
    }
}
