<?php
session_start();

$is_logged_in = isset($_SESSION['user_id']);
$userName = $_SESSION['user_name'] ?? 'Guest';
$initials = '';

function getInitials($fullName) {
    $parts = explode(' ', $fullName);
    $initials = strtoupper(substr($parts[0], 0, 1));
    if (count($parts) > 1) {
        $initials .= strtoupper(substr(end($parts), 0, 1));
    }
    return $initials;
}

if ($is_logged_in) {
    $initials = getInitials($userName);
}

$cartCount = isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0;
  

require_once __DIR__ . '/../app/models/Order.php';
require_once __DIR__ . '/../app/models/OrderItem.php';

$orderModel = new Order();
$orderItemModel = new OrderItem();

$orders = $orderModel->getByUserId($_SESSION['user_id']);

foreach ($orders as &$order) {
    $order['items'] = $orderItemModel->getByOrderId($order['id']);
}

            
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aunt Joy's Restaurant - Online Ordering</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
    <link href="../assests/css/style.css" rel="stylesheet">
</head>

<body>
    <!-- NAVBAR -->
    <nav class="navbar navbar-expand-lg fixed-top">
        <div class="container">

            <a class="navbar-brand fw-bold" href="#">
                <img src="../assests/img/logo11.png" alt="logo Logo" height="40"
                    style="border-style: solid; border-radius: 50px; border-color: #38bdf8;">
            </a>

            <button class="navbar-toggler bg-dark" type="button" data-bs-toggle="collapse" data-bs-target="#nav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="nav">

                <ul class="navbar-nav">
                    <li class="nav-item"><a href="index.php" class="nav-link">Home</a></li>
                    <li class="nav-item"><a href="menu.php" class="nav-link">Menu</a></li>
                    <li class="nav-item"><a href="myorders.php" class="nav-link">My Orders</a></li>
                    <li class="nav-item">
                        <a href="cart.php" class="nav-link cart-link">
                            <i class="fas fa-shopping-cart me-1"></i>
                            Cart (<span id="cart-count">
                                <?= $cartCount ?>
                            </span>)
                        </a>
                    </li>
                </ul>

                <form class="d-flex ms-auto me-lg-3 mt-2 mt-lg-0" action="search.php" method="GET" role="search">
                    <input class="form-control me-2 rounded-pill" type="search" name="q"
                        value="<?= htmlspecialchars($_GET['q'] ?? '') ?>" placeholder="Search food..."
                        aria-label="Search">

                    <button class="btn btn-outline-light rounded-pill" type="submit">
                        <i class="fa fa-search"></i>
                    </button>
                </form>

                <div class="d-flex mt-2 mt-lg-0">
                    <?php if ($is_logged_in): ?>
                    <div class="dropdown">
                        <button class="btn btn-dark d-flex align-items-center dropdown-toggle rounded-pill px-3"
                            type="button" data-bs-toggle="dropdown" aria-expanded="false"
                            style="background-color: #212529; border-color: #343a40;">

                            <span class="d-none d-md-inline me-1 text-light">
                                <?= htmlspecialchars($userName); ?>
                            </span>
                        </button>

                        <ul class="dropdown-menu dropdown-menu-end"
                            style="background-color: #212529; border-color: #343a40;">

                            <li>
                                <a class="dropdown-item text-danger" href="../public/logout.php"
                                    style="background-color: #212529;">
                                    <i class="fa fa-sign-out-alt me-1"></i> Logout
                                </a>
                            </li>
                        </ul>
                    </div>
                    <?php else: ?>
                    <a href="../public/login.php" class="btn rounded-pill" style="background-color: #38bdf8;">
                        <i class="fa fa-sign-in-alt me-1"></i> Login
                    </a>
                    <?php endif; ?>
                </div>
            </div>
    </nav>



    
<div class="container py-5">
    <h2 class="fw-bold mb-4">My Orders</h2>

    <?php if (empty($orders)): ?>
        <div class="alert alert-info text-center">
            You have no orders yet.
        </div>
    <?php else: ?>
        <div class="table-responsive">
            <table class="table table-bordered bg-white align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>Order #</th>
                        <th>Items</th>
                        <th>Delivery Location</th>
                        <th>Amount</th>
                        <th>Order Time</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>

                <?php foreach ($orders as $order): ?>
                    <tr>
                        <td class="fw-bold">#<?= $order['id']; ?></td>

                        <td>
                            <?php foreach ($order['items'] as $item): ?>
                                <div>
                                    <?= htmlspecialchars($item['meal_name']); ?> × <?= $item['quantity']; ?>
                                </div>
                            <?php endforeach; ?>
                        </td>

                        <td>
                            <?php if (strpos($order['delivery_address'], ',') !== false): ?>
                                <a target="_blank"
                                   href="https://www.google.com/maps?q=<?= urlencode($order['delivery_address']); ?>">
                                    📍 View on Map
                                </a>
                            <?php else: ?>
                                <?= htmlspecialchars($order['delivery_address']); ?>
                            <?php endif; ?>
                        </td>

                        <td class="fw-bold">
                            MWK <?= number_format($order['total_amount'], 2); ?>
                        </td>

                        <td>
                            <?= date('d M Y, H:i', strtotime($order['created_at'])); ?>
                        </td>

                        <td>
                            <span class="badge 
                                <?php
                                    switch ($order['status']) {
                                        case 'Delivered': echo 'bg-success'; break;
                                        case 'Cancelled': echo 'bg-danger'; break;
                                        case 'Out for Delivery': echo 'bg-primary'; break;
                                        case 'Preparing': echo 'bg-warning text-dark'; break;
                                        default: echo 'bg-secondary';
                                    }
                                ?>">
                                <?= $order['status']; ?>
                            </span>
                        </td>
                    </tr>
                <?php endforeach; ?>

                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>

</body>
</html>