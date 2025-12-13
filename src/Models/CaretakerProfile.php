<?php
namespace App\Models;

use App\Core\Model;

class CaretakerProfile extends Model
{
    protected $table = 'caretaker_profiles';

    public function getProfileByUserId(int $userId)
    {
        return $this->db->query("SELECT * FROM {$this->table} WHERE user_id = :user_id", ['user_id' => $userId])->findOne();
    }

    public function createOrUpdate(array $data)
    {
        $profile = $this->getProfileByUserId($data['user_id']);

        if ($profile) {
            // Update
            $sql = "UPDATE {$this->table} SET title = :title, description = :description, location = :location, availability = :availability WHERE user_id = :user_id";
            return $this->db->query($sql, $data);
        } else {
            // Create
            $sql = "INSERT INTO {$this->table} (user_id, title, description, location, availability) VALUES (:user_id, :title, :description, :location, :availability)";
            return $this->db->query($sql, $data);
        }
    }

    public function findAllWithFilters(array $filters)
    {
        $sql = "SELECT cp.*, u.username FROM {$this->table} cp JOIN users u ON cp.user_id = u.id WHERE 1=1";
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

        return $this->db->query($sql, $params)->findAll();
    }
}
