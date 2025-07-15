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

        /* Main Content */
        .main-content {
            margin-left: 280px;
            margin-top: 70px;
            padding: 30px;
            min-height: calc(100vh - 70px);
        }

        /* Page Header */
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

        /* Alert Categories */
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

        .category-card.info {
            --category-color: #17a2b8;
            --category-color-light: #d1ecf1;
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

        /* Alert Details Section */
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

        /* Alert Items */
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

        /* Modal Styles */
        .modal {
            display: none;
            position: fixed;
            z-index: 2000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.7);
            backdrop-filter: blur(8px);
        }

        .modal-content {
            background: white;
            margin: 3% auto;
            padding: 40px;
            border-radius: 20px;
            width: 90%;
            max-width: 600px;
            position: relative;
            animation: modalSlide 0.4s ease;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
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

        .form-input {
            width: 100%;
            padding: 15px;
            border: 2px solid #e9ecef;
            border-radius: 12px;
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

        /* Responsive */
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

        /* Notification Animation */
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
        return $product['current_stock'] > 0 && $product['current_stock'] <= $product['seuil_min'];
    });
    
    $criticalStock = array_filter($products, function($product) {
        return $product['current_stock'] <= ($product['seuil_min'] * 0.5);
    });
    
    $allAlerts = array_merge($outOfStock, $lowStock);
    
} catch(PDOException $e) {
    die("Erreur de connexion: " . $e->getMessage());
}

include "sys.php";
?>

<!-- Main Content -->
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

        <div class="category-card info">
            <div class="category-header">
                <div class="category-info">
                    <i class="category-icon fas fa-info-circle"></i>
                    <h3 class="category-title">Monitoring</h3>
                </div>
                <span class="category-count"><?php echo count($criticalStock); ?></span>
            </div>
            <p class="category-description">
                Products approaching critical levels that should be monitored closely.
            </p>
            <div class="quick-actions">
                <button class="action-btn" onclick="filterAlerts('info')">
                    <i class="fas fa-eye"></i> View All
                </button>
                <button class="action-btn" onclick="setReminders()">
                    <i class="fas fa-bell"></i> Set Reminders
                </button>
                <button class="action-btn" onclick="adjustThresholds()">
                    <i class="fas fa-sliders-h"></i> Adjust Thresholds
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
                <button class="filter-tab" onclick="filterAlerts('info')">Monitor</button>
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
                    <button class="action-btn-small" onclick="contactSupplier('<?php echo htmlspecialchars($product['fournisseur']); ?>')">
                        <i class="fas fa-phone"></i> Contact Supplier
                    </button>
                    <button class="action-btn-small" onclick="viewHistory(<?php echo $product['id_article']; ?>)">
                        <i class="fas fa-history"></i> View History
                    </button>
                    <button class="action-btn-small" onclick="markAsHandled(<?php echo $product['id_article']; ?>)">
                        <i class="fas fa-check"></i> Mark Handled
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
                    <button class="action-btn-small" onclick="createOrder(<?php echo $product['id_article']; ?>)">
                        <i class="fas fa-shopping-cart"></i> Create Order
                    </button>
                    <button class="action-btn-small" onclick="adjustThreshold(<?php echo $product['id_article']; ?>)">
                        <i class="fas fa-sliders-h"></i> Adjust Threshold
                    </button>
                    <button class="action-btn-small" onclick="markAsHandled(<?php echo $product['id_article']; ?>)">
                        <i class="fas fa-check"></i> Mark Handled
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
            <div class="form-group">
                <label class="form-label">Product Name</label>
                <input type="text" class="form-input" id="restockProductName" readonly>
            </div>
            <div class="form-group">
                <label class="form-label">Current Stock</label>
                <input type="number" class="form-input" id="restockCurrentStock" readonly>
            </div>
            <div class="form-group">
                <label class="form-label">Minimum Stock</label>
                <input type="number" class="form-input" id="restockMinStock" readonly>
            </div>
            <div class="form-group">
                <label class="form-label">
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
            <div class="form-buttons">
                <button type="button" class="btn-secondary" onclick="closeModal('restockModal')">Cancel</button>
                <button type="submit" class="btn-primary">Confirm Restock</button>
            </div>
        </form>
    </div>
</div>

<!-- Notification -->
<div id="notification" class="notification" style="display: none;">
    <i class="fas fa-check-circle"></i> <span id="notificationText">Action completed successfully!</span>
</div>

<script>
    // Fonctions pour les alertes
    function filterAlerts(type) {
        const alertItems = document.querySelectorAll('.alert-item');
        const tabs = document.querySelectorAll('.filter-tab');
        
        // Mettre à jour les onglets actifs
        tabs.forEach(tab => {
            tab.classList.remove('active');
            if (tab.textContent.toLowerCase().includes(type)) {
                tab.classList.add('active');
            }
        });
        
        // Filtrer les éléments d'alerte
        alertItems.forEach(item => {
            if (type === 'all') {
                item.style.display = 'block';
            } else {
                if (item.getAttribute('data-type') === type) {
                    item.style.display = 'block';
                } else {
                    item.style.display = 'none';
                }
            }
        });
    }
    
    // Fonctions pour les modales
    function showModal(modalId) {
        document.getElementById(modalId).style.display = 'block';
    }
    
    function closeModal(modalId) {
        document.getElementById(modalId).style.display = 'none';
    }
    
    // Fonction pour afficher une notification
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
    
    // Fonctions spécifiques aux actions
    function quickRestock(productId) {
        // Ici, vous devriez récupérer les données du produit depuis votre base de données
        // Pour l'exemple, nous utilisons des données statiques
        const product = {
            id: productId,
            name: "Produit " + productId,
            currentStock: 5,
            minStock: 20,
            supplier: "Fournisseur " + productId,
            unitPrice: 15.99
        };
        
        // Remplir le formulaire de réapprovisionnement
        document.getElementById('restockProductName').value = product.name;
        document.getElementById('restockCurrentStock').value = product.currentStock;
        document.getElementById('restockMinStock').value = product.minStock;
        document.getElementById('restockSupplier').value = product.supplier;
        document.getElementById('restockUnitPrice').value = product.unitPrice;
        
        // Définir la date de livraison par défaut (3 jours à partir d'aujourd'hui)
        const deliveryDate = new Date();
        deliveryDate.setDate(deliveryDate.getDate() + 3);
        document.getElementById('restockDeliveryDate').valueAsDate = deliveryDate;
        
        // Afficher la modal
        showModal('restockModal');
    }
    
    function contactSupplier(supplierName) {
        showNotification(`Supplier ${supplierName} contacted successfully.`);
    }
    
    function viewHistory(productId) {
        showNotification(`Viewing history for product ID: ${productId}`);
    }
    
    function markAsHandled(productId) {
        showNotification(`Alert for product ID: ${productId} marked as handled.`);
    }
    
    function createOrder(productId) {
        showNotification(`Purchase order created for product ID: ${productId}`);
    }
    
    function adjustThreshold(productId) {
        showNotification(`Adjusting threshold for product ID: ${productId}`);
    }
    
    function generateReport(type) {
    // Open report in a new tab
    window.open(`report_view.php?type=${type}`, '_blank');
    
    // Or alternatively, show in the same window:
    // window.location.href = `report_view.php?type=${type}`;
    
    showNotification(`Report generated successfully!`);
}
    
   function bulkAction(action) {
    let alertItems, message, productIds = [];
    
    if (action === 'restock') {
        alertItems = document.querySelectorAll('.alert-item.critical');
        message = "Êtes-vous sûr de vouloir commander en masse tous les produits en rupture de stock?";
    } 
    else if (action === 'order') {
        alertItems = document.querySelectorAll('.alert-item.warning');
        message = "Êtes-vous sûr de vouloir commander en masse tous les produits en stock faible?";
    }
    
    alertItems.forEach(alert => {
        const button = alert.querySelector('.alert-item-actions button');
        const match = button.getAttribute('onclick').match(/\((?:'|")?(\d+)(?:'|")?\)/);
        if (match && match[1]) {
            productIds.push(match[1]);
        }
    });
    
    if (productIds.length === 0) {
        const msg = action === 'restock' 
            ? 'Aucune alerte critique à réapprovisionner!' 
            : 'Aucun produit en stock faible à commander!';
        showNotification(msg, false);
        return;
    }
    
    if (confirm(message)) {
        window.location.href = `commande_groupée.php?products=${productIds.join(',')}&type=${action}`;
    }
}
    
    function setReminders() {
    // 1. Récupère tous les produits avec alertes (version plus fiable)
    const alertItems = document.querySelectorAll('.alert-item');
    const products = [];
    
    alertItems.forEach(item => {
        try {
            const id = item.querySelector('button').getAttribute('onclick')
                         .match(/(quickRestock|createOrder|adjustThreshold)\((\d+)\)/)[2];
            const name = item.querySelector('.alert-item-title').textContent;
            const type = item.getAttribute('data-type');
            
            products.push({ id, name, type });
        } catch (e) {
            console.error("Erreur analyse produit:", e);
        }
    });
    
    if (products.length === 0) {
        showNotification("No products found to set reminders!", false);
        return;
    }

    // 2. Crée le modal (version simplifiée)
    const modalId = 'reminderModal';
    if (document.getElementById(modalId)) return; // Empêche les doublons
    
    const modalHTML = `
    <div id="${modalId}" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Set Reminders</h3>
                <button class="close-btn" onclick="closeModal('${modalId}')">&times;</button>
            </div>
            <div style="padding: 20px;">
                <p>This feature would set reminders for ${products.length} products.</p>
                <div style="margin: 15px 0;">
                    <label>Frequency:</label>
                    <select id="reminderFreq" class="form-input">
                        <option value="daily">Daily</option>
                        <option value="weekly">Weekly</option>
                    </select>
                </div>
                <button onclick="confirmReminders()" class="btn-primary">
                    Confirm Reminders
                </button>
            </div>
        </div>
    </div>`;
    
    document.body.insertAdjacentHTML('beforeend', modalHTML);
    showModal(modalId);
}

// Fonction helper pour la confirmation
function confirmReminders() {
    const frequency = document.getElementById('reminderFreq').value;
    showNotification(`Reminders set to ${frequency}! Check browser console for details.`);
    closeModal('reminderModal');
    
    // Debug: affiche ce qui serait envoyé au serveur
    console.log("Reminders configuration:", {
        frequency,
        timestamp: new Date()
    });
}
 function adjustThresholds() {
    // 1. Récupération des produits de manière robuste
    const products = Array.from(document.querySelectorAll('.alert-item')).map(item => {
        try {
            // Meilleure méthode pour récupérer l'ID
            const buttons = item.querySelectorAll('button');
            let productId = null;
            
            for (const button of buttons) {
                const onclick = button.getAttribute('onclick') || '';
                const match = onclick.match(/(\d+)/);
                if (match) {
                    productId = match[0];
                    break;
                }
            }
            if (!productId) return null;

            // Extraction fiable des données
            const name = item.querySelector('.alert-item-title')?.textContent?.trim() || `Product ${productId}`;
            const desc = item.querySelector('.alert-item-description')?.innerHTML || '';
            
            const currentStock = desc.match(/Current stock:[^<]*<strong>(\d+)/i)?.[1] || '0';
            const minStock = desc.match(/Minimum required:[^<]*<strong>(\d+)/i)?.[1] || '0';

            return {
                id: productId,
                name,
                currentStock,
                minStock
            };
        } catch (e) {
            console.error("Error processing product:", e);
            return null;
        }
    }).filter(p => p !== null);

    if (products.length === 0) {
        showNotification("No products found for threshold adjustment", false);
        return;
    }

    // 2. Création du modal avec gestion des doublons
    const modalId = 'thresholdAdjustmentModal';
    const existingModal = document.getElementById(modalId);
    if (existingModal) existingModal.remove();

    const modalHTML = `
    <div id="${modalId}" class="modal">
        <div class="modal-content" style="max-width:800px">
            <div class="modal-header">
                <h3>Adjust Stock Thresholds</h3>
                <button class="close-btn" onclick="closeModalAndReload()">&times;</button>
            </div>
            <div style="max-height:60vh;overflow-y:auto;margin:20px 0">
                <table style="width:100%;border-collapse:collapse">
                    <thead>
                        <tr style="background:#f8f9fa">
                            <th style="padding:12px;text-align:left">Product</th>
                            <th style="padding:12px;text-align:center">Current</th>
                            <th style="padding:12px;text-align:center">Threshold</th>
                            <th style="padding:12px;text-align:center">New</th>
                        </tr>
                    </thead>
                    <tbody>
                        ${products.map(p => `
                        <tr>
                            <td style="padding:12px">
                                ${p.name}
                                <input type="hidden" class="product-id" value="${p.id}">
                            </td>
                            <td style="padding:12px;text-align:center">${p.currentStock}</td>
                            <td style="padding:12px;text-align:center">${p.minStock}</td>
                            <td style="padding:12px;text-align:center">
                                <input type="number" class="threshold-input form-input" 
                                       value="${p.minStock}" 
                                       min="1" 
                                       required
                                       style="width:80px;text-align:center">
                            </td>
                        </tr>
                        `).join('')}
                    </tbody>
                </table>
            </div>
            <div class="form-buttons" style="margin-top:20px">
                <button type="button" class="btn-secondary" onclick="closeModalAndReload()">
                    Cancel
                </button>
                <button type="button" class="btn-primary" id="saveThresholdsBtn">
                    Save Changes
                </button>
            </div>
        </div>
    </div>`;

    document.body.insertAdjacentHTML('beforeend', modalHTML);

    // 3. Fonction de fermeture
    window.closeModalAndReload = function() {
        const modal = document.getElementById(modalId);
        if (modal) modal.remove();
        location.reload();
    };

    // 4. Gestion de l'enregistrement
    document.getElementById('saveThresholdsBtn').addEventListener('click', async function() {
        const inputs = document.querySelectorAll(`#${modalId} .threshold-input`);
        const updates = [];
        let isValid = true;

        // Validation
        inputs.forEach(input => {
            if (!input.value || isNaN(input.value) || input.value < 1) {
                input.style.border = '2px solid red';
                isValid = false;
            } else {
                updates.push({
                    productId: input.closest('tr').querySelector('.product-id').value,
                    newThreshold: input.value
                });
            }
        });

        if (!isValid || updates.length === 0) {
            showNotification("Please enter valid threshold values", false);
            return;
        }

        // Envoi des données
        try {
            const response = await fetch('update_thresholds.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify({ updates })
            });

            const result = await response.json();

            if (!response.ok || !result.success) {
                throw new Error(result.message || "Failed to save thresholds");
            }

            showNotification("Thresholds updated successfully!");
            setTimeout(closeModalAndReload, 1500);

        } catch (error) {
            console.error("Save error:", error);
            showNotification(`Error: ${error.message}`, false);
        }
    });

    // Affichage du modal
    document.getElementById(modalId).style.display = 'block';
}
</script>
<script>
    // Check if we need to highlight a specific alert
    document.addEventListener('DOMContentLoaded', function() {
        const alertType = "<?php echo $alertType; ?>";
        const productId = <?php echo $productId; ?>;
        
        if (alertType && productId) {
            // Filter to show the specific alert type
            filterAlerts(alertType);
            
            // Scroll to and highlight the specific product
            setTimeout(() => {
                const alertItem = document.querySelector(`.alert-item[data-type="${alertType}"][data-id="${productId}"]`);
                if (alertItem) {
                    alertItem.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    alertItem.style.animation = 'pulse 2s 3';
                    
                    // Remove the animation after it's done
                    setTimeout(() => {
                        alertItem.style.animation = '';
                    }, 6000);
                }
            }, 500);
        }
        
        // Initialize any other necessary functions
    });

    // Modify the quickRestock function to redirect to stockroom.php after restock
    document.getElementById('restockForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const quantity = document.getElementById('restockQuantity').value;
        const productName = document.getElementById('restockProductName').value;
        const productId = <?php echo $productId ?? 'null'; ?>;
        
        // Here you would normally send data to server
        // For now we'll just show notification and redirect
        showNotification(`${quantity} units of ${productName} added to restock list.`);
        closeModal('restockModal');
        this.reset();
        
        // Redirect to stockroom.php after a delay
        setTimeout(() => {
            window.location.href = 'stockroom.php';
        }, 1500);
    });

    // Modify action functions to link with stockroom.php
    function viewHistory(productId) {
        window.location.href = `stockroom.php?product_id=${productId}&tab=history`;
    }

    function adjustThreshold(productId) {
        window.location.href = `stockroom.php?product_id=${productId}&tab=edit`;
    }

    // Add this function to handle clicks on alert items
    function handleAlertClick(productId, alertType) {
        window.location.href = `stockroom.php?product_id=${productId}&alert=${alertType}`;
    }
</script>
</body>
</html>