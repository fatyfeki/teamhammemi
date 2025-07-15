<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stockroom - CH OfficeTrack</title>
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

        .page-header {
            background: linear-gradient(135deg, #333333 0%, #5a0000 100%);
            border-radius: 20px;
            padding: 30px;
            color: white;
            margin-bottom: 30px;
            position: relative;
            overflow: hidden;
        }

        .page-header::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
            animation: float 6s ease-in-out infinite;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(180deg); }
        }

        .page-header-content {
            position: relative;
            z-index: 2;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .page-title {
            font-size: 32px;
            font-weight: 700;
            margin-bottom: 10px;
        }

        .page-subtitle {
            font-size: 16px;
            opacity: 0.9;
        }

        .add-product-btn {
            background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
            color: white;
            border: none;
            padding: 15px 30px;
            border-radius: 50px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 5px 15px rgba(40, 167, 69, 0.3);
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .add-product-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(40, 167, 69, 0.4);
        }

        /* Alerts Section */
        .alerts-section {
            margin-bottom: 30px;
        }

        .alert-card {
            background: white;
            border-left: 4px solid #dc3545;
            border-radius: 15px;
            padding: 25px;
            margin-bottom: 15px;
            box-shadow: 0 8px 25px rgba(0,0,0,0.1);
            animation: slideIn 0.5s ease;
        }

        @keyframes slideIn {
            from { transform: translateX(-20px); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }

        .alert-header {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 20px;
        }

        .alert-icon {
            color: #dc3545;
            font-size: 28px;
        }

        .alert-title {
            font-size: 20px;
            font-weight: 700;
            color: #333;
        }

        .alert-count {
            background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
            color: white;
            padding: 8px 15px;
            border-radius: 20px;
            font-size: 14px;
            font-weight: bold;
            box-shadow: 0 3px 10px rgba(220, 53, 69, 0.3);
        }

        .alert-products {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 20px;
        }

        .alert-product {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            border-radius: 12px;
            padding: 20px;
            text-align: center;
            border: 1px solid #e9ecef;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .alert-product::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: linear-gradient(90deg, #dc3545, #fd7e14);
        }

        .alert-product:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 20px rgba(0,0,0,0.15);
        }

        .alert-product-name {
            font-weight: 700;
            color: #333;
            margin-bottom: 8px;
            font-size: 16px;
        }

        .alert-product-stock {
            color: #dc3545;
            font-weight: bold;
            font-size: 14px;
        }

        /* Filters */
        .filters-section {
            background: white;
            border-radius: 20px;
            padding: 30px;
            margin-bottom: 30px;
            box-shadow: 0 8px 25px rgba(0,0,0,0.1);
        }

        .filters-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
        }

        .filters-title {
            font-size: 20px;
            font-weight: 700;
            color: #333;
        }

        .filters-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 25px;
            align-items: end;
        }

        .filter-group {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .filter-label {
            font-weight: 600;
            color: #333;
            font-size: 14px;
        }

        .filter-input {
            padding: 15px;
            border: 2px solid #e9ecef;
            border-radius: 12px;
            font-size: 14px;
            transition: all 0.3s ease;
            background: #f8f9fa;
        }

        .filter-input:focus {
            border-color: #8b0000;
            outline: none;
            box-shadow: 0 0 0 4px rgba(139, 0, 0, 0.1);
            background: white;
        }

        /* Products Table */
        .products-section {
            background: white;
            border-radius: 20px;
            padding: 30px;
            box-shadow: 0 8px 25px rgba(0,0,0,0.1);
        }

        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }

        .section-title {
            font-size: 24px;
            font-weight: 700;
            color: #333;
        }

        .table-container {
            overflow-x: auto;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }

        .products-table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            border-radius: 15px;
            overflow: hidden;
        }

        .products-table thead tr {
            background: white !important;
            border-bottom: 2px solid #dc3545;
        }

        .products-table th {
            background: white !important;
            color: #dc3545 !important;
            padding: 20px 15px;
            text-align: left;
            font-weight: 700;
            font-size: 14px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .products-table td {
            color: #333;
            padding: 18px 15px;
            border-bottom: 1px solid #e9ecef;
            vertical-align: middle;
        }

        .products-table tr {
            transition: all 0.3s ease;
        }

        .products-table tr:hover {
            transform: scale(1.01);
        }

        /* Style des lignes selon le stock */
        .products-table tr.stock-low {
            background: linear-gradient(135deg, #fff3e0 0%, #ffe0b2 100%);
            border-left: 4px solid #ff9800;
             color: #333; /* Texte noir */
        }

        .products-table tr.stock-out {
            background: linear-gradient(135deg, #ffebee 0%, #ffcdd2 100%);
            border-left: 4px solid #f44336;
            color: #333; /* Texte noir */
        }

        .products-table tr.stock-normal {
            background: white;
        }

        .products-table tr.stock-low:hover {
            background: linear-gradient(135deg, #ffe0b2 0%, #ffcc80 100%);
            box-shadow: 0 4px 15px rgba(255,152,0,0.2);
        }

        .products-table tr.stock-out:hover {
            background: linear-gradient(135deg, #ffcdd2 0%, #ef9a9a 100%);
            box-shadow: 0 4px 15px rgba(244,67,54,0.2);
        }

        .products-table tr.stock-normal:hover {
            background: #f8f9fa;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }

        .stock-badge {
            padding: 8px 16px;
            border-radius: 25px;
            font-size: 12px;
            font-weight: bold;
            text-align: center;
            min-width: 80px;
            display: inline-block;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .stock-high {
            background: linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%);
            color: #155724;
            box-shadow: 0 2px 8px rgba(21, 87, 36, 0.2);
        }

        .stock-medium {
            background: linear-gradient(135deg, #fff3cd 0%, #ffeaa7 100%);
            color: #856404;
            box-shadow: 0 2px 8px rgba(133, 100, 4, 0.2);
        }

        .stock-low {
            background: linear-gradient(135deg, #ffe0b2 0%, #ffcc80 100%);
            color: #e65100;
            box-shadow: 0 2px 8px rgba(230, 81, 0, 0.3);
        }

        .stock-out {
            background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
            color: white;
            animation: pulse 2s infinite;
            box-shadow: 0 2px 8px rgba(220, 53, 69, 0.4);
        }

        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.05); }
            100% { transform: scale(1); }
        }

        .action-buttons {
            display: flex;
            gap: 10px;
            justify-content: center;
        }

        .action-btn {
            padding: 10px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 14px;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 36px;
            height: 36px;
        }

        .btn-entry {
            background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
            color: white;
            box-shadow: 0 2px 8px rgba(40, 167, 69, 0.3);
        }

        .btn-exit {
            background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
            color: white;
            box-shadow: 0 2px 8px rgba(220, 53, 69, 0.3);
        }

        .btn-edit {
            background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
            color: white;
            box-shadow: 0 2px 8px rgba(0, 123, 255, 0.3);
        }

        .btn-delete {
            background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
            color: white;
            box-shadow: 0 2px 8px rgba(220, 53, 69, 0.3);
        }

        .action-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(0,0,0,0.3);
        }

        .action-btn:disabled {
            opacity: 0.5;
            cursor: not-allowed;
            transform: none;
            box-shadow: none;
        }

        /* Modal */
        .modal {
            display: none;
            position: fixed;
            z-index: 2000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.6);
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
            border-color: #8b0000;
            outline: none;
            box-shadow: 0 0 0 4px rgba(139, 0, 0, 0.1);
            background: white;
        }

        .form-buttons {
            display: flex;
            gap: 15px;
            justify-content: flex-end;
            margin-top: 30px;
        }

        .btn-primary {
            background: linear-gradient(135deg, #8b0000 0%, #5a0000 100%);
            color: white;
            padding: 15px 30px;
            border: none;
            border-radius: 12px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(139, 0, 0, 0.3);
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
            
            .top-navbar {
                left: 0;
            }
            
            .filters-grid {
                grid-template-columns: 1fr;
            }
            
            .products-table {
                font-size: 14px;
            }
            
            .products-table th,
            .products-table td {
                padding: 12px 8px;
            }
            
            .action-buttons {
                flex-direction: column;
                gap: 5px;
            }
            
            .action-btn {
                width: 100%;
                justify-content: center;
            }
        }
        .modal-content {
            max-height: 80vh;
            display: flex;
            flex-direction: column;
        }

        .modal-header {
            padding-bottom: 20px;
            border-bottom: 2px solid #f8f9fa;
        }

        #editForm {
            flex: 1;
            overflow-y: auto;
            padding-bottom: 20px;
        }

        .form-buttons {
            margin-top: 30px;
            display: flex;
            gap: 15px;
            justify-content: flex-end;
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
            <div>
                <h1 class="page-title">Stock Management</h1>
                <p class="page-subtitle">Monitor and manage your stock levels</p>
            </div>
            <a href="addproduct.php" class="add-product-btn">
                <i class="fas fa-plus"></i>
                Add Product
            </a>
        </div>
    </div>

    <!-- Filters Section -->
    <div class="filters-section">
        <div class="filters-header">
            <h3 class="filters-title">Advanced Filters</h3>
        </div>
        <div class="filters-grid">
            <div class="filter-group">
                <label class="filter-label">Category</label>
                <select class="filter-input" id="categoryFilter" onchange="applyFilters()">
                    <option value="">All Categories</option>
                    <?php
                    // Récupérer toutes les catégories uniques
                    $categories = array_unique(array_column($products, 'categorie_nom'));
                    foreach ($categories as $category): ?>
                        <option value="<?php echo htmlspecialchars($category); ?>"><?php echo htmlspecialchars($category); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            
            <div class="filter-group">
                <label class="filter-label">Stock Status</label>
                <select class="filter-input" id="stockFilter" onchange="applyFilters()">
                    <option value="">All Levels</option>
                    <option value="out">Out of Stock</option>
                    <option value="low">Low Stock</option>
                    <option value="medium">Medium Stock</option>
                    <option value="high">High Stock</option>
                </select>
            </div>
            
            <div class="filter-group">
                <label class="filter-label">Supplier</label>
                <select class="filter-input" id="supplierFilter" onchange="applyFilters()">
                    <option value="">All Suppliers</option>
                    <?php
                    // Récupérer tous les fournisseurs uniques
                    $suppliers = array_unique(array_column($products, 'fournisseur'));
                    foreach ($suppliers as $supplier): ?>
                        <option value="<?php echo htmlspecialchars($supplier); ?>"><?php echo htmlspecialchars($supplier); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            
            <div class="filter-group">
                <label class="filter-label">Product Search</label>
                <input type="text" class="filter-input" id="productSearch" placeholder="Enter product name..." onkeyup="applyFilters()">
            </div>
            
            <div class="filter-group">
                <button class="btn-primary" style="padding: 15px; width: 100%;" onclick="applyFilters()">
                    Apply Filters
                </button>
            </div>
        </div>
    </div>

    <!-- Products Table Section -->
    <div class="products-section">
        <div class="section-header">
            <h3 class="section-title">Stock Overview</h3>
        </div>
        
        <div class="table-container">
            <table class="products-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Product Name</th>
                        <th>Category</th>
                        <th>Import Date</th>
                        <th>Unit Price</th>
                        <th>Current Stock</th>
                        <th>Min. Stock</th>
                        <th>Unit</th>
                        <th>Supplier</th>
                        <th>Total Value</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="productsTableBody">
                    <?php foreach ($products as $product): ?>
                    <?php 
                        $stockClass = '';
                        if ($product['current_stock'] == 0) {
                            $stockClass = 'stock-out';
                        } elseif ($product['current_stock'] < $product['seuil_min']) {
                            $stockClass = 'stock-low';
                        } else {
                            $stockClass = 'stock-normal';
                        }
                        
                        $statusBadge = '';
                        if ($product['current_stock'] == 0) {
                            $statusBadge = 'stock-out';
                        } elseif ($product['current_stock'] < $product['seuil_min']) {
                            $statusBadge = 'stock-low';
                        } elseif ($product['current_stock'] >= $product['seuil_min'] * 2) {
                            $statusBadge = 'stock-high';
                        } else {
                            $statusBadge = 'stock-medium';
                        }
                    ?>
                    <tr class="<?php echo $stockClass; ?>" data-id="<?php echo $product['id_article']; ?>">
                        <td><?php echo $product['id_article']; ?></td>
                        <td><?php echo htmlspecialchars($product['nom']); ?></td>
                        <td><?php echo htmlspecialchars($product['categorie_nom']); ?></td>
                        <td><?php echo date('Y-m-d H:i', strtotime($product['date_importation'])); ?></td>
                        <td><?php echo number_format($product['prix_unitaire'], 2); ?> TND</td>
                        <td><?php echo $product['current_stock']; ?></td>
                        <td><?php echo $product['seuil_min']; ?></td>
                        <td><?php echo htmlspecialchars($product['unit']); ?></td>
                        <td><?php echo htmlspecialchars($product['fournisseur']); ?></td>
                        <td><?php echo number_format($product['prix_unitaire'] * $product['current_stock'], 2); ?> TND</td>
                        <td><span class="stock-badge <?php echo $statusBadge; ?>">
                            <?php 
                                if ($statusBadge == 'stock-out') echo 'Out';
                                elseif ($statusBadge == 'stock-low') echo 'Low';
                                elseif ($statusBadge == 'stock-medium') echo 'Medium';
                                else echo 'High';
                            ?>
                        </span></td>
                        <td>
                            <div class="action-buttons">
                                <button class="action-btn btn-entry" onclick="handleEntry(this.closest('tr'))">
                                    <i class="fas fa-plus"></i>
                                </button>
                                <button class="action-btn btn-exit" <?php echo ($product['current_stock'] == 0) ? 'disabled' : ''; ?> onclick="handleExit(this.closest('tr'))">
                                    <i class="fas fa-minus"></i>
                                </button>
                                <button class="action-btn btn-edit" onclick="handleEdit(this.closest('tr'))">
                                    <i class="fas fa-edit"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</main>

<!-- Entry Modal -->
<div id="entryModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h3 class="modal-title">Stock Entry</h3>
            <button class="close-btn" onclick="closeModal('entryModal')">&times;</button>
        </div>
        <form id="entryForm">
            <div class="form-group">
                <label class="form-label">Quantity to Add</label>
                <input type="number" class="form-input" id="entryQuantity" min="1" required>
            </div>
            <div class="form-group">
                <label class="form-label">Comment (optional)</label>
                <input type="text" class="form-input" id="entryComment">
            </div>
            <div class="form-buttons">
                <button type="button" class="btn-secondary" onclick="closeModal('entryModal')">Cancel</button>
                <button type="submit" class="btn-primary">Confirm</button>
            </div>
        </form>
    </div>
</div>

<!-- Exit Modal -->
<div id="exitModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h3 class="modal-title">Stock Exit</h3>
            <button class="close-btn" onclick="closeModal('exitModal')">&times;</button>
        </div>
        <form id="exitForm">
            <div class="form-group">
                <label class="form-label">Quantity to Remove</label>
                <input type="number" class="form-input" id="exitQuantity" min="1" required>
            </div>
            <div class="form-group">
                <label class="form-label">Comment (optional)</label>
                <input type="text" class="form-input" id="exitComment">
            </div>
            <div class="form-buttons">
                <button type="button" class="btn-secondary" onclick="closeModal('exitModal')">Cancel</button>
                <button type="submit" class="btn-primary">Confirm</button>
            </div>
        </form>
    </div>
</div>

<!-- Edit Modal -->
<div id="editModal" class="modal">
    <div class="modal-content" style="max-height: 80vh; display: flex; flex-direction: column;">
        <div class="modal-header">
            <h3 class="modal-title">Edit Product</h3>
            <button class="close-btn" onclick="closeModal('editModal')">&times;</button>
        </div>
        <form id="editForm" style="flex: 1; overflow-y: auto; padding-bottom: 20px;">
            <div class="form-group">
                <label class="form-label">Product Name</label>
                <input type="text" class="form-input" id="editProductName" required>
            </div>
            <div class="form-group">
                <label class="form-label">Category</label>
                <select class="form-input" id="editProductCategory" required>
                    <?php
                    $categories = array_unique(array_column($products, 'categorie_nom'));
                    foreach ($categories as $category): ?>
                        <option value="<?php echo htmlspecialchars($category); ?>"><?php echo htmlspecialchars($category); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label class="form-label">Unit Price (TND)</label>
                <input type="number" class="form-input" id="editProductPrice" step="0.01" min="0" required>
            </div>
            <div class="form-group">
                <label class="form-label">Current Stock</label>
                <input type="number" class="form-input" id="editCurrentStock" min="0" required>
            </div>
            <div class="form-group">
                <label class="form-label">Minimum Stock Level</label>
                <input type="number" class="form-input" id="editMinStock" min="1" required>
            </div>
            <div class="form-group">
                <label class="form-label">Unit of Measure</label>
                <input type="text" class="form-input" id="editProductUnit" required>
            </div>
            <div class="form-group">
                <label class="form-label">Supplier</label>
                <input type="text" class="form-input" id="editProductSupplier" required>
            </div>
            <div class="form-buttons">
                <button type="button" class="btn-secondary" onclick="closeModal('editModal')">Cancel</button>
                <button type="submit" class="btn-primary">Save</button>
            </div>
        </form>
    </div>
</div>

<script>
    // Global variables
    let currentProductId = null;
    let currentProductRow = null;
    let allProducts = [];

    // Initialize products data
    function initializeProducts() {
        const rows = document.querySelectorAll('#productsTableBody tr');
        allProducts = Array.from(rows).map(row => {
            const price = parseFloat(row.cells[4].textContent);
            const currentStock = parseInt(row.cells[5].textContent);
            const minStock = parseInt(row.cells[6].textContent);
            const totalValue = price * currentStock;
            
            // Update total value column
            row.cells[9].textContent = totalValue.toFixed(2) + ' TND';
            
            let status;
            if (currentStock === 0) {
                status = 'out';
            } else if (currentStock < minStock) {
                status = 'low';
            } else if (currentStock >= minStock * 2) {
                status = 'high';
            } else {
                status = 'medium';
            }
            
            return {
                id: row.dataset.id,
                name: row.cells[1].textContent,
                category: row.cells[2].textContent,
                price: price,
                currentStock: currentStock,
                minStock: minStock,
                unit: row.cells[7].textContent,
                supplier: row.cells[8].textContent,
                status: status,
                element: row
            };
        });
    }

    function applyFilters() {
        const categoryFilter = document.getElementById('categoryFilter').value;
        const stockFilter = document.getElementById('stockFilter').value;
        const supplierFilter = document.getElementById('supplierFilter').value;
        const searchQuery = document.getElementById('productSearch').value.toLowerCase();

        allProducts.forEach(product => {
            const matchesCategory = categoryFilter === '' || 
                product.category === categoryFilter;
            
            const matchesStock = stockFilter === '' || 
                product.status === stockFilter;
            
            const matchesSupplier = supplierFilter === '' ||
                product.supplier === supplierFilter;
            
            const matchesSearch = searchQuery === '' || 
                product.name.toLowerCase().includes(searchQuery) ||
                product.category.toLowerCase().includes(searchQuery) ||
                product.id.toLowerCase().includes(searchQuery) ||
                product.supplier.toLowerCase().includes(searchQuery);
            
            if (matchesCategory && matchesStock && matchesSupplier && matchesSearch) {
                product.element.style.display = '';
            } else {
                product.element.style.display = 'none';
            }
        });
    }

    // Handle entry button click
    function handleEntry(row) {
        currentProductId = row.dataset.id;
        currentProductRow = row;
        document.getElementById('entryModal').style.display = 'block';
    }

    // Handle exit button click
    function handleExit(row) {
        currentProductId = row.dataset.id;
        currentProductRow = row;
        document.getElementById('exitModal').style.display = 'block';
    }

    // Handle edit button click
    function handleEdit(row) {
        currentProductId = row.dataset.id;
        currentProductRow = row;
        
        // Fill the form with current product data
        document.getElementById('editProductName').value = row.cells[1].textContent;
        document.getElementById('editProductCategory').value = row.cells[2].textContent;
        document.getElementById('editProductPrice').value = parseFloat(row.cells[4].textContent);
        document.getElementById('editCurrentStock').value = parseInt(row.cells[5].textContent);
        document.getElementById('editMinStock').value = parseInt(row.cells[6].textContent);
        document.getElementById('editProductUnit').value = row.cells[7].textContent;
        document.getElementById('editProductSupplier').value = row.cells[8].textContent;
        
        document.getElementById('editModal').style.display = 'block';
    }

    // Close modal
    function closeModal(modalId) {
        document.getElementById(modalId).style.display = 'none';
    }
    // Update row status based on stock
    function updateRowStatus(row) {
        const currentStock = parseInt(row.cells[5].textContent);
        const minStock = parseInt(row.cells[6].textContent);
        
        // Remove all status classes
        row.classList.remove('stock-out', 'stock-low', 'stock-normal');
        
        // Determine new status
        if (currentStock === 0) {
            row.classList.add('stock-out');
            // Disable exit button
            row.querySelector('.btn-exit').disabled = true;
        } else if (currentStock < minStock) {
            row.classList.add('stock-low');
            // Enable exit button
            row.querySelector('.btn-exit').disabled = false;
        } else {
            row.classList.add('stock-normal');
            // Enable exit button
            row.querySelector('.btn-exit').disabled = false;
        }
        
        // Update status badge
        const statusBadge = row.querySelector('.stock-badge');
        if (currentStock === 0) {
            statusBadge.className = 'stock-badge stock-out';
            statusBadge.textContent = 'Out';
        } else if (currentStock < minStock) {
            statusBadge.className = 'stock-badge stock-low';
            statusBadge.textContent = 'Low';
        } else if (currentStock >= minStock * 2) {
            statusBadge.className = 'stock-badge stock-high';
            statusBadge.textContent = 'High';
        } else {
            statusBadge.className = 'stock-badge stock-medium';
            statusBadge.textContent = 'Medium';
        }
    }

    // Show alert message
    function showAlert(message, type) {
        const alert = document.createElement('div');
        alert.className = `alert alert-${type}`;
        alert.textContent = message;
        
        // You can implement a proper notification system here
        console.log(message);
    }

    // Initialize on page load
    document.addEventListener('DOMContentLoaded', function() {
        initializeProducts();
        applyFilters();
    });
    // Add this to your existing JavaScript in stockroom.php

// Function to check for stock alerts and show notification
function checkStockAlerts() {
    const alertProducts = allProducts.filter(p => 
        p.status === 'out' || p.status === 'low'
    );
    
    if (alertProducts.length > 0) {
        const alertBtn = document.createElement('a');
        alertBtn.href = 'stockalerts.php';
        alertBtn.className = 'alert-btn';
        alertBtn.innerHTML = `
            <i class="fas fa-exclamation-triangle"></i>
            <span>${alertProducts.length} Alerts</span>
        `;
        
        // Add styles for the alert button
        const style = document.createElement('style');
        style.textContent = `
            .alert-btn {
                position: fixed;
                bottom: 30px;
                right: 30px;
                background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
                color: white;
                padding: 15px 25px;
                border-radius: 50px;
                font-weight: 600;
                text-decoration: none;
                box-shadow: 0 5px 20px rgba(220, 53, 69, 0.4);
                display: flex;
                align-items: center;
                gap: 10px;
                z-index: 1000;
                animation: pulse 2s infinite;
            }
            @keyframes pulse {
                0% { transform: scale(1); }
                50% { transform: scale(1.05); }
                100% { transform: scale(1); }
            }
        `;
        document.head.appendChild(style);
        document.body.appendChild(alertBtn);
    }
}

// Call this function after initializing products
document.addEventListener('DOMContentLoaded', function() {
    initializeProducts();
    applyFilters();
    checkStockAlerts();
    
    // Check if we need to highlight a product from an alert
    const urlParams = new URLSearchParams(window.location.search);
    const productId = urlParams.get('product_id');
    const alertType = urlParams.get('alert');
    
    if (productId && alertType) {
        const row = document.querySelector(`tr[data-id="${productId}"]`);
        if (row) {
            setTimeout(() => {
                row.scrollIntoView({ behavior: 'smooth', block: 'center' });
                row.style.animation = 'pulse 2s 3';
                
                // Remove the animation after it's done
                setTimeout(() => {
                    row.style.animation = '';
                }, 6000);
            }, 500);
        }
    }
});
// Add this to your existing JavaScript in stockroom.php
function handleTabChange() {
    const urlParams = new URLSearchParams(window.location.search);
    const tab = urlParams.get('tab');
    
    if (tab === 'history') {
        // Show history tab/modal if implemented
        console.log('Showing history tab');
    } else if (tab === 'edit') {
        // Show edit modal for the product
        const productId = urlParams.get('product_id');
        if (productId) {
            const row = document.querySelector(`tr[data-id="${productId}"]`);
            if (row) {
                handleEdit(row);
            }
        }
    }
}

// Call this in your DOMContentLoaded event
document.addEventListener('DOMContentLoaded', function() {
    initializeProducts();
    applyFilters();
    checkStockAlerts();
    handleTabChange();
});
// Entry form submission
document.getElementById('entryForm').addEventListener('submit', function(e) {
    e.preventDefault();

    const quantity = parseInt(document.getElementById('entryQuantity').value);

    fetch('update_stock.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: `id=${currentProductId}&action=entry&quantity=${quantity}`
    })
    .then(res => res.text())
    .then(response => {
        if (response.trim() === "success") {
            location.reload();
        } else {
            showAlert("Erreur lors de la sauvegarde", 'danger');
        }
    });
});

// Exit form submission
document.getElementById('exitForm').addEventListener('submit', function(e) {
    e.preventDefault();

    const quantity = parseInt(document.getElementById('exitQuantity').value);

    fetch('update_stock.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: `id=${currentProductId}&action=exit&quantity=${quantity}`
    })
    .then(res => res.text())
    .then(response => {
        if (response.trim() === "success") {
            location.reload();
        } else {
            showAlert("Erreur lors de la sauvegarde", 'danger');
        }
    });
});

// Edit form submission
document.getElementById('editForm').addEventListener('submit', function(e) {
    e.preventDefault();

    const name = document.getElementById('editProductName').value;
    const category = document.getElementById('editProductCategory').value;
    const price = document.getElementById('editProductPrice').value;
    const currentStock = document.getElementById('editCurrentStock').value;
    const minStock = document.getElementById('editMinStock').value;
    const unit = document.getElementById('editProductUnit').value;
    const supplier = document.getElementById('editProductSupplier').value;

    fetch('update_stock.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: `id=${currentProductId}&action=edit&name=${encodeURIComponent(name)}&category=${encodeURIComponent(category)}&price=${price}&currentStock=${currentStock}&minStock=${minStock}&unit=${encodeURIComponent(unit)}&supplier=${encodeURIComponent(supplier)}`
    })
    .then(res => res.text())
    .then(response => {
        if (response.trim() === "success") {
            location.reload();
        } else {
            showAlert("Erreur lors de la sauvegarde", 'danger');
        }
    });
});

</script>
