<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Check if the user is logged in
$is_logged_in = isset($_SESSION['user_id']);
$userName = $_SESSION['user_name'] ?? 'Guest';
$initials = '';

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


$cartCount = isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0;  


$mealModel = new Meal();

$keyword = trim($_GET['q'] ?? '');

$latestMeals = [];

if (!empty($keyword)) {
    $latestMeals = $mealModel->search($keyword);
}

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




    <!-- MENU PREVIEW -->
    <section class="py-5" id="menu">
        <div class="container">

            <div class="text-center mb-4">
                <?php if (!empty($keyword)): ?>
                <h4>
                    Search results for
                    <span class="text-primary">"
                        <?= htmlspecialchars($keyword) ?>"
                    </span>
                </h4>
                <?php else: ?>
                <h4>Please enter a search term</h4>
                <?php endif; ?>
            </div>

            <div class="row g-4 justify-content-center">

                <?php if (!empty($latestMeals)): ?>
                <?php foreach ($latestMeals as $meal): ?>
                <div class="col-md-4 col-sm-6">
                    <div class="menu-card shadow-sm border border-secondary h-100">
                        <img src="../photos/<?= htmlspecialchars($meal['image_url'] ?: 'default-food.jpg'); ?>"
                            alt="<?= htmlspecialchars($meal['name']); ?>" class="img-fluid">

                        <div class="p-3 d-flex flex-column">
                            <h5 class="fw-bold">
                                <?= htmlspecialchars($meal['name']); ?>
                            </h5>

                            <p class="text-muted small flex-grow-1">
                                <?= htmlspecialchars(substr($meal['description'], 0, 50)); ?>...
                            </p>

                            <span class="price fw-bolder mb-2">
                                MWK
                                <?= number_format($meal['price']); ?>
                            </span>

                            <button class="btn btn-sky w-100 add-to-cart-btn" data-id="<?= $meal['id']; ?>"
                                data-name="<?= htmlspecialchars($meal['name']); ?>" data-price="<?= $meal['price']; ?>">
                                Add To Cart
                            </button>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>

                <?php else: ?>
                <div class="col-12 text-center text-muted py-5">
                    <p>No meals found matching your search.</p>
                </div>
                <?php endif; ?>

            </div>

        </div>
    </section>


    <!-- FEATURES -->
    <section class="features-section" id="features">
        <div class="container text-center">
            <h2 class="fw-bold text-white mb-5">Why Order With Us?</h2>

            <div class="row g-4">

                <div class="col-md-4">
                    <i class="fa-solid fa-bowl-food feature-icon"></i>
                    <h5 class="mt-3 fw-bold">Fresh Meals Daily</h5>
                    <p>All meals are prepared fresh with high-quality ingredients.</p>
                </div>

                <div class="col-md-4">
                    <i class="fa-solid fa-truck-fast feature-icon"></i>
                    <h5 class="mt-3 fw-bold">Fast Delivery</h5>
                    <p>We deliver anywhere within Mzuzu quickly and reliably.</p>
                </div>

                <div class="col-md-4">
                    <i class="fa-solid fa-mobile feature-icon"></i>
                    <h5 class="mt-3 fw-bold">Easy Online Ordering</h5>
                    <p>Browse, add to cart, and place your order with ease.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA -->
    <section class="cta-section" id="order">
        <div class="container">
            <h2 class="fw-bold">Ready to Place Your Order?</h2>
            <p>Enjoy fast delivery anywhere within Mzuzu. Fresh, affordable, and convenient.</p>
            <a href="#" class="btn btn-dark btn-lg">Order Now</a>
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
    <script>
        window.addEventListener('scroll', function () {
            const navbar = document.querySelector('.navbar');
            if (window.scrollY > 50) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });

        document.querySelectorAll('.add-to-cart-btn').forEach(button => {
            button.addEventListener('click', function () {
                const originalText = this.innerHTML;
                this.innerHTML = '<span class="loading"></span> Adding...';
                this.classList.add('loading');
                this.disabled = true;

                const meal = {
                    action: 'add',
                    meal_id: this.dataset.id,
                    meal_name: this.dataset.name,
                    meal_price: this.dataset.price
                };

                fetch('../app/controllers/CartController.php', {
                    method: 'POST',
                    headers: {
                        "Content-Type": "application/x-www-form-urlencoded",
                        "X-Requested-With": "XMLHttpRequest"
                    },
                    body: new URLSearchParams(meal)
                })
                    .then(res => res.json())
                    .then(data => {
                        showNotification(data.message, 'success');

                        updateCartCount();


                        this.innerHTML = originalText;
                        this.classList.remove('loading');
                        this.disabled = false;

                    })
                    .catch(err => {
                        console.error("Cart Error:", err);
                        showNotification('Already in Cart', 'error');

                        this.innerHTML = originalText;
                        this.classList.remove('loading');
                        this.disabled = false;
                    });
            });
        });

        function updateCartCount() {
            fetch('../app/controllers/CartController.php?action=count', {
                method: 'GET',
                headers: { "X-Requested-With": "XMLHttpRequest" }
            })
                .then(res => res.text())
                .then(count => {
                    const cartCountEl = document.getElementById('cart-count');
                    if (cartCountEl) {
                        cartCountEl.textContent = count;
                    }
                });
        }


        function showNotification(message, type = 'info') {
            const existingNotifications = document.querySelectorAll('.custom-notification');
            existingNotifications.forEach(notification => notification.remove());

            const notification = document.createElement('div');
            notification.className = `custom-notification alert alert-${type === 'error' ? 'danger' : type} alert-dismissible fade show`;
            notification.innerHTML = `
                ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            `;

            notification.style.cssText = `
                position: fixed;
                top: 100px;
                right: 20px;
                z-index: 9999;
                min-width: 300px;
                box-shadow: 0 4px 20px rgba(0,0,0,0.15);
                border: none;
                border-radius: 10px;
                animation: slideInRight 0.2s ease;
                background-color: #38bdf8;
            `;

            document.body.appendChild(notification);

            setTimeout(() => {
                if (notification.parentNode) {
                    notification.style.animation = 'slideOutRight 0.3s ease';
                    setTimeout(() => notification.remove(), 300);
                }
            }, 5000);
        }
        
        const style = document.createElement('style');
        style.textContent = `
            @keyframes slideInRight {
                from { transform: translateX(100%); opacity: 0; }
                to { transform: translateX(0); opacity: 1; }
            }
            @keyframes slideOutRight {
                from { transform: translateX(0); opacity: 1; }
                to { transform: translateX(100%); opacity: 0; }
            }
        `;
        document.head.appendChild(style);

        function updateCartCount() {
            fetch('../app/controllers/CartController.php?action=getCount')
                .then(res => res.json())
                .then(data => {
                    if (data.count !== undefined) {
                        const cartBadge = document.querySelector('.cart-count');
                        if (cartBadge) {
                            cartBadge.textContent = data.count;

                            cartBadge.style.transform = 'scale(1.5)';
                            setTimeout(() => {
                                cartBadge.style.transform = 'scale(1)';
                            }, 300);
                        }
                    }
                });
        }



        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        const tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });

        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                const href = this.getAttribute('href');
                if (href !== '#') {
                    e.preventDefault();
                    const target = document.querySelector(href);
                    if (target) {
                        window.scrollTo({
                            top: target.offsetTop - 80,
                            behavior: 'smooth'
                        });
                    }
                }
            });
        });
    </script>

</body>

</html>