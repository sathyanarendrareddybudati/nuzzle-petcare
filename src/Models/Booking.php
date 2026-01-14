<?php
namespace App\Models;

use App\Core\Database;
use PDO;

class Booking
{
    private PDO $db;
    private string $bookingsTable = 'bookings';

    public function __construct()
    {
        $this->db = Database::pdo();
    }

    public function getBookedServicesByUserId(int $userId): array
    {
        $sql = "SELECT b.*, s.name as service_name, l.name as location_name, p.name AS pet_name, u_client.name AS client_name
                FROM {$this->bookingsTable} b
                JOIN services s ON b.service_id = s.id
                JOIN locations l ON b.location_id = l.id
                JOIN users u_client ON b.client_id = u_client.id
                LEFT JOIN pets p ON b.pet_id = p.id
                WHERE b.provider_id = :user_id AND b.status != 'pending'
                ORDER BY b.created_at DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['user_id' => $userId]);
        return $stmt->fetchAll();
    }

    public function getServiceRequestsForUserId(int $userId): array
    {
        $sql = "SELECT b.*, s.name as service_name, l.name as location_name, p.name AS pet_name, u_client.name AS requester_name
                FROM {$this->bookingsTable} b
                JOIN services s ON b.service_id = s.id
                JOIN locations l ON b.location_id = l.id
                JOIN users u_client ON b.client_id = u_client.id
                LEFT JOIN pets p ON b.pet_id = p.id
                WHERE b.provider_id = :user_id AND b.status = 'pending'
                ORDER BY b.created_at DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['user_id' => $userId]);
        return $stmt->fetchAll();
    }

    public function getBookingsByClientId(int $clientId): array
    {
        $sql = "SELECT b.id, b.status, b.start_date, b.end_date, b.notes, b.rating, b.created_at,
                       s.name AS service_name,
                       l.name as location_name,
                       u_provider.name AS provider_name
                FROM {$this->bookingsTable} b
                JOIN services s ON b.service_id = s.id
                JOIN locations l ON b.location_id = l.id
                JOIN users u_provider ON b.provider_id = u_provider.id
                WHERE b.client_id = :client_id
                ORDER BY b.created_at DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['client_id' => $clientId]);
        return $stmt->fetchAll();
    }

    public function getBookingDetailsById(int $bookingId): ?array
    {
        $sql = "SELECT b.*, s.name as service_name, l.name as location_name, p.name AS pet_name,
                       u_provider.name AS provider_name,
                       u_client.name AS owner_name, u_client.id AS owner_id
                FROM {$this->bookingsTable} b
                JOIN services s ON b.service_id = s.id
                JOIN locations l ON b.location_id = l.id
                JOIN users u_provider ON b.provider_id = u_provider.id
                JOIN users u_client ON b.client_id = u_client.id
                LEFT JOIN pets p ON b.pet_id = p.id
                WHERE b.id = :booking_id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['booking_id' => $bookingId]);
        $result = $stmt->fetch();
        return $result ?: null;
    }

    public function create(array $data): ?int
    {
        try {
            $sql = "INSERT INTO {$this->bookingsTable} (pet_id, provider_id, client_id, service_id, location_id, start_date, end_date, status, notes)
                    VALUES (:pet_id, :provider_id, :client_id, :service_id, :location_id, :start_date, :end_date, :status, :notes)";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                ':pet_id' => $data['pet_id'],
                ':provider_id' => $data['provider_id'],
                ':client_id' => $data['client_id'],
                ':service_id' => $data['service_id'],
                ':location_id' => $data['location_id'],
                ':start_date' => $data['start_date'],
                ':end_date' => $data['end_date'],
                ':status' => $data['status'] ?? 'pending',
                ':notes' => $data['notes'] ?? null,
            ]);
            return (int)$this->db->lastInsertId();
        } catch (\Exception $e) {
            error_log($e->getMessage());
            return null;
        }
    }

    public function find(int $id): ?array
    {
        $stmt = $this->db->prepare("SELECT * FROM {$this->bookingsTable} WHERE id = :id");
        $stmt->execute(['id' => $id]);
        $result = $stmt->fetch();
        return $result ?: null;
    }
    
    public function updateStatus(int $id, string $status): bool
    {
        $stmt = $this->db->prepare("UPDATE {$this->bookingsTable} SET status = :status WHERE id = :id");
        return $stmt->execute(['status' => $status, 'id' => $id]);
    }

    public function addRating(int $id, int $rating, string $review): bool
    {
        $stmt = $this->db->prepare("UPDATE {$this->bookingsTable} SET rating = :rating, notes = :review WHERE id = :id");
        return $stmt->execute(['rating' => $rating, 'review' => $review, 'id' => $id]);
    }
}
