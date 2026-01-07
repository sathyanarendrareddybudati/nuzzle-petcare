<?php
namespace App\Models;

use App\Core\Model;
use PDO;

class Role extends Model
{
    public function getAllRoles(): array
    {
        $stmt = $this->db->query("SELECT id, name FROM roles");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getRoleNameById(int $id): ?string
    {
        $stmt = $this->db->prepare("SELECT name FROM roles WHERE id = :id");
        $stmt->execute([':id' => $id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['name'] ?? null;
    }
}
