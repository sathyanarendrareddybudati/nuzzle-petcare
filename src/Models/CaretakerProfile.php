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

        // Location is part of the user table, so remove it from this model's responsibility
        $profileData = $data;
        unset($profileData['location_id']);

        if ($profile) {
            // Update
            $sql = "UPDATE {$this->table} SET title = :title, bio = :bio, photo_url = :photo_url WHERE user_id = :user_id";
            // We need to remove location_id from the data array before executing
            $updateData = $profileData;
            unset($updateData['location_id']);
            return $this->db->prepare($sql)->execute($updateData);
        } else {
            // Create
            $sql = "INSERT INTO {$this->table} (user_id, title, bio, photo_url) VALUES (:user_id, :title, :bio, :photo_url)";
            $createData = $profileData;
            unset($createData['location_id']);
            return $this->db->prepare($sql)->execute($createData);
        }
    }

    public function getFeaturedProfiles(int $limit = 4): array
    {
        $sql = "SELECT cp.*, u.name as user_name, l.name as location_name
                FROM {$this->table} cp
                JOIN users u ON cp.user_id = u.id
                LEFT JOIN locations l ON u.location_id = l.id
                ORDER BY cp.created_at DESC
                LIMIT :limit";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findAllWithFilters(array $filters)
    {
        $sql = "SELECT cp.*, u.name as user_name, l.name as location_name
                FROM {$this->table} cp 
                JOIN users u ON cp.user_id = u.id
                LEFT JOIN locations l ON u.location_id = l.id 
                WHERE 1=1";
        $params = [];

        if (!empty($filters['location'])) {
            $sql .= " AND u.location_id = :location_id";
            $params['location_id'] = $filters['location'];
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
