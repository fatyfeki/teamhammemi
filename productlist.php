<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product List - CH OfficeTrack</title>
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

        /* Icons */
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

        /* Animations */
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

        /* Scrollbar */
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

        /* Product List Section */
        .product-section {
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
            display: flex;
            align-items: center;
            justify-content: space-between;
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

        .section-actions {
            display: flex;
            gap: 10px;
        }

        .btn {
            padding: 8px 16px;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
            border: none;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
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

        /* Product Table */
        .product-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .product-table th,
        .product-table td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #e9ecef;
        }

        .product-table th {
            background: #f8f9fa;
            font-weight: 600;
            color: #333;
            position: sticky;
            top: 0;
            z-index: 10;
        }

        .product-table tr:hover {
            background: #f8f9fa;
        }

        .product-image {
            width: 50px;
            height: 50px;
            border-radius: 8px;
            object-fit: cover;
            border: 1px solid #e9ecef;
        }

        .product-name {
            font-weight: 600;
            color: #333;
            margin-bottom: 4px;
        }

        .product-description {
            color: #6c757d;
            font-size: 13px;
        }

        .action-buttons {
            display: flex;
            gap: 8px;
        }

        .btn-action {
            padding: 6px 12px;
            border-radius: 6px;
            font-size: 12px;
            border: none;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .btn-edit {
            background: #17a2b8;
            color: white;
        }

        .btn-edit:hover {
            background: #138496;
        }

        .btn-delete {
            background: #dc3545;
            color: white;
        }

        .btn-delete:hover {
            background: #c82333;
        }

        .btn-view {
            background: #28a745;
            color: white;
        }

        .btn-view:hover {
            background: #218838;
        }

        /* Filters */
        .filters {
            display: flex;
            gap: 15px;
            margin-bottom: 20px;
            flex-wrap: wrap;
        }

        .filter-select {
            padding: 8px 12px;
            border: 1px solid #e9ecef;
            border-radius: 8px;
            font-size: 14px;
            background: white;
            min-width: 150px;
        }

        .filter-select:focus {
            border-color: #8b0000;
            outline: none;
        }

        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: #6c757d;
        }

        .empty-state i {
            font-size: 48px;
            margin-bottom: 20px;
            color: #dee2e6;
        }

        .empty-state h3 {
            margin-bottom: 10px;
            color: #495057;
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
            
            .product-table {
                font-size: 12px;
            }
            
            .product-table th,
            .product-table td {
                padding: 10px 8px;
            }
            
            .filters {
                flex-direction: column;
            }
            
            .filter-select {
                width: 100%;
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
    include 'db.php';
    include 'sys.php';

    try {
        // Get filters from URL
        $categoryFilter = isset($_GET['category_id']) ? intval($_GET['category_id']) : 0;
        $searchQuery = isset($_GET['search']) ? $_GET['search'] : '';
        $sortBy = isset($_GET['sort']) ? $_GET['sort'] : 'newest';

        // Base SQL query with correct column names
        $sql = "SELECT 
                    a.id_article, a.nom, a.description, a.marque, c.nom_categorie as categorie, 
                    a.date_importation, a.fournisseur, a.unit, 
                    a.seuil_min, a.current_stock as stock_actuel, 
                    a.prix_unitaire as prix_achat, 
                    (a.prix_unitaire * a.current_stock) as totale_achat, 
                    a.image, a.id_categorie
                FROM article a
                LEFT JOIN categories c ON a.id_categorie = c.id_categorie";
        
        // Add WHERE clauses based on filters
        $whereClauses = [];
        $params = [];
        
        if ($categoryFilter > 0) {
            $whereClauses[] = "a.id_categorie = :category_id";
            $params[':category_id'] = $categoryFilter;
        }
        
        if (!empty($searchQuery)) {
            $whereClauses[] = "(a.nom LIKE :search OR a.description LIKE :search OR a.marque LIKE :search OR a.fournisseur LIKE :search)";
            $params[':search'] = '%' . $searchQuery . '%';
        }
        
        if (!empty($whereClauses)) {
            $sql .= " WHERE " . implode(" AND ", $whereClauses);
        }
        
        // Add ORDER BY based on sort
        switch ($sortBy) {
            case 'oldest':
                $sql .= " ORDER BY a.date_importation ASC";
                break;
            case 'name_asc':
                $sql .= " ORDER BY a.nom ASC";
                break;
            case 'name_desc':
                $sql .= " ORDER BY a.nom DESC";
                break;
            case 'price_asc':
                $sql .= " ORDER BY a.prix_unitaire ASC";
                break;
            case 'price_desc':
                $sql .= " ORDER BY a.prix_unitaire DESC";
                break;
            default: // 'newest'
                $sql .= " ORDER BY a.date_importation DESC";
        }

        $stmt = $pdo->prepare($sql);
        
        foreach ($params as $key => $value) {
            $stmt->bindValue($key, $value);
        }
        
        $stmt->execute();
        $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        // Get categories for filter dropdown
        $stmt = $pdo->query("SELECT id_categorie, nom_categorie FROM categories ORDER BY nom_categorie");
        $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
    } catch(PDOException $e) {
        echo "<div class='alert alert-error'>Connection error: " . $e->getMessage() . "</div>";
        $products = [];
        $categories = [];
    }
    ?>

    <!-- Main Content -->
    <main class="main-content">
        <!-- Product List Section -->
        <section class="product-section">
            <h2 class="section-title">
                <span><i class="fas fa-boxes"></i> Product List</span>
                <div class="section-actions">
                    <a href="addproduct.php" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Add Product
                    </a>
                    <button class="btn btn-secondary" onclick="exportProducts()">
                        <i class="fas fa-download"></i> Export
                    </button>
                </div>
            </h2>
            
            <!-- Filters -->
            <div class="filters">
                <select class="filter-select" id="categoryFilter" onchange="filterProducts()">
                    <option value="">All Categories</option>
                    <?php foreach($categories as $category): ?>
                        <option value="<?php echo $category['id_categorie']; ?>" 
                            <?php echo $categoryFilter == $category['id_categorie'] ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($category['nom_categorie']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                
                <select class="filter-select" id="sortFilter" onchange="filterProducts()">
                    <option value="newest" <?php echo $sortBy == 'newest' ? 'selected' : ''; ?>>Newest</option>
                    <option value="oldest" <?php echo $sortBy == 'oldest' ? 'selected' : ''; ?>>Oldest</option>
                    <option value="name_asc" <?php echo $sortBy == 'name_asc' ? 'selected' : ''; ?>>Name (A-Z)</option>
                    <option value="name_desc" <?php echo $sortBy == 'name_desc' ? 'selected' : ''; ?>>Name (Z-A)</option>
                    <option value="price_asc" <?php echo $sortBy == 'price_asc' ? 'selected' : ''; ?>>Price (Low to High)</option>
                    <option value="price_desc" <?php echo $sortBy == 'price_desc' ? 'selected' : ''; ?>>Price (High to Low)</option>
                </select>
                
                <input type="text" class="filter-select" id="searchFilter" placeholder="Search..." 
                    value="<?php echo htmlspecialchars($searchQuery); ?>" onkeyup="filterProducts()">
            </div>
            
            <?php if(empty($products)): ?>
                <div class="empty-state">
                    <i class="fas fa-box-open"></i>
                    <h3>No Products Found</h3>
                    <p>No products match your search criteria.</p>
                    <a href="productlist.php" class="btn btn-primary" style="margin-top: 15px;">
                        <i class="fas fa-sync-alt"></i> Reset Filters
                    </a>
                </div>
            <?php else: ?>
                <!-- Product Table -->
                <div style="overflow-x: auto;">
                    <table class="product-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Product</th>
                                <th>Category</th>
                                <th>Brand</th>
                                <th>Supplier</th>
                                <th>Unit</th>
                                <th>Stock</th>
                                <th>Unit Price</th>
                                <th>Total</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($products as $product): ?>
                                <tr data-category-id="<?php echo $product['id_categorie'] ?? ''; ?>">
                                    <td><?php echo htmlspecialchars($product['id_article']); ?></td>
                                    <td>
                                        <div class="product-name">
                                            <?php if($product['image']): ?>
                                                <img src="<?php echo htmlspecialchars($product['image']); ?>" class="product-image" alt="<?php echo htmlspecialchars($product['nom']); ?>">
                                            <?php endif; ?>
                                            <?php echo htmlspecialchars($product['nom']); ?>
                                        </div>
                                        <div class="product-description"><?php echo htmlspecialchars(substr($product['description'], 0, 50)); ?>...</div>
                                    </td>
                                    <td><?php echo htmlspecialchars($product['categorie'] ?? 'N/A'); ?></td>
                                    <td><?php echo htmlspecialchars($product['marque'] ?? 'N/A'); ?></td>
                                    <td><?php echo htmlspecialchars($product['fournisseur'] ?? 'N/A'); ?></td>
                                    <td><?php echo htmlspecialchars($product['unit'] ?? 'N/A'); ?></td>
                                    <td><?php echo htmlspecialchars($product['stock_actuel'] ?? 0); ?></td>
                                    <td><?php echo number_format($product['prix_achat'] ?? 0, 2) . ' TND'; ?></td>
                                    <td><?php echo number_format($product['totale_achat'] ?? 0, 2) . ' TND'; ?></td>
                                    <td>
                                        <div class="action-buttons">
                                            <button class="btn-action btn-view" onclick="viewProduct(<?php echo $product['id_article']; ?>)">
                                                <i class="fas fa-eye"></i> View
                                            </button>
                                            <button class="btn-action btn-edit" onclick="editProduct(<?php echo $product['id_article']; ?>)">
                                                <i class="fas fa-edit"></i> Edit
                                            </button>
                                            <button class="btn-action btn-delete" onclick="deleteProduct(<?php echo $product['id_article']; ?>)">
                                                <i class="fas fa-trash"></i> Delete
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                
                <!-- Pagination -->
                <div class="pagination" style="margin-top: 20px; display: flex; justify-content: center;">
                    <button class="btn btn-secondary" style="margin-right: 10px;">
                        <i class="fas fa-chevron-left"></i> Previous
                    </button>
                    <span style="padding: 8px 16px; background: #f8f9fa; border-radius: 8px; margin: 0 5px;">
                        Page 1
                    </span>
                    <button class="btn btn-secondary" style="margin-left: 10px;">
                        Next <i class="fas fa-chevron-right"></i>
                    </button>
                </div>
            <?php endif; ?>
        </section>
    </main>

    <script>
        function filterProducts() {
            const categoryId = document.getElementById('categoryFilter').value;
            const sortBy = document.getElementById('sortFilter').value;
            const searchQuery = document.getElementById('searchFilter').value;
            
            // Build URL with all filters
            let url = 'productlist.php?';
            if (categoryId) url += `category_id=${categoryId}&`;
            if (sortBy !== 'newest') url += `sort=${sortBy}&`;
            if (searchQuery) url += `search=${encodeURIComponent(searchQuery)}`;
            
            // Remove trailing & or ? if no parameters
            if (url.endsWith('&') || url.endsWith('?')) {
                url = url.slice(0, -1);
            }
            
            window.location.href = url;
        }
        
        function viewProduct(id) {
            window.location.href = `viewproduct.php?id=${id}`;
        }

        function editProduct(id) {
            window.location.href = `editproduct.php?id=${id}`;
        }

        function deleteProduct(id) {
            if(confirm('Are you sure you want to delete this product?')) {
                fetch('deleteproduct.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({ id: id })
                })
                .then(response => response.json())
                .then(data => {
                    if(data.success) {
                        alert('Product deleted successfully!');
                        location.reload();
                    } else {
                        alert('Error: ' + data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Error deleting product');
                });
            }
        }

       function exportProducts() {
    // Get current date and time
    const now = new Date();
    const dateStr = now.toLocaleDateString();
    const timeStr = now.toLocaleTimeString();
    
    // Clone the table to avoid modifying the original
    const tableClone = document.querySelector('.product-table').cloneNode(true);
    
    // Remove the Actions column (last column)
    const rows = tableClone.querySelectorAll('tr');
    rows.forEach(row => {
        const cells = row.querySelectorAll('th, td');
        if (cells.length > 0) { // Make sure row has cells
            // Remove last cell (Actions column)
            row.removeChild(cells[cells.length - 1]);
        }
    });
    
    // Create HTML content with beautiful styling
    const style = `
        <style>
            body {
                font-family: 'Arial', sans-serif;
                color: #333;
                line-height: 1.6;
                padding: 20px;
            }
            .header {
                text-align: center;
                margin-bottom: 30px;
                border-bottom: 2px solid #8b0000;
                padding-bottom: 20px;
            }
            .title {
                color: #8b0000;
                font-size: 24px;
                font-weight: bold;
                margin-bottom: 5px;
            }
            .subtitle {
                color: #666;
                font-size: 14px;
                margin-bottom: 10px;
            }
            .meta {
                font-size: 12px;
                color: #888;
                margin-bottom: 20px;
            }
            table {
                width: 100%;
                border-collapse: collapse;
                margin: 25px 0;
                font-size: 14px;
                box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            }
            thead tr {
                background: linear-gradient(135deg, #8b0000 0%, #5a0000 100%);
                color: #ffffff;
                text-align: left;
                font-weight: bold;
            }
            th, td {
                padding: 12px 15px;
                border: 1px solid #e0e0e0;
            }
            tbody tr {
                border-bottom: 1px solid #e0e0e0;
            }
            tbody tr:nth-child(even) {
                background-color: #f9f9f9;
            }
            tbody tr:last-of-type {
                border-bottom: 2px solid #8b0000;
            }
            tbody tr:hover {
                background-color: #f1f1f1;
            }
            .product-info {
                display: flex;
                align-items: center;
            }
            .product-image {
                width: 50px;
                height: 50px;
                border-radius: 8px;
                object-fit: cover;
                margin-right: 15px;
                border: 1px solid #e0e0e0;
            }
            .product-details {
                display: flex;
                flex-direction: column;
            }
            .product-name {
                font-weight: bold;
                margin-bottom: 5px;
            }
            .product-description {
                font-size: 12px;
                color: #666;
            }
            .price-high {
                color: #c62828;
                font-weight: bold;
            }
            .price-medium {
                color: #f57c00;
                font-weight: bold;
            }
            .price-low {
                color: #2e7d32;
                font-weight: bold;
            }
            .category-badge {
                display: inline-block;
                padding: 5px 10px;
                border-radius: 4px;
                font-size: 12px;
                font-weight: bold;
                color: white;
                text-transform: uppercase;
                letter-spacing: 0.5px;
                background: #607d8b;
            }
            .footer {
                text-align: center;
                margin-top: 30px;
                padding-top: 20px;
                border-top: 1px solid #e0e0e0;
                font-size: 12px;
                color: #888;
            }
        </style>
    `;
    
    const htmlContent = `
        <html>
            <head>
                <title>Products List Export - CH OfficeTrack</title>
                ${style}
            </head>
            <body>
                <div class="header">
                    <div class="title">CH OfficeTrack - Products Inventory</div>
                    <div class="subtitle">Product Management System</div>
                    <div class="meta">Generated on ${dateStr} at ${timeStr}</div>
                </div>
                
                ${tableClone.outerHTML}
                
                <div class="footer">
                    <p>© ${now.getFullYear()} CH OfficeTrack - Confidential</p>
                </div>
            </body>
        </html>
    `;
    
    // Open a new window with the content
    const printWindow = window.open('', '_blank');
    printWindow.document.open();
    printWindow.document.write(htmlContent);
    printWindow.document.close();
    
    // Wait for content to load then print
    printWindow.onload = function() {
        setTimeout(() => {
            printWindow.print();
        }, 500);
    };
}
    </script>
</body>
</html>