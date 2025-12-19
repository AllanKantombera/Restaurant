<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/../models/Order.php';
require_once __DIR__ . '/../models/OrderItem.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../../public/login.php?redirect=checkout");
    exit;
}



$cart = $_SESSION['cart'] ?? [];

if (empty($cart)) {
    header("Location: ../../views/cart.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: ../../views/cart.php");
    exit;
}

$delivery_address = trim($_POST['delivery_address'] ?? '');
$gps_location     = trim($_POST['gps_location'] ?? '');

if (empty($delivery_address) && empty($gps_location)) {
    die("Delivery address or GPS location is required.");
}

$location = !empty($gps_location) ? $gps_location : null;

$totalAmount = 0;
foreach ($cart as $item) {
    $totalAmount += ($item['price'] * $item['qty']);
}

$orderModel = new Order();

$orderData = [
    'user_id'          => $_SESSION['user_id'], 
    'delivery_address'=> $delivery_address ?: 'GPS Location',
    'location'         => $location,
    'total_amount'     => $totalAmount,
    'status'           => 'Pending'
];

$order_id = $orderModel->create($orderData);

if (!$order_id) {
    die("Failed to create order.");
}

$orderItemModel = new OrderItem();

foreach ($cart as $item) {
    $orderItemModel->create([
        'order_id'   => $_SESSION['user_id'],
        'meal_id'    => $item['id'],
        'quantity'   => $item['qty'],
        'unit_price'=> $item['price'],
        'line_total'=> $item['price'] * $item['qty']
    ]);
}

unset($_SESSION['cart']);

header("Location: ../../views/order_success.php?order_id=" . $order_id);
exit;