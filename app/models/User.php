<?php

require_once "Database.php";

class User {

    private $db;
    private $table = 'users';

    public function __construct() {
        // Assuming Database class is autoloaded or required
        $this->db = Database::connect();
    }

    // Existing: Used for public registration
    public function register($name, $email, $password) {
        // CHECK IF EMAIL EXISTS
        $check = $this->db->prepare("SELECT id FROM " . $this->table . " WHERE email = ?");
        $check->execute([$email]);

        if ($check->rowCount() > 0) {
            return false;
        }

        $role_id = 4; // Default role
        $hashed = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $this->db->prepare("
            INSERT INTO " . $this->table . " (name, email, password, role_id)
            VALUES (?, ?, ?, ?)
        ");

        return $stmt->execute([$name, $email, $hashed, $role_id]);
    }

    // Existing: Used for login authentication
    public function login($email, $password) {
        $stmt = $this->db->prepare("SELECT * FROM " . $this->table . " WHERE email = ?");
        $stmt->execute([$email]);
    
        if ($stmt->rowCount() == 0) {
            return false;
        }
    
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
        if (!password_verify($password, $user['password'])) {
            return false;
        }
    
        return $user; // return user data
    }
    
    //  NEW: Used by Admin to create staff/internal users (Fixes the Error)
    public function createUser($data) {
        // 1. CHECK IF EMAIL EXISTS
        $check = $this->db->prepare("SELECT id FROM " . $this->table . " WHERE email = ?");
        $check->execute([$data['email']]);

        if ($check->rowCount() > 0) {
            return false; // Email already exists
        }

        // 2. Hash Password
        $hashed = password_hash($data['password'], PASSWORD_DEFAULT);

        // 3. Insert User
        $query = "INSERT INTO " . $this->table . " 
                  (name, email, phone, password, role_id)
                  VALUES (:name, :email, :phone, :password, :role_id)";

        $stmt = $this->db->prepare($query);

        $stmt->bindParam(':name', $data['name']);
        $stmt->bindParam(':email', $data['email']);
        $stmt->bindParam(':phone', $data['phone']);
        $stmt->bindParam(':password', $hashed);
        $stmt->bindParam(':role_id', $data['role_id']); 

        try {
            return $stmt->execute();
        } catch (PDOException $e) {
            // In a production environment, you would log $e->getMessage()
            return false; 
        }
    }
    
    // Used to check if email exists (helps with cleaner error handling in controller)
    public function checkIfEmailExists($email) {
        $check = $this->db->prepare("SELECT id FROM " . $this->table . " WHERE email = ?");
        $check->execute([$email]);
        return $check->rowCount() > 0;
    }

    // Get all users for the dashboard view
    public function getAllUsers() {
        // IMPORTANT: This query assumes you have a 'roles' table.
        $query = "SELECT u.id, u.name, u.email, u.phone, r.name as role 
                  FROM " . $this->table . " u
                  JOIN roles r ON u.role_id = r.id
                  ORDER BY u.id DESC";
        
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }





    public function getStaffUsers() {
        $query = "
            SELECT u.id, u.name, u.email, u.phone, r.name as role, u.is_active 
            FROM " . $this->table . " u
            JOIN roles r ON u.role_id = r.id
            WHERE u.role_id IN (1, 2, 3) 
            ORDER BY u.id ASC
        ";
        
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    /**
     * Retrieves all customers (role_id 4).
     */
    public function getCustomers() {
        $query = "
            SELECT u.id, u.name, u.email, u.phone, u.is_active 
            FROM " . $this->table . " u
            WHERE u.role_id = 4 
            ORDER BY u.id ASC
        ";
        
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    

    public function toggleUserStatus($userId, $newStatus) {
        $query = "UPDATE " . $this->table . " SET is_active = :status WHERE id = :id";
        
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':status', $newStatus, PDO::PARAM_INT);
        $stmt->bindParam(':id', $userId, PDO::PARAM_INT);
        
        try {
            return $stmt->execute();
        } catch (PDOException $e) {
            // Log the error
            return false;
        }
    }
}