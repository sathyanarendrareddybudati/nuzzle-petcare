<?php
namespace App\Models;

use App\Core\Model;
use PDO;

class CaretakerProfile extends Model
{
    protected $table = 'caretaker_profiles';

    public function getProfileByUserId(int $userId)
    {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE user_id = :user_id");
        $stmt->execute(['user_id' => $userId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function createOrUpdate(array $data)
    {
        $profile = $this->getProfileByUserId($data['user_id']);

        if ($profile) {
            // Update
            $sql = "UPDATE {$this->table} SET title = :title, description = :description, location = :location, availability = :availability WHERE user_id = :user_id";
            $stmt = $this->db->prepare($sql);
            return $stmt->execute($data);
        } else {
            // Create
            $sql = "INSERT INTO {$this->table} (user_id, title, description, location, availability) VALUES (:user_id, :title, :description, :location, :availability)";
            $stmt = $this->db->prepare($sql);
            return $stmt->execute($data);
        }
    }

    public function findAllWithFilters(array $filters)
    {
        $sql = "SELECT cp.*, u.name FROM {$this->table} cp JOIN users u ON cp.user_id = u.id WHERE 1=1";
        $params = [];

        if (!empty($filters['location'])) {
            $sql .= " AND cp.location LIKE :location";
            $params['location'] = '%' . $filters['location'] . '%';
        }

        if (!empty($filters['availability'])) {
            $sql .= " AND cp.availability LIKE :availability";
            $params['availability'] = '%' . $filters['availability'] . '%';
        }

        $sort = $filters['sort'] ?? 'newest';
        switch ($sort) {
            case 'oldest':
                $sql .= " ORDER BY cp.created_at ASC";
                break;
            case 'newest':
            default:
                $sql .= " ORDER BY cp.created_at DESC";
                break;
        }

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
