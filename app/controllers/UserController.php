<?php
require_once __DIR__ . '/../Models/User.php';
class UserController {
    
    protected $user; 

    public function __construct() {
        $this->user = new User();
    }


public function toggleStatus() {
    if (!isset($_GET['id']) || empty($_GET['id']) || !isset($_GET['status'])) {
        $msg = urlencode("Error: Missing required parameters.");
        header("Location: ../../views/admin_dashboard/users.php?msg=" . $msg);
        exit;
    }
    
    $userId = (int)$_GET['id'];
    $newStatus = (int)$_GET['status']; 
    
    $statusName = ($newStatus == 1) ? 'activated' : 'deactivated';
    
    if ($this->user->toggleUserStatus($userId, $newStatus)) {
        $msg = urlencode("Account successfully " . $statusName . ".");
    } else {
        $msg = urlencode("Error: Failed to change account status.");
    }
    
   
    header("Location: ../../views/admin_dashboard/users.php?msg=" . $msg);
    exit;
}

   
    public function addUser() {
       
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $msg = urlencode("Invalid access method.");
            header("Location: ../../views/admin_dashboard/users.php?msg=" . $msg);
            exit;
        }

       
        if (empty($_POST['password']) || $_POST['password'] !== $_POST['password_confirm']) {
            $msg = urlencode("Error: Passwords do not match or are empty.");
            header("Location: ../../views/admin_dashboard/users.php?msg=" . $msg);
            exit;
        }

      
        $userData = [
            'name'      => htmlspecialchars(trim($_POST['name'])),
            'email'     => htmlspecialchars(trim($_POST['email'])),
            'phone'     => htmlspecialchars(trim($_POST['phone'])),
            'role_id'   => intval($_POST['role']),
            'password'  => $_POST['password']
        ];

       
        if ($this->user->createUser($userData)) {
            $msg = urlencode("User Added Successfully!");
            header("Location: ../../views/admin_dashboard/users.php?msg=" . $msg);
            exit;
        } else {
          
            $msg = urlencode("Error: Failed to add user. Email may already exist.");
            header("Location: ../../views/admin_dashboard/users.php?msg=" . $msg);
            exit;
        }
    }

   
    public function showUsers() {
       
        return $this->user->getAllUsers();
    }
 
}



if (isset($_GET['action'])) {
    $controller = new UserController();
    $action = $_GET['action'];

    switch ($action) {
        case 'addUser':
            $controller->addUser();
            break;
            case 'toggleStatus': 
            $controller->toggleStatus();
            break;
        default:
           
            header("Location: ../../views/admin_dashboard/users.php");
            break;
    }   
}