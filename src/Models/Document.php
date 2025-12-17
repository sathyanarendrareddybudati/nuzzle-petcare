<?php
namespace App\Models;

use App\Core\Database;
use PDO;

class Document
{
    private PDO $db;
    private string $table = 'documents';

    public function __construct()
    {
        $this->db = Database::pdo();
    }

    public function create(array $data): int
    {
        $sql = "INSERT INTO {$this->table} (owner_type, owner_id, document_type, file_name, file_path, is_verified)
                VALUES (:owner_type, :owner_id, :document_type, :file_name, :file_path, :is_verified)";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':owner_type' => $data['owner_type'],
            ':owner_id' => $data['owner_id'],
            ':document_type' => $data['document_type'],
            ':file_name' => $data['file_name'],
            ':file_path' => $data['file_path'],
            ':is_verified' => $data['is_verified'] ?? false,
        ]);
        return (int)$this->db->lastInsertId();
    }

    public function findForOwner(string $ownerType, int $ownerId): array
    {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE owner_type = ? AND owner_id = ?");
        $stmt->execute([$ownerType, $ownerId]);
        return $stmt->fetchAll();
    }
}
