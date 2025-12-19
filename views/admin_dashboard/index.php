<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['role_id']) || $_SESSION['role_id'] != 1) {
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

require_once __DIR__ . '/../../app/models/Database.php';

$db = new Database();
$conn = $db->connect();

$stmt = $conn->prepare("
    SELECT COUNT(*) 
    FROM orders 
    WHERE DATE(created_at) = CURDATE()
");
$stmt->execute();
$newOrdersToday = $stmt->fetchColumn();

$stmt = $conn->prepare("
    SELECT COUNT(*) 
    FROM users 
    WHERE role_id = 4
");
$stmt->execute();
$totalCustomers = $stmt->fetchColumn();

$stmt = $conn->prepare("
    SELECT COUNT(*) 
    FROM users 
    WHERE role_id IN (1,2,3)
");
$stmt->execute();
$totalStaff = $stmt->fetchColumn();

$stmt = $conn->prepare("
    SELECT COUNT(*) 
    FROM meals
");
$stmt->execute();
$totalMeals = $stmt->fetchColumn();
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
                        <a class="nav-link active" href="index.php">
                            <i class="bi bi-speedometer2 me-2"></i> Overview
                        </a>
                    </li>

                    <li class="nav-item mb-2">
                        <a class="nav-link" href="meals.php">
                            <i class="bi bi-list-ul me-2"></i> Manage Menu
                        </a>
                    </li>

                    <li class="nav-item mb-2">
                        <a class="nav-link" href="users.php">
                            <i class="bi bi-people-fill me-2"></i> Users
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
                <h2 class="section-title">Dashboard Overview</h2>

                <!-- STAT CARDS -->
                <div class="row mb-4">

                    <!-- New Orders -->
                    <div class="col-md-3 mb-3">
                        <div class="card card-custom p-3 text-center stats-orders">
                            <i class="bi bi-cart-check-fill card-icon"></i>
                            <h3>
                                <?= $newOrdersToday ?>
                            </h3>
                            <p>New Orders Today</p>
                        </div>
                    </div>

                    <!-- Total Customers -->
                    <div class="col-md-3 mb-3">
                        <div class="card card-custom p-3 text-center stats-customers">
                            <i class="bi bi-people-fill card-icon"></i>
                            <h3>
                                <?= $totalCustomers ?>
                            </h3>
                            <p>Total Customers</p>
                        </div>
                    </div>

                    <!-- Staff Users -->
                    <div class="col-md-3 mb-3">
                        <div class="card card-custom p-3 text-center stats-menu">
                            <i class="bi bi-bag-dash-fill card-icon"></i>
                            <h3>
                                <?= $totalStaff ?>
                            </h3>
                            <p>Staff Users</p>
                        </div>
                    </div>

                    <!-- Total Meals -->
                    <div class="col-md-3 mb-3">
                        <div class="card card-custom p-3 text-center stats-revenue">
                            <i class="bi bi-cash-coin card-icon"></i>
                            <h3>
                                <?= $totalMeals ?>
                            </h3>
                            <p>Total Meals</p>
                        </div>
                    </div>

                </div>



            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>