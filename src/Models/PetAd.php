<?php
namespace App\Models;

use App\Core\Model;
use PDO;

class PetAd extends Model
{
    public function all(): array
    {
        $sql = "SELECT pa.*, s.name as service_name, l.name as location_name, u.name as user_name
                FROM pet_ads pa
                JOIN services s ON pa.service_id = s.id
                JOIN locations l ON pa.location_id = l.id
                JOIN users u ON pa.user_id = u.id
                ORDER BY pa.created_at DESC";
        return $this->db->query($sql)->findAll();
    }

    public function findAllWithFilters(array $filters): array
    {
        $sql = "SELECT pa.*, s.name as service_name, l.name as location_name, u.name as user_name
                FROM pet_ads pa
                JOIN services s ON pa.service_id = s.id
                JOIN locations l ON pa.location_id = l.id
                JOIN users u ON pa.user_id = u.id
                WHERE 1=1";
        $params = [];

        if (!empty($filters['location'])) {
            $sql .= " AND l.name LIKE :location";
            $params['location'] = '%' . $filters['location'] . '%';
        }

        if (!empty($filters['pet_type'])) {
            $sql .= " AND s.name LIKE :pet_type";
            $params['pet_type'] = '%' . $filters['pet_type'] . '%';
        }

        $sort = $filters['sort'] ?? 'newest';
        switch ($sort) {
            case 'oldest':
                $sql .= " ORDER BY pa.created_at ASC";
                break;
            case 'newest':
            default:
                $sql .= " ORDER BY pa.created_at DESC";
                break;
        }

        return $this->db->query($sql, $params)->findAll();
    }

    public function getAdsByUserId(int $userId): array
    {
        $sql = "SELECT pa.*, s.name as service_name, l.name as location_name
                FROM pet_ads pa
                JOIN services s ON pa.service_id = s.id
                JOIN locations l ON pa.location_id = l.id
                WHERE pa.user_id = :user_id";
        return $this->db->query($sql, ['user_id' => $userId])->findAll();
    }

    public function getAdById(int $adId): ?array
    {
        $sql = "SELECT pa.*, s.name as service_name, l.name as location_name, u.name as user_name, u.email as user_email
                FROM pet_ads pa
                JOIN services s ON pa.service_id = s.id
                JOIN locations l ON pa.location_id = l.id
                JOIN users u ON pa.user_id = u.id
                WHERE pa.id = :ad_id";
        return $this->db->query($sql, ['ad_id' => $adId])->findOne();
    }

    public function create(array $data): ?int
    {
        $sql = "INSERT INTO pet_ads (service_id, user_id, title, description, cost, status, start_date, end_date, location_id) 
                VALUES (:service_id, :user_id, :title, :description, :cost, :status, :start_date, :end_date, :location_id)";
        $this->db->query($sql, [
            'service_id' => $data['service_id'],
            'user_id' => $data['user_id'],
            'title' => $data['title'],
            'description' => $data['description'],
            'cost' => $data['cost'],
            'status' => $data['status'] ?? 'pending',
            'start_date' => $data['start_date'],
            'end_date' => $data['end_date'],
            'location_id' => $data['location_id'],
        ]);

        return (int)$this->db->lastInsertId();
    }

    public function getRecentAdsByUserId(int $userId, int $limit = 5): array
    {
        $sql = "SELECT pa.*, s.name as service_name, l.name as location_name
                FROM pet_ads pa
                JOIN services s ON pa.service_id = s.id
                JOIN locations l ON pa.location_id = l.id
                WHERE pa.user_id = :user_id
                ORDER BY pa.created_at DESC
                LIMIT :limit";
        return $this->db->query($sql, [
            'user_id' => $userId,
            'limit' => $limit
        ])->findAll();
    }

    public function getRecentAds(int $limit = 5): array
    {
        $sql = "SELECT pa.*, s.name as service_name, l.name as location_name
                FROM pet_ads pa
                JOIN services s ON pa.service_id = s.id
                JOIN locations l ON pa.location_id = l.id
                ORDER BY pa.created_at DESC
                LIMIT :limit";
        return $this->db->query($sql, ['limit' => $limit])->findAll();
    }
}
