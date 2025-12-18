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
        $stmt = $this->db->query('SELECT p.*, pc.name as species FROM pets p JOIN pet_categories pc ON p.category_id = pc.id ORDER BY p.created_at DESC');
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function find(int $id): ?array
    {
        $stmt = $this->db->prepare('SELECT p.*, pc.name as species FROM pets p JOIN pet_categories pc ON p.category_id = pc.id WHERE p.id = ? LIMIT 1');
        $stmt->execute([$id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ?: null;
    }

    public function getPetsByUserId(int $userId): array
    {
        $sql = 'SELECT p.id, p.name, p.breed, pc.name as species 
                FROM pets p 
                JOIN pet_categories pc ON p.category_id = pc.id 
                WHERE p.user_id = :user_id 
                ORDER BY p.name ASC';
        $stmt = $this->db->prepare($sql);
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

    public function update(int $id, array $data): bool
    {
        $sql = 'UPDATE pets SET 
                    name = :name, 
                    category_id = :category_id, 
                    breed = :breed, 
                    age_years = :age_years, 
                    age_months = :age_months, 
                    gender = :gender, 
                    description = :description';
        
        $params = [
            ':id' => $id,
            ':name' => $data['name'],
            ':category_id' => $data['category_id'],
            ':breed' => $data['breed'] ?? null,
            ':age_years' => (int)($data['age_years'] ?? 0),
            ':age_months' => (int)($data['age_months'] ?? 0),
            ':gender' => $data['gender'],
            ':description' => $data['description'] ?? null,
        ];

        if (isset($data['image_url'])) {
            $sql .= ', image_url = :image_url';
            $params[':image_url'] = $data['image_url'];
        }

        $sql .= ' WHERE id = :id';
        
        $stmt = $this->db->prepare($sql);
        return $stmt->execute($params);
    }

    public function delete(int $id): bool
    {
        $stmt = $this->db->prepare('DELETE FROM pets WHERE id = ?');
        return $stmt->execute([$id]);
    }
}
