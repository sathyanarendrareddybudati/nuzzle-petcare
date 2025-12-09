<?php
require_once __DIR__ . '/../config/database.php';

class User {
    private $db;
    private $table = 'users';

    public $id;
    public $role_id;
    public $name;
    public $email;
    public $password;
    public $phone_number;
    public $location_id;
    public $created_at;

    public function __construct() {
        $this->db = getDbConnection();
    }

    public function create($data = []) {
        if (!empty($data)) {
            foreach ($data as $key => $value) {
                if (property_exists($this, $key)) {
                    $this->$key = $value;
                }
            }
        }

        $query = 'INSERT INTO ' . $this->table . ' 
            SET 
                role_id = :role_id,
                name = :name,
                email = :email,
                password = :password,
                phone_number = :phone_number,
                location_id = :location_id';

        $stmt = $this->db->prepare($query);

        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->password = password_hash($this->password, PASSWORD_BCRYPT);
        $this->phone_number = htmlspecialchars(strip_tags($this->phone_number));
        $this->location_id = $this->location_id ?? null;

        if (!in_array($this->role_id, [2, 3, 4])) {
            throw new Exception('Invalid role_id provided');
        }

        $stmt->bindParam(':role_id', $this->role_id);
        $stmt->bindParam(':name', $this->name);
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':password', $this->password);
        $stmt->bindParam(':phone_number', $this->phone_number);
        $stmt->bindParam(':location_id', $this->location_id);

        if($stmt->execute()) {
            $this->id = $this->db->lastInsertId();
            return true;
        }

        printf("Error: %s.\n", $stmt->error);
        return false;
    }

    public function getByEmail($email) {
        $query = 'SELECT u.*, r.name as role_name, l.city, l.state, l.country 
                 FROM ' . $this->table . ' u 
                 LEFT JOIN roles r ON u.role_id = r.id 
                 LEFT JOIN locations l ON u.location_id = l.id 
                 WHERE u.email = ? 
                 LIMIT 1';

        $stmt = $this->db->prepare($query);
        $stmt->execute([$email]);
        
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getById($id) {
        $query = 'SELECT u.*, r.name as role_name, l.city, l.state, l.country 
                 FROM ' . $this->table . ' u 
                 LEFT JOIN roles r ON u.role_id = r.id 
                 LEFT JOIN locations l ON u.location_id = l.id 
                 WHERE u.id = ? 
                 LIMIT 1';

        $stmt = $this->db->prepare($query);
        $stmt->execute([$id]);
        
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Update user
    public function update() {
        $query = 'UPDATE ' . $this->table . ' 
                 SET 
                     name = :name,
                     email = :email,
                     phone_number = :phone_number,
                     location_id = :location_id
                 WHERE id = :id';

        $stmt = $this->db->prepare($query);

        // Sanitize data
        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->phone_number = htmlspecialchars(strip_tags($this->phone_number));

        // Bind data
        $stmt->bindParam(':name', $this->name);
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':phone_number', $this->phone_number);
        $stmt->bindParam(':location_id', $this->location_id);
        $stmt->bindParam(':id', $this->id);

        return $stmt->execute();
    }

    // Update password
    public function updatePassword($new_password) {
        $query = 'UPDATE ' . $this->table . ' SET password = :password WHERE id = :id';
        $stmt = $this->db->prepare($query);
        
        $hashed_password = password_hash($new_password, PASSWORD_BCRYPT);
        
        $stmt->bindParam(':password', $hashed_password);
        $stmt->bindParam(':id', $this->id);
        
        return $stmt->execute();
    }

    // Verify user credentials
    public function verifyCredentials($email, $password) {
        $user = $this->getByEmail($email);
        
        if ($user && password_verify($password, $user['password'])) {
            unset($user['password']); // Remove password from the returned user data
            return $user;
        }
        
        return false;
    }

    // Check if email exists
    public function emailExists($email) {
        $query = 'SELECT id FROM ' . $this->table . ' WHERE email = ? LIMIT 1';
        $stmt = $this->db->prepare($query);
        $stmt->execute([$email]);
        return $stmt->rowCount() > 0;
    }

    // Get all users (with pagination)
    public function getAll($page = 1, $limit = 10, $role_id = null) {
        $offset = ($page - 1) * $limit;
        $params = [];
        $where = '';
        
        if ($role_id) {
            $where = 'WHERE u.role_id = ?';
            $params[] = $role_id;
        }
        
        $query = "SELECT u.*, r.name as role_name, CONCAT(l.city, ', ', l.state) as location 
                 FROM {$this->table} u 
                 LEFT JOIN roles r ON u.role_id = r.id 
                 LEFT JOIN locations l ON u.location_id = l.id 
                 {$where}
                 ORDER BY u.created_at DESC 
                 LIMIT ? OFFSET ?";
        
        $params[] = (int)$limit;
        $params[] = (int)$offset;
        
        $stmt = $this->db->prepare($query);
        $stmt->execute($params);
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Count total users (for pagination)
    public function countAll($role_id = null) {
        $where = '';
        $params = [];
        
        if ($role_id) {
            $where = 'WHERE role_id = ?';
            $params[] = $role_id;
        }
        
        $query = "SELECT COUNT(*) as total FROM {$this->table} {$where}";
        $stmt = $this->db->prepare($query);
        $stmt->execute($params);
        
        return (int)$stmt->fetch(PDO::FETCH_ASSOC)['total'];
    }
}
