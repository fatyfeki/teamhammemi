<?php
// details_commande.php

// Connexion DB
$pdo = new PDO("mysql:host=localhost;dbname=ch office track", "root", "");
session_start();

// Récupérer l'ID de la commande depuis l'URL
$commandeId = $_GET['id'] ?? 0;

// Récupérer les informations de la commande
$stmt = $pdo->prepare("SELECT * FROM commande WHERE id_commande = ?");
$stmt->execute([$commandeId]);
$commande = $stmt->fetch();

// Récupérer les articles de la commande
$stmt = $pdo->prepare("SELECT l.*, a.nom, a.unit 
                      FROM lignecommande l
                      JOIN article a ON l.id_article = a.id_article
                      WHERE l.id_commande = ?");
$stmt->execute([$commandeId]);
$articles = $stmt->fetchAll();

// Calculer le total TTC (avec 18% de TVA par exemple)
$tva = 0.18;
$totalTTC = $commande['total_ht'] * (1 + $tva);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Détails de la Commande #<?php echo $commande['reference']; ?></title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 20px;
            background: #f5f5f5;
        }
        .container {
            max-width: 1000px;
            margin: 0 auto;
            background: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
        }
        .header {
            display: flex;
            justify-content: space-between;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 1px solid #eee;
        }
        .badge {
            display: inline-block;
            padding: 5px 10px;
            border-radius: 20px;
            font-weight: bold;
            font-size: 14px;
        }
        .badge.en_attente {
            background: #fff3cd;
            color: #856404;
        }
        .badge.en_cours {
            background: #cce5ff;
            color: #004085;
        }
        .badge.livree {
            background: #d4edda;
            color: #155724;
        }
        .badge.annulee {
            background: #f8d7da;
            color: #721c24;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        th, td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #f8f9fa;
        }
        .total-section {
            margin-top: 30px;
            padding: 20px;
            background: #f8f9fa;
            border-radius: 8px;
            display: flex;
            justify-content: flex-end;
        }
        .total-box {
            width: 300px;
        }
        .total-line {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
        }
        .total-line.total {
            font-weight: bold;
            font-size: 18px;
            border-top: 1px solid #ddd;
            padding-top: 10px;
            margin-top: 10px;
        }
        .actions {
            margin-top: 30px;
            display: flex;
            gap: 10px;
        }
        .btn {
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
        }
        .btn-primary {
            background: #007bff;
            color: white;
        }
        .btn-secondary {
            background: #6c757d;
            color: white;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div>
                <h1>Commande #<?php echo htmlspecialchars($commande['reference']); ?></h1>
                <p>Date: <?php echo date('d/m/Y H:i', strtotime($commande['date_creation'])); ?></p>
                <p>Fournisseur: <?php echo htmlspecialchars($commande['fournisseur']); ?></p>
            </div>
            <div>
                <span class="badge <?php echo $commande['statut']; ?>">
                    <?php 
                    $statutLabels = [
                        'en_attente' => 'En Attente',
                        'en_cours' => 'En Cours',
                        'livree' => 'Livrée',
                        'annulee' => 'Annulée'
                    ];
                    echo $statutLabels[$commande['statut']] ?? $commande['statut'];
                    ?>
                </span>
                <p>Livraison prévue: <?php echo $commande['date_livraison_prevue'] ? date('d/m/Y', strtotime($commande['date_livraison_prevue'])) : 'Non spécifiée'; ?></p>
            </div>
        </div>

        <?php if (!empty($commande['notes'])): ?>
        <div class="notes">
            <h3>Notes:</h3>
            <p><?php echo nl2br(htmlspecialchars($commande['notes'])); ?></p>
        </div>
        <?php endif; ?>

        <h2>Articles commandés</h2>
        <table>
            <thead>
                <tr>
                    <th>Article</th>
                    <th>Quantité</th>
                    <th>Prix unitaire</th>
                    <th>Sous-total</th>
                    <th>Reçu</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($articles as $article): ?>
                <tr>
                    <td>
                        <?php echo htmlspecialchars($article['nom']); ?>
                        <br><small>Réf: <?php echo $article['id_article']; ?></small>
                    </td>
                    <td><?php echo $article['quantite']; ?> <?php echo htmlspecialchars($article['unit']); ?></td>
                    <td><?php echo number_format($article['prix_unitaire'], 2); ?> TND</td>
                    <td><?php echo number_format($article['quantite'] * $article['prix_unitaire'], 2); ?> TND</td>
                    <td><?php echo $article['reçu']; ?> / <?php echo $article['quantite']; ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

         <div class="total-section">
            <div class="total-box">
                <div class="total-line">
                    <span>Total HT:</span>
                    <span><?php echo number_format($commande['total_ht'], 2); ?> TND</span>
                </div>
                <div class="total-line">
                    <span>TVA (18%):</span>
                    <span><?php echo number_format($commande['total_ht'] * $tva, 2); ?> TND</span>
                </div>
                <div class="total-line total">
                    <span>Total TTC:</span>
                    <span><?php echo number_format($totalTTC, 2); ?> TND</span>
                </div>
            </div>
        </div>

        <!-- Nouvelle section Signature -->
        <div class="signature-section" style="margin-top: 50px; padding-top: 30px; border-top: 1px solid #ddd;">
            <div style="display: flex; justify-content: space-between; margin-top: 50px;">
                <div style="text-align: center; width: 45%;">
                    <p style="border-top: 1px solid #000; width: 70%; margin: 0 auto; padding-top: 5px;">
                        Signature du fournisseur
                    </p>
                    <p style="margin-top: 5px; font-size: 12px; color: #666;">
                        Date: ___________________
                    </p>
                </div>
                <div style="text-align: center; width: 45%;">
                    <p style="border-top: 1px solid #000; width: 70%; margin: 0 auto; padding-top: 5px;">
                        Signature du responsable
                    </p>
                    <p style="margin-top: 5px; font-size: 12px; color: #666;">
                        Date: ___________________
                    </p>
                </div>
            </div>
        </div>

        <div class="actions" style="margin-top: 30px;">
            <a href="commandes.php" class="btn btn-secondary">Retour à la liste</a>
            <button class="btn btn-primary" onclick="window.print()">Imprimer</button>
            <?php if ($commande['statut'] == 'en_attente'): ?>
            <a href="annuler_commande.php?id=<?php echo $commandeId; ?>" class="btn btn-secondary">Annuler</a>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>