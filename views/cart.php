<?php
session_start();
$cart = $_SESSION['cart'] ?? [];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Your Cart</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<div class="container py-5">
    <h2 class="mb-4 fw-bold">🛒 Your Cart</h2>

    <?php if (empty($cart)): ?>
        <div class="alert alert-info text-center">
            Your cart is empty!
        </div>
    <?php else: ?>
        <table class="table table-bordered align-middle bg-white">
            <thead class="table-dark">
                <tr>
                    <th>Image</th>
                    <th>Meal</th>
                    <th>Price</th>
                    <th width="150">Quantity</th>
                    <th>Total</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>

                <?php 
                $grandTotal = 0;
                foreach ($cart as $item): 
                    $lineTotal = $item['price'] * $item['qty'];
                    $grandTotal += $lineTotal;
                ?>
                <tr>
                    <td width="100">
                        <img src="../photos/<?= $item['image']; ?>" class="img-fluid rounded">
                        <?= $item['image']; ?>
                    </td>

                    <td><?= htmlspecialchars($item['name']); ?></td>

                    <td>MWK <?= number_format($item['price']); ?></td>

                    <td>
                        <form method="POST" action="../app/controllers/cartcontroller.php" class="d-flex">
                            <input type="hidden" name="action" value="update">
                            <input type="hidden" name="meal_id" value="<?= $item['id']; ?>">

                            <input type="number" name="qty" class="form-control text-center" 
                                   value="<?= $item['qty']; ?>" min="1">

                            <button class="btn btn-primary btn-sm ms-2">Update</button>
                        </form>
                    </td>

                    <td>MWK <?= number_format($lineTotal); ?></td>

                    <td>
                        <form method="POST" action="../app/controllers/cartcontroller.php">
                            <input type="hidden" name="action" value="delete">
                            <input type="hidden" name="meal_id" value="<?= $item['id']; ?>">
                            <button class="btn btn-danger btn-sm">Remove</button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; ?>

            </tbody>
        </table>

        <div class="text-end">
            <h3 class="fw-bold">Grand Total: MWK <?= number_format($grandTotal); ?></h3>
            <button class="btn btn-success btn-lg mt-3">Proceed to Checkout</button>
        </div>

    <?php endif; ?>

</div>

</body>
</html>
