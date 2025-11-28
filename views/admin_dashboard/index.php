<?php
// CHECK/START SESSION AT THE VERY TOP OF THE FILE
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// 1. Define the variables from the session data
$userName = $_SESSION['user_name'] ?? 'Guest';
$initials = '';

function getInitials($fullName) {
    // If the name is just one word, return the first letter
    if (strpos($fullName, ' ') === false) {
        return strtoupper(substr($fullName, 0, 1));
    }
    
    $parts = explode(' ', $fullName);
    $initials = '';
    
    // Grab the first letter of the first word
    $initials .= strtoupper(substr($parts[0], 0, 1));
    
    // Grab the first letter of the last word
    if (count($parts) > 1) {
        $initials .= strtoupper(substr(end($parts), 0, 1));
    }
    
    return $initials;
}

// 3. Set the initials variable
if ($userName !== 'Guest') {
    $initials = getInitials($userName);
}
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
                    <li class="nav-item mb-2">
                        <a class="nav-link active" href="index.php">
                            <i class="bi bi-speedometer2 me-2"></i> Overview
                        </a>
                    </li>

                    <li class="nav-item mb-2">
                        <a class="nav-link" href="meals.php">
                            <i class="bi bi-list-ul me-2"></i> Meal Management
                        </a>
                    </li>

                    <li class="nav-item mb-2">
                        <a class="nav-link" href="users.php">
                            <i class="bi bi-people-fill me-2"></i> Users Management
                        </a>
                    </li>
                    
                </ul>
            </div>

            <!-- MAIN CONTENT -->
            <div class="col-md-10 main-content">
                <h2 class="section-title">Dashboard Overview</h2>

                <!-- STAT CARDS -->
                <div class="row mb-4">
                    <div class="col-md-3 mb-3">
                        <div class="card card-custom p-3 text-center stats-orders">
                            <i class="bi bi-cart-check-fill card-icon"></i>
                            <h3>120</h3>
                            <p>New Orders Today</p>
                        </div>
                    </div>

                    <div class="col-md-3 mb-3">
                        <div class="card card-custom p-3 text-center stats-customers">
                            <i class="bi bi-people-fill card-icon"></i>
                            <h3>850</h3>
                            <p>Total Customers</p>
                        </div>
                    </div>

                    <div class="col-md-3 mb-3">
                        <div class="card card-custom p-3 text-center stats-menu">
                            <i class="bi bi-bag-dash-fill card-icon"></i>
                            <h3>48</h3>
                            <p>Menu Items</p>
                        </div>
                    </div>

                    <div class="col-md-3 mb-3">
                        <div class="card card-custom p-3 text-center stats-revenue">
                            <i class="bi bi-cash-coin card-icon"></i>
                            <h3>K 340,000</h3>
                            <p>Today's Revenue</p>
                        </div>
                    </div>
                </div>

                <!-- RECENT ORDERS -->
                <div class="card card-custom p-4">
                    <h4 class="section-title">Recent Orders</h4>

                    <div class="table-responsive">
                        <table class="table table-dark table-striped">
                            <thead>
                                <tr>
                                    <th>Order #</th>
                                    <th>Customer</th>
                                    <th>Items</th>
                                    <th>Total</th>
                                    <th>Status</th>
                                    <th>Date</th>
                                </tr>
                            </thead>

                            <tbody>
                                <tr>
                                    <td>#4321</td>
                                    <td>John Banda</td>
                                    <td>3 Items</td>
                                    <td>K 6,500</td>
                                    <td><span class="status-badge status-pending">Pending</span></td>
                                    <td>Today</td>
                                </tr>

                                <tr>
                                    <td>#4318</td>
                                    <td>Mary Katunga</td>
                                    <td>1 Item</td>
                                    <td>K 2,200</td>
                                    <td><span class="status-badge status-completed">Completed</span></td>
                                    <td>Today</td>
                                </tr>

                                <tr>
                                    <td>#4310</td>
                                    <td>James Ghambi</td>
                                    <td>2 Items</td>
                                    <td>K 4,300</td>
                                    <td><span class="status-badge status-preparing">Preparing</span></td>
                                    <td>Yesterday</td>
                                </tr>
                                
                                <tr>
                                    <td>#4305</td>
                                    <td>Sarah Mwale</td>
                                    <td>4 Items</td>
                                    <td>K 8,750</td>
                                    <td><span class="status-badge status-completed">Completed</span></td>
                                    <td>Yesterday</td>
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