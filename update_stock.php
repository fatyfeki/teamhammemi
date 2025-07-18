<?php
session_start();

// Debug - à enlever en production
error_reporting(E_ALL);
ini_set('display_errors', 1);

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ch office track";

header('Content-Type: application/json');

try {
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($_SERVER["REQUEST_METHOD"] != "POST") {
        throw new Exception("Méthode non autorisée");
    }

    // Validation des données de base
    if (empty($_POST['id']) || empty($_POST['action'])) {
        throw new Exception("Données manquantes");
    }

    $id = intval($_POST["id"]);
    $action = $_POST["action"];
    $userId = $_SESSION['user_id'] ?? 1; // Fallback à l'admin (1) si non connecté

    if ($action === "entry" || $action === "exit") {
        if (empty($_POST['quantity'])) {
            throw new Exception("Quantité manquante");
        }

        $quantity = intval($_POST["quantity"]);
        $comment = $_POST['comment'] ?? '';

        if ($quantity <= 0) {
            throw new Exception("Quantité invalide");
        }

        $pdo->beginTransaction();

        try {
            // 1. Mise à jour du stock
            $sql = $action === "entry" 
                ? "UPDATE article SET current_stock = current_stock + ? WHERE id_article = ?"
                : "UPDATE article SET current_stock = current_stock - ? WHERE id_article = ?";
            
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$quantity, $id]);

            if ($stmt->rowCount() === 0) {
                throw new Exception("Produit non trouvé");
            }

            // 2. Enregistrement du mouvement
            $movementType = $action === "entry" ? "entrée" : "sortie";
            
            $stmt = $pdo->prepare("INSERT INTO mouvementstock 
                (type_mouvement, date_mouvement, quantite, commentaire, id_article, id_utilisateur) 
                VALUES (?, NOW(), ?, ?, ?, ?)");
            
            $stmt->execute([
                $movementType,
                $quantity,
                $comment,
                $id,
                $userId
            ]);

            $pdo->commit();
            echo json_encode(['status' => 'success', 'message' => 'Stock updated successfully']);
            
        } catch (Exception $e) {
            $pdo->rollBack();
            throw new Exception("Erreur transaction: " . $e->getMessage());
        }

    } elseif ($action === "edit") {
        // Validation des données d'édition
        $required = ['name', 'category', 'price', 'currentStock', 'minStock', 'unit', 'supplier'];
        foreach ($required as $field) {
            if (empty($_POST[$field])) {
                throw new Exception("Champ $field manquant");
            }
        }

        // Traitement de l'édition
        $name = $_POST["name"];
        $category = $_POST["category"];
        $price = floatval($_POST["price"]);
        $currentStock = intval($_POST["currentStock"]);
        $minStock = intval($_POST["minStock"]);
        $unit = $_POST["unit"];
        $supplier = $_POST["supplier"];

        // Vérification catégorie
        $stmt = $pdo->prepare("SELECT id_categorie FROM categories WHERE nom_categorie = ? LIMIT 1");
        $stmt->execute([$category]);
        $idCat = $stmt->fetchColumn();

        if (!$idCat) {
            // Création de la catégorie si elle n'existe pas
            $stmt = $pdo->prepare("INSERT INTO categories (nom_categorie) VALUES (?)");
            $stmt->execute([$category]);
            $idCat = $pdo->lastInsertId();
        }

        // Mise à jour du produit
        $stmt = $pdo->prepare("UPDATE article 
            SET nom = ?,
                id_categorie = ?,
                prix_unitaire = ?,
                current_stock = ?,
                seuil_min = ?,
                unit = ?,
                fournisseur = ?
            WHERE id_article = ?");
        
        $stmt->execute([
            $name,
            $idCat,
            $price,
            $currentStock,
            $minStock,
            $unit,
            $supplier,
            $id
        ]);

        echo json_encode(['status' => 'success', 'message' => 'Product updated successfully']);

    } else {
        throw new Exception("Action non valide");
    }

} catch(PDOException $e) {
    echo json_encode(['status' => 'error', 'message' => 'Erreur DB: ' . $e->getMessage()]);
} catch(Exception $e) {
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}