<?php
namespace App\Models;

use App\Core\Model;
use PDO;

class Faq extends Model
{
    public function getAllFaqs(): array
    {
        $sql = "SELECT * FROM faqs ORDER BY display_order ASC";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
