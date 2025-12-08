<?php
// Start the session if it hasn't been started yet
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Check if the user is logged in
$is_logged_in = isset($_SESSION['user_id']);
$userName = $_SESSION['user_name'] ?? 'Guest';
$initials = '';

// Function to extract initials (e.g., Allan Canto -> AC)
function getInitials($fullName) {
    $parts = explode(' ', $fullName);
    $initials = strtoupper(substr($parts[0], 0, 1));
    if (count($parts) > 1) {
        // Use the first letter of the last part of the name
        $initials .= strtoupper(substr(end($parts), 0, 1));
    }
    return $initials;
}

if ($is_logged_in) {
    $initials = getInitials($userName);
}

require_once __DIR__ . '/../app/Models/Meal.php'; 
// Assuming the path needs adjustment based on the view location relative to the model

$mealModel = new Meal();
$latestMeals = $mealModel->getLatestMeals();
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
            <img src="../assests/img/logo1.png" alt="logo Logo" height="40" style="border-radius: 30px;">
        </a>

        <button class="navbar-toggler bg-dark" type="button" data-bs-toggle="collapse" data-bs-target="#nav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="nav">

            <ul class="navbar-nav">
                <li class="nav-item"><a href="#" class="nav-link">Home</a></li>
                <li class="nav-item"><a href="#menu" class="nav-link">Menu</a></li>
                <li class="nav-item"><a href="#features" class="nav-link">Features</a></li>
                <li class="nav-item"><a href="#order" class="nav-link">Order</a></li>
            </ul>
            
            <form class="d-flex ms-auto me-lg-3 mt-2 mt-lg-0" role="search">
                <input class="form-control me-2 rounded-pill" type="search" placeholder="Search food..."
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
                            
                            <span class="me-2 fw-bold text-uppercase text-light" style="
                                background-color: #000000; /* Use a distinct accent color for the initials background */
                                border: 1px solid #000000; 
                                border-radius: 4px; 
                                padding: 2px 7px;
                                font-size: 0.9rem;">
                                <?= htmlspecialchars($initials); ?>
                            </span>
                            
                            <span class="d-none d-md-inline me-1 text-light"><?= htmlspecialchars($userName); ?></span>
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
                    <a href="../public/login.php" class="btn btn-primary rounded-pill">
                        <i class="fa fa-sign-in-alt me-1"></i> Login
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </nav>


    <!-- HERO -->
    <section class="hero" style="
    background: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)),
        url('../assests/img/cover1.jpg') center/cover no-repeat;">
        <div class="container">
            <h1 class="display-4 fw-bold">Delicious Meals Delivered Across Mzuzu</h1>
            <p class="lead mb-4">Fast, reliable and fresh — enjoy Aunt Joy’s best meals from the comfort of your home.
            </p>
            <a href="#menu" class="btn btn-sky btn-lg">Order Now</a>
        </div>
    </section>

    <!-- MENU PREVIEW -->
    <section class="py-5" id="menu">
    <div class="container">
        <div class="section-header text-center mb-5">
            <h2>Popular Meals</h2>
            <p>Freshly prepared and always delicious</p>
        </div>

        <div class="row g-4 justify-content-center">
            
            <?php if (!empty($Menu)): ?>
                <?php foreach ($Menu as $meal): ?>
                    <div class="col-md-4 col-sm-6">
                        <div class="menu-card shadow-sm border border-secondary">
                            <img src="../photos/<?= htmlspecialchars($meal['image_url'] ?? '../assests/img/default-food.jpg'); ?>" 
                                 alt="<?= htmlspecialchars($meal['name']); ?>"
                                 class="img-fluid">
                            <div class="p-3">
                                <h5 class="fw-bold"><?= htmlspecialchars($meal['name']); ?></h5>
                                <p class="text-muted small"><?= htmlspecialchars(substr($meal['description'], 0, 50)) . '...'; ?></p>
                                <span class="price fw-bolder">MWK <?= number_format($meal['price']); ?></span>
                                <button class="btn btn-sky w-100 mt-3" 
                                        data-meal-id="<?= htmlspecialchars($meal['id']); ?>">
                                    Add To Cart
                                </button>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-12 text-center text-muted py-5">
                    <p>Sorry, no meals are currently available on the menu!</p>
                </div>
            <?php endif; ?>
            
        </div>
        
        <div class="text-center mt-4">
            <a href="menu.php
            " class="btn btn-sky">View Full Menu</a>
        </div>
    </div>
</section>

    <!-- FOOTER -->
    <footer class="footer text-center py-5" style="background: #0f0f0f; color: #e2e8f0;">
        <div class="container">
            <!-- About Us -->
            <div class="mb-4">
                <h5 class="fw-bold" style="color: #38bdf8;">About Us</h5>
                <p style="max-width: 600px; margin: 0 auto; opacity: 0.9;">
                    Aunt Joy's Restaurant serves delicious meals with a focus on quality ingredients, fast service, and
                    a welcoming atmosphere. Experience the taste that keeps Mzuzu coming back for more.
                </p>
            </div>

            <!-- Contact Info -->
            <div class="mb-3">
                <p class="mb-1"><i class="fa-solid fa-phone me-2" style="color: #38bdf8;"></i>+265 999 123 456</p>
                <p><i class="fa-solid fa-envelope me-2" style="color: #38bdf8;"></i>info@auntjoysrestaurant.mw</p>
            </div>
            <p class="mt-3">&copy; 2025 Aunt Joy's Restaurant | All Rights Reserved</p>
        </div>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>