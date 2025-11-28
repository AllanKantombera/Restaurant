<?php

require_once "../app/models/User.php";

class AuthController {

    public $error = "";

    public function signup() {

        if (isset($_POST['signup'])) {

            $name = trim($_POST['name']);
            $email = trim($_POST['email']);
            $password = trim($_POST['password']);
            $confirm = trim($_POST['confirm']);

            // VALIDATION
            if ($password !== $confirm) {
                $this->error = "Passwords do not match.";
                return;
            }

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $this->error = "Invalid email format.";
                return;
            }

            $user = new User();

            if ($user->register($name, $email, $password)) {
                header("Location: login.php?success=1");
                exit;
            } else {
                $this->error = "Email already exists.";
            }
        }
    }

    public function login() {

        if ($_SERVER['REQUEST_METHOD'] === "POST") {

            $email = trim($_POST['email']);
            $password = trim($_POST['password']);

            $user = new User();
            $found = $user->login($email, $password);

            if (!$found) {
                return "Invalid email or password";
            }

            // Start session
            session_start();
            $_SESSION['user_id'] = $found['id'];
            $_SESSION['user_name'] = $found['name'];
            $_SESSION['role_id'] = $found['role_id'];

            // Redirect based on role
            if ($found['role_id'] == 1) {
                header("Location: ../views/admin_dashboard/index.php");
            } elseif ($found['role_id'] == 2) {
                header("Location: ../views/manager_dashboard/index.php");
            } elseif ($found['role_id'] == 3) {
                header("Location: ../views/sales_dashboard/index.php");
            } elseif ($found['role_id'] == 4) {
                header("Location: ../views/index.php");
            } else {
                header("Location: ../views/index.php");
            }

            exit;
        }

        return null; // No error
    }
}