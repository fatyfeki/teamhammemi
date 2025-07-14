<?php
header('Content-Type: application/json');

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ch office track";

try {
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    $id = $_POST['id'] ?? 0;
    
    // Vérifier s'il y a des produits dans cette catégorie
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM article WHERE id_categorie = ?");
    $stmt->execute([$id]);
    $productCount = $stmt->fetchColumn();
    
    if ($productCount > 0) {
        throw new Exception("Cannot delete category with products. Please move or delete the products first.");
    }
    
    $stmt = $pdo->prepare("DELETE FROM categories WHERE id_categorie = ?");
    $stmt->execute([$id]);
    
    echo json_encode([
        'success' => true,
        'message' => 'Category deleted successfully!'
    ]);
    
} catch(Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
}