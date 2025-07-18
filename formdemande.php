<?php
session_start();
require_once 'db.php';

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Vérifier si le panier est vide
if (empty($_SESSION['cart'])) {
    $_SESSION['error'] = "Votre panier est vide";
    header("Location: index.php");
    exit();
}

// Traitement du formulaire lorsqu'il est soumis
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit_demande'])) {
    $urgent = htmlspecialchars($_POST['urgent']);
    $reason = htmlspecialchars($_POST['reason']);
    $comment = htmlspecialchars($_POST['comment']);
    
    try {
        // Enregistrer chaque produit du panier comme une demande
        foreach ($_SESSION['cart'] as $item) {
            $stmt = $pdo->prepare("INSERT INTO demandes (id_utilisateur, product_name, category, quantity, urgent, reason, comment) 
                                  VALUES (?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute([
                $_SESSION['user_id'],
                $item['product_name'],
                $item['category'],
                $item['quantity'],
                $urgent,
                $reason,
                $comment
            ]);
        }
        
        // Vider le panier après enregistrement
        unset($_SESSION['cart']);
        
        $_SESSION['success'] = "Votre demande a été enregistrée avec succès!";
        header("Location: demande_success.php");
        exit();
    } catch (PDOException $e) {
        $_SESSION['error'] = "Erreur lors de l'enregistrement de la demande: " . $e->getMessage();
        header("Location: formdemande.php");
        exit();
    }
}

// Récupérer les produits du panier pour affichage
$cart_items = $_SESSION['cart'];
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmation de Demande - CH Office Track</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Segoe+UI:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --red-dark: #8B0000;
            --red-medium: #B22222;
            --red-light: #CD5C5C;
            --black: #1A1A1A;
            --gray-dark: #333333;
            --gray-medium: #666666;
            --gray-light: #E0E0E0;
            --white: #FFFFFF;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, var(--black), var(--gray-dark));
            color: var(--white);
            line-height: 1.6;
            min-height: 100vh;
        }
        
        /* Navigation */
        .navbar {
            background: var(--black);
            padding: 1rem 0;
            border-bottom: 3px solid var(--red-medium);
            position: sticky;
            top: 0;
            z-index: 100;
        }
        
        .nav-content {
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 20px;
        }
        
        .logo {
            font-size: 1.8rem;
            font-weight: 700;
            color: var(--red-medium);
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .logo i {
            color: var(--red-light);
            animation: rotate 10s linear infinite;
        }
        
        @keyframes rotate {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }
        
        .nav-links {
            display: flex;
            gap: 2rem;
            align-items: center;
        }
        
        .nav-link {
            color: var(--white);
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
            padding: 0.8rem 1.5rem;
            border-radius: 5px;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .nav-link:hover {
            background: var(--red-dark);
            color: var(--white);
            transform: translateY(-2px);
        }
        
        /* Hero Section */
        .hero {
            background: linear-gradient(to right, var(--red-dark), var(--black));
            padding: 60px 20px;
            text-align: center;
            border-bottom: 3px solid var(--red-medium);
        }
        
        .hero h1 {
            font-size: 2.5rem;
            margin-bottom: 20px;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
        }
        
        .hero p {
            font-size: 1.2rem;
            max-width: 800px;
            margin: 0 auto;
            opacity: 0.9;
        }
        
        /* Container Principal */
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 40px 20px;
        }
        
        /* Statistiques */
        .stats-section {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 30px;
            margin-bottom: 40px;
        }
        
        .stat-card {
            background: var(--white);
            color: var(--black);
            padding: 30px;
            border-radius: 8px;
            text-align: center;
            box-shadow: 0 0 0 1px var(--white),
                        0 0 0 3px var(--red-dark),
                        0 5px 15px rgba(139, 0, 0, 0.3);
            transition: all 0.3s ease;
            position: relative;
        }
        
        .stat-card::before {
            content: '';
            position: absolute;
            top: -5px;
            left: -5px;
            right: -5px;
            bottom: -5px;
            border: 2px solid var(--red-dark);
            border-radius: 10px;
            opacity: 0.5;
            z-index: -1;
            filter: blur(4px);
            transition: all 0.3s ease;
        }
        
        .stat-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 0 0 1px var(--white),
                        0 0 0 3px var(--red-medium),
                        0 15px 30px rgba(139, 0, 0, 0.4);
        }
        
        .stat-card:hover::before {
            opacity: 0.8;
            filter: blur(6px);
        }
        
        .stat-number {
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--red-dark);
            margin-bottom: 0.5rem;
        }
        
        .stat-label {
            color: var(--gray-dark);
            font-size: 1rem;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.1em;
        }
        
        /* Section Produits */
        .products-section {
            background: var(--white);
            color: var(--black);
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0 0 0 1px var(--white),
                        0 0 0 3px var(--red-dark),
                        0 5px 15px rgba(139, 0, 0, 0.3);
            margin-bottom: 40px;
            position: relative;
        }
        
        .products-section::before {
            content: '';
            position: absolute;
            top: -5px;
            left: -5px;
            right: -5px;
            bottom: -5px;
            border: 2px solid var(--red-dark);
            border-radius: 10px;
            opacity: 0.5;
            z-index: -1;
            filter: blur(4px);
        }
        
        .section-title {
            font-size: 1.8rem;
            font-weight: 600;
            color: var(--red-dark);
            margin-bottom: 30px;
            display: flex;
            align-items: center;
            gap: 1rem;
            border-bottom: 2px solid var(--red-medium);
            padding-bottom: 15px;
        }
        
        .section-title i {
            color: var(--red-medium);
        }
        
        .cart-items-grid {
            display: grid;
            gap: 20px;
        }
        
        .cart-item {
            background: var(--gray-light);
            padding: 25px;
            border-radius: 8px;
            border-left: 4px solid var(--red-medium);
            transition: all 0.3s ease;
        }
        
        .cart-item:hover {
            background: #f5f5f5;
            transform: translateX(5px);
            box-shadow: 0 5px 15px rgba(139, 0, 0, 0.2);
        }
        
        .item-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 15px;
        }
        
        .item-name {
            font-size: 1.3rem;
            font-weight: 600;
            color: var(--red-dark);
            margin-bottom: 5px;
        }
        
        .item-category {
            color: var(--gray-dark);
            font-size: 0.9rem;
            background: var(--white);
            padding: 5px 15px;
            border-radius: 20px;
            display: inline-block;
            border: 1px solid var(--red-light);
        }
        
        .item-quantity {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--red-dark);
            background: var(--white);
            padding: 15px 25px;
            border-radius: 8px;
            border: 2px solid var(--red-medium);
            display: flex;
            align-items: center;
            gap: 10px;
            min-width: 120px;
            justify-content: center;
        }
        
        /* Formulaire */
        .form-section {
            background: var(--white);
            color: var(--black);
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0 0 0 1px var(--white),
                        0 0 0 3px var(--red-dark),
                        0 5px 15px rgba(139, 0, 0, 0.3);
            position: relative;
        }
        
        .form-section::before {
            content: '';
            position: absolute;
            top: -5px;
            left: -5px;
            right: -5px;
            bottom: -5px;
            border: 2px solid var(--red-dark);
            border-radius: 10px;
            opacity: 0.5;
            z-index: -1;
            filter: blur(4px);
        }
        
        .form-group {
            margin-bottom: 30px;
        }
        
        .form-label {
            display: block;
            margin-bottom: 15px;
            color: var(--red-dark);
            font-weight: 600;
            font-size: 1.1rem;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .form-label i {
            color: var(--red-medium);
        }
        
        .urgent-group {
            background: #fff5f5;
            border: 2px solid var(--red-light);
            border-radius: 8px;
            padding: 30px;
            margin-bottom: 30px;
            border-left: 4px solid var(--red-medium);
        }
        
        .urgent-group .form-label {
            color: var(--red-dark);
            font-size: 1.2rem;
            margin-bottom: 20px;
        }
        
        .radio-options {
            display: flex;
            gap: 20px;
        }
        
        .radio-option {
            display: flex;
            align-items: center;
            gap: 10px;
            cursor: pointer;
            padding: 15px 25px;
            border-radius: 8px;
            transition: all 0.3s ease;
            background: var(--white);
            border: 2px solid var(--gray-light);
            flex: 1;
            justify-content: center;
        }
        
        .radio-option:hover {
            background: #f5f5f5;
            border-color: var(--red-light);
        }
        
        .radio-option.checked {
            border-color: var(--red-medium);
            background: #fff5f5;
        }
        
        .radio-option input[type="radio"] {
            width: 20px;
            height: 20px;
            accent-color: var(--red-medium);
        }
        
        .radio-option label {
            cursor: pointer;
            font-weight: 500;
            color: var(--black);
        }
        
        .form-input {
            width: 100%;
            padding: 15px 20px;
            background: var(--white);
            border: 2px solid var(--gray-light);
            border-radius: 8px;
            font-size: 1rem;
            color: var(--black);
            transition: all 0.3s ease;
            font-family: inherit;
        }
        
        .form-input:focus {
            outline: none;
            border-color: var(--red-medium);
            box-shadow: 0 0 0 3px rgba(139, 0, 0, 0.1);
        }
        
        .form-input::placeholder {
            color: var(--gray-medium);
        }
        
        .form-textarea {
            min-height: 120px;
            resize: vertical;
        }
        
        /* Bouton de Soumission */
        .submit-container {
            text-align: center;
            margin-top: 40px;
        }
        
        .submit-btn {
            background: var(--red-dark);
            color: var(--white);
            padding: 18px 40px;
            border: none;
            border-radius: 8px;
            font-size: 1.2rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 15px;
            min-width: 250px;
            text-transform: uppercase;
            letter-spacing: 0.1em;
        }
        
        .submit-btn:hover {
            background: var(--red-medium);
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(139, 0, 0, 0.3);
        }
        
        .submit-btn:active {
            transform: translateY(-1px);
        }
        
        /* Loading Overlay */
        .loading-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.8);
            z-index: 10000;
            display: none;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            gap: 30px;
        }
        
        .loading-overlay.show {
            display: flex;
        }
        
        .loading-spinner {
            width: 80px;
            height: 80px;
            border: 4px solid rgba(139, 0, 0, 0.3);
            border-top: 4px solid var(--red-medium);
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }
        
        .loading-text {
            color: var(--white);
            font-size: 1.2rem;
            text-align: center;
        }
        
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        
        /* Responsive Design */
        @media (max-width: 768px) {
            .hero h1 {
                font-size: 2rem;
            }
            
            .stats-section {
                grid-template-columns: 1fr;
            }
            
            .radio-options {
                flex-direction: column;
                gap: 15px;
            }
            
            .nav-links {
                gap: 1rem;
            }
            
            .nav-link {
                padding: 0.6rem 1rem;
                font-size: 0.9rem;
            }
            
            .item-header {
                flex-direction: column;
                gap: 15px;
            }
            
            .submit-btn {
                width: 100%;
            }
            
            .container {
                padding: 20px 15px;
            }
            
            .products-section,
            .form-section {
                padding: 25px;
            }
            
            .stat-card::before,
            .products-section::before,
            .form-section::before {
                top: -3px;
                left: -3px;
                right: -3px;
                bottom: -3px;
                filter: blur(3px);
            }
        }
        
        /* Animations */
        .fade-in {
            animation: fadeIn 0.8s ease forwards;
        }
        
        @keyframes fadeIn {
            0% {
                opacity: 0;
                transform: translateY(30px);
            }
            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        /* Notification */
        .notification {
            position: fixed;
            top: 20px;
            right: 20px;
            background: var(--white);
            color: var(--black);
            padding: 15px 20px;
            border-radius: 8px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
            z-index: 10001;
            transform: translateX(100%);
            transition: transform 0.3s ease;
            display: flex;
            align-items: center;
            gap: 10px;
            max-width: 350px;
        }
        
        .notification.error {
            border-left: 4px solid var(--red-medium);
        }
        
        .notification.info {
            border-left: 4px solid var(--gray-dark);
        }
        
        .notification.show {
            transform: translateX(0);
        }
         .cart-indicator {
            position: fixed;
            top: 20px;
            right: 20px;
            background: var(--primary-red);
            color: white;
            padding: 10px 15px;
            border-radius: 50px;
            display: flex;
            align-items: center;
            gap: 8px;
            z-index: 100;
            box-shadow: var(--shadow-lg);
            cursor: pointer;
            transition: var(--transition-all);
        }

        .cart-indicator:hover {
            transform: scale(1.05);
            box-shadow: var(--shadow-xl);
        }

        .cart-count {
            background: var(--neutral-white);
            color: var(--primary-red);
            width: 24px;
            height: 24px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
        }

        .cart-preview {
            position: fixed;
            top: 70px;
            right: 20px;
            background: var(--neutral-white);
            color: var(--neutral-gray-900);
            border-radius: var(--radius-xl);
            padding: 20px;
            width: 350px;
            max-height: 70vh;
            overflow-y: auto;
            box-shadow: var(--shadow-2xl);
            z-index: 99;
            transform: translateY(20px);
            opacity: 0;
            visibility: hidden;
            transition: var(--transition-all);
        }

        .cart-preview.active {
            transform: translateY(0);
            opacity: 1;
            visibility: visible;
        }

        .cart-preview-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
            padding-bottom: 10px;
            border-bottom: 1px solid var(--neutral-gray-200);
        }

        .cart-preview-title {
            font-size: 1.2rem;
            font-weight: 700;
            color: var(--primary-red);
        }

        .cart-preview-close {
            background: none;
            border: none;
            color: var(--neutral-gray-500);
            cursor: pointer;
            font-size: 1.2rem;
        }

        .cart-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 0;
            border-bottom: 1px solid var(--neutral-gray-100);
        }

        .cart-item-name {
            font-weight: 600;
            flex: 1;
        }

        .cart-item-qty {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .cart-item-qty button {
            background: var(--neutral-gray-100);
            border: none;
            width: 25px;
            height: 25px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: var(--transition-all);
        }

        .cart-item-qty button:hover {
            background: var(--primary-red);
            color: white;
        }

        .cart-actions {
            margin-top: 15px;
            display: flex;
            gap: 10px;
        }

        .cart-btn {
            flex: 1;
            padding: 10px;
            border-radius: var(--radius-lg);
            border: none;
            font-weight: 600;
            cursor: pointer;
            transition: var(--transition-all);
        }

        .cart-btn-primary {
            background: var(--primary-red);
            color: white;
        }

        .cart-btn-primary:hover {
            background: var(--primary-red-dark);
            transform: translateY(-2px);
        }

        .cart-btn-secondary {
            background: var(--neutral-gray-100);
            color: var(--neutral-gray-700);
        }

        .cart-btn-secondary:hover {
            background: var(--neutral-gray-200);
            transform: translateY(-2px);
        }

        .cart-empty {
            text-align: center;
            padding: 20px;
            color: var(--neutral-gray-500);
        }

        /* Notification */
        .notification {
            position: fixed;
            top: 20px;
            left: 50%;
            transform: translateX(-50%) translateY(-100px);
            background: var(--success-green);
            color: white;
            padding: 15px 25px;
            border-radius: var(--radius-md);
            box-shadow: var(--shadow-xl);
            z-index: 1000;
            transition: var(--transition-all);
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .notification.show {
            transform: translateX(-50%) translateY(0);
        }

        .notification.error {
            background: var(--danger-red);
        }

        /* Animation pour les boutons */
        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.05); }
            100% { transform: scale(1); }
        }

        .btn-pulse {
            animation: pulse 1.5s infinite;
        }
    </style>
</head>
<body>
   <!-- Notification -->
    <?php if(isset($_SESSION['success'])): ?>
        <div class="notification show" id="notification">
            <i class="fas fa-check-circle"></i>
            <?php echo $_SESSION['success']; unset($_SESSION['success']); ?>
        </div>
    <?php endif; ?>

    <!-- Cart Indicator -->
    <div class="cart-indicator" id="cartIndicator">
        <i class="fas fa-shopping-cart"></i>
        <span class="cart-count"><?php echo isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0; ?></span>
    </div>

    <!-- Cart Preview -->
    <div class="cart-preview" id="cartPreview">
        <div class="cart-preview-header">
            <h3 class="cart-preview-title">Votre Panier</h3>
            <button class="cart-preview-close" id="closeCartPreview">&times;</button>
        </div>
        
        <div class="cart-preview-content">
            <?php if(empty($_SESSION['cart'])): ?>
                <div class="cart-empty">
                    <i class="fas fa-shopping-cart" style="font-size: 2rem; opacity: 0.5; margin-bottom: 10px;"></i>
                    <p>Votre panier est vide</p>
                </div>
            <?php else: ?>
                <?php foreach($_SESSION['cart'] as $item): ?>
                    <div class="cart-item">
                        <div class="cart-item-name"><?php echo htmlspecialchars($item['product_name']); ?></div>
                        <div class="cart-item-qty">
                            <button class="decrease-qty" data-id="<?php echo $item['product_id']; ?>">-</button>
                            <span><?php echo $item['quantity']; ?></span>
                            <button class="increase-qty" data-id="<?php echo $item['product_id']; ?>">+</button>
                        </div>
                    </div>
                <?php endforeach; ?>
                
                <div class="cart-actions">
                    <button class="cart-btn cart-btn-secondary" id="clearCart">Vider</button>
                    <button class="cart-btn cart-btn-primary" id="checkout">Commander</button>
                </div>
            <?php endif; ?>
        </div>
    </div>
    <!-- Loading Overlay -->
    <div class="loading-overlay" id="loadingOverlay">
        <div class="loading-spinner"></div>
        <div class="loading-text">
            <div>Traitement de votre commande...</div>
            <div style="font-size: 0.9rem; margin-top: 10px; opacity: 0.7;">Veuillez patienter</div>
        </div>
    </div>

    <nav class="navbar">
        <div class="nav-content">
            <a href="index.php" class="logo">
                <i class="fas fa-cube"></i>
                CH Office Track
            </a>
            <div class="nav-links">
                <a href="index.php" class="nav-link">
                    <i class="fas fa-home"></i>
                    Accueil
                </a>
                <a href="mes_demandes.php" class="nav-link">
                    <i class="fas fa-list-ul"></i>
                    Mes Demandes
                </a>
                <a href="logout.php" class="nav-link">
                    <i class="fas fa-sign-out-alt"></i>
                    Déconnexion
                </a>
            </div>
        </div>
    </nav>

    <div class="hero">
        <h1>Confirmation de Demande</h1>
        <p>Finalisez votre demande avec précision et efficacité</p>
    </div>

    <div class="container">
        <div class="stats-section fade-in">
            <div class="stat-card">
                <div class="stat-number"><?= count($cart_items) ?></div>
                <div class="stat-label">Articles Sélectionnés</div>
            </div>
            <div class="stat-card">
                <div class="stat-number"><?= array_sum(array_column($cart_items, 'quantity')) ?></div>
                <div class="stat-label">Quantité Totale</div>
            </div>
            <div class="stat-card">
                <div class="stat-number"><?= count(array_unique(array_column($cart_items, 'category'))) ?></div>
                <div class="stat-label">Catégories</div>
            </div>
        </div>

        <div class="products-section fade-in">
            <h2 class="section-title">
                <i class="fas fa-shopping-cart"></i>
                Produits Sélectionnés
            </h2>
            <div class="cart-items-grid">
                <?php foreach ($cart_items as $item): ?>
                    <div class="cart-item">
                        <div class="item-header">
                            <div>
                                <div class="item-name"><?= htmlspecialchars($item['product_name']) ?></div>
                                <div class="item-category">
                                    <i class="fas fa-tag"></i>
                                    <?= htmlspecialchars($item['category']) ?>
                                </div>
                            </div>
                            <div class="item-quantity">
                                <i class="fas fa-cubes"></i>
                                <?= $item['quantity'] ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <div class="form-section fade-in">
            <form action="formdemande.php" method="post" id="demandeForm">
                <div class="urgent-group">
                    <label class="form-label">
                        <i class="fas fa-exclamation-triangle"></i>
                        Niveau de Priorité
                    </label>
                    <div class="radio-options">
                        <div class="radio-option">
                            <input type="radio" name="urgent" value="yes" id="urgent-yes" required>
                            <label for="urgent-yes">Urgente</label>
                        </div>
                        <div class="radio-option">
                            <input type="radio" name="urgent" value="no" id="urgent-no">
                            <label for="urgent-no">Normale</label>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="reason" class="form-label">
                        <i class="fas fa-question-circle"></i>
                        Motif de la Demande
                    </label>
                    <input type="text" id="reason" name="reason" class="form-input" 
                           placeholder="Décrivez brièvement la raison de votre demande...">
                </div>

                <div class="form-group">
                    <label for="comment" class="form-label">
                        <i class="fas fa-comment-dots"></i>
                        Commentaires Supplémentaires
                    </label>
                    <textarea id="comment" name="comment" class="form-input form-textarea" 
                              placeholder="Ajoutez des détails, instructions spéciales ou toute information pertinente..."></textarea>
                </div>

                <div class="submit-container">
                    <button type="submit" name="submit_demande" class="submit-btn">
                        <i class="fas fa-paper-plane"></i>
                        Confirmer la Demande
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Gestion des radio buttons
        document.querySelectorAll('input[type="radio"]').forEach(radio => {
            radio.addEventListener('change', function() {
                document.querySelectorAll('.radio-option').forEach(option => {
                    option.classList.remove('checked');
                });
                this.closest('.radio-option').classList.add('checked');
            });
        });

        // Validation et soumission du formulaire
        document.getElementById('demandeForm').addEventListener('submit', function(e) {
            const urgent = document.querySelector('input[name="urgent"]:checked');
            
            if (!urgent) {
                e.preventDefault();
                showNotification('Veuillez sélectionner le niveau de priorité', 'error');
                return;
            }

            document.getElementById('loadingOverlay').classList.add('show');
            
            const submitBtn = document.querySelector('.submit-btn');
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Traitement...';
        });

        // Notification système
        function showNotification(message, type = 'info') {
            const notification = document.createElement('div');
            notification.className = `notification ${type}`;
            notification.innerHTML = `
                <i class="fas ${type === 'error' ? 'fa-exclamation-circle' : 'fa-info-circle'}"></i>
                <span>${message}</span>
            `;
            
            document.body.appendChild(notification);
            
            setTimeout(() => {
                notification.classList.add('show');
            }, 100);
            
            setTimeout(() => {
                notification.classList.remove('show');
                setTimeout(() => {
                    if (document.body.contains(notification)) {
                        document.body.removeChild(notification);
                    }
                }, 300);
            }, 4000);
        }

        // Animation d'entrée
        window.addEventListener('load', function() {
            document.querySelectorAll('.fade-in').forEach((element, index) => {
                setTimeout(() => {
                    element.style.opacity = '1';
                    element.style.transform = 'translateY(0)';
                }, index * 200);
            });
        });

        // Initialisation des animations
        document.querySelectorAll('.fade-in').forEach(element => {
            element.style.opacity = '0';
            element.style.transform = 'translateY(30px)';
            element.style.transition = 'all 0.6s ease';
        });
    </script>
</body>
</html>