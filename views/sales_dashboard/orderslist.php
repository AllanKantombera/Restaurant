<?php
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    if (!isset($_SESSION['role_id']) || $_SESSION['role_id'] != 3) {
        header("Location: ../../public/login.php");
        exit;
    }

    $userName = $_SESSION['user_name'] ?? 'Guest';
    $initials = '';

    function getInitials($fullName) {
        if (strpos($fullName, ' ') === false) {
            return strtoupper(substr($fullName, 0, 1));
        }
        
        $parts = explode(' ', $fullName);
        $initials = '';
        
        $initials .= strtoupper(substr($parts[0], 0, 1));
        
        if (count($parts) > 1) {
            $initials .= strtoupper(substr(end($parts), 0, 1));
        }
        
        return $initials;
    }

    if ($userName !== 'Guest') {
        $initials = getInitials($userName);
    }

    require_once __DIR__ . '/../../app/models/Order.php';
    require_once __DIR__ . '/../../app/models/OrderItem.php';

    $orderModel = new Order();
    $orderItemModel = new OrderItem();

    $orders = $orderModel->getAllWithUser();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aunt Joy's Restaurant | Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="../../assests/css/dashboard.css" rel="stylesheet">

</head>

<body>

    <nav class="navbar navbar-dark px-4">
        <a class="navbar-brand d-flex align-items-center" href="#">
            <div class="logo">AJ</div>
            <span class="text-light fw-bold">Aunt Joy's Restaurant</span>
        </a>

        <div class="dropdown">
            <button class="btn btn-dark d-flex align-items-center dropdown-toggle" type="button"
                data-bs-toggle="dropdown" aria-expanded="false">

                <div class="logo me-2">
                    <?= $initials; ?>
                </div>

                <span class="text-light">
                    <?= htmlspecialchars($userName); ?>
                </span>
            </button>

            <ul class="dropdown-menu dropdown-menu-end bg-dark">
                <li>
                    <a class="dropdown-item bg-dark text-danger" href="../../public/logout.php">
                        Logout
                    </a>
                </li>
            </ul>
        </div>
    </nav>

    <div class="container-fluid">
        <div class="row">
            <!-- SIDEBAR -->
            <div class="col-md-2 sidebar">
                <ul class="nav flex-column">
                    <li class="nav-item mb-2">
                        <a class="nav-link " href="index.php">
                            <i class="bi bi-speedometer2 me-2"></i> Overview
                        </a>
                    </li>

                    <li class="nav-item mb-2">
                        <a class="nav-link" href="orders.php">
                            <i class="bi bi-list-ul me-2"></i> Orders
                        </a>
                    </li>

                    <li class="nav-item mb-2">
                        <a class="nav-link active" href="orderslist.php">
                            <i class="bi bi-people-fill me-2"></i> Orders List
                        </a>
                    </li>
                    <li class="nav-item mb-2">
                        <a class="nav-link" href="../index.php">
                            <i class="bi bi-home me-2"></i> Home
                        </a>
                    </li>
                </ul>
            </div>

            <!-- MAIN CONTENT -->
            <div class="col-md-10 main-content">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2 class="section-title">All Orders</h2>
                    
                </div>


                <!-- All Orders Table -->
                <div class="card card-custom p-4">
                  

                    <div class="table-responsive">
                        <table class="table table-dark table-hover">
                            <thead>
                                <tr>
                                    <th>Order ID</th>
                                    <th>Customer</th>
                                    <th>Items</th>
                                    <th>Amount</th>
                                    <th>Location</th>
                                    <th>Order Time</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                    <?php if (!empty($orders)): ?>
                                    <?php foreach ($orders as $order): ?>
                                    <?php
                                    $items = $orderItemModel->getByOrderId($order['id']);
                                ?>
                                <tr>
                                    <td>#
                                        <?= $order['id'] ?>
                                    </td>

                                    <td>
                                        <strong>
                                            <?= htmlspecialchars($order['customer_name']) ?>
                                        </strong>
                                    </td>

                                    <td>
                                        <?php if (!empty($items)): ?>
                                        <ul class="list-unstyled mb-0">
                                            <?php foreach ($items as $item): ?>
                                            <li>
                                                <?= $item['meal_name'] ?>
                                                ×
                                                <?= $item['quantity'] ?>
                                            </li>
                                            <?php endforeach; ?>
                                        </ul>
                                        <?php else: ?>
                                        <em>No items</em>
                                        <?php endif; ?>
                                    </td>

                                    <td>
                                        <strong>K
                                            <?= number_format($order['total_amount'], 2) ?>
                                        </strong>
                                    </td>
                                    <td>

                                        <?php if (!empty($order['location'])): ?>
                                        <?= htmlspecialchars($order['delivery_address'] ?? 'N/A') ?><br>

                                        <?php
                                            $coords = trim($order['location'], '()');
                                            $mapUrl = "https://www.google.com/maps?q={$coords}";
                                        ?>
                                        <a href="<?= $mapUrl ?>" target="_blank" class="text-decoration-none">
                                            <i class="bi bi-geo-alt-fill text-danger"></i>
                                            View Location
                                        </a>
                                        <?php else: ?>
                                        <em>No location</em>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?= date('d M Y, H:i', strtotime($order['created_at'])) ?>
                                    </td>

                                    <td>
                                    <span class="badge 
                                    <?php
                                        switch ($order['status']) {
                                            case 'Pending': echo 'bg-warning'; break;
                                            case 'Preparing': echo 'bg-info'; break;
                                            case 'Out for Delivery': echo 'bg-primary'; break;
                                            case 'Delivered': echo 'bg-success'; break;
                                            case 'Cancelled': echo 'bg-danger'; break;
                                            default: echo 'bg-secondary';
                                        }
                                    ?>">
                                            <?= $order['status'] ?>
                                        </span>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                                <?php else: ?>
                                <tr>
                                    <td colspan="6" class="text-center text-muted">
                                        No orders found
                                    </td>
                                </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>


                </div>
            </div>





        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>