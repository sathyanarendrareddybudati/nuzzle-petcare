<?php
namespace App\Models;

use App\Core\Model;
use PDO;

class Location extends Model
{
    public function getAllLocations(): array
    {
        $stmt = $this->db->query("SELECT id, name FROM locations");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function all(): array
    {
        return $this->getAllLocations();
    }
}
