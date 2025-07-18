<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stock Alerts - CH OfficeTrack</title>
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

        .main-content {
            margin-left: 280px;
            margin-top: 70px;
            padding: 30px;
            min-height: calc(100vh - 70px);
        }

        .page-header {
            background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
            border-radius: 20px;
            padding: 40px;
            color: white;
            margin-bottom: 30px;
            position: relative;
            overflow: hidden;
            box-shadow: 0 15px 35px rgba(220, 53, 69, 0.3);
        }

        .page-header::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
            animation: pulse 4s ease-in-out infinite;
        }

        @keyframes pulse {
            0%, 100% { transform: scale(0.8) rotate(0deg); opacity: 0.5; }
            50% { transform: scale(1.2) rotate(180deg); opacity: 0.8; }
        }

        .page-header-content {
            position: relative;
            z-index: 2;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .header-left {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .alert-icon-large {
            font-size: 48px;
            color: #fff;
            animation: blink 2s infinite;
        }

        @keyframes blink {
            0%, 50% { opacity: 1; }
            51%, 100% { opacity: 0.3; }
        }

        .page-title {
            font-size: 36px;
            font-weight: 800;
            margin-bottom: 8px;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
        }

        .page-subtitle {
            font-size: 18px;
            opacity: 0.9;
        }

        .alerts-summary {
            display: flex;
            gap: 20px;
            align-items: center;
        }

        .summary-item {
            background: rgba(255,255,255,0.2);
            padding: 15px 20px;
            border-radius: 15px;
            text-align: center;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255,255,255,0.3);
        }

        .summary-number {
            font-size: 24px;
            font-weight: 800;
            display: block;
        }

        .summary-label {
            font-size: 12px;
            opacity: 0.9;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .alert-categories {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 25px;
            margin-bottom: 30px;
        }

        .category-card {
            background: white;
            border-radius: 20px;
            padding: 30px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .category-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 40px rgba(0,0,0,0.15);
        }

        .category-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, var(--category-color, #dc3545), var(--category-color-light, #f8d7da));
        }

        .category-card.critical {
            --category-color: #dc3545;
            --category-color-light: #f8d7da;
        }

        .category-card.warning {
            --category-color: #ffc107;
            --category-color-light: #fff3cd;
        }

        .category-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .category-info {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .category-icon {
            font-size: 24px;
            color: var(--category-color);
        }

        .category-title {
            font-size: 20px;
            font-weight: 700;
            color: #333;
        }

        .category-count {
            background: linear-gradient(135deg, var(--category-color) 0%, var(--category-color-light) 100%);
            color: white;
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 14px;
            font-weight: bold;
            box-shadow: 0 3px 10px rgba(0,0,0,0.2);
        }

        .category-description {
            color: #666;
            margin-bottom: 20px;
            line-height: 1.5;
        }

        .quick-actions {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        .action-btn {
            background: linear-gradient(135deg, var(--category-color) 0%, var(--category-color-light) 100%);
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 25px;
            font-size: 12px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .action-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.3);
        }

        .alert-details {
            background: white;
            border-radius: 20px;
            padding: 30px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            margin-bottom: 30px;
        }

        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
        }

        .section-title {
            font-size: 24px;
            font-weight: 700;
            color: #333;
        }

        .filter-tabs {
            display: flex;
            gap: 10px;
            background: #f8f9fa;
            padding: 5px;
            border-radius: 15px;
        }

        .filter-tab {
            padding: 10px 20px;
            border: none;
            background: transparent;
            border-radius: 10px;
            cursor: pointer;
            font-weight: 600;
            color: #666;
            transition: all 0.3s ease;
        }

        .filter-tab.active {
            background: white;
            color: #dc3545;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .alert-items {
            display: grid;
            gap: 20px;
        }

        .alert-item {
            background: linear-gradient(135deg, #fff 0%, #f8f9fa 100%);
            border-radius: 15px;
            padding: 25px;
            border-left: 5px solid var(--alert-color, #dc3545);
            transition: all 0.3s ease;
            position: relative;
        }

        .alert-item:hover {
            transform: translateX(5px);
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
        }

        .alert-item.critical {
            --alert-color: #dc3545;
            background: linear-gradient(135deg, #fff5f5 0%, #fed7d7 100%);
        }

        .alert-item.warning {
            --alert-color: #ffc107;
            background: linear-gradient(135deg, #fffbf0 0%, #fef5e7 100%);
        }

        .alert-item-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 15px;
        }

        .alert-item-info {
            flex: 1;
        }

        .alert-item-title {
            font-size: 18px;
            font-weight: 700;
            color: #333;
            margin-bottom: 5px;
        }

        .alert-item-meta {
            display: flex;
            gap: 20px;
            color: #666;
            font-size: 14px;
            margin-bottom: 10px;
        }

        .alert-item-status {
            padding: 6px 12px;
            border-radius: 15px;
            font-size: 12px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .status-critical {
            background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
            color: white;
            animation: pulse-status 2s infinite;
        }

        .status-warning {
            background: linear-gradient(135deg, #ffc107 0%, #e0a800 100%);
            color: #333;
        }

        @keyframes pulse-status {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }

        .alert-item-description {
            color: #666;
            line-height: 1.6;
            margin-bottom: 20px;
        }

        .alert-item-actions {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        .action-btn-small {
            background: linear-gradient(135deg, var(--alert-color) 0%, var(--alert-color) 100%);
            color: white;
            border: none;
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .action-btn-small:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.2);
        }

        .modal {
            display: none;
            position: fixed;
            z-index: 9999; /* Increased z-index to ensure it's on top */
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto; /* Enable scrolling if needed */
            background: rgba(0,0,0,0.7);
            backdrop-filter: blur(8px);
        }

        .modal-content {
            background: white;
            margin: 5% auto; /* Adjusted margin */
            padding: 30px;
            border-radius: 20px;
            width: 90%;
            max-width: 600px;
            position: relative;
            animation: modalSlide 0.4s ease;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
            max-height: 90vh; /* Limit height */
            overflow-y: auto; /* Enable scrolling for content */
        }

        @keyframes modalSlide {
            from { transform: translateY(-50px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }

        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 2px solid #f8f9fa;
        }

        .modal-title {
            font-size: 24px;
            font-weight: 700;
            color: #333;
        }

        .close-btn {
            background: none;
            border: none;
            font-size: 28px;
            cursor: pointer;
            color: #666;
            padding: 0;
            width: 35px;
            height: 35px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            transition: all 0.3s ease;
        }

        .close-btn:hover {
            color: #333;
            background: #f8f9fa;
        }

        .form-group {
            margin-bottom: 25px;
        }

        .form-label {
            display: block;
            margin-bottom: 10px;
            font-weight: 600;
            color: #333;
            font-size: 14px;
        }

        .form-row {
            display: flex;
            gap: 15px;
            margin-bottom: 15px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-input {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid #e9ecef;
            border-radius: 10px;
            font-size: 14px;
            transition: all 0.3s ease;
            background: #f8f9fa;
        }

        .form-input:focus {
            border-color: #dc3545;
            outline: none;
            box-shadow: 0 0 0 4px rgba(220, 53, 69, 0.1);
            background: white;
        }

        .form-buttons {
            display: flex;
            gap: 15px;
            justify-content: flex-end;
            margin-top: 30px;
        }

        .btn-primary {
            background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
            color: white;
            padding: 15px 30px;
            border: none;
            border-radius: 12px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(220, 53, 69, 0.3);
        }

        .btn-secondary {
            background: linear-gradient(135deg, #6c757d 0%, #495057 100%);
            color: white;
            padding: 15px 30px;
            border: none;
            border-radius: 12px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(108, 117, 125, 0.3);
        }

        .btn-primary:hover, .btn-secondary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(0,0,0,0.4);
        }

        .notification {
            position: fixed;
            top: 20px;
            right: 20px;
            background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
            color: white;
            padding: 15px 20px;
            border-radius: 10px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.3);
            z-index: 3000;
            animation: slideInRight 0.5s ease;
        }

        @keyframes slideInRight {
            from { transform: translateX(100%); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }

        @media (max-width: 768px) {
            .main-content {
                margin-left: 0;
                padding: 20px;
            }
            
            .page-header-content {
                flex-direction: column;
                gap: 20px;
                text-align: center;
            }
            
            .alerts-summary {
                flex-direction: column;
                gap: 10px;
            }
            
            .alert-categories {
                grid-template-columns: 1fr;
            }
            
            .alert-item-header {
                flex-direction: column;
                gap: 15px;
            }
            
            .alert-item-meta {
                flex-direction: column;
                gap: 5px;
            }
        }
        
    /* Bulk Action Confirmation Modal */
    .bulk-confirm-modal {
        background: rgba(255,255,255,0.95);
        border-radius: 20px;
        padding: 30px;
        max-width: 500px;
        margin: 10% auto;
        box-shadow: 0 10px 40px rgba(0,0,0,0.2);
        border: 1px solid rgba(0,0,0,0.1);
        animation: fadeInUp 0.4s ease;
        position: relative;
        overflow: hidden;
    }
    
    .bulk-confirm-modal::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 6px;
        background: linear-gradient(90deg, #dc3545, #ffc107);
    }
    
    .bulk-confirm-header {
        display: flex;
        align-items: center;
        gap: 15px;
        margin-bottom: 20px;
    }
    
    .bulk-confirm-icon {
        font-size: 28px;
        color: #dc3545;
        background: rgba(220,53,69,0.1);
        width: 50px;
        height: 50px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .bulk-confirm-title {
        font-size: 22px;
        font-weight: 700;
        color: #333;
    }
    
    .bulk-confirm-body {
        margin: 25px 0;
        line-height: 1.6;
        color: #555;
    }
    
    .bulk-stats {
        display: flex;
        gap: 15px;
        margin: 20px 0;
        flex-wrap: wrap;
    }
    
    .bulk-stat {
        background: #f8f9fa;
        border-radius: 12px;
        padding: 15px;
        text-align: center;
        flex: 1;
        min-width: 100px;
    }
    
    .bulk-stat-number {
        font-size: 20px;
        font-weight: 800;
        color: #dc3545;
        margin-bottom: 5px;
    }
    
    .bulk-stat-label {
        font-size: 12px;
        color: #6c757d;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    
    .supplier-chip {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: #f1f1f1;
        padding: 10px 15px;
        border-radius: 50px;
        margin: 10px 0;
        font-weight: 600;
    }
    
    .bulk-confirm-footer {
        display: flex;
        justify-content: flex-end;
        gap: 15px;
        margin-top: 30px;
    }
    
    .bulk-confirm-btn {
        padding: 12px 25px;
        border-radius: 12px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        gap: 8px;
        border: none;
    }
    
    .bulk-confirm-primary {
        background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
        color: white;
    }
    
    .bulk-confirm-secondary {
        background: #f8f9fa;
        color: #495057;
    }
    
    /* Small animation for the modal */
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    </style>
</head>
<body>
<?php 
// Connexion à la base de données
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ch office track";

try {
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Récupérer tous les produits avec les noms de catégories
    $stmt = $pdo->query("SELECT a.*, c.nom_categorie as categorie_nom 
                         FROM article a
                         LEFT JOIN categories c ON a.id_categorie = c.id_categorie");
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Calculer les alertes
    $outOfStock = array_filter($products, function($product) {
        return $product['current_stock'] == 0;
    });
    
    $lowStock = array_filter($products, function($product) {
        return $product['current_stock'] > 0 && $product['current_stock'] < $product['seuil_min'];
    });
    
    $allAlerts = array_merge($outOfStock, $lowStock);
    
} catch(PDOException $e) {
    die("Erreur de connexion: " . $e->getMessage());
}

include "sys.php";
?>

<!-- Main Content -->
<main class="main-content">
    <!-- Page Header -->
    <div class="page-header">
        <div class="page-header-content">
            <div class="header-left">
                <i class="alert-icon-large fas fa-exclamation-triangle"></i>
                <div>
                    <h1 class="page-title">Stock Alerts</h1>
                    <p class="page-subtitle">Critical stock levels requiring immediate attention</p>
                </div>
            </div>
            <div class="alerts-summary">
                <div class="summary-item">
                    <span class="summary-number"><?php echo count($allAlerts); ?></span>
                    <span class="summary-label">Total Alerts</span>
                </div>
                <div class="summary-item">
                    <span class="summary-number"><?php echo count($outOfStock); ?></span>
                    <span class="summary-label">Out of Stock</span>
                </div>
                <div class="summary-item">
                    <span class="summary-number"><?php echo count($lowStock); ?></span>
                    <span class="summary-label">Low Stock</span>
                </div>
                <a href="stockroom.php" class="summary-item" style="text-decoration: none; color: white;">
                    <span class="summary-number"><i class="fas fa-warehouse"></i></span>
                    <span class="summary-label">Go to Stock</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Alert Categories -->
    <div class="alert-categories">
        <div class="category-card critical">
            <div class="category-header">
                <div class="category-info">
                    <i class="category-icon fas fa-exclamation-circle"></i>
                    <h3 class="category-title">Critical Alerts</h3>
                </div>
                <span class="category-count"><?php echo count($outOfStock); ?></span>
            </div>
            <p class="category-description">
                Products that are completely out of stock and require immediate restocking.
            </p>
            <div class="quick-actions">
                <button class="action-btn" onclick="filterAlerts('critical')">
                    <i class="fas fa-eye"></i> View All
                </button>
                <button class="action-btn" onclick="generateReport('critical')">
                    <i class="fas fa-file-pdf"></i> Export
                </button>
                <button class="action-btn" onclick="bulkAction('restock')">
                    <i class="fas fa-boxes"></i> Bulk Restock
                </button>
            </div>
        </div>

        <div class="category-card warning">
            <div class="category-header">
                <div class="category-info">
                    <i class="category-icon fas fa-exclamation-triangle"></i>
                    <h3 class="category-title">Low Stock Warnings</h3>
                </div>
                <span class="category-count"><?php echo count($lowStock); ?></span>
            </div>
            <p class="category-description">
                Products below minimum stock levels that need attention soon.
            </p>
            <div class="quick-actions">
                <button class="action-btn" onclick="filterAlerts('warning')">
                    <i class="fas fa-eye"></i> View All
                </button>
                <button class="action-btn" onclick="generateReport('warning')">
                    <i class="fas fa-file-pdf"></i> Export
                </button>
                <button class="action-btn" onclick="bulkAction('order')">
                    <i class="fas fa-shopping-cart"></i> Bulk Order
                </button>
            </div>
        </div>
    </div>

    <!-- Alert Details -->
    <div class="alert-details">
        <div class="section-header">
            <h3 class="section-title">Alert Details</h3>
            <div class="filter-tabs">
                <button class="filter-tab active" onclick="filterAlerts('all')">All Alerts</button>
                <button class="filter-tab" onclick="filterAlerts('critical')">Critical</button>
                <button class="filter-tab" onclick="filterAlerts('warning')">Warning</button>
            </div>
        </div>

        <div class="alert-items" id="alertItems">
            <?php foreach ($outOfStock as $product): ?>
            <div class="alert-item critical" data-type="critical">
                <div class="alert-item-header">
                    <div class="alert-item-info">
                        <h4 class="alert-item-title"><?php echo htmlspecialchars($product['nom']); ?></h4>
                        <div class="alert-item-meta">
                            <span><i class="fas fa-tag"></i> <?php echo htmlspecialchars($product['categorie_nom']); ?></span>
                            <span><i class="fas fa-building"></i> <?php echo htmlspecialchars($product['fournisseur']); ?></span>
                            <span><i class="fas fa-calendar"></i> <?php echo date('d/m/Y', strtotime($product['date_importation'])); ?></span>
                        </div>
                    </div>
                    <span class="alert-item-status status-critical">Out of Stock</span>
                </div>
                <p class="alert-item-description">
                    This product is completely out of stock. Current stock: <strong>0 <?php echo htmlspecialchars($product['unit']); ?></strong>. 
                    Minimum required: <strong><?php echo $product['seuil_min']; ?> <?php echo htmlspecialchars($product['unit']); ?></strong>.
                    <br>Unit price: <strong><?php echo number_format($product['prix_unitaire'], 2); ?> TND</strong>
                </p>
                <div class="alert-item-actions">
                    <button class="action-btn-small" onclick="quickRestock(<?php echo $product['id_article']; ?>)">
                        <i class="fas fa-plus"></i> Quick Restock
                    </button>
                    <button class="action-btn-small" onclick="contactSupplier('<?php echo $product['fournisseur']; ?>', [<?php echo $product['id_article']; ?>])">
                        <i class="fas fa-envelope"></i> Contact Supplier
                    </button>
                    <button class="action-btn-small" onclick="viewHistory(<?php echo $product['id_article']; ?>)">
                        <i class="fas fa-history"></i> View History
                    </button>
                    
                </div>
                
            </div>
            <?php endforeach; ?>

            <?php foreach ($lowStock as $product): ?>
            <div class="alert-item warning" data-type="warning">
                <div class="alert-item-header">
                    <div class="alert-item-info">
                        <h4 class="alert-item-title"><?php echo htmlspecialchars($product['nom']); ?></h4>
                        <div class="alert-item-meta">
                            <span><i class="fas fa-tag"></i> <?php echo htmlspecialchars($product['categorie_nom']); ?></span>
                            <span><i class="fas fa-building"></i> <?php echo htmlspecialchars($product['fournisseur']); ?></span>
                            <span><i class="fas fa-calendar"></i> <?php echo date('d/m/Y', strtotime($product['date_importation'])); ?></span>
                        </div>
                    </div>
                    <span class="alert-item-status status-warning">Low Stock</span>
                </div>
                <p class="alert-item-description">
                    This product is below minimum stock level. Current stock: <strong><?php echo $product['current_stock']; ?> <?php echo htmlspecialchars($product['unit']); ?></strong>. 
                    Minimum required: <strong><?php echo $product['seuil_min']; ?> <?php echo htmlspecialchars($product['unit']); ?></strong>.
                    <br>Unit price: <strong><?php echo number_format($product['prix_unitaire'], 2); ?> TND</strong>
                </p>
                <div class="alert-item-actions">
                    <button class="action-btn-small" onclick="quickRestock(<?php echo $product['id_article']; ?>)">
                        <i class="fas fa-plus"></i> Add Stock
                    </button>
                    <button class="action-btn-small" onclick="contactSupplier('<?php echo $product['fournisseur']; ?>', [<?php echo $product['id_article']; ?>])">
                        <i class="fas fa-envelope"></i> Contact Supplier
                    </button>
                    <button class="action-btn-small" onclick="adjustThreshold(<?php echo $product['id_article']; ?>)">
                        <i class="fas fa-sliders-h"></i> Adjust Threshold
                    </button>
                    
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</main>

<!-- Quick Restock Modal -->
<div id="restockModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h3 class="modal-title">Quick Restock</h3>
            <button class="close-btn" onclick="closeModal('restockModal')">&times;</button>
        </div>
        <form id="restockForm">
            <input type="hidden" id="restockProductId">
            <div class="form-group">
                <label class="form-label">Product</label>
                <input type="text" class="form-input" id="restockProductName" readonly>
            </div>
            <div class="form-row">
                <div class="form-group" style="flex: 1; margin-right: 15px;">
                    <label class="form-label">Current Stock</label>
                    <input type="number" class="form-input" id="restockCurrentStock" readonly>
                </div>
                <div class="form-group" style="flex: 1;">
                    <label class="form-label">Minimum Threshold</label>
                    <input type="number" class="form-input" id="restockMinStock" readonly>
                </div>
            </div>
            <div class="form-group">
                <label class="form-label">Quantity to Add</label>
                <input type="number" class="form-input" id="restockQuantity" min="1" required>
            </div>
            <div class="form-group">
                <label class="form-label">Supplier</label>
                <input type="text" class="form-input" id="restockSupplier" readonly>
            </div>
            <div class="form-group">
                <label class="form-label">Unit Price (TND)</label>
                <input type="number" class="form-input" id="restockUnitPrice" step="0.01" min="0" required>
            </div>
            <div class="form-group">
                <label class="form-label">Estimated Delivery Date</label>
                <input type="date" class="form-input" id="restockDeliveryDate" required>
            </div>
            <div class="form-group">
                <label class="form-label">Comment</label>
                <textarea class="form-input" id="restockComment" rows="3"></textarea>
            </div>
            <div class="form-buttons">
                <button type="button" class="btn-secondary" onclick="closeModal('restockModal')">Cancel</button>
                <button type="submit" class="btn-primary">Confirm</button>
            </div>
        </form>
    </div>
</div>

<!-- Notification -->
<div id="notification" class="notification" style="display: none;">
    <i class="fas fa-check-circle"></i> <span id="notificationText">Action completed successfully!</span>
</div>

<script>
    // Alert filtering
    function filterAlerts(type) {
        const alertItems = document.querySelectorAll('.alert-item');
        const tabs = document.querySelectorAll('.filter-tab');
        
        tabs.forEach(tab => {
            tab.classList.remove('active');
            if (tab.textContent.toLowerCase().includes(type)) {
                tab.classList.add('active');
            }
        });
        
        alertItems.forEach(item => {
            if (type === 'all') {
                item.style.display = 'block';
            } else {
                item.style.display = item.getAttribute('data-type') === type ? 'block' : 'none';
            }
        });
    }
    
    // Modal functions
    function showModal(modalId) {
        document.getElementById(modalId).style.display = 'block';
    }
    
    function closeModal(modalId) {
        document.getElementById(modalId).style.display = 'none';
    }
    
    // Notification system
    function showNotification(message, isSuccess = true) {
        const notification = document.getElementById('notification');
        const notificationText = document.getElementById('notificationText');
        
        notificationText.textContent = message;
        notification.style.display = 'block';
        
        if (isSuccess) {
            notification.style.background = 'linear-gradient(135deg, #28a745 0%, #20c997 100%)';
        } else {
            notification.style.background = 'linear-gradient(135deg, #dc3545 0%, #c82333 100%)';
        }
        
        setTimeout(() => {
            notification.style.display = 'none';
        }, 3000);
    }
    
    // Quick Restock functionality
    function quickRestock(productId) {
        const products = <?php echo json_encode($products); ?>;
        const product = products.find(p => p.id_article == productId);
        
        if (!product) {
            showNotification("Produit non trouvé !", false);
            return;
        }

        // Remplir le formulaire modal
        document.getElementById('restockProductId').value = product.id_article;
        document.getElementById('restockProductName').value = product.nom;
        document.getElementById('restockCurrentStock').value = product.current_stock;
        document.getElementById('restockMinStock').value = product.seuil_min;
        document.getElementById('restockSupplier').value = product.fournisseur;
        document.getElementById('restockUnitPrice').value = product.prix_unitaire;
        document.getElementById('restockComment').value = '';

        // Définir la date de livraison par défaut (3 jours à partir d'aujourd'hui)
        const deliveryDate = new Date();
        deliveryDate.setDate(deliveryDate.getDate() + 3);
        document.getElementById('restockDeliveryDate').valueAsDate = deliveryDate;

        // Afficher le modal
        showModal('restockModal');
    }

    // Gestion de la soumission du formulaire
    document.getElementById('restockForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        // Récupérer les valeurs du formulaire
        const productId = document.getElementById('restockProductId').value;
        const quantity = parseInt(document.getElementById('restockQuantity').value);
        const unitPrice = parseFloat(document.getElementById('restockUnitPrice').value);
        const deliveryDate = document.getElementById('restockDeliveryDate').value;
        const comment = document.getElementById('restockComment').value;

        // Validation simple
        if (quantity <= 0) {
            showNotification("La quantité doit être supérieure à 0", false);
            return;
        }

        // Afficher l'état de chargement
        const submitBtn = e.target.querySelector('button[type="submit"]');
        const originalBtnText = submitBtn.innerHTML;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Traitement...';
        submitBtn.disabled = true;

        // Envoyer les données via AJAX
        const xhr = new XMLHttpRequest();
        xhr.open('POST', 'update_stock.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        
        xhr.onload = function() {
            if (this.status === 200) {
                try {
                    const response = JSON.parse(this.responseText);
                    if (response.status === 'success') {
                        showNotification("Réapprovisionnement confirmé avec succès !");
                        closeModal('restockModal');
                        
                        // Recharger la page après un délai
                        setTimeout(() => {
                            window.location.reload();
                        }, 1500);
                    } else {
                        showNotification(response.message || "Erreur lors de la mise à jour", false);
                    }
                } catch (e) {
                    showNotification("Erreur de traitement de la réponse", false);
                }
            } else {
                showNotification("Erreur de communication avec le serveur", false);
            }
            
            // Restaurer le bouton
            submitBtn.innerHTML = originalBtnText;
            submitBtn.disabled = false;
        };
        
        xhr.onerror = function() {
            showNotification("Erreur réseau", false);
            submitBtn.innerHTML = originalBtnText;
            submitBtn.disabled = false;
        };
        
        const params = `id=${productId}&action=entry&quantity=${quantity}&comment=${encodeURIComponent(comment)}`;
        xhr.send(params);
    });

    // Contact Supplier function - redirects to commande_groupée.php
    function contactSupplier(supplierName, productIds) {
        const idsString = productIds.join(',');
        window.location.href = `commande_groupée.php?fournisseur=${encodeURIComponent(supplierName)}&products=${idsString}`;
    }

    // Bulk actions (restock/order)
   function bulkAction(action) {
    // Déterminer quels produits sont concernés selon l'action
    const alertSelector = action === 'restock' 
        ? '.alert-item.critical' 
        : '.alert-item.warning';
    
    const alertItems = document.querySelectorAll(alertSelector);
    
    // Vérifier s'il y a des produits à traiter
    if (alertItems.length === 0) {
        const message = action === 'restock'
            ? "Aucun produit en rupture de stock à réapprovisionner !"
            : "Aucun produit en stock faible à commander !";
        showNotification(message, false);
        return;
    }

    // Collecter les IDs des produits et leurs fournisseurs
    const productsData = [];
    const supplierCounts = {};
    
    alertItems.forEach(item => {
        try {
            // Récupérer l'ID du produit
            const firstActionBtn = item.querySelector('.alert-item-actions button:first-child');
            const productId = firstActionBtn.getAttribute('onclick').match(/\d+/)[0];
            
            // Récupérer le nom du fournisseur
            const supplierElement = item.querySelector('.alert-item-meta span:nth-child(2)');
            const supplierName = supplierElement.textContent.trim();
            
            // Stocker les données
            productsData.push({
                id: productId,
                supplier: supplierName
            });
            
            // Compter les fournisseurs
            supplierCounts[supplierName] = (supplierCounts[supplierName] || 0) + 1;
        } catch (error) {
            console.error("Erreur lors du traitement d'un produit:", error);
        }
    });

    // Trouver le fournisseur le plus fréquent
    const mostCommonSupplier = Object.keys(supplierCounts).reduce((a, b) => 
        supplierCounts[a] > supplierCounts[b] ? a : b);
    
    // Extraire seulement les IDs des produits
    const productIds = productsData.map(p => p.id);
    
    // Message de confirmation
    const confirmationMessage = action === 'restock'
        ? `Voulez-vous vraiment réapprovisionner ${productIds.length} produit(s) en rupture de stock chez ${mostCommonSupplier} ?`
        : `Voulez-vous vraiment commander ${productIds.length} produit(s) en stock faible chez ${mostCommonSupplier} ?`;
    
    // Demander confirmation
    if (confirm(confirmationMessage)) {
        // Redirection vers la page de commande groupée
        window.location.href = `commande_groupée.php?fournisseur=${
            encodeURIComponent(mostCommonSupplier)
        }&products=${
            productIds.join(',')
        }&type=${
            action
        }&bulk_action=true`;
    } else {
        showNotification('Action annulée', false);
    }
}

    // Other action functions
    function viewHistory(productId) {
        window.location.href = `stockroom.php?product_id=${productId}&tab=history`;
    }
    
   

    function updateAlertCounters() {
        // Get all visible alerts (not marked as handled)
        const criticalAlerts = document.querySelectorAll('.alert-item.critical:not([style*="opacity: 0.5"])').length;
        const warningAlerts = document.querySelectorAll('.alert-item.warning:not([style*="opacity: 0.5"])').length;
        const totalAlerts = criticalAlerts + warningAlerts;
        
        // Update UI counters
        document.querySelector('.category-card.critical .category-count').textContent = criticalAlerts;
        document.querySelector('.category-card.warning .category-count').textContent = warningAlerts;
        document.querySelector('.alerts-summary .summary-item:nth-child(1) .summary-number').textContent = totalAlerts;
        document.querySelector('.alerts-summary .summary-item:nth-child(2) .summary-number').textContent = criticalAlerts;
        document.querySelector('.alerts-summary .summary-item:nth-child(3) .summary-number').textContent = warningAlerts;
    }

    function adjustThreshold(productId) {
        window.location.href = `stockroom.php?product_id=${productId}&tab=edit`;
    }
    
    function generateReport(type) {
        window.open(`report_view.php?type=${type}`, '_blank');
        showNotification(`${type} report generated successfully!`);
    }

    // Show welcome message on load
    window.onload = function() {
        const userName = "<?php echo isset($_SESSION['user_name']) ? $_SESSION['user_name'] : 'Admin'; ?>";
        setTimeout(() => {
            showNotification(`Welcome back, ${userName}! You have <?php echo count($allAlerts); ?> stock alerts to review.`);
        }, 1000);
    };
</script>
<script>
    // Enhanced bulkAction function with stylish confirmation
    function bulkAction(action) {
        // Determine which products are concerned by the action
        const alertSelector = action === 'restock' 
            ? '.alert-item.critical' 
            : '.alert-item.warning';
        
        const alertItems = document.querySelectorAll(alertSelector);
        
        // Check if there are products to process
        if (alertItems.length === 0) {
            const message = action === 'restock'
                ? "No out-of-stock products to restock!"
                : "No low-stock products to order!";
            showNotification(message, false);
            return;
        }

        // Collect product data and count suppliers
        const productsData = [];
        const supplierCounts = {};
        
        alertItems.forEach(item => {
            try {
                const firstActionBtn = item.querySelector('.alert-item-actions button:first-child');
                const productId = firstActionBtn.getAttribute('onclick').match(/\d+/)[0];
                
                const supplierElement = item.querySelector('.alert-item-meta span:nth-child(2)');
                const supplierName = supplierElement.textContent.trim();
                
                productsData.push({
                    id: productId,
                    supplier: supplierName
                });
                
                supplierCounts[supplierName] = (supplierCounts[supplierName] || 0) + 1;
            } catch (error) {
                console.error("Error processing product:", error);
            }
        });

        // Find the most common supplier
        const mostCommonSupplier = Object.keys(supplierCounts).reduce((a, b) => 
            supplierCounts[a] > supplierCounts[b] ? a : b);
        
        // Create a modal for confirmation
        const modalHtml = `
            <div class="bulk-confirm-modal">
                <div class="bulk-confirm-header">
                    <div class="bulk-confirm-icon">
                        <i class="fas fa-${action === 'restock' ? 'boxes' : 'shopping-cart'}"></i>
                    </div>
                    <h3 class="bulk-confirm-title">
                        Confirm Bulk ${action === 'restock' ? 'Restock' : 'Order'}
                    </h3>
                </div>
                
                <div class="bulk-confirm-body">
                    <p>You're about to process ${alertItems.length} products with ${Object.keys(supplierCounts).length} suppliers.</p>
                    
                    <div class="bulk-stats">
                        <div class="bulk-stat">
                            <div class="bulk-stat-number">${alertItems.length}</div>
                            <div class="bulk-stat-label">Total Items</div>
                        </div>
                        <div class="bulk-stat">
                            <div class="bulk-stat-number">${Object.keys(supplierCounts).length}</div>
                            <div class="bulk-stat-label">Suppliers</div>
                        </div>
                    </div>
                    
                    <p>Main supplier:</p>
                    <div class="supplier-chip">
                        <i class="fas fa-building"></i>
                        ${mostCommonSupplier}
                    </div>
                </div>
                
                <div class="bulk-confirm-footer">
                    <button class="bulk-confirm-btn bulk-confirm-secondary" onclick="this.closest('.modal').style.display='none'">
                        <i class="fas fa-times"></i> Cancel
                    </button>
                    <button class="bulk-confirm-btn bulk-confirm-primary" onclick="proceedWithBulkAction('${mostCommonSupplier}', [${productsData.map(p => p.id).join(',')}], '${action}')">
                        <i class="fas fa-check"></i> Confirm
                    </button>
                </div>
            </div>
        `;
        
        // Create and show modal
        const modal = document.createElement('div');
        modal.className = 'modal';
        modal.style.display = 'block';
        modal.innerHTML = modalHtml;
        document.body.appendChild(modal);
        
        // Close modal when clicking outside
        modal.addEventListener('click', function(e) {
            if (e.target === this) {
                this.style.display = 'none';
            }
        });
    }
    
    // Function to proceed with the bulk action
    function proceedWithBulkAction(supplier, productIds, action) {
        // Close all modals
        document.querySelectorAll('.modal').forEach(m => m.style.display = 'none');
        
        // Show processing notification
        showNotification(`Processing ${productIds.length} items...`, true);
        
        // Redirect to grouped order page
        setTimeout(() => {
            window.location.href = `commande_groupée.php?fournisseur=${
                encodeURIComponent(supplier)
            }&products=${
                productIds.join(',')
            }&type=${
                action
            }&bulk_action=true`;
        }, 500);
    }
</script>
</body>
</html>