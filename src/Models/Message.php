<?php
namespace App\Models;

use App\Core\Model;
use PDO;

class Message extends Model
{
    public function getConversations(int $userId): array
    {
        $sql = "SELECT u.id as participant_id, u.username as participant_name, c.body_content as last_message, c.sent_at as last_message_date
                FROM communication_log c
                JOIN users u ON u.id = c.sender_user_id OR u.id = c.recipient_user_id
                WHERE (c.sender_user_id = :user_id1 OR c.recipient_user_id = :user_id2)
                AND u.id != :user_id3
                AND c.id IN (
                    SELECT MAX(id)
                    FROM communication_log
                    GROUP BY LEAST(sender_user_id, recipient_user_id), GREATEST(sender_user_id, recipient_user_id)
                )
                ORDER BY c.sent_at DESC";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            'user_id1' => $userId,
            'user_id2' => $userId,
            'user_id3' => $userId,
        ]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getMessages(int $userId, int $participantId): array
    {
        $sql = "SELECT * FROM communication_log
                WHERE (sender_user_id = :user_id AND recipient_user_id = :participant_id)
                   OR (sender_user_id = :participant_id AND recipient_user_id = :user_id)
                ORDER BY sent_at ASC";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['user_id' => $userId, 'participant_id' => $participantId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function create(array $data): bool
    {
        $sql = "INSERT INTO communication_log (sender_user_id, recipient_user_id, subject, body_content, communication_type) 
                VALUES (:sender_user_id, :recipient_user_id, :subject, :body_content, 'message')";

        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            'sender_user_id' => $data['sender_user_id'],
            'recipient_user_id' => $data['recipient_user_id'],
            'subject' => $data['subject'],
            'body_content' => $data['body_content'],
        ]);
    }
}
