<?php
// commandes.php

// Connexion DB
$pdo = new PDO("mysql:host=localhost;dbname=ch office track", "root", "");

if (isset($_GET['success']) && $_GET['success'] == 1) {
    $commandeId = $_GET['id'] ?? 0;
    
    // Récupérer les détails de la commande
    $stmt = $pdo->prepare("SELECT c.*, COUNT(l.id_ligne_commande) as nb_produits 
                          FROM commande c
                          LEFT JOIN lignecommande l ON c.id_commande = l.id_commande
                          WHERE c.id_commande = ?");
    $stmt->execute([$commandeId]);
    $commande = $stmt->fetch();
    ?>
    
    <div class="notification success">
        <div class="notification-icon">
            <i class="fas fa-check-circle"></i>
        </div>
        <div class="notification-content">
            <h3>Commande <?php echo htmlspecialchars($commande['reference']); ?> créée avec succès !</h3>
            <div class="notification-details">
                <span><i class="fas fa-box"></i> <?php echo $commande['nb_produits']; ?> produits</span>
                <span><i class="fas fa-money-bill-wave"></i> <?php echo number_format($commande['total_ht'], 2); ?> TND HT</span>
            </div>
        </div>
        <a href="details_commande.php?id=<?php echo $commandeId; ?>" class="btn btn-primary">
            <i class="fas fa-eye"></i> Voir le détail
        </a>
    </div>
    <?php
}

// Afficher l'historique des commandes
$stmt = $pdo->query("SELECT * FROM commande ORDER BY date_creation DESC");
$commandes = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Historique des Commandes - CH OfficeTrack</title>
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

        .notification {
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: white;
            border-radius: 15px;
            padding: 20px;
            margin-bottom: 30px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            border-left: 5px solid #28a745;
            position: relative;
            overflow: hidden;
        }

        .notification.success {
            border-left-color: #28a745;
        }

        .notification-icon {
            font-size: 28px;
            color: #28a745;
            margin-right: 20px;
        }

        .notification-content {
            flex: 1;
        }

        .notification-content h3 {
            font-size: 18px;
            margin-bottom: 8px;
            color: #333;
        }

        .notification-details {
            display: flex;
            gap: 20px;
        }

        .notification-details span {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 14px;
            color: #6c757d;
        }

        .btn {
            padding: 12px 20px;
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
            text-decoration: none;
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

        .data-table {
            width: 100%;
            background: white;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            border-collapse: separate;
            border-spacing: 0;
        }

        .data-table thead th {
            background: linear-gradient(135deg, #8b0000 0%, #5a0000 100%);
            color: white;
            padding: 16px 20px;
            font-weight: 600;
            text-align: left;
            position: sticky;
            top: 0;
        }

        .data-table tbody tr {
            transition: all 0.2s ease;
        }

        .data-table tbody tr:hover {
            background-color: #f8f9fa;
            transform: translateX(4px);
        }

        .data-table tbody td {
            padding: 14px 20px;
            border-bottom: 1px solid #e9ecef;
            color: #555;
        }

        .data-table tbody tr:last-child td {
            border-bottom: none;
        }

        .status-badge {
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            text-transform: capitalize;
        }

        .status-pending {
            background-color: #fff3cd;
            color: #856404;
        }

        .status-delivered {
            background-color: #d4edda;
            color: #155724;
        }

        .status-processing {
            background-color: #cce5ff;
            color: #004085;
        }

        .status-cancelled {
            background-color: #f8d7da;
            color: #721c24;
        }

        .empty-state {
            background: white;
            border-radius: 20px;
            padding: 40px;
            text-align: center;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        }

        .empty-state i {
            font-size: 50px;
            color: #8b0000;
            margin-bottom: 20px;
            opacity: 0.5;
        }

        .empty-state p {
            font-size: 16px;
            color: #6c757d;
            margin-bottom: 20px;
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
            
            .notification {
                flex-direction: column;
                align-items: flex-start;
                gap: 15px;
            }
            
            .data-table {
                display: block;
                overflow-x: auto;
            }
        }
    </style>
</head>
<body>
    <?php include "sys.php"; ?>
    
    <main class="main-content">
        <div class="page-header">
            <h1>Historique des Commandes</h1>
        </div>
        
        <?php if (!empty($commandes)): ?>
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Référence</th>
                        <th>Date</th>
                        <th>Fournisseur</th>
                        <th>Statut</th>
                        <th>Total HT</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($commandes as $commande): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($commande['reference']); ?></td>
                        <td><?php echo date('d/m/Y', strtotime($commande['date_creation'])); ?></td>
                        <td><?php echo htmlspecialchars($commande['fournisseur']); ?></td>
                        <td>
                            <span class="status-badge status-<?php echo strtolower($commande['statut']); ?>">
                                <?php echo ucfirst(str_replace('_', ' ', $commande['statut'])); ?>
                            </span>
                        </td>
                        <td><?php echo number_format($commande['total_ht'], 2); ?> TND</td>
                        <td>
                            <a href="details_commande.php?id=<?php echo $commande['id_commande']; ?>" class="btn btn-primary">
                                <i class="fas fa-eye"></i> Détails
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <div class="empty-state">
                <i class="fas fa-box-open"></i>
                <p>Aucune commande trouvée dans l'historique</p>
                <a href="commande_groupée.php" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Créer une commande
                </a>
            </div>
        <?php endif; ?>
    </main>
</body>
</html>