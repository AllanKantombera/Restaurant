<?php
require_once __DIR__ . '/../../config/Database.php';

class Meal {
    private $conn;
    private $table = "meals";

    public function __construct() {
        $database = new Database();
        $this->conn = $database->connect();
    }

    // Create a new meal
    public function create($data) {
        $sql = "INSERT INTO {$this->table} 
                (name, description, price, category_id, is_available, image_url, created_at, updated_at)
                VALUES (:name, :description, :price, :category_id, :is_available, :image_url, NOW(), NOW())";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':name', $data['name']);
        $stmt->bindParam(':description', $data['description']);
        $stmt->bindParam(':price', $data['price']);
        $stmt->bindParam(':category_id', $data['category_id']);
        $stmt->bindParam(':is_available', $data['is_available']);
        $stmt->bindParam(':image_url', $data['image_url']);

        return $stmt->execute();
    }

    public function getAll() {
        $stmt = $this->conn->prepare("SELECT * FROM meals ORDER BY id DESC");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getById($id) {
        $sql = "SELECT * FROM meals WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public function updateMeal($data) {
        $sql = "UPDATE meals SET name=?, description=?, price=?, category_id=?, is_available=?, image_url=? WHERE id=?";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            $data['name'],
            $data['description'],
            $data['price'],
            $data['category_id'],
            $data['is_available'],
            $data['image_url'],
            $data['id']
        ]);
    }

    
public function delete($id) {
    $query = "DELETE FROM " . $this->table . " WHERE id = :id";
    
    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(':id', $id);

    if ($stmt->execute()) {
        return true;
    }
    return false;
}

    public function getLatestMeals() {
        $query = "
        SELECT * FROM meals WHERE is_available = 1 ORDER BY id DESC LIMIT 3
        ";
        
        $stmt = $this->conn->prepare($query);
        
        try {
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            // Log error
            return [];
        }
    }

    public function Menu() {
        $query = "
        SELECT * FROM meals WHERE is_available = 1 ORDER BY id DESC
        ";
        
        $stmt = $this->conn->prepare($query);
        
        try {
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            // Log error
            return [];
        }
    }
    public function getByCategory($category_id) {
        $sql = "SELECT * FROM meals 
                WHERE category_id = ? AND is_available = 1
                ORDER BY id DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$category_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function search($keyword) {
        $sql = "SELECT * FROM meals
                WHERE is_available = 1
                AND (name LIKE :keyword OR description LIKE :keyword)
                ORDER BY name ASC";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':keyword', '%' . $keyword . '%', PDO::PARAM_STR);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


}