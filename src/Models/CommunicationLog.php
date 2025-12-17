<?php
namespace App\Models;

use App\Core\Database;
use PDO;

class CommunicationLog
{
    private PDO $db;
    private string $table = 'communication_log';

    public function __construct()
    {
        $this->db = Database::pdo();
    }

    public function create(array $data): int
    {
        $sql = "INSERT INTO {$this->table} (sender_user_id, recipient_user_id, subject, body_content, communication_type, delivery_status)
                VALUES (:sender_user_id, :recipient_user_id, :subject, :body_content, :communication_type, :delivery_status)";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':sender_user_id' => $data['sender_user_id'] ?? null,
            ':recipient_user_id' => $data['recipient_user_id'],
            ':subject' => $data['subject'],
            ':body_content' => $data['body_content'],
            ':communication_type' => $data['communication_type'],
            ':delivery_status' => $data['delivery_status'] ?? 'Sent',
        ]);
        return (int)$this->db->lastInsertId();
    }
}
