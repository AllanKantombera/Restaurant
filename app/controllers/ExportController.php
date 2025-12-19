<?php
require_once __DIR__ . '/../Models/Order.php';

$month = $_GET['month'] ?? date('m');
$year  = $_GET['year'] ?? date('Y');

$order = new Order();

$summary = $order->getSummary($month, $year);
$best    = $order->getBestSellingItems($month, $year);
$orders  = $order->getOrdersByMonth($month, $year);

header('Content-Type: text/csv');
header("Content-Disposition: attachment; filename=sales_report_{$month}_{$year}.csv");

$output = fopen('php://output', 'w');

fputcsv($output, ['SALES REPORT']);
fputcsv($output, ['Month', date("F", mktime(0,0,0,$month,1)) . " $year"]);
fputcsv($output, []);
fputcsv($output, ['Total Revenue', $summary['total_revenue'] ?? 0]);
fputcsv($output, ['Total Orders', $summary['total_orders'] ?? 0]);

fputcsv($output, []);
fputcsv($output, ['BEST SELLING ITEMS']);
fputcsv($output, ['Meal', 'Quantity Sold', 'Revenue']);

foreach ($best as $item) {
    fputcsv($output, [
        $item['name'],
        $item['total_sold'],
        $item['revenue']
    ]);
}

fputcsv($output, []);
fputcsv($output, ['ORDERS LIST']);
fputcsv($output, ['Order ID', 'Amount', 'Status', 'Date']);

foreach ($orders as $o) {
    fputcsv($output, [
        '#' . $o['id'],
        $o['total_amount'],
        $o['status'],
        date('d M Y H:i', strtotime($o['created_at']))
    ]);
}

fclose($output);
exit;
