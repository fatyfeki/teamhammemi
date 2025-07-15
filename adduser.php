<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add User - CH OfficeTrack</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #f1f1f1 0%, #e0e0e0 100%);
            min-height: 100vh;
        }

        /* Navigation Sidebar */
        .sidebar {
            position: fixed;
            left: 0;
            top: 0;
            width: 280px;
            height: 100vh;
            background: linear-gradient(180deg, #000000 0%, #1a0000 50%, #2b2b2b 100%);
            backdrop-filter: blur(20px);
            box-shadow: 
                0 10px 30px rgba(0,0,0,0.3),
                inset 1px 0 0 rgba(255,255,255,0.1);
            z-index: 1000;
            overflow-y: auto;
        }

        /* Header */
        .sidebar-header {
            background: linear-gradient(135deg, #8b0000 0%, #5a0000 100%);
            color: white;
            padding: 24px 20px;
            position: relative;
            overflow: hidden;
        }

        .sidebar-header::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
            animation: pulse 4s ease-in-out infinite;
        }

        @keyframes pulse {
            0%, 100% { transform: scale(1); opacity: 0.5; }
            50% { transform: scale(1.1); opacity: 0.8; }
        }

        .header-content {
            position: relative;
            z-index: 2;
        }

        .company-name {
            font-size: 16px;
            font-weight: 700;
            letter-spacing: 0.5px;
            margin-bottom: 4px;
        }

        .system-label {
            font-size: 12px;
            font-weight: 400;
            opacity: 0.9;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        /* Navigation Menu */
        .nav-menu {
            list-style: none;
            padding: 12px 0;
            margin: 0;
        }

        .nav-section {
            margin-bottom: 20px;
        }

        .nav-section-title {
            color: rgba(255,255,255,0.5);
            font-size: 11px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin: 0 20px 10px 20px;
            padding-bottom: 8px;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }

        .nav-item {
            margin: 2px 12px;
            border-radius: 12px;
            overflow: hidden;
        }

        .nav-link {
            display: flex;
            align-items: center;
            padding: 16px 20px;
            color: rgba(255,255,255,0.8);
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            border-radius: 12px;
            margin-bottom: 2px;
        }

        .nav-link::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            width: 0;
            height: 100%;
            background: linear-gradient(135deg, #8b0000 0%, #5a0000 100%);
            transition: width 0.3s ease;
            border-radius: 12px;
        }

        .nav-link:hover::before {
            width: 100%;
        }

        .nav-link:hover {
            color: #ffffff;
            transform: translateX(4px);
            box-shadow: 0 4px 20px rgba(139,0,0,0.3);
        }

        .nav-link.active {
            background: linear-gradient(135deg, #8b0000 0%, #5a0000 100%);
            color: #ffffff;
            box-shadow: 
                0 4px 20px rgba(139,0,0,0.4),
                inset 0 1px 0 rgba(255,255,255,0.2);
        }

        .nav-link.active::before {
            width: 100%;
        }

        /* Icônes */
        .nav-icon {
            width: 20px;
            height: 20px;
            margin-right: 16px;
            font-size: 16px;
            text-align: center;
            position: relative;
            z-index: 2;
        }

        .nav-text {
            position: relative;
            z-index: 2;
        }

        /* Animations d'entrée */
        .nav-item {
            opacity: 0;
            transform: translateX(-20px);
            animation: slideIn 0.5s ease forwards;
        }

        .nav-item:nth-child(1) { animation-delay: 0.1s; }
        .nav-item:nth-child(2) { animation-delay: 0.2s; }
        .nav-item:nth-child(3) { animation-delay: 0.3s; }
        .nav-item:nth-child(4) { animation-delay: 0.4s; }
        .nav-item:nth-child(5) { animation-delay: 0.5s; }
        .nav-item:nth-child(6) { animation-delay: 0.6s; }
        .nav-item:nth-child(7) { animation-delay: 0.7s; }
        .nav-item:nth-child(8) { animation-delay: 0.8s; }
        .nav-item:nth-child(9) { animation-delay: 0.9s; }
        .nav-item:nth-child(10) { animation-delay: 1.0s; }

        @keyframes slideIn {
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        /* Effet de brillance */
        .nav-link.active::after {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(
                90deg,
                transparent,
                rgba(255,255,255,0.2),
                transparent
            );
            transition: left 0.5s;
        }

        .nav-link.active:hover::after {
            left: 100%;
        }

        /* Scrollbar personnalisée */
        .sidebar::-webkit-scrollbar {
            width: 4px;
        }

        .sidebar::-webkit-scrollbar-track {
            background: rgba(255,255,255,0.1);
        }

        .sidebar::-webkit-scrollbar-thumb {
            background: rgba(255,255,255,0.3);
            border-radius: 2px;
        }

        .sidebar::-webkit-scrollbar-thumb:hover {
            background: rgba(255,255,255,0.5);
        }

        /* Top Navigation Bar */
        .top-navbar {
            position: fixed;
            top: 0;
            left: 280px;
            right: 0;
            height: 70px;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-bottom: 1px solid rgba(0, 0, 0, 0.1);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 30px;
            z-index: 999;
            box-shadow: 0 2px 20px rgba(0, 0, 0, 0.1);
        }

        .navbar-left {
            flex: 1;
            max-width: 1100px;
        }

        .navbar-right {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        /* Search Bar */
        .search-container {
            position: relative;
            width: 100%;
        }

        .search-input {
            width: 100%;
            padding: 12px 20px 12px 50px;
            border: 2px solid #e9ecef;
            border-radius: 25px;
            font-size: 14px;
            background: #f8f9fa;
            transition: all 0.3s ease;
            outline: none;
        }

        .search-input:focus {
            border-color: #8b0000;
            background: white;
            box-shadow: 0 0 0 4px rgba(139, 0, 0, 0.1);
        }

        .search-icon {
            position: absolute;
            left: 18px;
            top: 50%;
            transform: translateY(-50%);
            color: #6c757d;
            font-size: 14px;
        }

        /* Notifications */
        .notifications {
            position: relative;
            cursor: pointer;
        }

        .notifications .fas {
            font-size: 20px;
            color: #6c757d;
            transition: color 0.2s ease;
        }

        .notifications:hover .fas {
            color: #8b0000;
        }

        .notification-badge {
            position: absolute;
            top: -8px;
            right: -8px;
            background: #8b0000;
            color: white;
            border-radius: 50%;
            width: 20px;
            height: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 11px;
            font-weight: bold;
        }

        /* Profile Menu */
        .profile-menu {
            position: relative;
            display: flex;
            align-items: center;
            gap: 12px;
            cursor: pointer;
            padding: 8px 12px;
            border-radius: 12px;
            transition: background 0.2s ease;
        }

        .profile-menu:hover {
            background: #f8f9fa;
        }

        .profile-avatar {
            position: relative;
        }

        .profile-avatar img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid #e9ecef;
        }

        .status-indicator {
            position: absolute;
            bottom: 2px;
            right: 2px;
            width: 12px;
            height: 12px;
            background: #28a745;
            border-radius: 50%;
            border: 2px solid white;
        }

        .profile-info {
            display: flex;
            flex-direction: column;
            gap: 2px;
        }

        .profile-name {
            font-weight: 600;
            color: #333;
            font-size: 14px;
        }

        .profile-role {
            color: #6c757d;
            font-size: 12px;
        }

        /* Main Content Area */
        .main-content {
            margin-left: 280px;
            margin-top: 70px;
            padding: 40px 30px;
            min-height: calc(100vh - 70px);
        }

        /* Form Section */
        .form-section {
            background: white;
            border-radius: 20px;
            padding: 30px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            border: 1px solid #e9ecef;
            margin-bottom: 30px;
        }

        .section-title {
            font-size: 18px;
            font-weight: 600;
            color: #333;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid #f8f9fa;
            position: relative;
        }

        .section-title::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 0;
            width: 50px;
            height: 2px;
            background: linear-gradient(135deg, #8b0000 0%, #5a0000 100%);
        }

        /* Form Table */
        .form-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0 15px;
        }

        .form-table th {
            text-align: left;
            padding: 0 15px;
            font-weight: 500;
            color: #555;
            width: 200px;
            vertical-align: top;
            padding-top: 12px;
        }

        .form-table td {
            padding: 0 15px;
        }

        /* Form Inputs */
        .form-input {
            width: 100%;
            padding: 12px 16px;
            border: 2px solid #e9ecef;
            border-radius: 12px;
            font-size: 14px;
            transition: all 0.3s ease;
            background: #f8f9fa;
        }

        .form-input:focus {
            border-color: #8b0000;
            background: white;
            box-shadow: 0 0 0 4px rgba(139, 0, 0, 0.1);
            outline: none;
        }

        .form-select {
            width: 100%;
            padding: 12px 16px;
            border: 2px solid #e9ecef;
            border-radius: 12px;
            font-size: 14px;
            transition: all 0.3s ease;
            background: #f8f9fa;
            appearance: none;
            background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3e%3cpolyline points='6 9 12 15 18 9'%3e%3c/polyline%3e%3c/svg%3e");
            background-repeat: no-repeat;
            background-position: right 10px center;
            background-size: 1em;
        }

        .form-select:focus {
            border-color: #8b0000;
            background: white;
            box-shadow: 0 0 0 4px rgba(139, 0, 0, 0.1);
            outline: none;
        }

        .form-textarea {
            width: 100%;
            padding: 12px 16px;
            border: 2px solid #e9ecef;
            border-radius: 12px;
            font-size: 14px;
            transition: all 0.3s ease;
            background: #f8f9fa;
            min-height: 100px;
            resize: vertical;
        }

        .form-textarea:focus {
            border-color: #8b0000;
            background: white;
            box-shadow: 0 0 0 4px rgba(139, 0, 0, 0.1);
            outline: none;
        }

        /* Form Buttons */
        .form-buttons {
            display: flex;
            justify-content: flex-end;
            gap: 15px;
            margin-top: 20px;
        }

        .btn {
            padding: 12px 24px;
            border-radius: 12px;
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
            border: none;
        }

        .btn-primary {
            background: linear-gradient(135deg, #8b0000 0%, #5a0000 100%);
            color: white;
            box-shadow: 0 4px 15px rgba(139, 0, 0, 0.2);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(139, 0, 0, 0.3);
        }

        .btn-secondary {
            background: #f8f9fa;
            color: #333;
            border: 1px solid #e9ecef;
        }

        .btn-secondary:hover {
            background: #e9ecef;
        }

        /* Form Help Text */
        .form-help {
            font-size: 12px;
            color: #6c757d;
            margin-top: 8px;
            display: block;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
                transition: transform 0.3s ease;
            }
            
            .sidebar.active {
                transform: translateX(0);
            }
            
            .top-navbar {
                left: 0;
                padding: 0 20px;
            }
            
            .main-content {
                margin-left: 0;
                padding: 20px;
            }
            
            .form-table {
                display: block;
            }
            
            .form-table tbody {
                display: block;
            }
            
            .form-table tr {
                display: block;
                margin-bottom: 20px;
            }
            
            .form-table th, 
            .form-table td {
                display: block;
                width: 100%;
                padding: 5px 0;
            }
            
            .form-buttons {
                justify-content: center;
            }
        }

        /* Subtle glow effect */
        .sidebar::after {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            width: 1px;
            height: 100%;
            background: linear-gradient(
                180deg,
                transparent 0%,
                rgba(139,0,0,0.3) 20%,
                rgba(139,0,0,0.1) 80%,
                transparent 100%
            );
        }
    </style>
</head>
<body>
<?php 
include 'sys.php';
include 'db.php'; // Inclure la connexion à la base de données
include 'user.php'; // Inclure la classe Utilisateur

// Traitement du formulaire
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Récupération des données du formulaire
        $prenom = $_POST['prenom'] ?? '';
        $nom = $_POST['nom'] ?? '';
        $email = $_POST['email'] ?? '';
        $PhoneNumber = $_POST['PhoneNumber'] ?? '';
        $mot_de_passe = $_POST['mot_de_passe'] ?? '';
        $confirmation_mot_de_passe = $_POST['confirmation_mot_de_passe'] ?? '';
        $fonction = $_POST['fonction'] ?? 'utilisateur';
        
        // Validation des données
        $errors = [];
        
        if (empty($prenom)) $errors[] = "Le prénom est requis";
        if (empty($nom)) $errors[] = "Le nom est requis";
        if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = "Un email valide est requis";
        if (empty($mot_de_passe)) $errors[] = "Le mot de passe est requis";
        if ($mot_de_passe !== $confirmation_mot_de_passe) $errors[] = "Les mots de passe ne correspondent pas";
        if (strlen($mot_de_passe) < 8) $errors[] = "Le mot de passe doit contenir au moins 8 caractères";
        
        // Si pas d'erreurs, procéder à l'insertion
        if (empty($errors)) {
            // Vérification si l'email existe déjà
            $stmt_check = $pdo->prepare("SELECT COUNT(*) FROM Utilisateur WHERE email = :email");
            $stmt_check->execute([':email' => $email]);
            $email_exists = $stmt_check->fetchColumn();
            
            if ($email_exists) {
                $errors[] = "Cet email est déjà utilisé par un autre utilisateur";
            } else {
                // Hachage du mot de passe
                $mot_de_passe_hash = password_hash($mot_de_passe, PASSWORD_BCRYPT);
                
                if ($mot_de_passe_hash === false) {
                    $errors[] = "Erreur lors du hachage du mot de passe";
                } else {
                    // Création d'un nouvel utilisateur
                    $nouvelUtilisateur = new Utilisateur(
                        null, // id_utilisateur sera auto-incrémenté
                        $nom,
                        $prenom,
                        $email,
                        $PhoneNumber,
                        $mot_de_passe_hash,
                        $fonction
                    );
                    
                    // Préparation de la requête SQL
                   $stmt = $pdo->prepare("INSERT INTO Utilisateur (nom, prenom, email, mot_de_passe, fonction, PhoneNumber) 
                       VALUES (:nom, :prenom, :email, :mot_de_passe, :fonction, :PhoneNumber)");
                    
                    // Exécution avec les paramètres
                    $success = $stmt->execute([
                        ':nom' => $nouvelUtilisateur->getNom(),
                        ':prenom' => $nouvelUtilisateur->getPrenom(),
                        ':email' => $nouvelUtilisateur->getEmail(),
                        ':PhoneNumber' => $nouvelUtilisateur->getPhoneNumber(),
                        ':mot_de_passe' => $nouvelUtilisateur->getMotDePasse(),
                        ':fonction' => $nouvelUtilisateur->getFonction()
                    ]);
                    
                    if ($success) {
                        // Message de succès
                        $success_message = "L'utilisateur a été créé avec succès!";
                        // Réinitialisation des valeurs du formulaire
                        $_POST = array();
                    } else {
                        $errors[] = "Erreur lors de l'insertion dans la base de données";
                    }
                }
            }
        }
    } catch (PDOException $e) {
        $errors[] = "Erreur lors de la création de l'utilisateur: " . $e->getMessage();
    }
}
?>
    <!-- Main Content -->
    <main class="main-content">
        <!-- Form Section -->
        <section class="form-section">
            <h2 class="section-title"><i class="fas fa-user-plus"></i> Add New User</h2>
            
            <?php if (!empty($errors)): ?>
                <div class="alert alert-danger" style="color: #721c24; background-color: #f8d7da; border-color: #f5c6cb; padding: 10px; border-radius: 5px; margin-bottom: 20px;">
                    <ul>
                        <?php foreach ($errors as $error): ?>
                            <li><?php echo htmlspecialchars($error); ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>
            
            <?php if (isset($success_message)): ?>
                <div class="alert alert-success" style="color: #155724; background-color: #d4edda; border-color: #c3e6cb; padding: 10px; border-radius: 5px; margin-bottom: 20px;">
                    <?php echo htmlspecialchars($success_message); ?>
                </div>
            <?php endif; ?>
            
            <form id="add-user-form" method="POST" action="">
    <table class="form-table">
        <tr>
            <th>First Name</th>
            <td>
                <input type="text" name="prenom" id="prenom" class="form-input" placeholder="Enter first name" required value="<?php echo htmlspecialchars($_POST['prenom'] ?? ''); ?>">
                <span class="form-help">User's first name (required)</span>
            </td>
        </tr>
        <tr>
            <th>Last Name</th>
            <td>
                <input type="text" name="nom" id="nom" class="form-input" placeholder="Enter last name" required value="<?php echo htmlspecialchars($_POST['nom'] ?? ''); ?>">
                <span class="form-help">User's last name (required)</span>
            </td>
        </tr>
        <tr>
            <th>Email Address</th>
            <td>
                <input type="email" name="email" id="email" class="form-input" placeholder="Enter email address" required value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>">
                <span class="form-help">Will be used for login and notifications</span>
            </td>
        </tr>
        <tr>
            <th>Phone Number</th>
            <td>
                <input type="tel" name="PhoneNumber" id="PhoneNumber" class="form-input" placeholder="Enter phone number" value="<?php echo htmlspecialchars($_POST['PhoneNumber'] ?? ''); ?>">
                <span class="form-help">User's contact number (optional)</span>
            </td>
        </tr>
        <tr>
            <th>Password</th>
            <td>
                <input type="password" name="mot_de_passe" id="mot_de_passe" class="form-input" placeholder="Enter password" required>
                <span class="form-help">Minimum 8 characters with numbers and special characters</span>
            </td>
        </tr>
        <tr>
            <th>Confirm Password</th>
            <td>
                <input type="password" name="confirmation_mot_de_passe" id="confirmation_mot_de_passe" class="form-input" placeholder="Confirm password" required>
            </td>
        </tr>
        <tr>
            <th>User Role</th>
            <td>
                <select class="form-select" name="fonction" id="fonction" required>
                    <option value="utilisateur" <?php echo (($_POST['fonction'] ?? '') === 'utilisateur' ? 'selected' : ''); ?>>User</option>
                    <option value="responsable" <?php echo (($_POST['fonction'] ?? '') === 'responsable' ? 'selected' : ''); ?>>Responsible</option>
                    <option value="gestionnaire" <?php echo (($_POST['fonction'] ?? '') === 'gestionnaire' ? 'selected' : ''); ?>>Manager</option>
                    <option value="admin" <?php echo (($_POST['fonction'] ?? '') === 'admin' ? 'selected' : ''); ?>>Admin</option>
                </select>
                <span class="form-help">Determines user permissions</span>
            </td>
        </tr>
    </table>
    
    <div class="form-buttons">
        <button type="button" class="btn btn-secondary" id="cancel-btn">Cancel</button>
        <button type="submit" class="btn btn-primary">Create User</button>
    </div>
    </form>
        </section>
    </main>

    <script>
        // Fonction pour vider le formulaire
        document.getElementById('cancel-btn').addEventListener('click', function() {
            document.getElementById('add-user-form').reset();
        });
    </script>
</body>
</html>