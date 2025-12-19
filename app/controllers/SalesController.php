<?php
session_start();
require_once __DIR__ . '/../../config/Database.php';

$db = (new Database())->connect();

$stmt = $db->prepare("
    SELECT o.*, u.name AS customer_name
    FROM orders o
    LEFT JOIN users u ON u.id = o.user_id
    ORDER BY o.created_at DESC
");
$stmt->execute();
$orders = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach ($orders as &$order) {
    $itemsStmt = $db->prepare("
        SELECT oi.*, m.name
        FROM order_items oi
        JOIN meals m ON m.id = oi.meal_id
        WHERE oi.order_id = ?
    ");
    $itemsStmt->execute([$order['id']]);
    $order['items'] = $itemsStmt->fetchAll(PDO::FETCH_ASSOC);
}

require_once __DIR__ . '/../../views/sales_dashboard/orders.php';



if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $orderId = intval($_POST['order_id']);
    $status  = $_POST['status'];

    $allowed = ['pending', 'preparing', 'ready', 'delivered'];

    if (!in_array($status, $allowed)) {
        http_response_code(400);
        echo "Invalid status";
        exit;
    }

    $stmt = $db->prepare("
        UPDATE orders 
        SET status = ?, updated_at = NOW()
        WHERE id = ?
    ");
    $stmt->execute([$status, $orderId]);

    echo "success";
    exit;
}
