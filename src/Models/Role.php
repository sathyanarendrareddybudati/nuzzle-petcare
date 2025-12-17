<?php
namespace App\Models;

use App\Core\Model;
use PDO;

class Role extends Model
{
    public function getAllRoles(): array
    {
        $stmt = $this->db->query("SELECT id, name FROM roles WHERE name != 'admin'");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
