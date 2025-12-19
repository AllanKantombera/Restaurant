<?php 
require_once "../app/controllers/AuthController.php";
$auth = new AuthController();
$auth->signup();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aunt Joy's Restaurant | Sign Up</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #eaf4ff 0%, #d4e9ff 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            padding: 20px;
        }
        .auth-container {
            max-width: 480px;
            width: 100%;
            margin: 0 auto;
        }
        .auth-card {
            background: white;
            border-radius: 20px;
            padding: 45px 40px;
            box-shadow: 0 15px 40px rgba(91, 182, 255, 0.15);
            border-top: 4px solid #5bb6ff;
        }
        .logo-container {
            margin-bottom: 35px;
        }
        .logo-title {
            color: #0b2545;
            font-weight: 700;
            font-size: 28px;
            margin-bottom: 5px;
        }
        .logo-subtitle {
            color: #5bb6ff;
            font-size: 16px;
            letter-spacing: 1px;
        }
        .form-label {
            color: #0b2545;
            font-weight: 500;
            margin-bottom: 8px;
            font-size: 14px;
        }
        .form-control {
            border: 2px solid #eaf4ff;
            border-radius: 10px;
            padding: 12px 16px;
            font-size: 15px;
            transition: all 0.3s;
        }
        .form-control:focus {
            border-color: #5bb6ff;
            box-shadow: 0 0 0 3px rgba(91, 182, 255, 0.15);
        }
        .btn-main {
            background: linear-gradient(135deg, #5bb6ff 0%, #3ea4f8 100%);
            border: none;
            color: white;
            border-radius: 10px;
            padding: 14px;
            font-weight: 600;
            font-size: 16px;
            letter-spacing: 0.5px;
            transition: all 0.3s;
            margin-top: 10px;
        }
        .btn-main:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(91, 182, 255, 0.3);
        }
        .auth-footer {
            margin-top: 25px;
            color: #6c757d;
            font-size: 15px;
        }
        .auth-link {
            color: #3ea4f8;
            text-decoration: none;
            font-weight: 600;
            transition: color 0.3s;
        }
        .auth-link:hover {
            color: #0b2545;
            text-decoration: underline;
        }
        .input-group {
            position: relative;
        }
        .password-toggle {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: #6c757d;
            cursor: pointer;
            z-index: 3;
        }
        .password-strength {
            height: 4px;
            background: #e9ecef;
            border-radius: 2px;
            margin-top: 8px;
            overflow: hidden;
        }
        .strength-meter {
            height: 100%;
            width: 0%;
            border-radius: 2px;
            transition: all 0.3s;
        }
    </style>
</head>
<body>
    <div class="auth-container">
        <div class="auth-card">
            <div class="logo-container text-center">
                <div class="logo-title">Aunt Joy's</div>
                <div class="logo-subtitle">RESTAURANT</div>
            </div>
            
            <h4 class="text-center mb-4" style="color: #0b2545;">Create Account</h4>
            
            <?php if (!empty($auth->error)): ?>
                <div class="alert alert-danger d-flex align-items-center" role="alert">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>
                    <div><?= $auth->error ?></div>
                </div>
            <?php endif; ?>

            <form method="POST">
                <div class="mb-4">
                    <label class="form-label">Full Name</label>
                    <div class="input-group">
                        <span class="input-group-text bg-transparent border-end-0">
                            <i class="bi bi-person" style="color: #5bb6ff;"></i>
                        </span>
                        <input type="text" name="name" class="form-control border-start-0 ps-0" placeholder="Enter your full name" required>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label">Email Address</label>
                    <div class="input-group">
                        <span class="input-group-text bg-transparent border-end-0">
                            <i class="bi bi-envelope" style="color: #5bb6ff;"></i>
                        </span>
                        <input type="email" name="email" class="form-control border-start-0 ps-0" placeholder="Enter your email" required>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label">Password</label>
                    <div class="input-group">
                        <span class="input-group-text bg-transparent border-end-0">
                            <i class="bi bi-lock" style="color: #5bb6ff;"></i>
                        </span>
                        <input type="password" name="password" class="form-control border-start-0 ps-0" id="password" placeholder="Create a password" required>
                        <button type="button" class="password-toggle" id="togglePassword">
                            <i class="bi bi-eye"></i>
                        </button>
                    </div>
                    <div class="password-strength">
                        <div class="strength-meter" id="passwordStrength"></div>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label">Confirm Password</label>
                    <div class="input-group">
                        <span class="input-group-text bg-transparent border-end-0">
                            <i class="bi bi-lock-fill" style="color: #5bb6ff;"></i>
                        </span>
                        <input type="password" name="confirm" class="form-control border-start-0 ps-0" id="confirmPassword" placeholder="Confirm your password" required>
                        <button type="button" class="password-toggle" id="toggleConfirmPassword">
                            <i class="bi bi-eye"></i>
                        </button>
                    </div>
                </div>

                <button class="btn btn-main w-100 py-3" name="signup">
                    <i class="bi bi-person-plus me-2"></i>Create Account
                </button>
            </form>

            <div class="auth-footer text-center">
                Already have an account?  
                <a href="login.php" class="auth-link">Sign In</a>
            </div>
        </div>
    </div>

    <script>
        const passwordInput = document.getElementById('password');
        const confirmInput = document.getElementById('confirmPassword');
        const strengthMeter = document.getElementById('passwordStrength');
        const togglePassword = document.getElementById('togglePassword');
        const toggleConfirmPassword = document.getElementById('toggleConfirmPassword');
        
        function updatePasswordStrength() {
            const password = passwordInput.value;
            let strength = 0;
            
            if (password.length >= 8) strength += 25;
            if (/[A-Z]/.test(password)) strength += 25;
            if (/[a-z]/.test(password)) strength += 25;
            if (/[0-9]/.test(password) || /[^A-Za-z0-9]/.test(password)) strength += 25;
            
            strengthMeter.style.width = strength + '%';
            
            if (strength < 50) strengthMeter.style.background = '#dc3545';
            else if (strength < 75) strengthMeter.style.background = '#ffc107';
            else strengthMeter.style.background = '#28a745';
        }
        
        function togglePasswordVisibility(input, toggleBtn) {
            const type = input.getAttribute('type') === 'password' ? 'text' : 'password';
            input.setAttribute('type', type);
            const icon = toggleBtn.querySelector('i');
            icon.classList.toggle('bi-eye');
            icon.classList.toggle('bi-eye-slash');
        }
        
        passwordInput.addEventListener('input', updatePasswordStrength);
        
        togglePassword.addEventListener('click', () => {
            togglePasswordVisibility(passwordInput, togglePassword);
        });
        
        toggleConfirmPassword.addEventListener('click', () => {
            togglePasswordVisibility(confirmInput, toggleConfirmPassword);
        });
    </script>
</body>
</html>