<?php
// commande_groupée.php

// Connexion DB
$pdo = new PDO("mysql:host=localhost;dbname=ch office track", "root", "");
session_start();

// Récupérer les produits depuis l'URL
$productIds = explode(',', $_GET['products'] ?? '');
$placeholders = implode(',', array_fill(0, count($productIds), '?'));

// Récupérer les infos produits
$stmt = $pdo->prepare("SELECT * FROM article WHERE id_article IN ($placeholders)");
$stmt->execute($productIds);
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Traitement du formulaire
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $pdo->beginTransaction();
        
        // Générer une référence de commande
        $reference = 'CMD-' . date('Y') . '-' . str_pad(rand(1000, 9999), 4, '0', STR_PAD_LEFT);
        
        // Créer la commande principale
        $stmt = $pdo->prepare("INSERT INTO commande 
                              (reference, fournisseur, date_livraison_prevue, id_utilisateur, notes) 
                              VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([
            $reference,
            $_POST['fournisseur'] ?? '',
            $_POST['date_livraison'],
            $_SESSION['user_id'] ?? 1,
            $_POST['notes']
        ]);
        $commandeId = $pdo->lastInsertId();
        
        // Ajouter les items
        $totalHT = 0;
        foreach ($products as $product) {
            $quantite = $_POST['quantite_'.$product['id_article'] ?? 0];
            if ($quantite > 0) {
                $prix_unitaire = $product['prix_unitaire'];
                $stmt = $pdo->prepare("INSERT INTO lignecommande 
                                      (id_commande, id_article, quantite, prix_unitaire) 
                                      VALUES (?, ?, ?, ?)");
                $stmt->execute([
                    $commandeId,
                    $product['id_article'],
                    $quantite,
                    $prix_unitaire
                ]);
                
                $totalHT += $quantite * $prix_unitaire;
            }
        }
        
        // Mettre à jour le total HT de la commande
        $stmt = $pdo->prepare("UPDATE commande SET total_ht = ? WHERE id_commande = ?");
        $stmt->execute([$totalHT, $commandeId]);
        
        $pdo->commit();
        header("Location: commandes.php?success=1&id=$commandeId");
        exit;
        
    } catch (Exception $e) {
        $pdo->rollBack();
        $error = "Erreur: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Commande Groupée - CH OfficeTrack</title>
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

        .main-content {
            margin-left: 280px;
            margin-top: 70px;
            padding: 40px 30px;
            min-height: calc(100vh - 70px);
        }

        .page-header {
            background: linear-gradient(135deg, #333333 0%, #5a0000 100%);
            border-radius: 20px;
            padding: 30px 40px;
            color: white;
            margin-bottom: 30px;
            position: relative;
            overflow: hidden;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
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

        .page-header h1 {
            font-size: 32px;
            font-weight: 700;
            margin-bottom: 10px;
            position: relative;
            z-index: 2;
        }

        .page-header p {
            font-size: 16px;
            opacity: 0.9;
            position: relative;
            z-index: 2;
        }

        .alert-danger {
            color: #721c24;
            background-color: #f8d7da;
            padding: 15px;
            border-radius: 12px;
            margin-bottom: 25px;
            border-left: 4px solid #f5c6cb;
            position: relative;
            overflow: hidden;
        }

        .alert-danger::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, rgba(255,255,255,0.3), transparent);
            animation: shine 2s infinite;
        }

        @keyframes shine {
            0% { transform: translateX(-100%); }
            100% { transform: translateX(100%); }
        }

        form {
            background: white;
            border-radius: 20px;
            padding: 30px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            border: 1px solid #e9ecef;
            margin-bottom: 30px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #333;
        }

        .form-input {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid #e9ecef;
            border-radius: 12px;
            font-size: 14px;
            transition: all 0.3s ease;
            outline: none;
        }

        .form-input:focus {
            border-color: #8b0000;
            box-shadow: 0 0 0 4px rgba(139, 0, 0, 0.1);
        }

        textarea.form-input {
            min-height: 100px;
            resize: vertical;
        }

        h3 {
            font-size: 20px;
            margin: 25px 0 15px;
            color: #333;
            position: relative;
            padding-bottom: 10px;
        }

        h3::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 50px;
            height: 3px;
            background: linear-gradient(135deg, #8b0000 0%, #5a0000 100%);
            border-radius: 3px;
        }

        .product-card {
            background: #f8f9fa;
            border-radius: 15px;
            padding: 20px;
            margin-bottom: 15px;
            transition: all 0.3s ease;
            border: 2px solid transparent;
            position: relative;
            overflow: hidden;
        }

        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
            border-color: #8b0000;
            background: white;
        }

        .product-card h4 {
            font-size: 18px;
            color: #8b0000;
            margin-bottom: 10px;
        }

        .product-card p {
            margin-bottom: 8px;
            color: #555;
            font-size: 14px;
        }

        .form-buttons {
            display: flex;
            gap: 15px;
            margin-top: 30px;
        }

        .btn {
            padding: 12px 25px;
            border: none;
            border-radius: 12px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .btn-secondary {
            background: #6c757d;
            color: white;
        }

        .btn-secondary:hover {
            background: #5a6268;
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(108, 117, 125, 0.3);
        }

        .btn-primary {
            background: linear-gradient(135deg, #8b0000 0%, #5a0000 100%);
            color: white;
        }

        .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(139, 0, 0, 0.3);
            background: linear-gradient(135deg, #9b0000 0%, #6a0000 100%);
        }

        @media (max-width: 768px) {
            .main-content {
                margin-left: 0;
                padding: 20px;
            }
            
            .page-header {
                padding: 20px;
            }
            
            .page-header h1 {
                font-size: 24px;
            }
            
            form {
                padding: 20px;
            }
            
            .form-buttons {
                flex-direction: column;
            }
            
            .btn {
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <?php include "sys.php"; ?>
    
    <main class="main-content">
        <div class="page-header">
            <h1>Commande Groupée</h1>
            <p>Réapprovisionnement de <?php echo count($products); ?> produits</p>
        </div>
        
        <?php if (!empty($error)): ?>
            <div class="alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>
        
        <form method="POST">
            <div class="form-group">
                <label>Fournisseur</label>
                <input type="text" name="fournisseur" class="form-input" value="Fournisseur principal" required>
            </div>
            
            <div class="form-group">
                <label>Date de livraison prévue</label>
                <input type="date" name="date_livraison" class="form-input" 
                       min="<?php echo date('Y-m-d'); ?>" required>
            </div>
            
            <div class="form-group">
                <label>Notes pour le fournisseur</label>
                <textarea name="notes" class="form-input" rows="3"></textarea>
            </div>
            
            <h3>Produits à commander</h3>
            <?php foreach ($products as $product): ?>
            <div class="product-card">
                <h4><?php echo htmlspecialchars($product['nom']); ?></h4>
                <p>Fournisseur: <?php echo htmlspecialchars($product['fournisseur']); ?></p>
                <p>Stock actuel: <?php echo $product['current_stock']; ?> <?php echo htmlspecialchars($product['unit']); ?></p>
                <p>Seuil minimum: <?php echo $product['seuil_min']; ?> <?php echo htmlspecialchars($product['unit']); ?></p>
                <p>Prix unitaire: <?php echo $product['prix_unitaire']; ?> TND</p>
                
                <div class="form-group">
                    <label>Quantité à commander</label>
                    <input type="number" name="quantite_<?php echo $product['id_article']; ?>" 
                           class="form-input" min="1" 
                           value="<?php echo max($product['seuil_min'] - $product['current_stock'], $product['seuil_min']); ?>" 
                           required>
                </div>
            </div>
            <?php endforeach; ?>
            
            <div class="form-buttons">
                <button type="button" class="btn btn-secondary" onclick="history.back()">
                    <i class="fas fa-arrow-left"></i> Annuler
                </button>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-check"></i> Valider la commande groupée
                </button>
            </div>
        </form>
    </main>
</body>
</html>