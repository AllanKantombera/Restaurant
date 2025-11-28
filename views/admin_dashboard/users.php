<?php
// views/admin/users.php (at the very top)

// Adjust path as needed based on where this view file is located relative to the controller
require_once __DIR__ . '/../../app/Controllers/UserController.php';
// Note: The UserController requires the Model and Database, which should be included at the top of UserController.php

$userController = new UserController();

$userModel = new User(); 
$staffUsers = $userModel->getStaffUsers();
$customers = $userModel->getCustomers();


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
                        <a class="nav-link" href="meals.php">
                            <i class="bi bi-list-ul me-2"></i>Manage Menu
                        </a>
                    </li>

                    <li class="nav-item mb-2">
                        <a class="nav-link active" href="users.php">
                            <i class="bi bi-people-fill me-2"></i> Users
                        </a>
                    </li>

                </ul>
            </div>


            <!-- MAIN CONTENT -->


            <!-- MAIN CONTENT -->
            <div class="col-md-10 main-content">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2 class="section-title">Users Management</h2>
                    <div>
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addUserModal">
                            <i class="bi bi-person-plus me-2"></i>Add New User
                        </button>
                    </div>
                </div>

                <!-- Tabs Navigation -->
                <ul class="nav nav-tabs mb-4" style="border-bottom-color: #1e2a38;">
                    <li class="nav-item">
                        <a class="nav-link active" style="background: #111723; border-color: #1e2a38; color: #79bffd;"
                            href="#staff" data-bs-toggle="tab">Staff Users</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" style="background: #111723; border-color: #1e2a38; color: #9ecbff;"
                            href="#customers" data-bs-toggle="tab">Customers</a>
                    </li>
                </ul>

                <div class="tab-content">
                    <!-- Staff Users Tab -->
                    <div class="tab-pane fade show active" id="staff">
                        <!-- Staff Users Table -->
                        <div class="card card-custom p-4">
                            <h4 class="section-title mb-4">Staff Users</h4>

                            <div class="table-responsive">
                                <table class="table table-dark table-hover">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Role</th>
                                            <th>Phone</th>
                                            <th>Status</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (!empty($staffUsers)): ?>
                                        <?php foreach ($staffUsers as $user): ?>
                                        <tr>
                                         
                                            <td>
                                                <?= htmlspecialchars($user['name']); ?>
                                            </td>
                                            <td>
                                                <?= htmlspecialchars($user['email']); ?>
                                            </td>
                                            <td>
                                                <span class="badge 
                                                <?php 
                                                    // Dynamic badge coloring based on role name
                                                    if ($user['role'] == 'Admin') echo 'bg-danger';
                                                    else if ($user['role'] == 'Manager') echo 'bg-warning text-dark';
                                                    else if ($user['role'] == 'Sales') echo 'bg-info';
                                                    else echo 'bg-secondary';
                                                ?>">
                                                    <?= htmlspecialchars($user['role']); ?>
                                                </span>
                                            </td>
                                            <td>
                                                <?= htmlspecialchars($user['phone']); ?>
                                            </td>
                                            <td>
                                                <span
                                                    class="badge <?= $user['is_active'] ? 'bg-success' : 'bg-secondary'; ?>">
                                                    <?= $user['is_active'] ? 'Active' : 'Inactive'; ?>
                                                </span>
                                            </td>
                                            <td>
                                                <div class="btn-group btn-group-sm">
                                                    <button
                                                        class="btn <?= $user['is_active'] ? 'btn-outline-danger' : 'btn-outline-success'; ?> btn-sm"
                                                        onclick="confirmToggleStatus(<?= htmlspecialchars($user['id']); ?>, <?= htmlspecialchars($user['is_active']); ?>)">
                                                        <?= $user['is_active'] ? 'Deactivate' : 'Activate'; ?>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                        <?php endforeach; ?>
                                        <?php else: ?>
                                        <tr>
                                            <td colspan="8" class="text-center text-muted">No staff users found.</td>
                                        </tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Customers Tab -->
                    <div class="tab-pane fade" id="customers">

                        <!-- Customers Table -->
                        <div class="card card-custom p-4">
                            <h4 class="section-title mb-4">Customers</h4>

                            <div class="table-responsive">
                                <table class="table table-dark table-hover">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Phone</th>

                                            <th>Status</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (!empty($customers)): ?>
                                        <?php foreach ($customers as $customer): ?>
                                        <tr>
                                          
                                            <td>
                                                <?= htmlspecialchars($customer['name']); ?>
                                            </td>
                                            <td>
                                                <?= htmlspecialchars($customer['email']); ?>
                                            </td>
                                            <td>
                                                <?= htmlspecialchars($customer['phone']); ?>
                                            </td>
                                            <td>
                                                <span
                                                    class="badge <?= $customer['is_active'] ? 'bg-success' : 'bg-secondary'; ?>">
                                                    <?= $customer['is_active'] ? 'Active' : 'Inactive'; ?>
                                                </span>
                                            </td>
                                            <td>
                                                <div class="btn-group btn-group-sm">
                                                                                                      <button
                                                        class="btn <?= $customer['is_active'] ? 'btn-outline-danger' : 'btn-outline-success'; ?> btn-sm"
                                                        onclick="confirmToggleStatus(<?= htmlspecialchars($customer['id']); ?>, <?= htmlspecialchars($customer['is_active']); ?>)">
                                                        <?= $customer['is_active'] ? 'Deactivate' : 'Activate'; ?>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                        <?php endforeach; ?>
                                        <?php else: ?>
                                        <tr>
                                            <td colspan="6" class="text-center text-muted">No customer users found.</td>
                                        </tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>



            <div class="modal fade" id="addUserModal" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content" style="background: #111723; border-color: #1e2a38;">
                        <div class="modal-header" style="border-color: #1e2a38;">
                            <h5 class="modal-title" style="color: #79bffd;">Add New User</h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="../../app/Controllers/UserController.php?action=addUser" method="POST">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label" style="color: #dce7f5;">Full Name</label>
                                        <input type="text" name="name" class="form-control"
                                            style="background: #0d1117; border-color: #1e2a38; color: #dce7f5;"
                                            placeholder="Enter full name" required>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label" style="color: #dce7f5;">Email</label>
                                        <input type="email" name="email" class="form-control"
                                            style="background: #0d1117; border-color: #1e2a38; color: #dce7f5;"
                                            placeholder="Enter email" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label" style="color: #dce7f5;">Phone</label>
                                        <input type="tel" name="phone" class="form-control"
                                            style="background: #0d1117; border-color: #1e2a38; color: #dce7f5;"
                                            placeholder="Enter phone number">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label" style="color: #dce7f5;">Role</label>
                                        <select name="role" class="form-select"
                                            style="background: #0d1117; border-color: #1e2a38; color: #dce7f5;"
                                            required>
                                            <option value="" style="color: #dce7f5;">Select Role</option>
                                            <option value="1">Admin</option>
                                            <option value="2">Manager</option>
                                            <option value="3">Sales</option>
                                            <option value="4">Custommer</option>

                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label" style="color: #dce7f5;">Password</label>
                                        <input type="password" name="password" id="password" class="form-control"
                                            style="background: #0d1117; border-color: #1e2a38; color: #dce7f5;"
                                            placeholder="Enter password" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label" style="color: #dce7f5;">Confirm Password</label>
                                        <input type="password" name="password_confirm" id="password_confirm"
                                            class="form-control"
                                            style="background: #0d1117; border-color: #1e2a38; color: #dce7f5;"
                                            placeholder="Confirm password" required>
                                    </div>
                                </div>
                                <div class="modal-footer" style="border-color: #1e2a38;">
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn btn-primary">Add User</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>



        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // --- NEW TOAST LOGIC ---
        document.addEventListener('DOMContentLoaded', function () {
            const urlParams = new URLSearchParams(window.location.search);
            const msg = urlParams.get('msg');

            if (msg) {
                const modalEl = document.getElementById('statusModal');
                const modalBodyMessage = document.getElementById('modalBodyMessage');
                const modalIcon = document.getElementById('modalIcon');

                // 1. Decode and set message
                // Replace '+' with space and decode the URL encoded string
                const decodedMsg = decodeURIComponent(msg.replace(/\+/g, ' '));
                modalBodyMessage.textContent = decodedMsg;

                // 2. Set Icon and Theme based on success/error keywords
                // Success (Green check)
                if (decodedMsg.toLowerCase().includes('success') || decodedMsg.toLowerCase().includes('added')) {
                    modalIcon.className = 'bi bi-check-circle-fill display-4 mb-3 text-success';
                }
                // Error/Failure (Red X)
                else if (decodedMsg.toLowerCase().includes('failed') || decodedMsg.toLowerCase().includes('error')) {
                    modalIcon.className = 'bi bi-x-octagon-fill display-4 mb-3 text-danger';
                }
                // General/Info (Blue Info)
                else {
                    modalIcon.className = 'bi bi-info-circle-fill display-4 mb-3 text-info';
                }

                // 3. Show the Modal
                const statusModal = new bootstrap.Modal(modalEl);
                statusModal.show();

                // 4. Clean up the URL (Removes ?msg=... from the URL bar after showing the modal)
                // This prevents the modal from reappearing if the user refreshes the page.
                history.replaceState(null, '', window.location.pathname);
            }
        });

        // Add this function near your other JavaScript functions
        function confirmToggleStatus(id, currentStatus) {
            const nextStatus = (currentStatus == 1) ? 0 : 1; // If active (1), next is 0 (deactivate)
            const actionText = (nextStatus == 0) ? 'deactivate' : 'activate';

            if (confirm(`Are you sure you want to ${actionText} this account?`)) {
                // Link to the controller file with the action, ID, AND the desired NEW status
                window.location.href = `../../app/Controllers/UserController.php?action=toggleStatus&id=${id}&status=${nextStatus}`;
            }
        }
    </script>

</body>

</html>