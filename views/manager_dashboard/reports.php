<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['role_id']) || $_SESSION['role_id'] != 2) {
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

require_once __DIR__ . '/../../app/Controllers/OrderController.php';


$orderModel = new Order();
$orderItemModel = new OrderItem();

$month = $_GET['month'] ?? date('m');
$year  = $_GET['year'] ?? date('Y');

$summary = $orderModel->getMonthlyReport($month, $year);
$bestSelling = $orderItemModel->getBestSellingItems($month, $year);

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
                        <a class="nav-link" href="index.php">
                            <i class="bi bi-speedometer2 me-2"></i> Overview
                        </a>
                    </li>

                    <li class="nav-item mb-2">
                        <a class="nav-link active" href="reports.php">
                            <i class="bi bi-graph-up me-2"></i> Reports
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

                <!-- Header -->
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2 class="section-title">Analytics & Reports</h2>

                    <form method="GET" class="d-flex gap-2">
                        <select name="month" class="form-select bg-dark text-white border-secondary">
                            <?php for ($m = 1; $m <= 12; $m++): ?>
                            <option value="<?= $m ?>" <?=$m==$month ? 'selected' : '' ?>>
                                <?= date("F", mktime(0, 0, 0, $m, 1)) ?>
                            </option>
                            <?php endfor; ?>
                        </select>

                        <select name="year" class="form-select bg-dark text-white border-secondary">
                            <?php for ($y = date('Y'); $y >= 2023; $y--): ?>
                            <option value="<?= $y ?>" <?=$y==$year ? 'selected' : '' ?>>
                                <?= $y ?>
                            </option>
                            <?php endfor; ?>
                        </select>

                        <button class="btn btn-primary fw-semibold">
                            <i class="bi bi-filter"></i> Apply
                        </button>
                    </form>
                </div>

                <!-- Key Metrics Cards -->
                <div class="row mb-4">

                    <!-- Total Revenue -->
                    <div class="col-md-3 mb-3">
                        <div class="card card-custom p-4 text-center">
                            <i class="bi bi-currency-dollar card-icon"></i>
                            <h3 class="metric-value">
                                K
                                <?= number_format($summary['total_revenue'] ?? 0) ?>
                            </h3>
                            <p class="metric-label">Total Revenue</p>
                        </div>
                    </div>

                    <!-- Total Orders -->
                    <div class="col-md-3 mb-3">
                        <div class="card card-custom p-4 text-center">
                            <i class="bi bi-cart-check card-icon"></i>
                            <h3 class="metric-value">
                                <?= $summary['total_orders'] ?? 0 ?>
                            </h3>
                            <p class="metric-label">Total Orders</p>
                        </div>
                    </div>

                    <!-- Avg Order -->
                    <div class="col-md-3 mb-3">
                        <div class="card card-custom p-4 text-center">
                            <i class="bi bi-graph-up card-icon"></i>
                            <h3 class="metric-value">
                                K
                                <?= number_format(
                        ($summary['total_orders'] ?? 0) > 0
                        ? ($summary['total_revenue'] / $summary['total_orders'])
                        : 0
                    ) ?>
                            </h3>
                            <p class="metric-label">Avg Order Value</p>
                        </div>
                    </div>

                    <!-- Best Seller -->
                    <div class="col-md-3 mb-3">
                        <div class="card card-custom p-4 text-center">
                            <i class="bi bi-trophy card-icon"></i>
                            <h5 class="metric-value">
                                <?= $bestSelling[0]['name'] ?? 'N/A' ?>
                            </h5>
                            <p class="metric-label">Best Selling Item</p>
                        </div>
                    </div>

                </div>

                <!-- Best Selling Table -->
                <div class="card card-custom p-3">
                    <h5 class="mb-3 fw-semibold">
                        Best Selling Meals
                    </h5>

                    <div class="table-responsive">
                        <table class="table table-dark table-hover align-middle mb-0">
                            <thead>
                                <tr>
                                    <th>Meal</th>
                                    <th>Quantity Sold</th>
                                    <th>Revenue</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($bestSelling)): ?>
                                <?php foreach ($bestSelling as $item): ?>
                                <tr>
                                    <td>
                                        <?= htmlspecialchars($item['name']) ?>
                                    </td>
                                    <td>
                                        <?= $item['total_sold'] ?>
                                    </td>
                                    <td>K
                                        <?= number_format($item['revenue']) ?>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                                <?php else: ?>
                                <tr>
                                    <td colspan="3" class="text-center text-muted">
                                        No data available
                                    </td>
                                </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div><br>
                <a href="../../app/controllers/ExportController.php?month=<?= $month ?>&year=<?= $year ?>"
                    class="btn btn-primary">
                    <i class="bi bi-file-earmark-excel"></i> Export Excel
                </a>
                <a href="print_report.php?month=<?= $month ?>&year=<?= $year ?>" target="_blank"
                    class="btn btn-primary">
                    <i class="bi bi-file-earmark-pdf"></i> Export PDF
                </a>

            </div>


</body>

</html>