<?php
namespace App\Models;

use App\Core\Model;

class Contact extends Model
{
    public function create(array $data): bool
    {
        $sql = "INSERT INTO contact (name, email, subject, message) VALUES (:name, :email, :subject, :message)";
        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            'name' => $data['name'],
            'email' => $data['email'],
            'subject' => $data['subject'],
            'message' => $data['message'],
        ]);
    }
}