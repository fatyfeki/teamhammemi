<?php 
session_start(); // Démarrage de la session pour le panier

// Database connection
$host = 'localhost';
$dbname = 'ch office track';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

// Gestion du panier
if (isset($_POST['add_to_cart'])) {
    $product_id = $_POST['product_id'];
    $product_name = $_POST['product_name'];
    $category = $_POST['category'];
    
    // Initialiser le panier si inexistant
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }
    
    // Vérifier si le produit est déjà dans le panier
    $found = false;
    foreach ($_SESSION['cart'] as &$item) {
        if ($item['product_id'] == $product_id) {
            $item['quantity'] += 1;
            $found = true;
            break;
        }
    }
    
    // Si non trouvé, ajouter au panier
    if (!$found) {
        $_SESSION['cart'][] = [
            'product_id' => $product_id,
            'product_name' => $product_name,
            'category' => $category,
            'quantity' => 1
        ];
    }
    
    // Message de succès
    $_SESSION['success'] = "Produit ajouté au panier!";
    header("Location: ".$_SERVER['PHP_SELF']);
    exit();
}

// Fetch products with categories
$sql = "SELECT a.*, c.nom_categorie, c.icon 
        FROM article a 
        LEFT JOIN categories c ON a.id_categorie = c.id_categorie 
        ORDER BY a.date_importation DESC";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Group products by category
$productsByCategory = [];
foreach ($products as $product) {
    $category = $product['nom_categorie'] ?? 'Uncategorized';
    $productsByCategory[$category][] = $product;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CH Office Track - Products Catalog</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root {
            --primary-red: #dc2626;
            --primary-red-dark: #991b1b;
            --primary-red-light: #fca5a5;
            --secondary-gold: #f59e0b;
            --accent-blue: #3b82f6;
            --success-green: #10b981;
            --warning-orange: #f97316;
            --danger-red: #ef4444;
            
            --neutral-black: #0f172a;
            --neutral-gray-900: #1e293b;
            --neutral-gray-800: #334155;
            --neutral-gray-700: #475569;
            --neutral-gray-600: #64748b;
            --neutral-gray-500: #94a3b8;
            --neutral-gray-400: #cbd5e1;
            --neutral-gray-300: #e2e8f0;
            --neutral-gray-200: #f1f5f9;
            --neutral-gray-100: #f8fafc;
            --neutral-white: #ffffff;
            
            --shadow-sm: 0 1px 2px 0 rgb(0 0 0 / 0.05);
            --shadow-md: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);
            --shadow-lg: 0 10px 15px -3px rgb(0 0 0 / 0.1), 0 4px 6px -4px rgb(0 0 0 / 0.1);
            --shadow-xl: 0 20px 25px -5px rgb(0 0 0 / 0.1), 0 8px 10px -6px rgb(0 0 0 / 0.1);
            --shadow-2xl: 0 25px 50px -12px rgb(0 0 0 / 0.25);
            
            --radius-sm: 0.375rem;
            --radius-md: 0.5rem;
            --radius-lg: 0.75rem;
            --radius-xl: 1rem;
            --radius-2xl: 1.5rem;
            
            --transition-all: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            --transition-transform: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: linear-gradient(135deg, var(--neutral-black) 0%, var(--neutral-gray-900) 100%);
            color: var(--neutral-white);
            line-height: 1.6;
            overflow-x: hidden;
            scroll-behavior: smooth;
        }
        
        /* Enhanced animated background */
        .particles {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: 1;
            overflow: hidden;
        }
        
        .particle {
            position: absolute;
            border-radius: 50%;
            animation: float 8s ease-in-out infinite;
        }
        
        .particle:nth-child(odd) {
            width: 4px;
            height: 4px;
            background: radial-gradient(circle, var(--primary-red) 0%, transparent 70%);
            animation-duration: 6s;
        }
        
        .particle:nth-child(even) {
            width: 2px;
            height: 2px;
            background: radial-gradient(circle, var(--secondary-gold) 0%, transparent 70%);
            animation-duration: 10s;
        }
        
        @keyframes float {
            0%, 100% { 
                transform: translateY(0px) translateX(0px) rotate(0deg);
                opacity: 0.3;
            }
            25% { 
                transform: translateY(-30px) translateX(20px) rotate(90deg);
                opacity: 0.6;
            }
            50% { 
                transform: translateY(-60px) translateX(-10px) rotate(180deg);
                opacity: 0.8;
            }
            75% { 
                transform: translateY(-30px) translateX(-20px) rotate(270deg);
                opacity: 0.6;
            }
        }
        
        /* Hero section with glassmorphism */
        .hero {
            background: linear-gradient(135deg, 
                var(--primary-red) 0%, 
                var(--primary-red-dark) 25%, 
                var(--neutral-black) 75%, 
                var(--neutral-gray-900) 100%);
            padding: 100px 20px 80px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }
        
        .hero::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: radial-gradient(circle at 30% 20%, rgba(255, 255, 255, 0.1) 0%, transparent 50%),
                        radial-gradient(circle at 70% 80%, rgba(245, 158, 11, 0.1) 0%, transparent 50%);
            animation: pulse 4s ease-in-out infinite alternate;
        }
        
        @keyframes pulse {
            0% { opacity: 0.3; }
            100% { opacity: 0.7; }
        }
        
        .hero-content {
            position: relative;
            z-index: 2;
            max-width: 1200px;
            margin: 0 auto;
        }
        
        .hero h1 {
            font-size: clamp(2.5rem, 5vw, 4rem);
            font-weight: 800;
            margin-bottom: 24px;
            background: linear-gradient(135deg, var(--neutral-white) 0%, var(--secondary-gold) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            text-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
            animation: slideInUp 1s ease-out;
        }
        
        .hero p {
            font-size: 1.25rem;
            opacity: 0.9;
            max-width: 800px;
            margin: 0 auto;
            animation: slideInUp 1s ease-out 0.2s both;
        }
        
        @keyframes slideInUp {
            from {
                transform: translateY(30px);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }
        
        /* Main content with improved spacing */
        .main-content {
            background: linear-gradient(to bottom, var(--neutral-white), var(--neutral-gray-100));
            padding: 80px 0;
            position: relative;
            z-index: 2;
        }
        
        .container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 20px;
        }
        
        /* Enhanced search and filter section */
        .search-filter {
            background: var(--neutral-white);
            backdrop-filter: blur(10px);
            border: 1px solid var(--neutral-gray-200);
            padding: 30px;
            border-radius: var(--radius-2xl);
            margin-bottom: 40px;
            box-shadow: var(--shadow-xl);
            position: sticky;
            top: 0;
            z-index: 10;
        }
        
        .search-filter h3 {
            color: var(--primary-red);
            margin-bottom: 20px;
            font-size: 1.5rem;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 12px;
        }
        
        .filter-row {
            display: grid;
            grid-template-columns: 2fr 1fr 1fr;
            gap: 20px;
        }
        
        .filter-group {
            position: relative;
        }
        
        .filter-group label {
            display: block;
            color: var(--neutral-gray-700);
            margin-bottom: 8px;
            font-weight: 600;
            font-size: 0.875rem;
            text-transform: uppercase;
            letter-spacing: 0.025em;
        }
        
        .filter-group input,
        .filter-group select {
            width: 100%;
            padding: 14px 18px;
            border: 2px solid var(--neutral-gray-300);
            border-radius: var(--radius-lg);
            font-size: 1rem;
            transition: var(--transition-all);
            background: var(--neutral-white);
            color: var(--neutral-gray-800);
        }
        
        .filter-group input:focus,
        .filter-group select:focus {
            outline: none;
            border-color: var(--primary-red);
            box-shadow: 0 0 0 3px rgba(220, 38, 38, 0.1);
            transform: translateY(-2px);
        }
        
        .filter-group input::placeholder {
            color: var(--neutral-gray-500);
        }
        
        /* Category tabs */
        .category-tabs {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-bottom: 30px;
            position: sticky;
            top: 120px;
            background: var(--neutral-white);
            padding: 15px 0;
            z-index: 9;
        }
        
        .category-tab {
            padding: 10px 20px;
            border-radius: 50px;
            background: var(--neutral-gray-100);
            color: var(--neutral-gray-700);
            font-weight: 600;
            cursor: pointer;
            transition: var(--transition-all);
            border: 1px solid var(--neutral-gray-200);
            font-size: 0.9rem;
        }
        
        .category-tab:hover, 
        .category-tab.active {
            background: var(--primary-red);
            color: white;
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
        }
        
        /* Category sections */
        .category-section {
            margin-bottom: 60px;
            animation: slideInUp 0.8s ease-out both;
        }
        
        .category-header {
            display: flex;
            align-items: center;
            margin-bottom: 30px;
            padding: 25px 30px;
            background: linear-gradient(135deg, var(--primary-red) 0%, var(--primary-red-dark) 100%);
            border-radius: var(--radius-2xl);
            box-shadow: var(--shadow-xl);
            position: relative;
            overflow: hidden;
            transition: var(--transition-transform);
        }
        
        .category-header:hover {
            transform: translateY(-4px);
            box-shadow: var(--shadow-2xl);
        }
        
        .category-icon {
            font-size: 2.5rem;
            margin-right: 20px;
            color: var(--secondary-gold);
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
            animation: bounce 2s infinite;
        }
        
        .category-title {
            font-size: 2rem;
            font-weight: 800;
            color: var(--neutral-white);
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
            position: relative;
            z-index: 1;
        }
        
        /* Enhanced product grid */
        .products-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
            gap: 30px;
        }
        
        /* Improved product card design */
        .product-card {
            background: var(--neutral-white);
            border-radius: var(--radius-xl);
            overflow: hidden;
            box-shadow: var(--shadow-lg);
            transition: var(--transition-all);
            color: var(--neutral-gray-800);
            position: relative;
            cursor: pointer;
            border: 1px solid var(--neutral-gray-200);
            display: flex;
            flex-direction: column;
            height: 100%;
        }
        
        .product-card:hover {
            transform: translateY(-8px);
            box-shadow: var(--shadow-2xl);
        }
        
        .product-image-container {
            position: relative;
            overflow: hidden;
            height: 220px;
            background: linear-gradient(135deg, var(--neutral-gray-100) 0%, var(--neutral-gray-200) 100%);
        }
        
        .product-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: var(--transition-transform);
        }
        
        .product-card:hover .product-image {
            transform: scale(1.05);
        }
        
        .product-content {
            padding: 24px;
            flex-grow: 1;
            display: flex;
            flex-direction: column;
        }
        
        .product-badge {
            position: absolute;
            top: 15px;
            right: 15px;
            padding: 6px 12px;
            border-radius: 50px;
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.025em;
            z-index: 3;
            color: white;
        }
        
        .product-badge.in-stock {
            background: var(--success-green);
        }
        
        .product-badge.low-stock {
            background: var(--warning-orange);
        }
        
        .product-badge.out-of-stock {
            background: var(--danger-red);
        }
        
        .product-title {
            color: var(--neutral-gray-900);
            font-size: 1.25rem;
            font-weight: 700;
            margin-bottom: 8px;
            line-height: 1.3;
        }
        
        .product-brand {
            color: var(--secondary-gold);
            font-size: 0.75rem;
            font-weight: 600;
            margin-bottom: 12px;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }
        
        .product-description {
            color: var(--neutral-gray-600);
            margin-bottom: 15px;
            line-height: 1.5;
            font-size: 0.875rem;
            flex-grow: 1;
        }
        
        .product-details {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
            padding: 15px;
            background: var(--neutral-gray-100);
            border-radius: var(--radius-md);
            border: 1px solid var(--neutral-gray-200);
        }
        
        .product-price {
            font-size: 1.5rem;
            font-weight: 800;
            color: var(--primary-red);
            display: flex;
            align-items: center;
            gap: 4px;
        }
        
        .product-stock {
            display: flex;
            align-items: center;
            gap: 6px;
            color: var(--neutral-gray-600);
            font-weight: 500;
            font-size: 0.875rem;
        }
        
        .product-supplier {
            color: var(--neutral-gray-500);
            font-size: 0.75rem;
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            gap: 6px;
        }
        
        .product-actions {
            display: flex;
            gap: 10px;
            margin-top: auto;
        }
        
        .btn {
            padding: 12px 20px;
            border: none;
            border-radius: var(--radius-lg);
            font-weight: 600;
            font-size: 0.875rem;
            cursor: pointer;
            transition: var(--transition-all);
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            text-transform: uppercase;
            letter-spacing: 0.025em;
            position: relative;
            overflow: hidden;
        }
        
        .btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: var(--transition-all);
        }
        
        .btn:hover::before {
            left: 100%;
        }
        
        .btn-primary {
            background: linear-gradient(135deg, var(--primary-red) 0%, var(--primary-red-dark) 100%);
            color: var(--neutral-white);
            flex: 1;
            box-shadow: var(--shadow-md);
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-lg);
        }
        
        .btn-primary:disabled {
            opacity: 0.6;
            cursor: not-allowed;
            transform: none;
            background: var(--neutral-gray-400);
        }
        
        .btn-secondary {
            background: var(--neutral-white);
            color: var(--neutral-gray-700);
            border: 2px solid var(--neutral-gray-300);
            box-shadow: var(--shadow-sm);
        }
        
        .btn-secondary:hover {
            background: var(--neutral-gray-100);
            border-color: var(--primary-red);
            color: var(--primary-red);
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
        }
        
        .no-products {
            text-align: center;
            padding: 100px 20px;
            color: var(--neutral-gray-500);
            font-size: 1.25rem;
        }
        
        .no-products i {
            font-size: 5rem;
            margin-bottom: 24px;
            color: var(--neutral-gray-400);
            animation: bounce 2s infinite;
        }
        
        .highlight {
            background-color: #fef3c7;
            color: #92400e;
            padding: 2px 4px;
            border-radius: 3px;
        }
        
        /* Loading animation */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .fade-in {
            animation: fadeIn 0.6s ease-out;
        }
        
        /* Scroll reveal animations */
        .reveal {
            opacity: 0;
            transform: translateY(30px);
            transition: all 0.8s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }
        
        .reveal.active {
            opacity: 1;
            transform: translateY(0);
        }
        
        /* Responsive design */
        @media (max-width: 1024px) {
            .filter-row {
                grid-template-columns: 1fr 1fr;
            }
            
            .products-grid {
                grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
                gap: 25px;
            }
            
            .category-header {
                padding: 20px 25px;
            }
            
            .category-icon {
                font-size: 2rem;
                margin-right: 15px;
            }
            
            .category-title {
                font-size: 1.75rem;
            }
        }
        
        @media (max-width: 768px) {
            .hero {
                padding: 80px 20px 60px;
            }
            
            .hero h1 {
                font-size: 2.5rem;
            }
            
            .hero p {
                font-size: 1.125rem;
            }
            
            .search-filter {
                padding: 25px 20px;
            }
            
            .filter-row {
                grid-template-columns: 1fr;
                gap: 15px;
            }
            
            .category-tabs {
                top: 110px;
            }
            
            .category-header {
                flex-direction: column;
                text-align: center;
                padding: 25px 20px;
            }
            
            .category-icon {
                margin-right: 0;
                margin-bottom: 15px;
            }
            
            .products-grid {
                grid-template-columns: 1fr;
                gap: 20px;
            }
            
            .product-content {
                padding: 20px;
            }
            
            .product-details {
                flex-direction: column;
                gap: 10px;
                text-align: center;
            }
            
            .product-actions {
                flex-direction: column;
            }
        }
        
        @media (max-width: 480px) {
            .container {
                padding: 0 15px;
            }
            
            .hero {
                padding: 60px 15px 40px;
            }
            
            .main-content {
                padding: 60px 0;
            }
            
            .search-filter {
                padding: 20px 15px;
            }
            
            .category-header {
                padding: 20px 15px;
            }
            
            .product-content {
                padding: 18px;
            }
            
            .btn {
                padding: 10px 15px;
                font-size: 0.8rem;
            }
              /* Nouveaux styles pour le panier */
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
    <!-- Animated background particles -->
    <div class="particles">
        <?php for($i = 0; $i < 80; $i++): ?>
            <div class="particle" style="
                left: <?php echo rand(0, 100); ?>%;
                top: <?php echo rand(0, 100); ?>%;
                animation-delay: <?php echo rand(0, 10); ?>s;
            "></div>
        <?php endfor; ?>
    </div>

    <div class="hero">
        <div class="hero-content">
            <h1><i class="fas fa-boxes"></i> Product Catalog</h1>
            <p>Discover our comprehensive collection of premium office supplies, cutting-edge equipment, and essential workplace solutions.</p>
        </div>
    </div>
    
    <div class="main-content">
        <div class="container">
            <!-- Enhanced Search and Filter Section -->
            <div class="search-filter">
                <h3><i class="fas fa-filter"></i> Filter Products</h3>
                <div class="filter-row">
                    <div class="filter-group">
                        <label for="search"><i class="fas fa-search"></i> Search</label>
                        <input type="text" id="search" placeholder="Product name, brand or description...">
                    </div>
                    <div class="filter-group">
                        <label for="category-filter"><i class="fas fa-tag"></i> Category</label>
                        <select id="category-filter">
                            <option value="">All Categories</option>
                            <?php foreach($productsByCategory as $category => $products): ?>
                                <option value="<?php echo htmlspecialchars($category); ?>">
                                    <?php echo htmlspecialchars($category); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="filter-group">
                        <label for="stock-filter"><i class="fas fa-cubes"></i> Stock</label>
                        <select id="stock-filter">
                            <option value="">All</option>
                            <option value="in-stock">In Stock</option>
                            <option value="low-stock">Low Stock</option>
                            <option value="out-of-stock">Out of Stock</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Category tabs for quick navigation -->
            <div class="category-tabs">
                <div class="category-tab active" data-category="all">All Products</div>
                <?php foreach($productsByCategory as $category => $products): ?>
                    <div class="category-tab" data-category="<?php echo htmlspecialchars($category); ?>">
                        <?php echo htmlspecialchars($category); ?>
                    </div>
                <?php endforeach; ?>
            </div>
              <div class="product-card reveal" 
         data-name="<?php echo htmlspecialchars(strtolower($product['nom'])); ?>"
         data-brand="<?php echo htmlspecialchars(strtolower($product['marque'] ?? '')); ?>"
         data-category="<?php echo htmlspecialchars($category); ?>"
         data-stock="<?php echo $stockStatus; ?>">
        
        <div class="product-image-container">
            <div class="product-badge <?php echo $stockStatus; ?>">
                <?php echo $stockText; ?>
            </div>
            
            <img src="uploads/<?php echo htmlspecialchars($product['image']); ?>" 
                 alt="<?php echo htmlspecialchars($product['nom']); ?>" 
                 class="product-image"
                 onerror="this.src='https://via.placeholder.com/400x250/f1f5f9/64748b?text=No+Image+Available'">
        </div>
        
        <div class="product-content">
            <h3 class="product-title"><?php echo htmlspecialchars($product['nom']); ?></h3>
            
            <?php if(!empty($product['marque'])): ?>
                <div class="product-brand"><?php echo htmlspecialchars($product['marque']); ?></div>
            <?php endif; ?>
            
            <?php if(!empty($product['description'])): ?>
                <p class="product-description"><?php echo htmlspecialchars($product['description']); ?></p>
            <?php endif; ?>
            
            <div class="product-details">
                <div class="product-stock">
                    <i class="fas fa-cube"></i>
                    <span><?php echo $product['current_stock']; ?> <?php echo $product['unit']; ?></span>
                </div>
            </div>
            
            <div class="product-supplier">
                <i class="fas fa-truck"></i>
                <span><?php echo htmlspecialchars($product['fournisseur']); ?></span>
            </div>
            
            <div class="product-actions">
                <form method="post" style="width: 100%;">
                    <input type="hidden" name="product_id" value="<?php echo $product['id_article']; ?>">
                    <input type="hidden" name="product_name" value="<?php echo htmlspecialchars($product['nom']); ?>">
                    <input type="hidden" name="category" value="<?php echo htmlspecialchars($category); ?>">
                    <button type="submit" name="add_to_cart" class="btn btn-primary <?php echo $product['current_stock'] == 0 ? 'disabled' : ''; ?>">
                        <i class="fas fa-cart-plus"></i> Ajouter au panier
                    </button>
                </form>
            </div>
        </div>
    </div>

            <?php if(empty($products)): ?>
                <div class="no-products">
                    <i class="fas fa-box-open"></i>
                    <p>No products available at the moment.</p>
                </div>
            <?php else: ?>
                <?php foreach($productsByCategory as $category => $categoryProducts): ?>
                    <div class="category-section reveal" id="category-<?php echo urlencode($category); ?>" data-category="<?php echo htmlspecialchars($category); ?>">
                        <div class="category-header">
                            <i class="<?php echo !empty($categoryProducts[0]['icon']) ? $categoryProducts[0]['icon'] : 'fas fa-box'; ?> category-icon"></i>
                            <h2 class="category-title"><?php echo htmlspecialchars($category); ?></h2>
                        </div>
                        
                        <div class="products-grid">
                            <?php foreach($categoryProducts as $product): ?>
                                <?php
                                $stockStatus = 'in-stock';
                                $stockText = 'In Stock';
                                if ($product['current_stock'] == 0) {
                                    $stockStatus = 'out-of-stock';
                                    $stockText = 'Out of Stock';
                                } elseif ($product['current_stock'] <= $product['seuil_min']) {
                                    $stockStatus = 'low-stock';
                                    $stockText = 'Low Stock';
                                }
                                ?>
                                
                                <div class="product-card reveal" 
                                     data-name="<?php echo htmlspecialchars(strtolower($product['nom'])); ?>"
                                     data-brand="<?php echo htmlspecialchars(strtolower($product['marque'] ?? '')); ?>"
                                     data-category="<?php echo htmlspecialchars($category); ?>"
                                     data-stock="<?php echo $stockStatus; ?>">
                                    
                                    <div class="product-image-container">
                                        <div class="product-badge <?php echo $stockStatus; ?>">
                                            <?php echo $stockText; ?>
                                        </div>
                                        
                                        <img src="uploads/<?php echo htmlspecialchars($product['image']); ?>" 
                                             alt="<?php echo htmlspecialchars($product['nom']); ?>" 
                                             class="product-image"
                                             onerror="this.src='https://via.placeholder.com/400x250/f1f5f9/64748b?text=No+Image+Available'">
                                    </div>
                                    
                                    <div class="product-content">
                                        <h3 class="product-title"><?php echo htmlspecialchars($product['nom']); ?></h3>
                                        
                                        <?php if(!empty($product['marque'])): ?>
                                            <div class="product-brand"><?php echo htmlspecialchars($product['marque']); ?></div>
                                        <?php endif; ?>
                                        
                                        <?php if(!empty($product['description'])): ?>
                                            <p class="product-description"><?php echo htmlspecialchars($product['description']); ?></p>
                                        <?php endif; ?>
                                        
                                        <div class="product-details">
                                            <div class="product-price">
                                                <i class="fas fa-dollar-sign"></i>
                                                <?php echo number_format($product['prix_unitaire'], 2); ?>
                                            </div>
                                            <div class="product-stock">
                                                <i class="fas fa-cube"></i>
                                                <span><?php echo $product['current_stock']; ?> <?php echo $product['unit']; ?></span>
                                            </div>
                                        </div>
                                        
                                        <div class="product-supplier">
                                            <i class="fas fa-truck"></i>
                                            <span><?php echo htmlspecialchars($product['fournisseur']); ?></span>
                                        </div>
                                        
                                        <div class="product-actions">
                                            <button class="btn btn-primary" <?php echo $product['current_stock'] == 0 ? 'disabled' : ''; ?>>
                                                <i class="fas fa-cart-plus"></i> Add to Cart
                                            </button>
                                            <button class="btn btn-secondary">
                                                <i class="fas fa-info-circle"></i> Details
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // DOM Elements
            const searchInput = document.getElementById('search');
            const categoryFilter = document.getElementById('category-filter');
            const stockFilter = document.getElementById('stock-filter');
            const categoryTabs = document.querySelectorAll('.category-tab');
            
            // Filter products function
            function filterProducts() {
                const searchTerm = searchInput.value.toLowerCase();
                const categoryValue = categoryFilter.value;
                const stockValue = stockFilter.value;
                
                // Filter product cards
                document.querySelectorAll('.product-card').forEach(card => {
                    const name = card.dataset.name || '';
                    const brand = card.dataset.brand || '';
                    const category = card.dataset.category || '';
                    const stock = card.dataset.stock || '';
                    
                    const matchesSearch = searchTerm === '' || 
                                         name.includes(searchTerm) || 
                                         brand.includes(searchTerm);
                    
                    const matchesCategory = categoryValue === '' || category === categoryValue;
                    const matchesStock = stockValue === '' || stock === stockValue;
                    
                    if (matchesSearch && matchesCategory && matchesStock) {
                        card.style.display = 'block';
                        setTimeout(() => {
                            card.style.opacity = '1';
                            card.style.transform = 'translateY(0)';
                        }, 50);
                    } else {
                        card.style.opacity = '0';
                        card.style.transform = 'translateY(10px)';
                        setTimeout(() => {
                            card.style.display = 'none';
                        }, 200);
                    }
                });
                
                // Handle category sections visibility
                document.querySelectorAll('.category-section').forEach(section => {
                    const hasVisibleProducts = section.querySelector('.product-card[style*="display: block"]') !== null;
                    
                    if (hasVisibleProducts) {
                        section.style.display = 'block';
                        setTimeout(() => {
                            section.style.opacity = '1';
                        }, 50);
                    } else {
                        section.style.opacity = '0';
                        setTimeout(() => {
                            section.style.display = 'none';
                        }, 200);
                    }
                });
                
                // Update active tabs
                updateActiveTabs();
            }
            
            // Update active tabs based on filters
            function updateActiveTabs() {
                const activeCategory = categoryFilter.value;
                
                categoryTabs.forEach(tab => {
                    tab.classList.remove('active');
                    
                    if ((activeCategory === '' && tab.dataset.category === 'all') || 
                        tab.dataset.category === activeCategory) {
                        tab.classList.add('active');
                    }
                });
            }
            
            // Category tabs navigation
            categoryTabs.forEach(tab => {
                tab.addEventListener('click', function() {
                    const category = this.dataset.category;
                    
                    if (category === 'all') {
                        categoryFilter.value = '';
                    } else {
                        categoryFilter.value = category;
                    }
                    
                    filterProducts();
                    
                    // Scroll to category if not "all"
                    if (category !== 'all') {
                        const section = document.getElementById(`category-${encodeURIComponent(category)}`);
                        if (section) {
                            section.scrollIntoView({ behavior: 'smooth', block: 'start' });
                        }
                    }
                });
            });
            
            // Search input with debounce and highlighting
            searchInput.addEventListener('input', function() {
                clearTimeout(this.searchTimeout);
                this.searchTimeout = setTimeout(() => {
                    filterProducts();
                    
                    // Highlight search term in product titles
                    const term = this.value.toLowerCase();
                    if (term) {
                        document.querySelectorAll('.product-title').forEach(title => {
                            const text = title.textContent;
                            const highlighted = text.replace(
                                new RegExp(term, 'gi'),
                                match => `<span class="highlight">${match}</span>`
                            );
                            title.innerHTML = highlighted;
                        });
                    } else {
                        document.querySelectorAll('.product-title').forEach(title => {
                            title.innerHTML = title.textContent;
                        });
                    }
                }, 300);
            });
            
            // Filter change events
            categoryFilter.addEventListener('change', filterProducts);
            stockFilter.addEventListener('change', filterProducts);
            
            // Reset filters (if you add a reset button)
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') {
                    searchInput.value = '';
                    categoryFilter.value = '';
                    stockFilter.value = '';
                    filterProducts();
                }
            });
            
            // Intersection Observer for scroll animations
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('active');
                    }
                });
            }, { threshold: 0.1 });
            
            document.querySelectorAll('.reveal').forEach(el => observer.observe(el));
            
            // Handle image loading errors
            document.querySelectorAll('.product-image').forEach(img => {
                img.onerror = function() {
                    this.src = 'https://via.placeholder.com/400x250/f1f5f9/64748b?text=No+Image';
                    this.style.opacity = '0.7';
                };
            });
            
            // Stagger animations for product cards
            document.querySelectorAll('.product-card').forEach((card, index) => {
                card.style.transitionDelay = `${index * 0.05}s`;
            });
            
            // Initialize filtering
            filterProducts();
             <script>
        // Gestion du panier
        const cartIndicator = document.getElementById('cartIndicator');
        const cartPreview = document.getElementById('cartPreview');
        const closeCartPreview = document.getElementById('closeCartPreview');
        const clearCartBtn = document.getElementById('clearCart');
        const checkoutBtn = document.getElementById('checkout');
        
        // Ouvrir/fermer le panier
        cartIndicator.addEventListener('click', () => {
            cartPreview.classList.toggle('active');
        });
        
        closeCartPreview.addEventListener('click', () => {
            cartPreview.classList.remove('active');
        });
        
        // Vider le panier
        clearCartBtn?.addEventListener('click', () => {
            if (confirm('Voulez-vous vraiment vider votre panier?')) {
                fetch('clear_cart.php')
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            location.reload();
                        }
                    });
            }
        });
        
        // Passer commande
        checkoutBtn?.addEventListener('click', () => {
            window.location.href = 'formdemande.php';
        });
        
        // Gestion des quantités
        document.querySelectorAll('.increase-qty').forEach(btn => {
            btn.addEventListener('click', function() {
                const productId = this.dataset.id;
                updateCartItem(productId, 'increase');
            });
        });
        
        document.querySelectorAll('.decrease-qty').forEach(btn => {
            btn.addEventListener('click', function() {
                const productId = this.dataset.id;
                updateCartItem(productId, 'decrease');
            });
        });
        
        function updateCartItem(productId, action) {
            fetch('update_cart.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `product_id=${productId}&action=${action}`
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                }
            });
        }
        
        // Notification automatique
        const notification = document.getElementById('notification');
        if (notification) {
            setTimeout(() => {
                notification.classList.remove('show');
                setTimeout(() => notification.remove(), 300);
            }, 3000);
        }
        
        // Animation du bouton d'ajout au panier
        document.querySelectorAll('[name="add_to_cart"]').forEach(btn => {
            btn.addEventListener('click', function() {
                this.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Ajout...';
                this.classList.add('btn-pulse');
                
                setTimeout(() => {
                    this.innerHTML = '<i class="fas fa-check"></i> Ajouté!';
                    setTimeout(() => {
                        this.innerHTML = '<i class="fas fa-cart-plus"></i> Ajouter au panier';
                        this.classList.remove('btn-pulse');
                    }, 1000);
                }, 500);
            });
        });
    
<
        });
    </script>
    
    <?php include 'footer.php'; ?>
</body>
</html>