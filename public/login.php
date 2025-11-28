<?php
require_once "../app/controllers/AuthController.php";

$auth = new AuthController();
$error = $auth->login();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aunt Joy | Login</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            background: #eaf4ff;
            color: #0b2545;
        }
        .auth-card {
            background: #ffffff;
            border-radius: 15px;
            padding: 35px;
            max-width: 460px;
            margin: 60px auto;
            box-shadow: 0 8px 25px rgba(0,0,0,0.1);
            border-left: 5px solid #5bb6ff;
        }
        .btn-main {
            background: #5bb6ff;
            border: none;
            color: white;
        }
        .btn-main:hover {
            background: #3ea4f8;
        }
        a {
            color: #007bff;
        }
    </style>
</head>

<body>

    <div class="auth-card text-center">

        <h2 class="fw-bold mb-4">Aunt Joy's Restaurant</h2>
        <h5 class="text-secondary mb-4">Login</h5>

        <?php if ($error): ?>
            <div class="alert alert-danger"><?= $error ?></div>
        <?php endif; ?>

        <form method="POST">
            <div class="mb-3 text-start">
                <label class="form-label">Email Address</label>
                <input type="email" class="form-control" name="email" placeholder="Enter email" required>
            </div>

            <div class="mb-3 text-start">
                <label class="form-label">Password</label>
                <input type="password" class="form-control" name="password" placeholder="Enter password" required>
            </div>

            <button class="btn btn-main w-100 py-2 mt-3">Login</button>
        </form>

        <p class="mt-3">
            Don’t have an account?  
            <a href="signup.php">Sign Up</a>
        </p>

    </div>

</body>
</html>
