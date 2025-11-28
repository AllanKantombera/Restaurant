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

        <div class="d-flex">
            <span class="text-light me-3">sales User</span>
            <button class="btn btn-sm btn-outline-light">Logout</button>
        </div>
    </nav>

    <div class="container-fluid">
        <div class="row">
            <!-- SIDEBAR -->
            <div class="col-md-2 sidebar">
                <ul class="nav flex-column">
                    <!-- Overview -->
                    <li class="nav-item mb-2">
                        <a class="nav-link active" href="index.html">
                            <i class="bi bi-speedometer2 me-2"></i> Overview
                        </a>
                    </li>
                    <!-- Orders -->
                    <li class="nav-item mb-2">
                        <a class="nav-link" href="orders.html">
                            <i class="bi bi-bag-check me-2"></i> Orders
                        </a>
                    </li>
                    <!-- Orders List -->
                    <li class="nav-item mb-2">
                        <a class="nav-link" href="orderslist.html">
                            <i class="bi bi-card-checklist me-2"></i> Orders List
                        </a>
                    </li>
                </ul>
            </div>



            <!-- MAIN CONTENT -->
            <div class="col-md-10 main-content">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2 class="section-title">Sales Overview</h2>
                    <div class="text-end">
                        <div class="text-light small">Today: <span id="currentDate"></span></div>
                        <div class="text-muted small" id="currentTime"></div>
                    </div>
                </div>

                <!-- STAT CARDS -->
                <div class="row mb-4 text-light">
                    <!-- Pending Orders -->
                    <div class="col-md-3 mb-3">
                        <div class="card card-custom p-3 text-center stats-pending">
                            <i class="bi bi-clock-history card-icon"></i>
                            <h3>8</h3>
                            <p>Pending Orders</p>
                            <small class="text-warning"><i class="bi bi-arrow-up"></i> 2 waiting</small>
                        </div>
                    </div>

                    <!-- Delivered Orders -->
                    <div class="col-md-3 mb-3">
                        <div class="card card-custom p-3 text-center stats-delivered">
                            <i class="bi bi-check-circle-fill card-icon"></i>
                            <h3>24</h3>
                            <p>Delivered Orders</p>
                            <small class="text-success"><i class="bi bi-arrow-up"></i> 65% success rate</small>
                        </div>
                    </div>

                    <!-- Total Orders Today -->
                    <div class="col-md-3 mb-3">
                        <div class="card card-custom p-3 text-center stats-total">
                            <i class="bi bi-cart-check-fill card-icon"></i>
                            <h3>32</h3>
                            <p>Total Orders Today</p>
                            <small class="text-info">+4 from yesterday</small>
                        </div>
                    </div>

                    <!-- Total Revenue Today -->
                    <div class="col-md-3 mb-3">
                        <div class="card card-custom p-3 text-center stats-revenue">
                            <i class="bi bi-cash-coin card-icon"></i>
                            <h3>K 86,400</h3>
                            <p>Total Revenue Today</p>
                            <small class="text-success"><i class="bi bi-arrow-up"></i> 12% growth</small>
                        </div>
                    </div>
                </div>

                <!-- Top Pending Orders Table -->
                <div class="card card-custom p-4">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h4 class="section-title mb-0">Top Pending Orders</h4>
                        <a href="#" class="btn btn-sm btn-outline-primary">View All Orders</a>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-dark table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>Order #</th>
                                    <th>Customer</th>
                                    <th>Items</th>
                                    <th>Total</th>
                                    <th>Time Placed</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="fw-bold">#4325</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="rounded-circle d-flex align-items-center justify-content-center me-2"
                                                style="width: 32px; height: 32px; background: linear-gradient(135deg, #65b9ff, #79bffd); color: white; font-size: 0.8rem; font-weight: bold;">
                                                PM
                                            </div>
                                            Peter Mwale
                                        </div>
                                    </td>
                                    <td>
                                        <span class="d-block">2x Chicken Burger</span>
                                        <small class="text-muted">1x Fries, 2x Coke</small>
                                    </td>
                                    <td class="fw-bold" style="color: #ffd700;">K 12,500</td>
                                    <td>
                                        <span class="text-warning">15 mins ago</span>
                                    </td>
                                    <td>
                                        <span class="badge bg-warning text-dark">Preparing</span>
                                    </td>
                                    <td>
                                        <button class="btn btn-sm btn-success">
                                            <i class="bi bi-check-lg me-1"></i>Ready
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">#4324</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="rounded-circle d-flex align-items-center justify-content-center me-2"
                                                style="width: 32px; height: 32px; background: linear-gradient(135deg, #198754, #20c997); color: white; font-size: 0.8rem; font-weight: bold;">
                                                SK
                                            </div>
                                            Sarah Kunda
                                        </div>
                                    </td>
                                    <td>
                                        <span class="d-block">1x Beef Pizza</span>
                                        <small class="text-muted">Large, Extra Cheese</small>
                                    </td>
                                    <td class="fw-bold" style="color: #ffd700;">K 8,200</td>
                                    <td>
                                        <span class="text-warning">22 mins ago</span>
                                    </td>
                                    <td>
                                        <span class="badge bg-info">Pending</span>
                                    </td>
                                    <td>
                                        <button class="btn btn-sm btn-warning">
                                            <i class="bi bi-arrow-clockwise me-1"></i>Preparing
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">#4323</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="rounded-circle d-flex align-items-center justify-content-center me-2"
                                                style="width: 32px; height: 32px; background: linear-gradient(135deg, #fd7e14, #ffc107); color: white; font-size: 0.8rem; font-weight: bold;">
                                                TM
                                            </div>
                                            Thomas Banda
                                        </div>
                                    </td>
                                    <td>
                                        <span class="d-block">1x Grilled Chicken</span>
                                        <small class="text-muted">With Vegetables, Rice</small>
                                    </td>
                                    <td class="fw-bold" style="color: #ffd700;">K 6,500</td>
                                    <td>
                                        <span class="text-warning">35 mins ago</span>
                                    </td>
                                    <td>
                                        <span class="badge bg-info">Pending</span>
                                    </td>
                                    <td>
                                        <button class="btn btn-sm btn-warning">
                                            <i class="bi bi-arrow-clockwise me-1"></i>Preparing
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">#4322</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="rounded-circle d-flex align-items-center justify-content-center me-2"
                                                style="width: 32px; height: 32px; background: linear-gradient(135deg, #6f42c1, #d63384); color: white; font-size: 0.8rem; font-weight: bold;">
                                                LM
                                            </div>
                                            Lisa Mulenga
                                        </div>
                                    </td>
                                    <td>
                                        <span class="d-block">3x Vegetable Salad</span>
                                        <small class="text-muted">2x Juice, 1x Water</small>
                                    </td>
                                    <td class="fw-bold" style="color: #ffd700;">K 9,600</td>
                                    <td>
                                        <span class="text-warning">48 mins ago</span>
                                    </td>
                                    <td>
                                        <span class="badge bg-warning text-dark">Preparing</span>
                                    </td>
                                    <td>
                                        <button class="btn btn-sm btn-success">
                                            <i class="bi bi-check-lg me-1"></i>Ready
                                        </button>
                                    </td>
                                </tr>
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