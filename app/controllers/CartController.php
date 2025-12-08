<?php
session_start();
// NOTE: Removed header("Content-Type: application/json"); 
// because this file now handles traditional form POSTs which redirect.

// Ensure cart session array exists
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// ------------------------------
// ADD TO CART (Logic needs external Meal model/data)
// This block is left for context but has been simplified/commented for stability.
// ------------------------------
if (isset($_POST['action']) && $_POST['action'] === "add") {
    // Assuming 'meal_id', 'name', 'price', and 'image_url' are correctly posted here.
    $meal_id = intval($_POST['meal_id'] ?? 0);
    $meal_name = $_POST['name'] ?? 'Unknown Meal';
    $meal_price = floatval($_POST['price'] ?? 0.00);
    $meal_image = $_POST['image_url'] ?? '';

    if ($meal_id > 0 && $meal_price > 0) {
        if (isset($_SESSION['cart'][$meal_id])) {
            $_SESSION['cart'][$meal_id]['qty'] += 1;
        } else {
            $_SESSION['cart'][$meal_id] = [
                "id" => $meal_id,
                "name" => $meal_name,
                "price" => $meal_price,
                "image" => $meal_image, // Ensure the image key is saved
                "qty" => 1
            ];
        }
    }
    header("Location: ../../views/cart.php");
    exit;
}

// ------------------------------
// UPDATE QUANTITY
// ------------------------------
if (isset($_POST['action']) && $_POST['action'] === "update") {
    $meal_id = intval($_POST['meal_id'] ?? 0);
    $qty = intval($_POST['qty'] ?? 1);
    
    // Ensure quantity is at least 1, otherwise remove it (or set to 1)
    if ($qty < 1) {
        // If the user sets quantity to 0, we can treat it as a removal
        if (isset($_SESSION['cart'][$meal_id])) {
            unset($_SESSION['cart'][$meal_id]);
        }
    } elseif (isset($_SESSION['cart'][$meal_id])) {
        // Update quantity
        $_SESSION['cart'][$meal_id]['qty'] = $qty;
    }
    
    header("Location: ../../views/cart.php");
    exit;
}

// ------------------------------
// DELETE ITEM
// ------------------------------
// The 'delete' action name used in your HTML is non-standard but is handled here.
if (isset($_POST['action']) && $_POST['action'] === "delete") {
    $meal_id = intval($_POST['meal_id'] ?? 0);
    if (isset($_SESSION['cart'][$meal_id])) {
        unset($_SESSION['cart'][$meal_id]);
    }
    header("Location: ../../views/cart.php");
    exit;
}

// Default fallback if no action is provided
// header("Location: ../../views/cart.php");
// exit;

?>