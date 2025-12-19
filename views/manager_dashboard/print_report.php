<?php
require_once __DIR__ . '/../../app/models/Order.php';

$month = $_GET['month'] ?? date('m');
$year  = $_GET['year'] ?? date('Y');

$orderModel = new Order();

$summary = $orderModel->getMonthlySummary($month, $year);

$orders = $orderModel->getOrdersByMonth($month, $year);

$bestItems = $orderModel->getBestSellingItems($month, $year);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Aunt Joy’s Restaurant – Sales Report</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="../../assests/css/dashboard.css" rel="stylesheet">

    <style>
        body {
            background: #0b0f1a;
            color: #ffffff;
            font-family: 'Segoe UI', sans-serif;
        }

        .brand {
            color: #00b4ff;
            font-weight: 700;
            letter-spacing: 1px;
        }

        .card {
            background: #11162a;
            border: 1px solid #00b4ff;
        }

        .metric {
            color: #00b4ff;
            font-size: 1.6rem;
            font-weight: bold;
        }

        table {
            color: #ffffff;
        }

        thead {
            background: #151616;
            color: #ffffff;
        }

        tbody tr:nth-child(even) {
            background: #151b30;
        }

        .badge {
            background: #00b4ff;
            color: #f3f3f3;
        }

        @media print {
            .no-print { display: none; }
        }
    </style>
</head>

<body>

<div class="container my-4">

    <!-- HEADER -->
    <div class="text-center mb-4">
        <h1 class="brand">AUNT JOY’S RESTAURANT</h1>
        <p class="text-muted">
            Sales Report — <?= date('F Y', strtotime("$year-$month-01")) ?>
        </p>
    </div>

    <!-- METRICS -->
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card p-3 text-center">
                <div class="metric">MWK <?= number_format($summary['total_revenue'] ?? 0) ?></div>
                <small>Total Revenue</small>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card p-3 text-center">
                <div class="metric"><?= $summary['total_orders'] ?? 0 ?></div>
                <small>Total Orders</small>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card p-3 text-center">
                <div class="metric">MWK <?= number_format($summary['avg_order'] ?? 0) ?></div>
                <small>Avg Order Value</small>
            </div>
        </div>
    </div>

    <!-- BEST SELLING -->
    <h5 class="brand mb-2">Best Selling Items</h5>
    <table class="table table-sm table-bordered mb-4">
        <thead>
            <tr>
                <th>Meal</th>
                <th>Units Sold</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($bestItems as $item): ?>
                <tr>
                    <td><?= htmlspecialchars($item['name']) ?></td>
                    <td><?= $item['total_sold'] ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <!-- ORDERS -->
    <h5 class="brand mb-2">Orders</h5>
    <table class="table table-sm table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>Amount</th>
                <th>Status</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($orders as $order): ?>
                <tr>
                    <td>#<?= $order['id'] ?></td>
                    <td>MWK <?= number_format($order['total_amount']) ?></td>
                    <td><span class="badge"><?= $order['status'] ?></span></td>
                    <td><?= date('d M Y, H:i', strtotime($order['created_at'])) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <div class="text-center mt-4 no-print">
        <button onclick="window.print()" class="btn btn-outline-light px-4">
            Export PDF
        </button>
    </div>

</div>

</body>
</html>