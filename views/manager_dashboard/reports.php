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
            <span class="text-light me-3">Admin User</span>
            <button class="btn btn-sm btn-outline-light">Logout</button>
        </div>
    </nav>

    <div class="container-fluid">
        <div class="row">
            <!-- SIDEBAR -->
            <div class="col-md-2 sidebar">
                <ul class="nav flex-column">
                    <li class="nav-item mb-2">
                        <a class="nav-link active" href="index.php">
                            <i class="bi bi-speedometer2 me-2"></i> Overview
                        </a>
                    </li>
                
                    <li class="nav-item mb-2">
                        <a class="nav-link active" href="reports.php">
                            <i class="bi bi-graph-up me-2"></i> Reports
                        </a>
                    </li>
                
                    <li class="nav-item mb-2">
                        <a class="nav-link" href="reportsExport.php">
                            <i class="bi bi-download me-2"></i> Export Reports
                        </a>
                    </li>

                </ul>
            </div>


            <!-- MAIN CONTENT -->
            <div class="col-md-10 main-content">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2 class="section-title">Analytics & Reports</h2>
                    <div class="d-flex gap-2">
                        
                    </div>
                </div>

                <!-- Key Metrics Cards -->
                <div class="row mb-4">
                    <!-- Total Revenue -->
                    <div class="col-md-3 mb-3">
                        <div class="card card-custom p-3 text-center">
                            <i class="bi bi-currency-dollar card-icon"></i>
                            <h3 style="color: #adb5bd;">K 425,600</h3>
                            <p style="color: #cfe6ff;">Total Revenue</p>
                            
                        </div>
                    </div>

                    <!-- Total Orders -->
                    <div class="col-md-3 mb-3">
                        <div class="card card-custom p-3 text-center">
                            <i class="bi bi-cart-check card-icon"></i>
                            <h3 style="color: #adb5bd;">156</h3>
                            <p style="color: #cfe6ff;">Total Orders</p>
                            
                        </div>
                    </div>

                    <!-- Average Order Value -->
                    <div class="col-md-3 mb-3">
                        <div class="card card-custom p-3 text-center">
                            <i class="bi bi-graph-up card-icon"></i>
                            <h3 style="color: #adb5bd;">K 2,728</h3>
                            <p style="color: #cfe6ff;">Avg Order Value</p>
                           
                        </div>
                    </div>

                    <!-- Best Selling Item -->
                    <div class="col-md-3 mb-3">
                        <div class="card card-custom p-3 text-center">
                            <i class="bi bi-trophy card-icon"></i>
                            <h3 style="color: #adb5bd;">42</h3>
                            <p style="color: #cfe6ff;">Chicken Burger Sales</p>
                        </div>
                    </div>
                </div>

                <!-- Charts and Graphs Row -->
                <div class="row mb-4">
                    <!-- Revenue Chart -->
                    <div class="col-md-12 mb-3">
                        <div class="card card-custom p-4">
                            <h4 class="section-title mb-4">Revenue Trend</h4>
                            <div class="revenue-chart"
                                style="height: 300px; background: #0d1117; border-radius: 8px; padding: 20px;">
                                <!-- Simple CSS Bar Chart -->
                                <div class="d-flex align-items-end justify-content-between h-100">
                                    <div class="text-center mx-2">
                                        <div class="bg-primary rounded" style="height: 120px; width: 40px;"></div>
                                        <div class="text-muted small mt-2">Mon</div>
                                    </div>
                                    <div class="text-center mx-2">
                                        <div class="bg-primary rounded" style="height: 180px; width: 40px;"></div>
                                        <div class="text-muted small mt-2">Tue</div>
                                    </div>
                                    <div class="text-center mx-2">
                                        <div class="bg-primary rounded" style="height: 220px; width: 40px;"></div>
                                        <div class="text-muted small mt-2">Wed</div>
                                    </div>
                                    <div class="text-center mx-2">
                                        <div class="bg-primary rounded" style="height: 280px; width: 40px;"></div>
                                        <div class="text-muted small mt-2">Thu</div>
                                    </div>
                                    <div class="text-center mx-2">
                                        <div class="bg-primary rounded" style="height: 240px; width: 40px;"></div>
                                        <div class="text-muted small mt-2">Fri</div>
                                    </div>
                                    <div class="text-center mx-2">
                                        <div class="bg-primary rounded" style="height: 300px; width: 40px;"></div>
                                        <div class="text-muted small mt-2">Sat</div>
                                    </div>
                                    <div class="text-center mx-2">
                                        <div class="bg-primary rounded" style="height: 200px; width: 40px;"></div>
                                        <div class="text-muted small mt-2">Sun</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    
                </div>

                <!-- Best Selling Items -->
                <div class="row">
                    <!-- Top Selling Items -->
                    <div class="col-md-6 mb-3">
                        <div class="card card-custom p-4">
                            <h4 class="section-title mb-4">Best Selling Items</h4>
                            <div class="best-items">
                                <div class="d-flex align-items-center justify-content-between mb-3 p-2 rounded"
                                    style="background: rgba(30, 42, 56, 0.5);">
                                    <div class="d-flex align-items-center">
                                        <div class="rounded-circle bg-primary d-flex align-items-center justify-content-center me-3"
                                            style="width: 40px; height: 40px; color: white;">
                                            <i class="bi bi-cup-hot"></i>
                                        </div>
                                        <div>
                                            <div style="color: #dce7f5;">Chicken Burger</div>
                                            <small class="text-muted">Main Course</small>
                                        </div>
                                    </div>
                                    <div class="text-end">
                                        <div style="color: #ffd700;" class="fw-bold">42 orders</div>
                                        <small class="text-success">K 189,000</small>
                                    </div>
                                </div>

                                <div class="d-flex align-items-center justify-content-between mb-3 p-2 rounded"
                                    style="background: rgba(30, 42, 56, 0.5);">
                                    <div class="d-flex align-items-center">
                                        <div class="rounded-circle bg-success d-flex align-items-center justify-content-center me-3"
                                            style="width: 40px; height: 40px; color: white;">
                                            <i class="bi bi-egg-fried"></i>
                                        </div>
                                        <div>
                                            <div style="color: #dce7f5;">Beef Pizza</div>
                                            <small class="text-muted">Main Course</small>
                                        </div>
                                    </div>
                                    <div class="text-end">
                                        <div style="color: #ffd700;" class="fw-bold">38 orders</div>
                                        <small class="text-success">K 156,000</small>
                                    </div>
                                </div>

                                <div class="d-flex align-items-center justify-content-between mb-3 p-2 rounded"
                                    style="background: rgba(30, 42, 56, 0.5);">
                                    <div class="d-flex align-items-center">
                                        <div class="rounded-circle bg-warning d-flex align-items-center justify-content-center me-3"
                                            style="width: 40px; height: 40px; color: black;">
                                            <i class="bi bi-basket"></i>
                                        </div>
                                        <div>
                                            <div style="color: #dce7f5;">Grilled Chicken</div>
                                            <small class="text-muted">Main Course</small>
                                        </div>
                                    </div>
                                    <div class="text-end">
                                        <div style="color: #ffd700;" class="fw-bold">35 orders</div>
                                        <small class="text-success">K 122,500</small>
                                    </div>
                                </div>

                                <div class="d-flex align-items-center justify-content-between mb-3 p-2 rounded"
                                    style="background: rgba(30, 42, 56, 0.5);">
                                    <div class="d-flex align-items-center">
                                        <div class="rounded-circle bg-info d-flex align-items-center justify-content-center me-3"
                                            style="width: 40px; height: 40px; color: white;">
                                            <i class="bi bi-flower1"></i>
                                        </div>
                                        <div>
                                            <div style="color: #dce7f5;">Vegetable Salad</div>
                                            <small class="text-muted">Appetizer</small>
                                        </div>
                                    </div>
                                    <div class="text-end">
                                        <div style="color: #ffd700;" class="fw-bold">28 orders</div>
                                        <small class="text-success">K 89,600</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <script>
                // Simple time period selector
                document.addEventListener('DOMContentLoaded', function () {
                    const periodSelect = document.querySelector('select');
                    periodSelect.addEventListener('change', function () {
                        // In real application, this would fetch new data based on selected period
                        console.log('Period changed to:', this.value);
                    });
                });
            </script>



        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>