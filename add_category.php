<?php
header('Content-Type: application/json');

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ch office track";

try {
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    $name = $_POST['name'] ?? '';
    $description = $_POST['description'] ?? '';
    $icon = $_POST['icon'] ?? 'fa-tag';
    
    if (empty($name)) {
        throw new Exception("Category name is required");
    }
    
    $stmt = $pdo->prepare("INSERT INTO categories (nom_categorie, description, icon) VALUES (?, ?, ?)");
    $stmt->execute([$name, $description, $icon]);
    
    echo json_encode([
        'success' => true,
        'message' => 'Category added successfully!',
        'id' => $pdo->lastInsertId()
    ]);
    
} catch(Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
}