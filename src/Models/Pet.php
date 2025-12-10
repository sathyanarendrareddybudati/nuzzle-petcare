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
        $stmt = $this->db->query('SELECT * FROM pet_ads ORDER BY created_at DESC');
        return $stmt->fetchAll();
    }

    public function find(int $id): ?array
    {
        $stmt = $this->db->prepare('SELECT * FROM pet_ads WHERE id = ? LIMIT 1');
        $stmt->execute([$id]);
        $row = $stmt->fetch();
        return $row ?: null;
    }

    public function related(string $species, int $excludeId, int $limit = 3): array
    {
        $stmt = $this->db->prepare('SELECT * FROM pet_ads WHERE species = ? AND id != ? ORDER BY id DESC LIMIT ?');
        $stmt->bindValue(1, $species);
        $stmt->bindValue(2, $excludeId, PDO::PARAM_INT);
        $stmt->bindValue(3, $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function create(array $data): int
    {
        $sql = 'INSERT INTO pet_ads (name, species, breed, age, gender, price, description, location, contact_phone, contact_email, image_url)
                VALUES (:name, :species, :breed, :age, :gender, :price, :description, :location, :contact_phone, :contact_email, :image_url)';
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':name' => $data['name'],
            ':species' => $data['species'],
            ':breed' => $data['breed'] ?? null,
            ':age' => (int)($data['age'] ?? 0),
            ':gender' => $data['gender'],
            ':price' => (float)($data['price'] ?? 0),
            ':description' => $data['description'] ?? null,
            ':location' => $data['location'],
            ':contact_phone' => $data['contact_phone'] ?? '',
            ':contact_email' => $data['contact_email'] ?? null,
            ':image_url' => $data['image_url'] ?? null,
        ]);
        return (int)$this->db->lastInsertId();
    }
}
