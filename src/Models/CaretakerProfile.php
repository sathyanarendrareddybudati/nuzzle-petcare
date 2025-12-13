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
}
