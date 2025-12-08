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
                </ul>
            </div>

            <!-- MAIN CONTENT -->
            <div class="col-md-10 main-content">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2 class="section-title">All Orders</h2>
                    <div class="d-flex gap-2">
                        <div class="input-group" style="width: 300px;">
                            <span class="input-group-text"
                                style="background: #111723; border-color: #1e2a38; color: #9ecbff;">
                                <i class="bi bi-search"></i>
                            </span>
                            <input type="text" class="form-control"
                                style="background: #111723; border-color: #1e2a38; color: #dce7f5;"
                                placeholder="Search orders...">
                        </div>
                        <button class="btn btn-outline-primary">
                            <i class="bi bi-download me-1"></i>Export
                        </button>
                    </div>
                </div>



                <!-- Orders Summary Cards -->
                <div class="row mb-4">
                    <div class="col-md-3 mb-3">
                        <div class="card card-custom text-center p-3">
                            <div class="text-info">Total Orders</div>
                            <h4 class="my-2" style="color: #adb5bd;">156</h4>
                            <p>This month</p>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="card card-custom text-center p-3">
                            <div class="text-warning">Pending</div>
                            <h4 class="my-2" style="color: #adb5bd;">8</h4>
                            <p>Active orders</p>
                        </div>
                    </div>

                    <div class="col-md-3 mb-3">
                        <div class="card card-custom text-center p-3">
                            <div class="text-success">Completed</div>
                            <h4 class="my-2" style="color: #adb5bd;">142</h4>
                            <p>This month</p>
                        </div>
                    </div>

                    <div class="col-md-3 mb-3">
                        <div class="card card-custom text-center p-3">
                            <div class="text-warning">Revenue</div>
                            <h4 class="my-2" style="color: #ffd700;">K 425K</h4>
                            <p>This month</p>
                        </div>
                    </div>
                </div>

                <!-- All Orders Table -->
                <div class="card card-custom p-4">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h4 class="section-title mb-0">Order History</h4>
                        <div class="text-muted">Showing 1-15 of 156 orders</div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-dark table-hover">
                            <thead>
                                <tr>
                                    <th>Order #</th>
                                    <th>Customer</th>
                                    <th>Type</th>
                                    <th>Items</th>
                                    <th>Amount</th>
                                    <th>Payment</th>
                                    <th>Status</th>
                                    <th>Order Time</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Order 1 -->
                                <tr>
                                    <td class="fw-bold">#4325</td>
                                    <td>
                                        Peter Mwale

                                    </td>
                                    <td><span class="badge bg-secondary">Dine-in</span></td>
                                    <td>
                                        <span class="d-block">2x Chicken Burger</span>
                                        <small class="text-muted">1x Fries, 2x Coke</small>
                                    </td>
                                    <td class="fw-bold" style="color: #ffd700;">K 12,500</td>
                                    <td><span class="badge bg-success">Paid</span></td>
                                    <td><span class="badge bg-success">Delivered</span></td>
                                    <td>
                                        <div>Today</div>
                                        <small class="text-muted">15:30</small>
                                    </td>
                                    <td>
                                        <button class="btn btn-sm btn-outline-info">
                                            <i class="bi bi-eye"></i>
                                        </button>
                                    </td>
                                </tr>

                                <!-- Order 2 -->
                                <tr>
                                    <td class="fw-bold">#4324</td>
                                    <td>
                                        Sarah Kunda

                                    </td>
                                    <td><span class="badge bg-info">Takeaway</span></td>
                                    <td>
                                        <span class="d-block">1x Beef Pizza</span>
                                        <small class="text-muted">Large, Extra Cheese</small>
                                    </td>
                                    <td class="fw-bold" style="color: #ffd700;">K 8,200</td>
                                    <td><span class="badge bg-success">Paid</span></td>
                                    <td><span class="badge bg-warning text-dark">Preparing</span></td>
                                    <td>
                                        <div>Today</div>
                                        <small class="text-muted">15:23</small>
                                    </td>
                                    <td>
                                        <button class="btn btn-sm btn-outline-warning">
                                            <i class="bi bi-pencil"></i>
                                        </button>
                                    </td>
                                </tr>

                                <!-- Order 3 -->
                                <tr>
                                    <td class="fw-bold">#4323</td>
                                    <td>

                                        Thomas Banda

                                    </td>
                                    <td><span class="badge bg-primary">Delivery</span></td>
                                    <td>
                                        <span class="d-block">1x Grilled Chicken</span>
                                        <small class="text-muted">With Vegetables, Rice</small>
                                    </td>
                                    <td class="fw-bold" style="color: #ffd700;">K 6,500</td>
                                    <td><span class="badge bg-warning text-dark">Pending</span></td>
                                    <td><span class="badge bg-info">Pending</span></td>
                                    <td>
                                        <div>Today</div>
                                        <small class="text-muted">15:10</small>
                                    </td>
                                    <td>
                                        <button class="btn btn-sm btn-outline-warning">
                                            <i class="bi bi-pencil"></i>
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