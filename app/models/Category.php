<?php
require_once __DIR__ . '/../../config/Database.php';

class Category {
    private $conn;
    private $table = "categories";

    public function __construct() {
        $database = new Database();
        $this->conn = $database->connect();
    }

    public function getAll() {
        $stmt = $this->conn->prepare("SELECT * FROM {$this->table} ORDER BY name ASC");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
