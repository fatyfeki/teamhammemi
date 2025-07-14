<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ch office track";

try {
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Ajouter une nouvelle catégorie
    if (isset($_POST['add_category'])) {
        $categoryName = trim($_POST['category_name']);
        
        if (!empty($categoryName)) {
            // Vérifier si la catégorie existe déjà
            $stmt = $pdo->prepare("SELECT COUNT(*) FROM categories WHERE nom_categorie = ?");
            $stmt->execute([$categoryName]);
            $count = $stmt->fetchColumn();
            
            if ($count == 0) {
                $stmt = $pdo->prepare("INSERT INTO categories (nom_categorie) VALUES (?)");
                $stmt->execute([$categoryName]);
                
                header("Location: manage_categories.php?success=1");
                exit;
            } else {
                header("Location: manage_categories.php?error=Category+already+exists");
                exit;
            }
        }
    }
    
    // Supprimer une catégorie
    if (isset($_GET['delete_category'])) {
        $id = intval($_GET['delete_category']);
        
        // Vérifier s'il y a des produits dans cette catégorie
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM article WHERE id_categorie = ?");
        $stmt->execute([$id]);
        $productCount = $stmt->fetchColumn();
        
        if ($productCount > 0) {
            header("Location: manage_categories.php?error=Cannot+delete+category+with+products");
            exit;
        }
        
        $stmt = $pdo->prepare("DELETE FROM categories WHERE id_categorie = ?");
        $stmt->execute([$id]);
        
        header("Location: manage_categories.php?success=2");
        exit;
    }
    
    // Récupérer toutes les catégories
    $stmt = $pdo->query("SELECT id_categorie, nom_categorie FROM categories ORDER BY nom_categorie");
    $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
} catch(PDOException $e) {
    die("Error: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Manage Categories</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        /* Conserver le style existant de addproduct.php */
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
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }
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
        .alert-danger {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-control {
            width: 100%;
            padding: 12px 16px;
            border: 2px solid #e9ecef;
            border-radius: 12px;
            font-size: 14px;
            transition: all 0.3s ease;
            background: #f8f9fa;
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
        .btn-danger {
            background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
            color: white;
            box-shadow: 0 4px 15px rgba(220, 53, 69, 0.2);
        }
        .list-group {
            list-style: none;
        }
        .list-group-item {
            padding: 15px;
            border: 1px solid #e9ecef;
            margin-bottom: 10px;
            border-radius: 12px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .row {
            display: flex;
            flex-wrap: wrap;
            margin: 0 -15px;
        }
        .col-md-6 {
            flex: 0 0 50%;
            max-width: 50%;
            padding: 0 15px;
        }
    </style>
</head>
<body>
<?php include 'sys.php'; ?>
    
    <div class="container">
        <h2>Manage Categories</h2>
        
        <?php if (isset($_GET['success'])): ?>
            <div class="alert alert-success">
                <?php 
                if ($_GET['success'] == 1) echo "Category added successfully!";
                elseif ($_GET['success'] == 2) echo "Category deleted successfully!";
                ?>
            </div>
        <?php endif; ?>
        
        <?php if (isset($_GET['error'])): ?>
            <div class="alert alert-danger">
                <?php echo htmlspecialchars(str_replace('+', ' ', $_GET['error'])); ?>
            </div>
        <?php endif; ?>
        
        <div class="row">
            <div class="col-md-6">
                <h3>Add New Category</h3>
                <form method="POST">
                    <div class="form-group">
                        <label>Category Name</label>
                        <input type="text" name="category_name" class="form-control" required>
                    </div>
                    <button type="submit" name="add_category" class="btn btn-primary">Add Category</button>
                </form>
            </div>
            
            <div class="col-md-6">
                <h3>Existing Categories</h3>
                <ul class="list-group">
                    <?php foreach($categories as $category): ?>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span><?php echo htmlspecialchars($category['nom_categorie']); ?></span>
                            <span>
                                <a href="?delete_category=<?php echo $category['id_categorie']; ?>" 
                                   class="btn btn-danger" 
                                   onclick="return confirm('Are you sure you want to delete this category?')">
                                    <i class="fas fa-trash"></i> Delete
                                </a>
                            </span>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </div>
</body>
</html>