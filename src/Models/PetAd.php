<?php
namespace App\Models;

use App\Core\Model;
use PDO;

class PetAd extends Model
{
    public function all(): array
    {
        $sql = "SELECT pa.*, p.name, p.gender, p.breed, p.age_years, p.image_url, pc.name as species, s.name as service_name, l.name as location_name, u.name as user_name
                FROM pet_ads pa
                LEFT JOIN pets p ON pa.pet_id = p.id
                LEFT JOIN pet_categories pc ON p.category_id = pc.id
                JOIN services s ON pa.service_id = s.id
                JOIN locations l ON pa.location_id = l.id
                JOIN users u ON pa.user_id = u.id
                ORDER BY pa.created_at DESC";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function find(int $id): ?array
    {
        $stmt = $this->db->prepare('SELECT * FROM pet_ads WHERE id = ?');
        $stmt->execute([$id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ?: null;
    }

    public function findAllWithFilters(array $filters): array
    {
        $sql = "SELECT pa.*, p.name, p.gender, p.breed, p.age_years, p.image_url, pc.name as species, s.name as service_name, l.name as location_name, u.name as user_name
                FROM pet_ads pa
                LEFT JOIN pets p ON pa.pet_id = p.id
                LEFT JOIN pet_categories pc ON p.category_id = pc.id
                JOIN services s ON pa.service_id = s.id
                JOIN locations l ON pa.location_id = l.id
                JOIN users u ON pa.user_id = u.id
                WHERE 1=1";
        $params = [];

        if (!empty($filters['q'])) {
            $sql .= " AND (pa.title LIKE :q1 OR pa.description LIKE :q2 OR l.name LIKE :q3 OR p.name LIKE :q4 OR p.breed LIKE :q5)";
            $params[':q1'] = '%' . $filters['q'] . '%';
            $params[':q2'] = '%' . $filters['q'] . '%';
            $params[':q3'] = '%' . $filters['q'] . '%';
            $params[':q4'] = '%' . $filters['q'] . '%';
            $params[':q5'] = '%' . $filters['q'] . '%';
        }

        if (!empty($filters['species'])) {
            $sql .= " AND pc.name = :species";
            $params['species'] = $filters['species'];
        }

        if (!empty($filters['gender'])) {
            $sql .= " AND p.gender = :gender";
            $params['gender'] = $filters['gender'];
        }

        if (!empty($filters['service'])) {
            $sql .= " AND s.id = :service";
            $params['service'] = $filters['service'];
        }

        if (!empty($filters['location'])) {
            $sql .= " AND l.id = :location";
            $params['location'] = $filters['location'];
        }

        $sort = $filters['sort'] ?? 'newest';
        $sql .= match ($sort) {
            'price_asc' => " ORDER BY pa.price ASC",
            'price_desc' => " ORDER BY pa.price DESC",
            default => " ORDER BY pa.created_at DESC",
        };

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAdsByUserId(int $userId): array
    {
        $sql = "SELECT pa.*, s.name as service_name, l.name as location_name
                FROM pet_ads pa
                JOIN services s ON pa.service_id = s.id
                JOIN locations l ON pa.location_id = l.id
                WHERE pa.user_id = :user_id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['user_id' => $userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAdById(int $adId): ?array
    {
        $sql = "SELECT pa.*, p.name, p.gender, p.breed, p.age_years, p.image_url, pc.name as species, s.name as service_name, l.name as location_name, u.name as user_name, u.email as user_email
                FROM pet_ads pa
                LEFT JOIN pets p ON pa.pet_id = p.id
                LEFT JOIN pet_categories pc ON p.category_id = pc.id
                JOIN services s ON pa.service_id = s.id
                JOIN locations l ON pa.location_id = l.id
                JOIN users u ON pa.user_id = u.id
                WHERE pa.id = :ad_id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['ad_id' => $adId]);
        $ad = $stmt->fetch(PDO::FETCH_ASSOC);
        return $ad ?: null;
    }

    public function create(array $data): ?int
    {
        $sql = "INSERT INTO pet_ads (service_id, user_id, pet_id, title, description, price, status, start_date, end_date, location_id, ad_type) 
                VALUES (:service_id, :user_id, :pet_id, :title, :description, :price, :status, :start_date, :end_date, :location_id, :ad_type)";
        $stmt = $this->db->prepare($sql);
        $success = $stmt->execute([
            'service_id' => $data['service_id'],
            'user_id' => $data['user_id'],
            'pet_id' => $data['pet_id'],
            'title' => $data['title'],
            'description' => $data['description'],
            'price' => $data['price'],
            'status' => $data['status'] ?? 'pending',
            'start_date' => $data['start_date'],
            'end_date' => $data['end_date'],
            'location_id' => $data['location_id'],
            'ad_type' => $data['ad_type'],
        ]);

        return $success ? (int)$this->db->lastInsertId() : null;
    }

    public function update(int $id, array $data): bool
    {
        $sql = "UPDATE pet_ads SET 
                    service_id = :service_id,
                    pet_id = :pet_id,
                    title = :title,
                    description = :description,
                    price = :price,
                    status = :status,
                    start_date = :start_date,
                    end_date =.end_date,
                    location_id = :location_id,
                    ad_type = :ad_type
                WHERE id = :id";
        $params = [
            ':id' => $id,
            ':service_id' => $data['service_id'],
            ':pet_id' => $data['pet_id'],
            ':title' => $data['title'],
            ':description' => $data['description'],
            ':price' => $data['price'],
            ':status' => $data['status'] ?? 'pending',
            ':start_date' => $data['start_date'],
            ':end_date' => $data['end_date'],
            ':location_id' => $data['location_id'],
            ':ad_type' => $data['ad_type'],
        ];
        $stmt = $this->db->prepare($sql);
        return $stmt->execute($params);
    }

    public function delete(int $id): bool
    {
        $stmt = $this->db->prepare('DELETE FROM pet_ads WHERE id = ?');
        return $stmt->execute([$id]);
    }

    public function getRecentAdsByUserId(int $userId, int $limit = 5): array
    {
        $sql = "SELECT pa.*, s.name as service_name, l.name as location
                FROM pet_ads pa
                JOIN services s ON pa.service_id = s.id
                JOIN locations l ON pa.location_id = l.id
                WHERE pa.user_id = :user_id
                ORDER BY pa.created_at DESC
                LIMIT :limit";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':user_id', $userId, PDO::PARAM_INT);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getRecentAds(int $limit = 5): array
    {
        $sql = "SELECT pa.*, s.name as service_name, l.name as location
                FROM pet_ads pa
                JOIN services s ON pa.service_id = s.id
                JOIN locations l ON pa.location_id = l.id
                ORDER BY pa.created_at DESC
                LIMIT :limit";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
