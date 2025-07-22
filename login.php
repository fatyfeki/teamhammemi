<?php 
session_start();

// Si l'utilisateur est déjà connecté
if (isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

// Traitement du formulaire
if (isset($_POST['submit'])) {
    require_once "db.php";

    $email = $_POST['email'];
    $password = $_POST['password'];

    try {
        // Modification 1: Utiliser le bon nom de table (utilisateur au lieu de users)
        $stmt = $pdo->prepare("SELECT * FROM utilisateur WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        if ($user) {
            // Modification 2: Vérifier le mot de passe haché
            if (password_verify($password, $user['mot_de_passe'])) {
                // Modification 3: Utiliser les bons noms de champs
                $_SESSION['user_id'] = $user['id_utilisateur'];
                $_SESSION['nom'] = $user['nom'];
                $_SESSION['prenom'] = $user['prenom'];
                $_SESSION['email'] = $user['email'];
                $_SESSION['fonction'] = $user['fonction'];
                header("Location: index.php");
                exit();
            } else {
                $error = "Email ou mot de passe incorrect";
            }
        } else {
            $error = "Email ou mot de passe incorrect";
        }
    } catch (PDOException $e) {
        $error = "Erreur de connexion : " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            background-color: #f5f5f5;
        }

        .login-section {
            background-color: white;
            padding: 60px 0;
            margin: 40px 0;
        }

        .container {
            display: flex;
            justify-content: center;
            padding: 0 20px;
        }

        .form-container {
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 0 0 4px rgba(231, 25, 25, 0.2), 0 10px 30px rgba(0, 0, 0, 0.1);
            padding: 40px 30px;
            max-width: 420px;
            width: 100%;
            text-align: center;
            animation: fadeIn 0.6s ease;
            border: 2px solid rgba(231, 25, 25, 0.3);
            position: relative;
            overflow: hidden;
        }

        .form-container::before {
            content: '';
            position: absolute;
            top: -10px;
            left: -10px;
            right: -10px;
            bottom: -10px;
            border: 2px solid rgba(231, 25, 25, 0.1);
            border-radius: 20px;
            z-index: -1;
            animation: pulse 2s infinite;
        }

        .form-logo img {
            width: 60px;
            height: 60px;
        }

        h1 {
            margin-top: 20px;
            font-size: 26px;
            color: #333;
        }

        .form-subtitle {
            margin: 8px 0 20px;
            color: rgb(235, 29, 29);
            font-size: 14px;
        }

        .form-group {
            margin-bottom: 20px;
            text-align: left;
        }

        .form-group label {
            display: block;
            margin-bottom: 6px;
            font-size: 14px;
            color: #333;
        }

        .form-group input {
            width: 100%;
            padding: 12px 14px;
            border-radius: 8px;
            border: 1px solid #ccc;
            font-size: 15px;
            background-color: #f9f9f9;
            transition: border 0.3s;
        }

        .form-group input:focus {
            border-color: rgb(231, 25, 25);
            outline: none;
            box-shadow: 0 0 0 2px rgba(231, 25, 25, 0.1);
        }

        .btn-login {
            width: 100%;
            padding: 14px;
            background-color: rgb(231, 25, 25);
            color: #fff;
            font-weight: bold;
            border-radius: 8px;
            border: none;
            cursor: pointer;
            transition: 0.3s;
        }

        .btn-login:hover {
            background-color: rgb(200, 20, 20);
            transform: translateY(-2px);
        }

        .error {
            color: #e63946;
            background-color: rgba(230, 57, 70, 0.1);
            padding: 12px;
            border-radius: 6px;
            margin-bottom: 15px;
            font-size: 14px;
        }

        .links {
            margin-top: 20px;
            font-size: 14px;
            color: #666;
        }

        .links a {
            color: rgb(231, 25, 25);
            text-decoration: none;
            font-weight: 500;
        }

        .links a:hover {
            text-decoration: underline;
        }

        .admin-link a,
        .home-link a {
            color: rgb(100, 94, 94);
            font-weight: bold;
        }

        .admin-link, .home-link {
            margin-top: 15px;
            font-size: 14px;
        }
        .admin-link a:hover,
        .home-link a:hover {
            color: rgb(231, 25, 25); /* Changement de couleur au survol */
            text-decoration: underline; /* Optionnel: soulignement au survol */
        }
        @keyframes fadeIn {
            from {opacity: 0; transform: translateY(20px);}
            to {opacity: 1; transform: translateY(0);}
        }

        @keyframes pulse {
            0% {border-color: rgba(231, 25, 25, 0.1);}
            50% {border-color: rgba(231, 25, 25, 0.3);}
            100% {border-color: rgba(231, 25, 25, 0.1);}
        }
    </style>
</head>
<body>

<?php include("header.php"); ?>

<section class="login-section">
    <div class="container">
        <div class="form-container">
            <div class="form-logo">
                <img src="images/log.png" alt="C2H Logo">
            </div>

            <h1>Connexion</h1>
            <p class="form-subtitle">Log in to your account</p>

            <?php if (!empty($error)): ?>
                <div class="error"><?= $error ?></div>
            <?php endif; ?>

            <form method="post">
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email" required placeholder="email@domain.com">
                </div>
                <div class="form-group">
                    <label>Password</label>
                    <input type="password" name="password" required placeholder="••••••••">
                </div>
                <button type="submit" name="submit" class="btn-login">Log in</button>
            </form>

            <div class="links">
                Don't have an account? <a href="signup.php">Create an account</a>
            </div>
            <div class="admin-link">
                <a href="admin_login.php">Admin Access</a>
            </div>
            <div class="home-link">
                <a href="index.php">Back to home</a>
            </div>
        </div>
    </div>
</section>

<?php include("footer.php"); ?>

</body>
</html>