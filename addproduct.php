<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product - CH OfficeTrack</title>
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
            outline: none;
        }

        .search-icon {
            position: absolute;
            left: 18px;
            top: 50%;
            transform: translateY(-50%);
            color: #6c757d;
            font-size: 14px;
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

        /* Form Grid */
        .form-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .form-group {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .form-group.full-width {
            grid-column: 1 / -1;
        }

        .form-label {
            font-weight: 500;
            color: #555;
            font-size: 14px;
        }

        .form-label .required {
            color: #dc3545;
            margin-left: 2px;
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
            margin-top: 30px;
        }

        .btn {
            padding: 12px 24px;
            border-radius: 12px;
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

        /* Form Help Text */
        .form-help {
            font-size: 12px;
            color: #6c757d;
            margin-top: 4px;
        }

        /* File Upload Styles */
        .file-upload {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 15px;
        }

        .file-upload-preview {
            width: 150px;
            height: 150px;
            border-radius: 12px;
            background-color: #f8f9fa;
            border: 2px dashed #e9ecef;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            position: relative;
            transition: all 0.3s ease;
        }

        .file-upload-preview:hover {
            border-color: #8b0000;
            background-color: #fff;
        }

        .file-upload-preview img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: none;
        }

        .file-upload-preview i {
            font-size: 40px;
            color: #6c757d;
            margin-bottom: 10px;
        }

        .file-upload-preview .preview-text {
            font-size: 12px;
            color: #6c757d;
            text-align: center;
        }

        .file-upload-label {
            padding: 10px 20px;
            background: linear-gradient(135deg, #8b0000 0%, #5a0000 100%);
            color: white;
            border-radius: 12px;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 14px;
            box-shadow: 0 4px 15px rgba(139, 0, 0, 0.2);
        }

        .file-upload-label:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(139, 0, 0, 0.3);
        }

        .file-upload-input {
            display: none;
        }

        .file-upload-info {
            font-size: 12px;
            color: #6c757d;
            margin-top: 5px;
        }

        /* Total Amount Display */
        .total-display {
            background: linear-gradient(135deg, #8b0000 0%, #5a0000 100%);
            color: white;
            padding: 20px;
            border-radius: 12px;
            margin-top: 20px;
            text-align: center;
        }

        .total-label {
            font-size: 14px;
            font-weight: 500;
            margin-bottom: 8px;
        }

        .total-amount {
            font-size: 24px;
            font-weight: 700;
            margin-bottom: 8px;
        }

        .total-formula {
            font-size: 12px;
            opacity: 0.8;
        }

        /* Alert messages */
        .alert {
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 12px;
            font-size: 14px;
        }

        .alert-success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .alert-error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
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
            
            .form-grid {
                grid-template-columns: 1fr;
            }
            
            .form-buttons {
                justify-content: center;
            }

            .file-upload-preview {
                width: 120px;
                height: 120px;
            }
        }
    </style>
</head>
<body>
    <?php 
    // Include database connection
    include 'db.php';
    include 'article.php';
    
    // Include sidebar (if sys.php contains sidebar)
    if (file_exists('sys.php')) {
        include 'sys.php'; 
    }
    ?>
   
    <!-- Top Navigation -->
    <nav class="top-navbar">
        <div class="navbar-left">
            <div class="search-container">
                <i class="fas fa-search search-icon"></i>
                <input type="text" class="search-input" placeholder="Search for a product...">
            </div>
        </div>
        <div class="navbar-right">
            <i class="fas fa-bell" style="font-size: 18px; color: #6c757d;"></i>
            <i class="fas fa-user-circle" style="font-size: 18px; color: #6c757d;"></i>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="main-content">
        <!-- Form Section -->
        <section class="form-section">
            <h2 class="section-title"><i class="fas fa-box-open"></i> Add New Product</h2>
            
            <?php if (isset($_GET['success']) && $_GET['success'] == 1): ?>
                <div class="alert alert-success">
                    Product added successfully!
                </div>
            <?php elseif (isset($_GET['error'])): ?>
                <div class="alert alert-error">
                    <?php echo htmlspecialchars($_GET['error']); ?>
                </div>
            <?php endif; ?>
            
            <form id="add-product-form" action="process_product.php" method="POST" enctype="multipart/form-data">
                <div class="form-grid">
                    <!-- Product Name -->
                    <div class="form-group">
                        <label class="form-label">Product Name <span class="required">*</span></label>
                        <input type="text" name="nom" class="form-input" placeholder="Product name" required>
                        <span class="form-help">Enter product name</span>
                    </div>
                    
                    <!-- Description -->
                    <div class="form-group">
                        <label class="form-label">Description</label>
                        <textarea name="description" class="form-textarea" placeholder="Product description"></textarea>
                        <span class="form-help">Detailed product description</span>
                    </div>
                    
                    <!-- Brand -->
                    <div class="form-group">
                        <label class="form-label">Brand</label>
                        <input type="text" name="marque" class="form-input" placeholder="Product brand">
                        <span class="form-help">Manufacturer or brand</span>
                    </div>
                    
                    <!-- Category -->
                    <div class="form-group">
                        <label class="form-label">Category <span class="required">*</span></label>
                        <select name="id_categorie" class="form-select" required>
                            <option value="">Select a category</option>
                            <?php
                            try {
                                $stmt = $pdo->query("SELECT id_categorie, nom_categorie FROM categories ORDER BY nom_categorie");
                                $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                
                                foreach($categories as $category) {
                                    echo '<option value="'.$category['id_categorie'].'">'.htmlspecialchars($category['nom_categorie']).'</option>';
                                }
                            } catch(PDOException $e) {
                                echo '<option value="">Error loading categories</option>';
                            }
                            ?>
                        </select>
                        <span class="form-help">Product category</span>
                    </div>
                    
                    <!-- Import Date -->
                    <div class="form-group">
                        <label class="form-label">Import Date <span class="required">*</span></label>
                        <input type="datetime-local" name="date_importation" class="form-input" required>
                        <span class="form-help">Product import date</span>
                    </div>
                    
                    <!-- Supplier -->
                    <div class="form-group">
                        <label class="form-label">Supplier <span class="required">*</span></label>
                        <input type="text" name="fournisseur" class="form-input" placeholder="Supplier name" required>
                        <span class="form-help">Product supplier</span>
                    </div>
                    
                    <!-- Unit -->
                    <div class="form-group">
                        <label class="form-label">Unit <span class="required">*</span></label>
                        <select name="unit" class="form-select" required>
                            <option value="">Select unit</option>
                            <option value="piece">Piece</option>
                            <option value="set">Set</option>
                            <option value="pack">Pack</option>
                        </select>
                        <span class="form-help">Unit of measurement</span>
                    </div>
                    
                    <!-- Minimum Threshold -->
                    <div class="form-group">
                        <label class="form-label">Minimum Threshold <span class="required">*</span></label>
                        <input type="number" name="seuil_min" class="form-input" placeholder="0" min="0" required>
                        <span class="form-help">Alert threshold</span>
                    </div>
                    
                    <!-- Purchase Price -->
                    <div class="form-group">
                        <label class="form-label">Purchase Price (TND) <span class="required">*</span></label>
                        <input type="number" name="prix_unitaire" class="form-input" placeholder="0.00" step="0.01" min="0" required>
                        <span class="form-help">Unit purchase price</span>
                    </div>
                    
                    <!-- Quantity -->
                    <div class="form-group">
                        <label class="form-label">Quantity <span class="required">*</span></label>
                        <input type="number" name="stock_actuel" class="form-input" placeholder="0" min="1" required>
                        <span class="form-help">Current stock quantity</span>
                    </div>
                    
                    <!-- Product Image -->
                    <div class="form-group full-width">
                        <label class="form-label">Product Image</label>
                        <div class="file-upload">
                            <div class="file-upload-preview">
                                <i class="fas fa-box-open"></i>
                                <span class="preview-text">No image selected</span>
                                <img id="image-preview" src="#" alt="Preview">
                            </div>
                            <label for="product_image" class="file-upload-label">
                                <i class="fas fa-upload"></i> Choose Image
                            </label>
                            <input type="file" id="product_image" name="product_image" class="file-upload-input" accept="image/*">
                            <span class="file-upload-info">Max size: 5MB (JPEG, PNG, GIF)</span>
                        </div>
                    </div>
                    
                    <!-- Automatic Total -->
                    <div class="form-group full-width">
                        <div class="total-display">
                            <div class="total-label">Purchase Total</div>
                            <div class="total-amount" id="total-amount">0.00 TND</div>
                            <div class="total-formula">Purchase Price × Quantity</div>
                        </div>
                    </div>
                </div>
                
                <div class="form-buttons">
                    <button type="button" class="btn btn-secondary" onclick="resetForm()">
                        <i class="fas fa-times"></i> Cancel
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Add Product
                    </button>
                </div>
            </form>
        </section>
    </main>

    <script>
        // Calcul automatique du total
        function calculateTotal() {
            const prixAchat = parseFloat(document.querySelector('input[name="prix_unitaire"]').value) || 0;
            const quantite = parseInt(document.querySelector('input[name="stock_actuel"]').value) || 0;
            const total = prixAchat * quantite;
            
            document.getElementById('total-amount').textContent = total.toFixed(2) + ' TND';
        }

        // Écouter les changements des champs prix et quantité
        document.querySelector('input[name="prix_unitaire"]').addEventListener('input', calculateTotal);
        document.querySelector('input[name="stock_actuel"]').addEventListener('input', calculateTotal);

        // Initialiser la date d'importation avec la date actuelle
        document.addEventListener('DOMContentLoaded', function() {
            const now = new Date();
            const formattedDate = now.getFullYear() + '-' + 
                String(now.getMonth() + 1).padStart(2, '0') + '-' + 
                String(now.getDate()).padStart(2, '0') + 'T' + 
                String(now.getHours()).padStart(2, '0') + ':' + 
                String(now.getMinutes()).padStart(2, '0');
            
            document.querySelector('input[name="date_importation"]').value = formattedDate;
            
            // Calculer le total initial
            calculateTotal();
        });

        // Aperçu de l'image
        document.getElementById('product_image').addEventListener('change', function(e) {
            const file = e.target.files[0];
            const preview = document.getElementById('image-preview');
            const previewContainer = document.querySelector('.file-upload-preview');
            const icon = previewContainer.querySelector('i');
            const text = previewContainer.querySelector('.preview-text');

            if (file) {
                const reader = new FileReader();
                
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.style.display = 'block';
                    icon.style.display = 'none';
                    text.style.display = 'none';
                }
                
                reader.readAsDataURL(file);
            } else {
                preview.src = '#';
                preview.style.display = 'none';
                icon.style.display = 'block';
                text.style.display = 'block';
            }
        });

        // Reset form function
        function resetForm() {
            document.getElementById('add-product-form').reset();
            document.getElementById('total-amount').textContent = '0.00 TND';
            
            // Reset image preview
            const preview = document.getElementById('image-preview');
            const previewContainer = document.querySelector('.file-upload-preview');
            const icon = previewContainer.querySelector('i');
            const text = previewContainer.querySelector('.preview-text');
            
            preview.src = '#';
            preview.style.display = 'none';
            icon.style.display = 'block';
            text.style.display = 'block';
            
            // Reset date
            const now = new Date();
            const formattedDate = now.getFullYear() + '-' + 
                String(now.getMonth() + 1).padStart(2, '0') + '-' + 
                String(now.getDate()).padStart(2, '0') + 'T' + 
                String(now.getHours()).padStart(2, '0') + ':' + 
                String(now.getMinutes()).padStart(2, '0');
            
            document.querySelector('input[name="date_importation"]').value = formattedDate;
        }
    </script>
</body>
</html>