<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Category Management - CH OfficeTrack</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
        }

        .categories-container {
            margin-left: 280px;
            margin-top: 70px;
            padding: 40px 30px;
            min-height: calc(100vh - 70px);
        }

        .categories-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 40px;
            padding: 25px 0;
            border-bottom: 2px solid rgba(139, 0, 0, 0.1);
        }

        .categories-title {
            font-size: 32px;
            color: #333;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .categories-title i {
            color: #8b0000;
            font-size: 28px;
        }

        .header-actions {
            display: flex;
            gap: 15px;
            align-items: center;
        }

        .search-box {
            position: relative;
            display: flex;
            align-items: center;
        }

        .search-input {
            padding: 12px 45px 12px 15px;
            border: 2px solid #e9ecef;
            border-radius: 25px;
            font-size: 14px;
            width: 250px;
            transition: all 0.3s ease;
            background: white;
        }

        .search-input:focus {
            border-color: #8b0000;
            box-shadow: 0 0 0 4px rgba(139, 0, 0, 0.1);
            outline: none;
            width: 300px;
        }

        .search-icon {
            position: absolute;
            right: 15px;
            color: #6c757d;
            font-size: 16px;
        }

        .add-category-btn {
            background: linear-gradient(135deg, #8b0000 0%, #5a0000 100%);
            color: white;
            border: none;
            padding: 14px 28px;
            border-radius: 25px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 10px;
            box-shadow: 0 4px 15px rgba(139, 0, 0, 0.2);
            position: relative;
            overflow: hidden;
        }

        .add-category-btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: left 0.5s;
        }

        .add-category-btn:hover::before {
            left: 100%;
        }

        .add-category-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(139, 0, 0, 0.3);
        }

        .categories-stats {
            display: flex;
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: white;
            padding: 20px;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.08);
            flex: 1;
            display: flex;
            align-items: center;
            gap: 15px;
            transition: transform 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-3px);
        }

        .stat-icon {
            width: 50px;
            height: 50px;
            background: linear-gradient(135deg, #8b0000 0%, #5a0000 100%);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 18px;
        }

        .stat-info h3 {
            font-size: 24px;
            font-weight: 700;
            color: #333;
            margin-bottom: 5px;
        }

        .stat-info p {
            color: #6c757d;
            font-size: 14px;
        }

        .categories-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 25px;
        }

        .category-card {
            background: white;
            border-radius: 20px;
            padding: 30px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.08);
            transition: all 0.3s ease;
            cursor: pointer;
            border: 2px solid transparent;
            position: relative;
            overflow: hidden;
        }

        .category-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(135deg, #8b0000 0%, #5a0000 100%);
            transform: scaleX(0);
            transition: transform 0.3s ease;
        }

        .category-card:hover::before {
            transform: scaleX(1);
        }

        .category-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 15px 40px rgba(0,0,0,0.15);
            border-color: #8b0000;
        }

        .category-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 20px;
        }

        .category-icon {
            width: 70px;
            height: 70px;
            background: linear-gradient(135deg, #8b0000 0%, #5a0000 100%);
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 28px;
            color: white;
            box-shadow: 0 4px 15px rgba(139, 0, 0, 0.2);
        }

        .category-actions {
            display: flex;
            gap: 10px;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .category-card:hover .category-actions {
            opacity: 1;
        }

        .action-btn {
            width: 35px;
            height: 35px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 14px;
            transition: all 0.3s ease;
        }

        .edit-btn {
            background: #ffc107;
            color: white;
        }

        .edit-btn:hover {
            background: #e0a800;
            transform: scale(1.1);
        }

        .delete-btn {
            background: #dc3545;
            color: white;
        }

        .delete-btn:hover {
            background: #c82333;
            transform: scale(1.1);
        }

        .category-card h3 {
            font-size: 20px;
            font-weight: 600;
            margin-bottom: 10px;
            color: #333;
        }

        .category-card p {
            color: #6c757d;
            font-size: 14px;
            line-height: 1.6;
            margin-bottom: 15px;
        }

        .category-meta {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-top: 15px;
            border-top: 1px solid #e9ecef;
        }

        .product-count {
            font-size: 12px;
            color: #8b0000;
            font-weight: 600;
            background: rgba(139, 0, 0, 0.1);
            padding: 5px 10px;
            border-radius: 15px;
        }

        .category-tag {
            font-size: 12px;
            color: #6c757d;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        /* Modal Styles */
        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0,0,0,0.6);
            display: none;
            justify-content: center;
            align-items: center;
            z-index: 2000;
            backdrop-filter: blur(5px);
        }

        .modal-content {
            background: white;
            border-radius: 25px;
            padding: 40px;
            width: 90%;
            max-width: 550px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
            position: relative;
            transform: scale(0.9);
            opacity: 0;
            transition: all 0.3s ease;
        }

        .modal-overlay.active .modal-content {
            transform: scale(1);
            opacity: 1;
        }

        .close-modal {
            position: absolute;
            top: 25px;
            right: 25px;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: #f8f9fa;
            border: none;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            color: #6c757d;
            transition: all 0.3s ease;
        }

        .close-modal:hover {
            background: #e9ecef;
            transform: rotate(90deg);
        }

        .modal-title {
            font-size: 24px;
            margin-bottom: 30px;
            color: #333;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .modal-title i {
            color: #8b0000;
        }

        .form-group {
            margin-bottom: 25px;
        }

        .form-group label {
            display: block;
            margin-bottom: 10px;
            font-weight: 600;
            color: #333;
            font-size: 14px;
        }

        .form-control {
            width: 100%;
            padding: 15px 20px;
            border: 2px solid #e9ecef;
            border-radius: 15px;
            font-size: 14px;
            transition: all 0.3s ease;
            background: white;
        }

        .form-control:focus {
            border-color: #8b0000;
            box-shadow: 0 0 0 4px rgba(139, 0, 0, 0.1);
            outline: none;
        }

        .icon-preview {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-top: 10px;
        }

        .icon-preview-box {
            width: 50px;
            height: 50px;
            background: linear-gradient(135deg, #8b0000 0%, #5a0000 100%);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 20px;
        }

        .submit-btn {
            background: linear-gradient(135deg, #8b0000 0%, #5a0000 100%);
            color: white;
            border: none;
            padding: 15px 30px;
            border-radius: 15px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            width: 100%;
            margin-top: 20px;
            position: relative;
            overflow: hidden;
        }

        .submit-btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: left 0.5s;
        }

        .submit-btn:hover::before {
            left: 100%;
        }

        .submit-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(139, 0, 0, 0.3);
        }

        /* Animations */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .category-card {
            animation: fadeInUp 0.6s ease forwards;
        }

        .category-card:nth-child(1) { animation-delay: 0.1s; }
        .category-card:nth-child(2) { animation-delay: 0.2s; }
        .category-card:nth-child(3) { animation-delay: 0.3s; }
        .category-card:nth-child(4) { animation-delay: 0.4s; }
        .category-card:nth-child(5) { animation-delay: 0.5s; }

        /* Success Message */
        .success-message {
            position: fixed;
            top: 100px;
            right: 30px;
            background: #28a745;
            color: white;
            padding: 15px 25px;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(40, 167, 69, 0.3);
            transform: translateX(100%);
            transition: transform 0.3s ease;
            z-index: 3000;
        }

        .success-message.show {
            transform: translateX(0);
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .categories-container {
                margin-left: 0;
                padding: 20px 15px;
                margin-top: 60px;
            }
            
            .categories-header {
                flex-direction: column;
                gap: 20px;
                align-items: stretch;
            }
            
            .header-actions {
                flex-direction: column;
                gap: 15px;
            }
            
            .search-input {
                width: 100%;
            }
            
            .search-input:focus {
                width: 100%;
            }
            
            .categories-grid {
                grid-template-columns: 1fr;
            }
            
            .categories-stats {
                flex-direction: column;
            }
            
            .modal-content {
                padding: 25px;
                margin: 20px;
            }
        }
    </style>
</head>
<body>
<?php include "sys.php";?>
<?php 
// Connexion à la base de données
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ch office track";

try {
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Récupérer toutes les catégories
    $stmt = $pdo->query("SELECT c.*, COUNT(a.id_article) as product_count 
                         FROM categories c 
                         LEFT JOIN article a ON c.id_categorie = a.id_categorie 
                         GROUP BY c.id_categorie 
                         ORDER BY c.nom_categorie");
    $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Récupérer le nombre total de produits
    $stmt = $pdo->query("SELECT COUNT(*) as total FROM article");
    $totalProducts = $stmt->fetchColumn();
    
    // Récupérer le nombre total de catégories
    $totalCategories = count($categories);
    
} catch(PDOException $e) {
    die("Erreur de connexion: " . $e->getMessage());
}
?>

    <!-- Success Message -->
    <div class="success-message" id="successMessage">
        <i class="fas fa-check-circle"></i> Category added successfully!
    </div>

    <!-- Main Content -->
    <main class="categories-container">
        <div class="categories-header">
            <h1 class="categories-title">
                <i class="fas fa-tags"></i> Category Management
            </h1>
            <div class="header-actions">
                <div class="search-box">
                    <input type="text" class="search-input" placeholder="Search categories..." id="searchInput">
                    <i class="fas fa-search search-icon"></i>
                </div>
                <button class="add-category-btn" onclick="showAddCategoryModal()">
                    <i class="fas fa-plus"></i> Add Category
                </button>
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="categories-stats">
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-layer-group"></i>
                </div>
                <div class="stat-info">
                    <h3 id="totalCategories"><?php echo $totalCategories; ?></h3>
                    <p>Total Categories</p>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-box"></i>
                </div>
                <div class="stat-info">
                    <h3 id="totalProducts"><?php echo $totalProducts; ?></h3>
                    <p>Total Products</p>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-star"></i>
                </div>
                <div class="stat-info">
                    <h3 id="activeCategories"><?php echo $totalCategories; ?></h3>
                    <p>Active Categories</p>
                </div>
            </div>
        </div>
        
        <!-- Categories Grid -->
        <div class="categories-grid" id="categoriesGrid">
            <?php foreach($categories as $category): ?>
                <div class="category-card" data-category="<?php echo $category['id_categorie']; ?>" onclick="viewProductsByCategory(<?php echo $category['id_categorie']; ?>)">                <div class="category-header">
                    <div class="category-icon">
                        <i class="fas <?php echo htmlspecialchars($category['icon'] ?? 'fa-tag'); ?>"></i>
                    </div>
                    <div class="category-actions">
                        <button class="action-btn edit-btn" onclick="editCategory(<?php echo $category['id_categorie']; ?>)">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button class="action-btn delete-btn" onclick="deleteCategory(<?php echo $category['id_categorie']; ?>)">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </div>
                <h3><?php echo htmlspecialchars($category['nom_categorie']); ?></h3>
                <p><?php echo htmlspecialchars($category['description'] ?? 'No description'); ?></p>
                <div class="category-meta">
                    <span class="product-count"><?php echo $category['product_count']; ?> products</span>
                    <span class="category-tag">
                        <i class="fas fa-clock"></i> 
                        <?php echo isset($category['date_creation']) ? 'Created ' . date('M d, Y', strtotime($category['date_creation'])) : 'No date'; ?>
                    </span>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </main>

    <!-- Modal to add/edit category -->
    <div class="modal-overlay" id="categoryModal">
        <div class="modal-content">
            <button class="close-modal" onclick="hideAddCategoryModal()">
                <i class="fas fa-times"></i>
            </button>
            <h2 class="modal-title">
                <i class="fas fa-plus-circle"></i>
                <span id="modalTitle">Add New Category</span>
            </h2>
            <form id="addCategoryForm">
                <input type="hidden" id="categoryId">
                <div class="form-group">
                    <label for="categoryName">Category Name *</label>
                    <input type="text" id="categoryName" class="form-control" required placeholder="Enter category name">
                </div>
                <div class="form-group">
                    <label for="categoryDescription">Description</label>
                    <textarea id="categoryDescription" class="form-control" rows="3" placeholder="Enter category description"></textarea>
                </div>
                <div class="form-group">
                    <label for="categoryIcon">Icon (choose from Font Awesome)</label>
                    <select id="categoryIcon" class="form-control" onchange="updateIconPreview()">
                        <option value="fa-file-alt">📄 Stationery</option>
                        <option value="fa-laptop">💻 IT Equipment</option>
                        <option value="fa-chair">🪑 Furniture</option>
                        <option value="fa-print">🖨️ Printing</option>
                        <option value="fa-broom">🧹 Cleaning</option>
                        <option value="fa-pen">✏️ Pen</option>
                        <option value="fa-ruler">📏 Ruler</option>
                        <option value="fa-coffee">☕ Coffee</option>
                        <option value="fa-phone">📞 Phone</option>
                        <option value="fa-book">📚 Books</option>
                        <option value="fa-tools">🔧 Tools</option>
                        <option value="fa-lightbulb">💡 Lighting</option>
                    </select>
                    <div class="icon-preview">
                        <div class="icon-preview-box">
                            <i class="fas fa-file-alt" id="iconPreview"></i>
                        </div>
                        <span>Icon Preview</span>
                    </div>
                </div>
                <button type="submit" class="submit-btn">
                    <i class="fas fa-save"></i> Save Category
                </button>
            </form>
        </div>
    </div>

    <script>
        // Show add category modal
        function showAddCategoryModal() {
            document.getElementById('modalTitle').textContent = 'Add New Category';
            document.getElementById('addCategoryForm').reset();
            document.getElementById('categoryId').value = '';
            document.getElementById('iconPreview').className = 'fas fa-file-alt';
            document.getElementById('categoryModal').style.display = 'flex';
            setTimeout(() => {
                document.getElementById('categoryModal').classList.add('active');
            }, 10);
        }
        function viewProductsByCategory(categoryId) {
            window.location.href = `productlist.php?category_id=${categoryId}`;
        }

        // Edit category
        function editCategory(categoryId) {
            const categoryCard = document.querySelector(`[data-category="${categoryId}"]`);
            
            if (categoryCard) {
                document.getElementById('modalTitle').textContent = 'Edit Category';
                document.getElementById('categoryId').value = categoryId;
                document.getElementById('categoryName').value = categoryCard.querySelector('h3').textContent;
                document.getElementById('categoryDescription').value = categoryCard.querySelector('p').textContent;
                
                const icon = categoryCard.querySelector('.category-icon i').className;
                const iconValue = icon.replace('fas ', '');
                document.getElementById('categoryIcon').value = iconValue;
                updateIconPreview();
                
                showAddCategoryModal();
            }
        }

        // Delete category
        function deleteCategory(categoryId) {
            if (confirm('Are you sure you want to delete this category? Products in this category will not be deleted.')) {
                fetch('delete_category.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: `id=${categoryId}`
                })
                .then(response => response.json())
                .then(data => {
                    if(data.success) {
                        document.querySelector(`[data-category="${categoryId}"]`).remove();
                        showSuccessMessage(data.message);
                        // Update stats
                        document.getElementById('totalCategories').textContent = 
                            parseInt(document.getElementById('totalCategories').textContent) - 1;
                        document.getElementById('activeCategories').textContent = 
                            parseInt(document.getElementById('activeCategories').textContent) - 1;
                    } else {
                        alert('Error: ' + data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Error deleting category');
                });
            }
        }

        // Hide modal
        function hideAddCategoryModal() {
            document.getElementById('categoryModal').classList.remove('active');
            setTimeout(() => {
                document.getElementById('categoryModal').style.display = 'none';
            }, 300);
        }

        // Update icon preview
        function updateIconPreview() {
            const selectedIcon = document.getElementById('categoryIcon').value;
            document.getElementById('iconPreview').className = `fas ${selectedIcon}`;
        }

        // Show success message
        function showSuccessMessage(message) {
            const successMsg = document.getElementById('successMessage');
            successMsg.innerHTML = `<i class="fas fa-check-circle"></i> ${message}`;
            successMsg.classList.add('show');
            setTimeout(() => {
                successMsg.classList.remove('show');
            }, 3000);
        }

        // Setup search functionality
        function setupSearch() {
            const searchInput = document.getElementById('searchInput');
            let searchTimeout;

            searchInput.addEventListener('input', (e) => {
                clearTimeout(searchTimeout);
                searchTimeout = setTimeout(() => {
                    const searchTerm = e.target.value.toLowerCase().trim();
                    const categoryCards = document.querySelectorAll('.category-card');
                    
                    categoryCards.forEach(card => {
                        const name = card.querySelector('h3').textContent.toLowerCase();
                        const description = card.querySelector('p').textContent.toLowerCase();
                        
                        if (name.includes(searchTerm) || description.includes(searchTerm)) {
                            card.style.display = 'block';
                        } else {
                            card.style.display = 'none';
                        }
                    });
                }, 300);
            });
            
        }

        // Form handling
        document.getElementById('addCategoryForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const id = document.getElementById('categoryId').value;
            const name = document.getElementById('categoryName').value.trim();
            const description = document.getElementById('categoryDescription').value.trim();
            const icon = document.getElementById('categoryIcon').value;
            
            if (!name) {
                alert('Category name is required!');
                return;
            }

            const formData = new FormData();
            formData.append('name', name);
            formData.append('description', description);
            formData.append('icon', icon);
            
            let url = 'add_category.php';
            if (id) {
                url = 'update_category.php';
                formData.append('id', id);
            }
            
            fetch(url, {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if(data.success) {
                    showSuccessMessage(data.message);
                    setTimeout(() => {
                        location.reload();
                    }, 1500);
                } else {
                    alert('Error: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error saving category');
            });
        });

        function filterProducts() {
    const categoryId = parseInt(document.getElementById('categoryFilter').value);
    const sortBy = document.getElementById('sortFilter').value;
    const searchQuery = document.getElementById('searchFilter').value.toLowerCase();
    
    // Redirect with category filter
    if (categoryId > 0) {
        window.location.href = `productlist.php?category_id=${categoryId}`;
    } else {
        window.location.href = `productlist.php`;
    }
}
        // Close modal when clicking outside
        window.addEventListener('click', function(e) {
            if (e.target === document.getElementById('categoryModal')) {
                hideAddCategoryModal();
            }
        });

        // Initialize page
        document.addEventListener('DOMContentLoaded', function() {
            setupSearch();
        });
    </script>
</body>
</html>