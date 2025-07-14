<?php
session_start();

// Associative array containing authorized admin credentials
$valid_admin = [
    'email' => 'admin@test.com',
    'password' => 'admin123', 
    'code' => 'ADMIN2024'
];

// Form processing
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    $code = $_POST['code'] ?? '';

    if ($email === $valid_admin['email'] && 
        $password === $valid_admin['password'] && 
        $code === $valid_admin['code']) {
        
        $_SESSION['admin_logged'] = true;
        header('Location: TB.php');
        exit();
    } else {
        $error = "Invalid credentials";
    }
}
?>
<?php include("header.php"); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
    :root {
        --primary-color: #dc3545;
        --primary-dark: #c82333;
        --secondary-color: #6c757d;
        --light-color: #f8f9fa;
        --dark-color: #343a40;
        --gray-color: #6c757d;
        --light-gray: #f1f1f1;
        --success-color: #28a745;
        --error-color: #dc3545;
        --transition: all 0.3s ease;
    }

    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
    }

    body {
        background-color: #f5f5f5;
        min-height: 100vh;
        font-size: 14px;
    }

    .container {
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 100vh;
        padding: 20px;
    }

    .login-section {
        background-color: white;
        width: 100%;
        padding: 40px 0;
    }

    .form-container {
        background: white;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        padding: 40px;
        width: 100%;
        max-width: 400px;
        text-align: center;
        margin: 0 auto;
    }

    .form-logo {
        margin-bottom: 30px;
    }

    .form-logo img {
        width: 60px;
        height: 60px;
    }

    .form-title {
        font-size: 24px;
        font-weight: 600;
        color: #333;
        margin-bottom: 10px;
    }

    .form-subtitle {
        color: #666;
        margin-bottom: 30px;
        font-size: 14px;
    }

    .form-group {
        margin-bottom: 20px;
        text-align: left;
    }

    .form-group input {
        width: 100%;
        padding: 12px;
        border: 1px solid #ddd;
        border-radius: 4px;
        font-size: 14px;
        transition: var(--transition);
    }

    .form-group input:focus {
        outline: none;
        border-color: var(--primary-color);
        box-shadow: 0 0 0 2px rgba(220, 53, 69, 0.2);
    }

    .btn-submit {
        width: 100%;
        background: var(--primary-color);
        color: white;
        padding: 12px;
        border: none;
        border-radius: 4px;
        font-size: 14px;
        font-weight: 500;
        cursor: pointer;
        transition: var(--transition);
        margin-top: 20px;
    }

    .btn-submit:hover {
        background: var(--primary-dark);
    }

    .message {
        padding: 15px;
        margin-bottom: 20px;
        border-radius: 4px;
        text-align: center;
        font-weight: 500;
    }

    .message.error {
        background-color: rgba(220, 53, 69, 0.15);
        color: var(--error-color);
        border: 1px solid rgba(220, 53, 69, 0.3);
    }

    /* Responsive */
    @media (max-width: 768px) {
        .form-container {
            padding: 30px 20px;
        }
    }
    .login-links {
        margin-top: 15px;
        text-align: center;
    }

    .login-links a {
        color:rgb(54, 50, 51);
        text-decoration: none;
        font-weight: bold;
        margin: 0 10px;
    }

    .login-links a:hover {
        text-decoration: underline;
    }
    </style>
</head>
<body>
    <section class="login-section">
        <div class="container">
            <div class="form-container">
                <div class="form-logo">
                    <i class="fas fa-lock" style="font-size: 40px; color: var(--primary-color);"></i>
                </div>
                
                <h1 class="form-title">Admin Login</h1>
                <p class="form-subtitle">Enter your credentials to access the admin panel</p>
                
                <?php if (isset($error)): ?>
                    <div class="message error">
                        <p><?= $error ?></p>
                    </div>
                <?php endif; ?>

                <form method="POST">
                    <div class="form-group">
                        <input type="email" name="email" placeholder="Admin Email" required>
                    </div>
                    
                    <div class="form-group">
                        <input type="password" name="password" placeholder="Password" required>
                    </div>
                    
                    <div class="form-group">
                        <input type="text" name="code" placeholder="Admin Code" required>
                    </div>
                    
                    <button type="submit" class="btn-submit">Login</button>
                    
                </form>
                <div class="login-links">
                    <a href="TB.php">Home</a>
                </div>
            </div>
        </div>
    </section>
<?php include("footer.php"); ?>
</body>
</html>