<?php
require_once __DIR__ . '/../../config/Database.php';

class OrderItem {

    private $conn;
    private $table = "order_items";

    public function __construct() {
        $database = new Database();
        $this->conn = $database->connect();
    }

   

    public function create($data) {
        $sql = "
            INSERT INTO order_items
            (order_id, meal_id, quantity, unit_price, line_total, created_at)
            VALUES (?, ?, ?, ?, ?, NOW())
        ";
    
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            $data['order_id'],
            $data['meal_id'],
            $data['quantity'],
            $data['unit_price'],
            $data['line_total']
        ]);
    }
    

   
    public function getByOrderId($order_id) {
        $sql = "
            SELECT 
                oi.id,
                oi.order_id,
                oi.meal_id,
                oi.quantity,
                oi.unit_price,
                oi.line_total,
                m.name AS meal_name
            FROM order_items oi
            JOIN meals m ON m.id = oi.meal_id
            WHERE oi.order_id = ?
        ";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$order_id]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

  
    public function deleteByOrderId($order_id) {
        $sql = "DELETE FROM {$this->table} WHERE order_id = ?";

        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([$order_id]);
    }
    public function getBestSellingItems($month, $year) {
        $sql = "
            SELECT 
                m.name,
                SUM(oi.quantity) AS total_sold,
                SUM(oi.line_total) AS revenue
            FROM order_items oi
            JOIN meals m ON m.id = oi.meal_id
            JOIN orders o ON o.id = oi.order_id
            WHERE MONTH(o.created_at) = ?
              AND YEAR(o.created_at) = ?
              AND o.status != 'Cancelled'
            GROUP BY oi.meal_id
            ORDER BY total_sold DESC
            LIMIT 5
        ";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$month, $year]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
}
