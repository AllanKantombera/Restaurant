<?php
// File: app/controllers/MealController.php

require_once __DIR__ . '/../../config/Database.php';
require_once __DIR__ . '/../models/Meal.php';

class MealController {
    private $meal;

    public function __construct() {
        $this->meal = new Meal();
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    }

    // 1. Add Meal
    public function addMeal() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = trim($_POST['name']);
            $description = trim($_POST['description']);
            $price = floatval($_POST['price']);
            $category_id = intval($_POST['category_id']);
            // Convert status to 1 or 0
            $is_available = intval($_POST['is_available']);

            // Validate Image
            if (!isset($_FILES['image']) || $_FILES['image']['error'] !== UPLOAD_ERR_OK) {
                die("Error uploading image.");
            }

            $file = $_FILES['image'];
            $allowed = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
            $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

            if (!in_array($ext, $allowed)) {
                die("Invalid image format.");
            }

            // Generate unique name
            $imageName = time() . '_' . uniqid() . '.' . $ext;
            $targetDir = __DIR__ . '/../../photos/';
            
            // Ensure directory exists
            if (!is_dir($targetDir)) {
                mkdir($targetDir, 0777, true);
            }

            if (move_uploaded_file($file['tmp_name'], $targetDir . $imageName)) {
                $data = [
                    'name' => $name,
                    'description' => $description,
                    'price' => $price,
                    'category_id' => $category_id,
                    'is_available' => $is_available,
                    'image_url' => $imageName
                ];

                if ($this->meal->create($data)) {
                    header("Location: ../../views/admin_dashboard/meals.php?msg=Meal Added Successfully");
                } else {
                    die("Database Error");
                }
            } else {
                die("Failed to move uploaded file.");
            }
        }
    }

    // 2. Update Meal
    public function updateMeal() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = intval($_POST['id']);
            
            // Fetch existing meal to get current image
            $currentMeal = $this->meal->getById($id);
            if (!$currentMeal) {
                die("Meal not found");
            }

            $name = trim($_POST['name']);
            $description = trim($_POST['description']);
            $price = floatval($_POST['price']);
            $category_id = intval($_POST['category_id']);
            $is_available = intval($_POST['is_available']);
            
            $imageName = $currentMeal['image_url']; // Default to old image

            // Check if a new image was uploaded
            if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                $file = $_FILES['image'];
                $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
                $newImageName = time() . '_' . uniqid() . '.' . $ext;
                $targetDir = __DIR__ . '/../../photos/';

                if (move_uploaded_file($file['tmp_name'], $targetDir . $newImageName)) {
                    $imageName = $newImageName; // Update to new image name
                    
                    // Optional: Delete old image to save space
                    if (file_exists($targetDir . $currentMeal['image_url'])) {
                        unlink($targetDir . $currentMeal['image_url']);
                    }
                }
            }

            $data = [
                'id' => $id,
                'name' => $name,
                'description' => $description,
                'price' => $price,
                'category_id' => $category_id,
                'is_available' => $is_available,
                'image_url' => $imageName
            ];

            // Assuming your Model has an updateMeal method
            if ($this->meal->updateMeal($data)) {
                header("Location: ../../views/admin_dashboard/meals.php?msg=Meal Updated");
            } else {
                die("Update Failed");
            }
        }
    }
// In app/controllers/MealController.php

public function deleteMeal() { // REMOVE $id from these parentheses
        
    // Check if ID exists in the URL (e.g., ?action=deleteMeal&id=5)
    if (isset($_GET['id'])) {
        $id = $_GET['id'];

        // Call the Model's delete function
        // Ensure your Meal.php model has a 'delete($id)' function
        if ($this->meal->delete($id)) {
            // Success: Redirect
            header("Location: ../../views/admin_dashboard/meals.php?msg=Meal Deleted Successfully");
            exit;
        } else {
            die("Failed to delete meal.");
        }
    } else {
        die("No ID provided.");
    }
}

}

// Route the request
if (isset($_GET['action'])) {
    $controller = new MealController();
    $action = $_GET['action'];

    switch ($action) {
        case 'addMeal':
            $controller->addMeal();
            break;
        case 'updateMeal':
            $controller->updateMeal();
            break;
        case 'deleteMeal':
            $controller->deleteMeal();
            break;
        default:
            header("Location: ../../views/admin_dashboard/meals.php");
            break;
    }
}
?>