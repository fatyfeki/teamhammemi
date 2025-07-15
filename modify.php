<?php
session_start(); // Ajout de session_start pour les messages flash
require_once 'db.php';
require_once 'user.php';

// Initialisation des variables
$successMessage = '';
$errors = [];
$user = null;

// Récupération de l'ID depuis l'URL
$userId = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Charger les données de l'utilisateur si un ID est fourni
if ($userId > 0) {
    try {
        $stmt = $pdo->prepare("SELECT * FROM utilisateur WHERE id_utilisateur = ?");
        $stmt->execute([$userId]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if (!$user) {
            $errors[] = "User not found";
        }
    } catch (PDOException $e) {
        $errors[] = "Database error: " . $e->getMessage();
    }
} elseif ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    $errors[] = "No user ID provided";
}

// Traitement du formulaire lorsqu'il est soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupération des données du formulaire
    $userId = isset($_POST['user_id']) ? (int)$_POST['user_id'] : 0;
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $fonction = isset($_POST['fonction']) ? trim($_POST['fonction']) : '';
    $phone = isset($_POST['phone']) ? trim($_POST['phone']) : ''; // Correction: utiliser 'phone' au lieu de 'PhoneNumber'
    $newPassword = isset($_POST['new_password']) ? trim($_POST['new_password']) : '';
    $confirmPassword = isset($_POST['confirm_password']) ? trim($_POST['confirm_password']) : '';
    
    // Validation
    if (empty($email)) {
        $errors[] = "Email is required";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format";
    }
    
    if (empty($fonction)) {
        $errors[] = "Role is required";
    }
    
    if ($newPassword !== $confirmPassword) {
        $errors[] = "Passwords don't match";
    } elseif ($newPassword && strlen($newPassword) < 6) {
        $errors[] = "Password must be at least 6 characters";
    }
    
    // Si pas d'erreurs, procéder à la mise à jour
    if (empty($errors)) {
        try {
            // Préparation de la requête
            $query = "UPDATE utilisateur SET email = :email, fonction = :fonction, PhoneNumber = :phone";
            $params = [
                ':email' => $email,
                ':fonction' => $fonction,
                ':phone' => $phone, // Correction: utiliser la bonne variable
                ':id' => $userId
            ];
            
            // Ajout du mot de passe si fourni
            if ($newPassword) {
                $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
                $query .= ", mot_de_passe = :password";
                $params[':password'] = $hashedPassword;
            }
            
            $query .= " WHERE id_utilisateur = :id";
            
            // Exécution
            $stmt = $pdo->prepare($query);
            $success = $stmt->execute($params);
            
            if ($success && $stmt->rowCount() > 0) {
                // Message de succès dans la session
                $_SESSION['success_message'] = "User updated successfully!";
                
                // Redirection vers userlist.php
                header("Location: userlist.php");
                exit();
            } else {
                $errors[] = "No changes made or user not found";
            }
        } catch (PDOException $e) {
            $errors[] = "Database error: " . $e->getMessage();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modify User - CH OfficeTrack</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f5f5f5;
            min-height: 100vh;
        }

        .sidebar {
            position: fixed;
            left: 0;
            top: 0;
            width: 280px;
            height: 100vh;
            background: linear-gradient(180deg, #000000 0%, #1a0000 50%, #2b2b2b 100%);
            z-index: 1000;
            overflow-y: auto;
        }

        .main-content {
            margin-left: 280px;
            margin-top: 70px;
            padding: 40px 30px;
            min-height: calc(100vh - 70px);
        }

        .page-header {
            background: linear-gradient(135deg, #333333 0%, #5a0000 100%);
            border-radius: 20px;
            padding: 40px;
            color: white;
            margin-bottom: 30px;
            position: relative;
            overflow: hidden;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
        }

        .page-title {
            font-size: 32px;
            font-weight: 700;
            margin-bottom: 8px;
            background: linear-gradient(45deg, #fff, #8b0000);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .page-subtitle {
            font-size: 16px;
            opacity: 0.9;
            font-weight: 300;
        }

        .btn {
            padding: 12px 24px;
            border: none;
            border-radius: 12px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-secondary {
            background: rgba(255,255,255,0.1);
            color: white;
            border: 1px solid rgba(255,255,255,0.2);
        }

        .btn-secondary:hover {
            background: rgba(255,255,255,0.2);
            transform: translateY(-2px);
        }

        .form-container {
            background: white;
            border-radius: 20px;
            padding: 40px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            border: 1px solid #e9ecef;
            position: relative;
        }

        .form-container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(135deg, #8b0000 0%, #5a0000 100%);
        }

        .form-row {
            display: flex;
            gap: 20px;
            margin-bottom: 25px;
        }

        .form-group {
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        .form-label {
            font-weight: 600;
            color: #333;
            margin-bottom: 8px;
            font-size: 14px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .form-label.required::after {
            content: '*';
            color: #dc3545;
            font-weight: bold;
        }

        .form-input, .form-select {
            padding: 14px 16px;
            border: 2px solid #e9ecef;
            border-radius: 12px;
            font-size: 14px;
            background: #f8f9fa;
            transition: all 0.3s ease;
            outline: none;
        }

        .form-input:focus, .form-select:focus {
            border-color: #8b0000;
            background: white;
            box-shadow: 0 0 0 4px rgba(139, 0, 0, 0.1);
        }

        .form-actions {
            display: flex;
            gap: 15px;
            justify-content: flex-end;
            margin-top: 40px;
            padding-top: 30px;
            border-top: 2px solid #f8f9fa;
        }

        .btn-save {
            background: #28a745;
            color: white;
            border: none;
            padding: 14px 28px;
            border-radius: 12px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .btn-save:hover {
            background: #218838;
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(40, 167, 69, 0.3);
        }

        .btn-cancel {
            background: #6c757d;
            color: white;
            border: none;
            padding: 14px 28px;
            border-radius: 12px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .btn-cancel:hover {
            background: #5a6268;
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(108, 117, 125, 0.3);
        }

        .alert {
            padding: 16px 20px;
            border-radius: 12px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .alert-success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .alert-error {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        .header-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
                transition: transform 0.3s ease;
            }
            
            .sidebar.active {
                transform: translateX(0);
            }
            
            .main-content {
                margin-left: 0;
                padding: 20px;
            }
            
            .page-title {
                font-size: 24px;
            }
            
            .form-row {
                flex-direction: column;
            }
            
            .form-actions {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
    <?php include 'sys.php'; ?>
    
    <!-- Main Content -->
    <main class="main-content">
        <!-- Page Header -->
        <section class="page-header">
            <div class="header-content">
                <div>
                    <h1 class="page-title">Modify User</h1>
                    <p class="page-subtitle">Edit user information</p>
                </div>
                <div class="header-actions">
                    <a href="userlist.php" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i>
                        Back to Users
                    </a>
                </div>
            </div>
        </section>

        <!-- Modify User Form -->
        <section class="form-container">
            <!-- Affichage des messages -->
            <?php if (!empty($successMessage)): ?>
                <div class="alert alert-success">
                    <i class="fas fa-check-circle"></i>
                    <?php echo htmlspecialchars($successMessage); ?>
                </div>
            <?php endif; ?>
            
            <?php if (!empty($errors)): ?>
                <div class="alert alert-error">
                    <i class="fas fa-exclamation-circle"></i>
                    <?php echo htmlspecialchars(implode('<br>', $errors)); ?>
                </div>
            <?php endif; ?>

            <!-- Formulaire -->
            <?php if ($user || $_SERVER['REQUEST_METHOD'] === 'POST'): ?>
                <form method="POST" onsubmit="return confirm('Are you sure you want to save these changes?')">
                    <input type="hidden" name="user_id" value="<?php echo isset($user['id_utilisateur']) ? (int)$user['id_utilisateur'] : $userId; ?>">

                    <!-- Email -->
                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label required">
                                <i class="fas fa-envelope"></i>
                                Email
                            </label>
                            <input type="email" name="email" class="form-input" required
                                   value="<?php echo isset($user['email']) ? htmlspecialchars($user['email']) : (isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''); ?>">
                        </div>
                    </div>

                    <!-- Phone Number -->
                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">
                                <i class="fas fa-phone"></i>
                                Phone Number
                            </label>
                            <input type="tel" name="phone" class="form-input"
                                   value="<?php echo isset($user['PhoneNumber']) ? htmlspecialchars($user['PhoneNumber']) : (isset($_POST['phone']) ? htmlspecialchars($_POST['phone']) : ''); ?>">
                        </div>
                    </div>

                    <!-- Role/Fonction -->
                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label required">
                                <i class="fas fa-user-tag"></i>
                                Role (Fonction)
                            </label>
                            <select name="fonction" class="form-select" required>
                                <option value="">Select Role</option>
                                <option value="Administrateur" <?php echo (isset($user['fonction']) && $user['fonction'] === 'Administrateur') || (isset($_POST['fonction']) && $_POST['fonction'] === 'Administrateur') ? 'selected' : ''; ?>>Administrateur</option>
                                <option value="Employé" <?php echo (isset($user['fonction']) && $user['fonction'] === 'Employé') || (isset($_POST['fonction']) && $_POST['fonction'] === 'Employé') ? 'selected' : ''; ?>>Employé</option>
                                <option value="Client" <?php echo (isset($user['fonction']) && $user['fonction'] === 'Client') || (isset($_POST['fonction']) && $_POST['fonction'] === 'Client') ? 'selected' : ''; ?>>Client</option>
                            </select>
                        </div>
                    </div>

                    <!-- Password Section -->
                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">
                                <i class="fas fa-lock"></i>
                                New Password
                            </label>
                            <input type="password" name="new_password" class="form-input" placeholder="Leave blank to keep current password">
                        </div>
                        <div class="form-group">
                            <label class="form-label">
                                <i class="fas fa-lock"></i>
                                Confirm Password
                            </label>
                            <input type="password" name="confirm_password" class="form-input" placeholder="Confirm new password">
                        </div>
                    </div>

                    <!-- Form Actions -->
                    <div class="form-actions">
                        <button type="button" class="btn-cancel" onclick="window.location.href='userlist.php'">
                            <i class="fas fa-times"></i>
                            Cancel
                        </button>
                        <button type="submit" class="btn-save">
                            <i class="fas fa-save"></i>
                            Save Changes
                        </button>
                    </div>
                </form>
            <?php else: ?>
                <div class="alert alert-error">
                    <i class="fas fa-exclamation-circle"></i>
                    Please select a user to modify from the users list.
                </div>
            <?php endif; ?>
        </section>
    </main>

    <script>
        // Validation côté client
        document.querySelector('form').addEventListener('submit', function(e) {
            const newPassword = document.querySelector('[name="new_password"]').value;
            const confirmPassword = document.querySelector('[name="confirm_password"]').value;
            
            if (newPassword !== confirmPassword) {
                alert('Passwords do not match');
                e.preventDefault();
                return false;
            }
            
            if (newPassword && newPassword.length < 6) {
                alert('Password must be at least 6 characters');
                e.preventDefault();
                return false;
            }
            
            return true;
        });
    </script>
</body>
</html>