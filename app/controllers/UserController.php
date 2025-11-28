<?php
// app/Controllers/UserController.php

// 1. Include dependencies directly (no Autoloader being used)
require_once __DIR__ . '/../Models/User.php';
//require_once __DIR__ . '/../../config/Database.php';

class UserController {
    
    protected $user; // Instance of the User Model

    public function __construct() {
        $this->user = new User();
    }

// In app/Controllers/UserController.php, inside the UserController class

/**
 * Handles the activation/deactivation action requested via URL.
 * Requires ?id= and ?status= (0 or 1)
 */
public function toggleStatus() {
    // 1. Ensure ID and status are present in the URL
    if (!isset($_GET['id']) || empty($_GET['id']) || !isset($_GET['status'])) {
        $msg = urlencode("Error: Missing required parameters.");
        header("Location: ../../views/admin_dashboard/users.php?msg=" . $msg);
        exit;
    }
    
    $userId = (int)$_GET['id'];
    $newStatus = (int)$_GET['status']; // 0 or 1
    
    // Determine the status name for the success message
    $statusName = ($newStatus == 1) ? 'activated' : 'deactivated';
    
    // 2. Call the Model to toggle the user status
    if ($this->user->toggleUserStatus($userId, $newStatus)) {
        $msg = urlencode("Account successfully " . $statusName . ".");
    } else {
        $msg = urlencode("Error: Failed to change account status.");
    }
    
    // 3. Redirect back to the users list
    header("Location: ../../views/admin_dashboard/users.php?msg=" . $msg);
    exit;
}

    /**
     * Handles user creation from the Admin dashboard form submission.
     */
    public function addUser() {
        // We only proceed if data was POSTed
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $msg = urlencode("Invalid access method.");
            header("Location: ../../views/admin_dashboard/users.php?msg=" . $msg);
            exit;
        }

        // 1. Simple validation (passwords match and are not empty)
        if (empty($_POST['password']) || $_POST['password'] !== $_POST['password_confirm']) {
            $msg = urlencode("Error: Passwords do not match or are empty.");
            header("Location: ../../views/admin_dashboard/users.php?msg=" . $msg);
            exit;
        }

        // 2. Prepare data array for Model
        $userData = [
            'name'      => htmlspecialchars(trim($_POST['name'])),
            'email'     => htmlspecialchars(trim($_POST['email'])),
            'phone'     => htmlspecialchars(trim($_POST['phone'])),
            'role_id'   => intval($_POST['role']),
            'password'  => $_POST['password']
        ];

        // 3. Call the Model method
        if ($this->user->createUser($userData)) {
            $msg = urlencode("User Added Successfully!");
            header("Location: ../../views/admin_dashboard/users.php?msg=" . $msg);
            exit;
        } else {
            // Check for email conflict (you might need to update your User model to expose this check)
            // For now, assume failure is due to email or DB error.
            $msg = urlencode("Error: Failed to add user. Email may already exist.");
            header("Location: ../../views/admin_dashboard/users.php?msg=" . $msg);
            exit;
        }
    }

    /**
     * Displays the users page (Called from the view file itself).
     */
    public function showUsers() {
        // This method is primarily used to fetch data for the view template.
        return $this->user->getAllUsers();
    }
    
    // Add other user functions (delete, update) here as needed...
}


// =======================================================
// Procedural Routing Logic (Direct-to-Controller Entry Point)
// =======================================================

if (isset($_GET['action'])) {
    $controller = new UserController();
    $action = $_GET['action'];

    switch ($action) {
        case 'addUser':
            $controller->addUser();
            break;
            case 'toggleStatus': // <-- CHANGE ACTION NAME
            $controller->toggleStatus();
            break;
        default:
            // Redirect back to the users list page if action is unrecognized
            header("Location: ../../views/admin_dashboard/users.php");
            break;
    }   
}