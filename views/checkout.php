<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../public/login.php?redirect=checkout");
    exit;
}

$cart = $_SESSION['cart'] ?? [];
if (empty($cart)) {
    header("Location: cart.php");
    exit;
}



$cart = $_SESSION['cart'] ?? [];

if (empty($cart)) {
    header("Location: cart.php");
    exit;
}

$grandTotal = 0;
foreach ($cart as $item) {
    $grandTotal += ($item['price'] * $item['qty']);
}

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$is_logged_in = isset($_SESSION['user_id']);
$userName = $_SESSION['user_name'] ?? 'Guest';
$initials = '';

function getInitials($fullName) {
    $parts = explode(' ', $fullName);
    $initials = strtoupper(substr($parts[0], 0, 1));
    if (count($parts) > 1) {
        $initials .= strtoupper(substr(end($parts), 0, 1));
    }
    return $initials;
}

if ($is_logged_in) {
    $initials = getInitials($userName);
}

require_once __DIR__ . '/../app/Models/Meal.php'; 

$mealModel = new Meal();
$latestMeals = $mealModel->getLatestMeals();

$cartCount = isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0;
               
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aunt Joy's Restaurant - Online Ordering</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
    <link href="../assests/css/style.css" rel="stylesheet">
</head>

<body>
    <!-- NAVBAR -->
    <nav class="navbar navbar-expand-lg fixed-top">
        <div class="container">

            <a class="navbar-brand fw-bold" href="#">
                <img src="../assests/img/logo11.png" alt="logo Logo" height="40"
                    style="border-style: solid; border-radius: 50px; border-color: #38bdf8;">
            </a>

            <button class="navbar-toggler bg-dark" type="button" data-bs-toggle="collapse" data-bs-target="#nav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="nav">

                <ul class="navbar-nav">
                    <li class="nav-item"><a href="index.php" class="nav-link">Home</a></li>
                    <li class="nav-item"><a href="menu.php" class="nav-link">Menu</a></li>
                    <li class="nav-item"><a href="myorders.php" class="nav-link">My Orders</a></li>
                    <li class="nav-item">
                        <a href="cart.php" class="nav-link cart-link">
                            <i class="fas fa-shopping-cart me-1"></i>
                            Cart (<span id="cart-count">
                                <?= $cartCount ?>
                            </span>)
                        </a>
                    </li>
                </ul>


                <form class="d-flex ms-auto me-lg-3 mt-2 mt-lg-0" action="search.php" method="GET" role="search">
                    <input class="form-control me-2 rounded-pill" type="search" name="q"
                        value="<?= htmlspecialchars($_GET['q'] ?? '') ?>" placeholder="Search food..."
                        aria-label="Search">

                    <button class="btn btn-outline-light rounded-pill" type="submit">
                        <i class="fa fa-search"></i>
                    </button>
                </form>

                <div class="d-flex mt-2 mt-lg-0">
                    <?php if ($is_logged_in): ?>
                    <div class="dropdown">
                        <button class="btn btn-dark d-flex align-items-center dropdown-toggle rounded-pill px-3"
                            type="button" data-bs-toggle="dropdown" aria-expanded="false"
                            style="background-color: #212529; border-color: #343a40;">

                            <span class="d-none d-md-inline me-1 text-light">
                                <?= htmlspecialchars($userName); ?>
                            </span>
                        </button>

                        <ul class="dropdown-menu dropdown-menu-end"
                            style="background-color: #212529; border-color: #343a40;">

                            <li>
                                <a class="dropdown-item text-danger" href="../public/logout.php"
                                    style="background-color: #212529;">
                                    <i class="fa fa-sign-out-alt me-1"></i> Logout
                                </a>
                            </li>
                        </ul>
                    </div>
                    <?php else: ?>
                    <a href="../public/login.php" class="btn rounded-pill" style="background-color: #38bdf8;">
                        <i class="fa fa-sign-in-alt me-1"></i> Login
                    </a>
                    <?php endif; ?>
                </div>
            </div>
    </nav>



<div class="container py-5">
    <h2 class="fw-bold mb-4">Checkout</h2>

    <div class="row g-4">

        <!-- Order Summary -->
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-header bg-dark text-white fw-bold">Order Summary</div>
                <div class="card-body">

                    <?php foreach ($cart as $item): ?>
                        <div class="d-flex justify-content-between border-bottom py-2">
                            <span><?= htmlspecialchars($item['name']); ?> (x<?= $item['qty']; ?>)</span>
                            <span>MWK <?= number_format($item['price'] * $item['qty']); ?></span>
                        </div>
                    <?php endforeach; ?>

                    <h4 class="text-end mt-3 fw-bold">
                        Total: MWK <?= number_format($grandTotal); ?>
                    </h4>
                </div>
            </div>
        </div>



        <!-- Checkout Form -->
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-header bg-dark text-white fw-bold">Delivery Details</div>

                <div class="card-body">
                    <form method="POST" action="../app/controllers/CheckoutController.php">

                        <div class="mb-3">
                            <label class="form-label fw-bold">Delivery Address (Area/Town/Village)</label>
                            <input type="text" name="delivery_address" class="form-control" placeholder="e.g. Mzuni, Kandaha" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Or Send GPS Location (optional)</label>

                            <input type="hidden" name="gps_location" id="gps_location">

                            <button type="button" class="btn btn-secondary" onclick="getLocation()">
                                Use My GPS Location
                            </button>

                            <p class="text-muted small mt-2" id="gps_status"></p>
                        </div>

                        <button type="submit" class="btn btn-primary w-100 btn-lg fw-bold mt-3">
                            Confirm Order
                        </button>

                    </form>
                </div>
            </div>
        </div>

    </div>

</div>


<script>
function getLocation() {
    const status = document.getElementById("gps_status");

    if (!navigator.geolocation) {
        status.innerText = "GPS not supported by your device.";
        return;
    }

    status.innerText = "Getting your location...";

    navigator.geolocation.getCurrentPosition(
        position => {
            const coords = position.coords.latitude + "," + position.coords.longitude;
            document.getElementById("gps_location").value = coords;
            status.innerText = "Location captured ✔";
        },
        () => {
            status.innerText = "Unable to get location.";
        }
    );
}
</script>

</body>
</html>