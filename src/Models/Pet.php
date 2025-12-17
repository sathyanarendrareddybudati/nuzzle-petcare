<?php
namespace App\Models;

use App\Core\Database;
use PDO;

class Pet
{
    private PDO $db;
    public function __construct()
    {
        $this->db = Database::pdo();
    }

    public function all(): array
    {
        $stmt = $this->db->query('SELECT * FROM pets ORDER BY created_at DESC');
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function find(int $id): ?array
    {
        $stmt = $this->db->prepare('SELECT * FROM pets WHERE id = ? LIMIT 1');
        $stmt->execute([$id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ?: null;
    }

    public function getPetsByUserId(int $userId): array
    {
        $stmt = $this->db->prepare('SELECT id, name FROM pets WHERE user_id = :user_id ORDER BY name ASC');
        $stmt->execute([':user_id' => $userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function create(array $data): int
    {
        $sql = 'INSERT INTO pets (user_id, category_id, name, breed, age_years, age_months, gender, description, image_url)
                VALUES (:user_id, :category_id, :name, :breed, :age_years, :age_months, :gender, :description, :image_url)';
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':user_id' => $data['user_id'],
            ':category_id' => $data['category_id'],
            ':name' => $data['name'],
            ':breed' => $data['breed'] ?? null,
            ':age_years' => (int)($data['age_years'] ?? 0),
            ':age_months' => (int)($data['age_months'] ?? 0),
            ':gender' => $data['gender'],
            ':description' => $data['description'] ?? null,
            ':image_url' => $data['image_url'] ?? null,
        ]);
        return (int)$this->db->lastInsertId();
    }
}