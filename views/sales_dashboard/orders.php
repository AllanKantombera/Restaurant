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


?>
<?php
require_once __DIR__ . '/../../app/Controllers/OrderController.php';

$controller = new OrderController();
$orders = $controller->getOrdersForSales();



$statuses = [
    'Pending',
    'Preparing',
    'Out for Delivery',
    'Delivered',
    'Cancelled'
];
?>

<?php if (!empty($orders)): ?>
<?php foreach ($orders as $order): ?>

<?php endforeach; ?>
<?php else: ?>
<tr>
    <td colspan="7" class="text-center text-muted">
        No orders found
    </td>
</tr>
<?php endif; ?>


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
    <!-- Fixed Navbar -->

    <nav class="navbar navbar-dark px-4">
        <a class="navbar-brand d-flex align-items-center" href="#">
            <div class="logo">AJ</div>
            <span class="text-light fw-bold">Aunt Joy's Restaurant</span>
        </a>
    
        <div class="dropdown">
            <button class="btn btn-dark d-flex align-items-center dropdown-toggle" 
                    type="button" data-bs-toggle="dropdown" aria-expanded="false">
                
                <div class="logo me-2"><?= $initials; ?></div>
                
                <span class="text-light"><?= htmlspecialchars($userName); ?></span>
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
                    <!-- Overview -->
                    <li class="nav-item mb-2">
                        <a class="nav-link " href="index.php">
                            <i class="bi bi-speedometer2 me-2"></i> Overview
                        </a>
                    </li>
                    <!-- Orders -->
                    <li class="nav-item mb-2">
                        <a class="nav-link active" href="orders.php">
                            <i class="bi bi-bag-check me-2"></i> Orders
                        </a>
                    </li>
                    <!-- Orders List -->
                    <li class="nav-item mb-2">
                        <a class="nav-link" href="orderslist.php">
                            <i class="bi bi-card-checklist me-2"></i> Orders List
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
                    <h2 class="section-title">Orders Management</h2>
                    <div class="text-end">
                        <div class="text-light small" id="currentDateTime"></div>
                    </div>
                </div>

                <!-- Pending Orders Section -->
                <div class="card card-custom p-4 mb-4">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h4 class="section-title mb-0">
                            <i class="bi bi-clock-history me-2"></i>Pending Orders

                        </h4>

                    </div>

                    <div class="table-responsive">
                        <table class="table table-dark table-hover" id="pendingOrdersTable">
                            <thead>
                                <tr>
                                    <th>Order ID</th>
                                    <th>Customer</th>
                                    <th>Items</th>
                                    <th>Total</th>
                                    <th>Time Placed</th>
                                    <th>Location</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($orders as $order): ?>
                                <tr data-status="<?= $order['status']; ?>">
                                    <td class="fw-bold">#
                                        <?= $order['id']; ?>
                                    </td>

                                    <td>
                                        <div>
                                            <?= htmlspecialchars($order['customer_name'] ?? 'Guest'); ?>
                                        </div>
                                    </td>

                                    <td>
                                        <?php foreach ($order['items'] as $item): ?>
                                        <span class="d-block">
                                            <?= $item['quantity']; ?>x
                                            <?= htmlspecialchars($item['meal_name']); ?>
                                        </span>
                                        <?php endforeach; ?>
                                    </td>

                                    <td class="fw-bold" style="color:#ffd700;">
                                        K
                                        <?= number_format($order['total_amount']); ?>
                                    </td>

                                    <td>
                                        <span>
                                            <?= date('H:i', strtotime($order['created_at'])); ?>
                                        </span>
                                        <small class="d-block text-warning">
                                            <?= floor((time() - strtotime($order['created_at'])) / 60); ?> mins ago
                                        </small>
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
                                        <?php
                                    $badge = match ($order['status']) {
                                        'Pending'   => 'bg-info',
                                        'Out for Delivery'   => 'bg-info',
                                        'Preparing' => 'bg-warning text-dark',
                                        'Ready'     => 'bg-success',
                                        'Delivered' => 'bg-secondary',
                                        'Cancelled' => 'bg-danger',
                                    };
                                    ?>
                                        <span class="badge <?= $badge; ?>">
                                            <?= ucfirst($order['status']); ?>
                                        </span>
                                    </td>

                                    <td>
                                        <form method="POST" action="../../app/controllers/OrderController.php"
                                            class="d-flex gap-2">
                                            <input type="hidden" name="order_id" value="<?= $order['id'] ?>">

                                            <select name="status" class="form-select form-select-sm"
                                                style="color: white; background-color: black; border-color: black;">
                                                <?php foreach ($statuses as $status): ?>
                                                <option value="<?= $status ?>" <?=$order['status']===$status
                                                    ? 'selected' : '' ?>>
                                                    <?= $status ?>
                                                </option>
                                                <?php endforeach; ?>
                                            </select>
                                    </td>

                                    <td>
                                        <button type="submit" class="btn btn-primary btn-sm">
                                            Update
                                        </button>
                                        </form>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>




        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
<script>
    function updateOrderStatus(orderId, status) {
        if (!confirm("Update order status?")) return;

        fetch('../app/controllers/SalesController.php', {
            method: 'POST',
            headers: { "Content-Type": "application/x-www-form-urlencoded" },
            body: new URLSearchParams({
                order_id: orderId,
                status: status
            })
        })
            .then(res => res.text())
            .then(() => location.reload())
            .catch(err => console.error(err));
    }
</script>

</html>