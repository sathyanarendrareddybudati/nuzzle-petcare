<?php

namespace App\Models;

use App\Core\Model;
use PDO;

class PetCategory extends Model
{
    public function all(): array
    {
        $stmt = $this->db->prepare("SELECT * FROM pet_categories");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
