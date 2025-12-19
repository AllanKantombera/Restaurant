<?php
require_once __DIR__ . '/../Models/Order.php';
require_once __DIR__ . '/../Models/OrderItem.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (isset($_POST['order_id'], $_POST['status'])) {

        $order_id = $_POST['order_id'];
        $status   = $_POST['status'];

       
        $allowedStatuses = [
            'Pending',
            'Preparing',
            'Out for Delivery',
            'Delivered',
            'Cancelled'
        ];

        if (!in_array($status, $allowedStatuses)) {
            die('Invalid status');
        }

        $order = new Order();
        $order->updateStatus($order_id, $status);

        header("Location: ../../views/sales_dashboard/orders.php");
        exit;
    }
}



class OrderController {

    private $orderModel;
    private $orderItemModel;

    public function __construct() {
        $this->orderModel = new Order();        
        $this->orderItemModel = new OrderItem();
    }

    public function getOrdersForSales() {
        $orders = $this->orderModel->getAll();

        foreach ($orders as &$order) {
            $order['items'] = $this->orderItemModel->getByOrderId($order['id']);
        }

        return $orders;
    }
   
}
