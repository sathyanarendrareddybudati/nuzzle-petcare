<?php
namespace App\Models;

use App\Core\Model;
use PDO;

class Service extends Model
{
    public function getAllServices(): array
    {
        $stmt = $this->db->query("SELECT id, name FROM services");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
