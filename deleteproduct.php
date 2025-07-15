<?php
header('Content-Type: application/json');

// Inclure la configuration de la base de données
include 'db.php';

$data = json_decode(file_get_contents('php://input'), true);
$id = $data['id'] ?? null;
$type = $data['type'] ?? 'product'; // 'product' ou 'category'

if (!$id) {
    echo json_encode(['success' => false, 'message' => 'ID is required']);
    exit;
}

try {
    $pdo->beginTransaction();
    
    if ($type === 'product') {
        // Suppression d'un produit
        $stmt = $pdo->prepare("SELECT image, nom, description FROM article WHERE id_article = ?");
        $stmt->execute([$id]);
        $product = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if (!$product) {
            $pdo->rollBack();
            echo json_encode(['success' => false, 'message' => 'Product not found']);
            exit;
        }
        
        // Supprimer l'image associée si elle existe
        if (!empty($product['image'])) {
            $imagePath = 'uploads/' . basename($product['image']);
            if (file_exists($imagePath) && is_writable($imagePath)) {
                unlink($imagePath);
            }
        }
        
        // Supprimer le produit
        $stmt = $pdo->prepare("DELETE FROM article WHERE id_article = ?");
        $stmt->execute([$id]);
        
        echo json_encode([
            'success' => true, 
            'message' => 'Product deleted successfully',
            'product_name' => $product['nom'],
            'description' => $product['description']
        ]);
        
    } elseif ($type === 'category') {
        // Suppression d'une catégorie
        $stmt = $pdo->prepare("SELECT nom_categorie FROM categories WHERE id_categorie = ?");
        $stmt->execute([$id]);
        $category = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if (!$category) {
            $pdo->rollBack();
            echo json_encode(['success' => false, 'message' => 'Category not found']);
            exit;
        }
        
        // Compter les produits dans cette catégorie
        $stmt = $pdo->prepare("SELECT COUNT(*) as product_count FROM article WHERE id_categorie = ?");
        $stmt->execute([$id]);
        $count = $stmt->fetch(PDO::FETCH_ASSOC);
        $productCount = $count['product_count'];
        
        // Trouver l'ID de la catégorie "Non classé"
        $stmt = $pdo->query("SELECT id_categorie FROM categories WHERE nom_categorie = 'Uncategorized'");
        $uncategorized = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if (!$uncategorized) {
            $stmt = $pdo->prepare("INSERT INTO categories (nom_categorie) VALUES ('Uncategorized')");
            $stmt->execute();
            $uncategorizedId = $pdo->lastInsertId();
        } else {
            $uncategorizedId = $uncategorized['id_categorie'];
        }
        
        // Déplacer les produits vers "Uncategorized"
        if ($productCount > 0) {
            $stmt = $pdo->prepare("UPDATE article SET id_categorie = ? WHERE id_categorie = ?");
            $stmt->execute([$uncategorizedId, $id]);
        }
        
        // Supprimer la catégorie
        $stmt = $pdo->prepare("DELETE FROM categories WHERE id_categorie = ?");
        $stmt->execute([$id]);
        
        echo json_encode([
            'success' => true, 
            'message' => 'Category deleted successfully',
            'category_name' => $category['nom_categorie'],
            'product_count' => $productCount
        ]);
    }
    
    $pdo->commit();
    
} catch (PDOException $e) {
    $pdo->rollBack();
    echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
}
?>
