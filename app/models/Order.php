<?php

require_once __DIR__ . '/../../config/Database.php';

class Order {
    private $conn;
    private $table = "orders";

    public function __construct() {
        $database = new Database();
        $this->conn = $database->connect();
    }

    public function create($data) {
        $sql = "
            INSERT INTO orders 
            (user_id, delivery_address, location, total_amount, status, created_at)
            VALUES (?, ?, ?, ?, ?, NOW())
        ";
    
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([
            $data['user_id'],
            $data['delivery_address'],
            $data['location'],
            $data['total_amount'],
            $data['status']
        ]);
    
        return $this->conn->lastInsertId();
    }
    

    public function getAll() {
        $sql = "
            SELECT o.*, u.name AS customer_name
            FROM orders o
            LEFT JOIN users u ON u.id = o.user_id
            ORDER BY o.created_at DESC
        ";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    
    public function updateStatus($order_id, $status) {
        $sql = "UPDATE {$this->table} 
                SET status = ?, updated_at = NOW()
                WHERE id = ?";

        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([$status, $order_id]);
    }

    public function getAllWithUser() {
        $sql = "
            SELECT 
                o.*,
                u.name AS customer_name
            FROM orders o
            JOIN users u ON u.id = o.user_id
            ORDER BY o.created_at DESC
        ";
    
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getByUserId($user_id) {
        $sql = "
            SELECT *
            FROM {$this->table}
            WHERE user_id = ?
            ORDER BY created_at DESC
        ";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$user_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getMonthlyReport($month, $year) {
        $sql = "
            SELECT 
                COUNT(*) AS total_orders,
                SUM(total_amount) AS total_revenue
            FROM orders
            WHERE MONTH(created_at) = ?
            AND YEAR(created_at) = ?
            AND status != 'Cancelled'
        ";
    
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$month, $year]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public function getSummary($month, $year)
    {
        $sql = "
            SELECT 
                COUNT(*) AS total_orders,
                SUM(total_amount) AS total_revenue
            FROM orders
            WHERE MONTH(created_at)=? AND YEAR(created_at)=?
        ";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$month, $year]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getBestSellingItems($month, $year)
    {
        $sql = "
            SELECT m.name,
                   SUM(oi.quantity) AS total_sold,
                   SUM(oi.line_total) AS revenue
            FROM order_items oi
            JOIN orders o ON o.id = oi.order_id
            JOIN meals m ON m.id = oi.meal_id
            WHERE MONTH(o.created_at)=? AND YEAR(o.created_at)=?
            GROUP BY oi.meal_id
            ORDER BY total_sold DESC
            LIMIT 5
        ";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$month, $year]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getOrdersByMonth($month, $year)
    {
        $sql = "
            SELECT id, total_amount, created_at, status
            FROM orders
            WHERE MONTH(created_at)=? AND YEAR(created_at)=?
            ORDER BY created_at DESC
        ";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$month, $year]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getMonthlySummary($month, $year)
{
    $sql = "
        SELECT 
            COUNT(*) AS total_orders,
            SUM(total_amount) AS total_revenue,
            AVG(total_amount) AS avg_order
        FROM orders
        WHERE MONTH(created_at)=? AND YEAR(created_at)=?
          AND status != 'Cancelled'
    ";
    $stmt = $this->conn->prepare($sql);
    $stmt->execute([$month, $year]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}




}
