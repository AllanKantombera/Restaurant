<?php
require_once __DIR__ . '/../../config/Database.php';
require_once __DIR__ . '/../../app/models/Meal.php';

$meal = new Meal();
$meals = $meal->getAll();



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
    <!-- Navbar -->
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

    <div class="modal fade" id="statusModal" tabindex="-1" aria-labelledby="statusModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered">
            <div class="modal-content" style="background: #161b22; border: 1px solid #30363d; color: #fff;">
                <div class="modal-body text-center p-4">
                    <i id="modalIcon" class="bi display-4 mb-3 text-success"></i>


                    <h5 id="modalBodyMessage" class="text-secondary"></h5>

                    <button type="button" class="btn btn-sm btn-primary mt-2" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row">
            <!-- SIDEBAR -->
            <div class="col-md-2 sidebar">
                <ul class="nav flex-column">
                    <li class="nav-item mb-2">
                        <a class="nav-link" href="index.php">
                            <i class="bi bi-speedometer2 me-2"></i> Overview
                        </a>
                    </li>

                    <li class="nav-item mb-2">
                        <a class="nav-link active" href="meals.php">
                            <i class="bi bi-list-ul me-2"></i>Manage Menu
                        </a>
                    </li>

                    <li class="nav-item mb-2">
                        <a class="nav-link " href="users.php">
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



            <div class="col-md-10 main-content p-4">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2 class="section-title">Meal Management</h2>
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addMealModal">
                        <i class="bi bi-plus-circle me-2"></i>Add New Meal
                    </button>
                </div>

                

                <div class="row">
                    <?php if (empty($meals)): ?>
                        <div class="col-12 text-center mt-5">
                            <p class="text-muted">No meals found. Add new meals to display them here.</p>
                        </div>
                    <?php endif; ?>

                    <?php foreach ($meals as $m): ?>
                        <div class="col-md-4 mb-4">
                            <div class="card h-100" style="background-color: #161b22; border: 1px solid #30363d;">
                                <div class="position-relative">
                                    <img src="../../photos/<?php echo htmlspecialchars($m['image_url']); ?>"
                                        class="card-img-top"
                                        style="height:200px; object-fit:cover;"
                                        alt="<?php echo htmlspecialchars($m['name']); ?>"
                                        onerror="this.src='../../assets/img/placeholder.jpg'">

                                    <?php if ($m['is_available'] == 1): ?>
                                        <span class="badge bg-success position-absolute top-0 end-0 m-2">Active</span>
                                    <?php else: ?>
                                        <span class="badge bg-danger position-absolute top-0 end-0 m-2">Inactive</span>
                                    <?php endif; ?>
                                </div>

                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                        <h5 class="card-title text-light"><?= htmlspecialchars($m['name']); ?></h5>
                                        <span class="fw-bold text-warning">K <?= number_format($m['price']); ?></span>
                                    </div>

                                    <p class="card-text text-secondary small">
                                        <?= htmlspecialchars(substr($m['description'], 0, 100)) . '...'; ?>
                                    </p>

                                    <div class="d-flex gap-2 mt-3">
                                        <?php
                                        $mealJson = json_encode([
                                            "id" => $m["id"], 
                                            "name" => $m["name"],
                                            "price" => $m["price"],
                                            "description" => $m["description"],
                                            "category_id" => $m["category_id"],
                                            "is_available" => $m["is_available"],
                                            "image_url" => $m["image_url"]
                                        ], JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_TAG | JSON_HEX_AMP);
                                        ?>
                                        
                                        <button class="btn btn-sm btn-outline-warning flex-fill"
                                            onclick='loadMealData(<?php echo $mealJson; ?>)'
                                            data-bs-toggle="modal"
                                            data-bs-target="#editMealModal">
                                            <i class="bi bi-pencil me-1"></i>Edit
                                        </button>

                                        <button class="btn btn-sm btn-outline-danger flex-fill"
                                            onclick="confirmDelete(<?= $m['id']; ?>)">
                                            <i class="bi bi-trash me-1"></i>Delete
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="addMealModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content" style="background: #111723; border: 1px solid #30363d; color: #fff;">
                <div class="modal-header border-secondary">
                    <h5 class="modal-title">Add New Meal</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form action="../../app/controllers/MealController.php?action=addMeal" method="POST" enctype="multipart/form-data">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Meal Name</label>
                                <input type="text" name="name" class="form-control bg-dark text-light border-secondary" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Price (K)</label>
                                <input type="number" name="price" class="form-control bg-dark text-light border-secondary" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Category</label>
                                <select name="category_id" class="form-select bg-dark text-light border-secondary" required>
                                    <option value="">Select Category</option>
                                    <option value="1">Appetizers</option>
                                    <option value="2">Main Course</option>
                                    <option value="3">Desserts</option>
                                    <option value="4">Beverages</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Status</label>
                                <select name="is_available" class="form-select bg-dark text-light border-secondary">
                                    <option value="1">Active</option>
                                    <option value="0">Inactive</option>
                                </select>
                            </div>
                            <div class="col-12">
                                <label class="form-label">Description</label>
                                <textarea name="description" class="form-control bg-dark text-light border-secondary" rows="3"></textarea>
                            </div>
                            <div class="col-12">
                                <label class="form-label">Meal Image</label>
                                <input type="file" name="image" class="form-control bg-dark text-light border-secondary" accept="image/*" required>
                            </div>
                        </div>
                        <div class="modal-footer border-secondary mt-3">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Save Meal</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="editMealModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content" style="background: #111723; border: 1px solid #30363d; color: #fff;">
                <div class="modal-header border-secondary">
                    <h5 class="modal-title">Edit Meal</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="editMealForm" action="../../app/controllers/MealController.php?action=updateMeal" method="POST" enctype="multipart/form-data">
                        
                        <input type="hidden" name="id" id="edit_id">

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Meal Name</label>
                                <input type="text" name="name" id="edit_name" class="form-control bg-dark text-light border-secondary" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Price (K)</label>
                                <input type="number" name="price" id="edit_price" class="form-control bg-dark text-light border-secondary" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Category</label>
                                <select name="category_id" id="edit_category" class="form-select bg-dark text-light border-secondary" required>
                                    <option value="1">Appetizers</option>
                                    <option value="2">Main Course</option>
                                    <option value="3">Desserts</option>
                                    <option value="4">Beverages</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Status</label>
                                <select name="is_available" id="edit_status" class="form-select bg-dark text-light border-secondary">
                                    <option value="1">Active</option>
                                    <option value="0">Inactive</option>
                                </select>
                            </div>
                            <div class="col-12">
                                <label class="form-label">Description</label>
                                <textarea name="description" id="edit_description" class="form-control bg-dark text-light border-secondary" rows="3"></textarea>
                            </div>
                            <div class="col-12">
                                <label class="form-label">Change Image (Optional)</label>
                                <input type="file" name="image" class="form-control bg-dark text-light border-secondary" accept="image/*">
                            </div>
                        </div>
                        <div class="modal-footer border-secondary mt-3">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-warning">Update Meal</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        function loadMealData(meal) {
            document.getElementById('edit_id').value = meal.id;
            document.getElementById('edit_name').value = meal.name;
            document.getElementById('edit_price').value = meal.price;
            document.getElementById('edit_description').value = meal.description;
            document.getElementById('edit_category').value = meal.category_id;
            document.getElementById('edit_status').value = meal.is_available;
        }

        function confirmDelete(id) {
            if (confirm('Are you sure you want to delete this meal? This cannot be undone.')) {
                window.location.href = `../../app/controllers/MealController.php?action=deleteMeal&id=${id}`;
            }
        }

        document.addEventListener('DOMContentLoaded', function () {
            const urlParams = new URLSearchParams(window.location.search);
            const msg = urlParams.get('msg');
            
            if (msg) {
                const modalEl = document.getElementById('statusModal');
                const modalBodyMessage = document.getElementById('modalBodyMessage');
                const modalIcon = document.getElementById('modalIcon');
                
                const decodedMsg = decodeURIComponent(msg.replace(/\+/g, ' ')); 
                modalBodyMessage.textContent = decodedMsg;

                if (decodedMsg.toLowerCase().includes('success') || decodedMsg.toLowerCase().includes('added')) {
                    modalIcon.className = 'bi bi-check-circle-fill display-4 mb-3 text-success';
                } 
                else if (decodedMsg.toLowerCase().includes('failed') || decodedMsg.toLowerCase().includes('error')) {
                    modalIcon.className = 'bi bi-x-octagon-fill display-4 mb-3 text-danger';
                }
                else {
                    modalIcon.className = 'bi bi-info-circle-fill display-4 mb-3 text-info';
                }
                const statusModal = new bootstrap.Modal(modalEl);
                statusModal.show();

                history.replaceState(null, '', window.location.pathname);
            }
        });
    </script>


</body>

</html>