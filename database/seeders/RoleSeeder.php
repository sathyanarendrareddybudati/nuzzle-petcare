<?php
namespace Database\Seeders;

use App\Core\Database;
use PDO;

class RoleSeeder
{
    public function run(): void
    {
        $db = Database::pdo();

        $roles = [
            ['id' => 1, 'name' => 'admin'],
            ['id' => 2, 'name' => 'pet_owner'],
            ['id' => 3, 'name' => 'service_provider'],
        ];

        $stmt = $db->prepare("INSERT INTO roles (id, name) VALUES (:id, :name) ON DUPLICATE KEY UPDATE name = :name");

        echo "Seeding roles...\n";
        foreach ($roles as $role) {
            $stmt->execute($role);
            echo "  - Seeded role: {$role['name']}\n";
        }
        echo "Role seeding complete.\n";
    }
}
