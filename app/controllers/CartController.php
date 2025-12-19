<?php
session_start();
require_once __DIR__ . '/../models/Meal.php';

$mealModel = new Meal();

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

function jsonResponse($message, $status = true) {
    echo json_encode(["status" => $status, "message" => $message]);
    exit;
}

$action = $_POST['action'] ?? null;

if ($action === "add") {

    $meal_id = intval($_POST['meal_id']);
    $meal = $mealModel->getById($meal_id);

    if (!$meal) {
        jsonResponse("Meal not found!", false);
    }

    if (isset($_SESSION['cart'][$meal_id])) {
        $_SESSION['cart'][$meal_id]['qty'] += 1;
        $count = isset($_SESSION['cart']) ? array_sum($_SESSION['cart']) : 0;
        echo $count;
    } else {
        $_SESSION['cart'][$meal_id] = [
            "id"    => $meal['id'],
            "name"  => $meal['name'],
            "price" => $meal['price'],
            "image" => $meal['image_url'] ?? "default.png",
            "qty"   => 1
        ];
    }

    jsonResponse("Meal added to cart!");
}



if ($action === "update") {
    $meal_id = intval($_POST['meal_id']);
    $qty     = max(1, intval($_POST['qty']));

    if (isset($_SESSION['cart'][$meal_id])) {
        $_SESSION['cart'][$meal_id]['qty'] = $qty;
    }

    header("Location: ../../views/cart.php");
    exit;
}



if ($action === "delete") {

    $meal_id = intval($_POST['meal_id']);

    if (isset($_SESSION['cart'][$meal_id])) {
        unset($_SESSION['cart'][$meal_id]);
    }

    header("Location: ../../views/cart.php");
    exit;
}

?>
