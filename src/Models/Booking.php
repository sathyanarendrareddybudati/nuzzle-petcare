<?php
namespace App\Models;

use App\Core\Database;
use PDO;

class Booking
{
    private PDO $db;
    private string $table = 'bookings';

    public function __construct()
    {
        $this->db = Database::pdo();
    }

    public function getBookedServicesByUserId(int $userId): array
    {
        $sql = "SELECT b.*, pa.title AS ad_title, u.name AS ad_owner_name
                FROM {$this->table} b
                JOIN pet_ads pa ON b.pet_ad_id = pa.id
                JOIN users u ON pa.user_id = u.id
                WHERE b.provider_id = :user_id
                ORDER BY b.created_at DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['user_id' => $userId]);
        return $stmt->fetchAll();
    }

    public function getServiceRequestsForUserId(int $userId): array
    {
        $sql = "SELECT b.*, pa.title AS ad_title, u.name AS provider_name
                FROM {$this->table} b
                JOIN pet_ads pa ON b.pet_ad_id = pa.id
                JOIN users u ON b.provider_id = u.id
                WHERE pa.user_id = :user_id
                ORDER BY b.created_at DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['user_id' => $userId]);
        return $stmt->fetchAll();
    }
    
    public function getBookingDetailsById(int $bookingId): ?array
    {
        $sql = "SELECT b.*,
                       pa.title AS ad_title,
                       pa.user_id AS ad_owner_id,
                       u_owner.name AS ad_owner_name,
                       u_provider.name AS provider_name
                FROM {$this->table} b
                JOIN pet_ads pa ON b.pet_ad_id = pa.id
                JOIN users u_owner ON pa.user_id = u_owner.id
                JOIN users u_provider ON b.provider_id = u_provider.id
                WHERE b.id = :booking_id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['booking_id' => $bookingId]);
        $result = $stmt->fetch();
        return $result ?: null;
    }

    public function create(array $data): int
    {
        $sql = "INSERT INTO {$this->table} (pet_ad_id, provider_id, status, start_date, end_date, notes)
                VALUES (:pet_ad_id, :provider_id, :status, :start_date, :end_date, :notes)";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':pet_ad_id' => $data['pet_ad_id'],
            ':provider_id' => $data['provider_id'],
            ':status' => $data['status'] ?? 'pending',
            ':start_date' => $data['start_date'] ?? null,
            ':end_date' => $data['end_date'] ?? null,
            ':notes' => $data['notes'] ?? null,
        ]);
        return (int)$this->db->lastInsertId();
    }

    public function find(int $id): ?array
    {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE id = :id");
        $stmt->execute(['id' => $id]);
        $result = $stmt->fetch();
        return $result ?: null;
    }
    
    public function updateStatus(int $id, string $status): bool
    {
        $stmt = $this->db->prepare("UPDATE {$this->table} SET status = :status WHERE id = :id");
        return $stmt->execute(['status' => $status, 'id' => $id]);
    }

    public function addRating(int $id, int $rating, string $review): bool
    {
        $stmt = $this->db->prepare("UPDATE {$this->table} SET rating = :rating, notes = :review WHERE id = :id");
        return $stmt->execute(['rating' => $rating, 'review' => $review, 'id' => $id]);
    }
}
