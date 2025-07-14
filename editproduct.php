<?php
$id = $_GET['id'] ?? null;

if (!$id) {
    header("Location: productlist.php");
    exit;
}

try {
    $pdo = new PDO("mysql:host=localhost;dbname=ch office track", "root", "");
    $stmt = $pdo->prepare("SELECT * FROM article WHERE id_article = ?");
    $stmt->execute([$id]);
    $product = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$product) {
        header("Location: productlist.php");
        exit;
    }

    // Traitement de la modification
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $nom = $_POST['nom'] ?? '';
        $description = $_POST['description'] ?? '';
        $marque = $_POST['marque'] ?? '';
        $categorie = $_POST['categorie'] ?? '';
        $fournisseur = $_POST['fournisseur'] ?? '';
        $info_fournisseur = $_POST['info_fournisseur'] ?? '';
        $prix_achat = $_POST['prix_achat'] ?? 0;
        $totale_achat = $_POST['totale_achat'] ?? 0;

        $updateStmt = $pdo->prepare("UPDATE article SET nom = ?, description = ?, marque = ?, categorie = ?, fournisseur = ?, info_fournisseur = ?, prix_achat = ?, totale_achat = ? WHERE id_article = ?");
        $updateStmt->execute([$nom, $description, $marque, $categorie, $fournisseur, $info_fournisseur, $prix_achat, $totale_achat, $id]);
        
        header("Location: productlist.php?success=1");
        exit;
    }
    
} catch (PDOException $e) {
    die("Erreur de base de données : " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier le produit - CH OfficeTrack</title>
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
            position: relative;
        }

        /* Overlay flou pour simuler l'arrière-plan avec la sidebar */
        .background-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(5px);
            z-index: 999;
        }

        /* Simulation de la sidebar en arrière-plan */
        .sidebar-blur {
            position: fixed;
            left: 0;
            top: 0;
            width: 280px;
            height: 100vh;
            background: linear-gradient(180deg, #000000 0%, #1a0000 50%, #2b2b2b 100%);
            backdrop-filter: blur(20px);
            box-shadow: 0 10px 30px rgba(0,0,0,0.3);
            z-index: 998;
            opacity: 0.8;
        }

        .sidebar-header-blur {
            background: linear-gradient(135deg, #8b0000 0%, #5a0000 100%);
            height: 88px;
            position: relative;
            overflow: hidden;
        }

        .sidebar-header-blur::before {
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

        /* Top navbar simulation */
        .top-navbar-blur {
            position: fixed;
            top: 0;
            left: 280px;
            right: 0;
            height: 70px;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-bottom: 1px solid rgba(0, 0, 0, 0.1);
            z-index: 998;
            box-shadow: 0 2px 20px rgba(0, 0, 0, 0.1);
            opacity: 0.8;
        }

        /* Modal Container */
        .modal-container {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 1000;
            padding: 20px;
        }

        .modal {
            background: white;
            border-radius: 20px;
            width: 100%;
            max-width: 600px;
            max-height: 90vh;
            overflow-y: auto;
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.25);
            position: relative;
            animation: modalSlideIn 0.3s ease-out;
        }

        @keyframes modalSlideIn {
            from {
                opacity: 0;
                transform: translateY(-50px) scale(0.9);
            }
            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        .modal-header {
            background: linear-gradient(135deg, #8b0000 0%, #5a0000 100%);
            color: white;
            padding: 24px 30px;
            border-radius: 20px 20px 0 0;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: relative;
            overflow: hidden;
        }

        .modal-header::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
            animation: pulse 4s ease-in-out infinite;
        }

        .modal-title {
            font-size: 24px;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 12px;
            position: relative;
            z-index: 2;
        }

        .close-btn {
            background: rgba(255, 255, 255, 0.1);
            border: none;
            font-size: 24px;
            color: white;
            cursor: pointer;
            padding: 8px 12px;
            border-radius: 8px;
            transition: all 0.3s ease;
            position: relative;
            z-index: 2;
        }

        .close-btn:hover {
            background: rgba(255, 255, 255, 0.2);
            transform: scale(1.1);
        }

        .modal-body {
            padding: 30px;
        }

        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-bottom: 20px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group.full-width {
            grid-column: 1 / -1;
        }

        .form-label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #333;
            font-size: 14px;
        }

        .form-input, .form-select, .form-textarea {
            width: 100%;
            padding: 12px 16px;
            border: 2px solid #e1e5e9;
            border-radius: 12px;
            font-size: 16px;
            transition: all 0.3s ease;
            background-color: #f8f9fa;
            font-family: inherit;
        }

        .form-input:focus, .form-select:focus, .form-textarea:focus {
            outline: none;
            border-color: #8b0000;
            background-color: white;
            box-shadow: 0 0 0 4px rgba(139, 0, 0, 0.1);
        }

        .form-textarea {
            resize: vertical;
            min-height: 80px;
        }

        .form-select {
            cursor: pointer;
        }

        .currency-group {
            position: relative;
        }

        .currency-group::after {
            content: "TND";
            position: absolute;
            right: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: #666;
            font-size: 14px;
            font-weight: 500;
            pointer-events: none;
        }

        .currency-group .form-input {
            padding-right: 55px;
        }

        .form-actions {
            display: flex;
            gap: 15px;
            justify-content: flex-end;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #e1e5e9;
        }

        .btn {
            padding: 12px 24px;
            border-radius: 12px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            border: none;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .btn-secondary {
            background-color: #6c757d;
            color: white;
            box-shadow: 0 4px 15px rgba(108, 117, 125, 0.2);
        }

        .btn-secondary:hover {
            background-color: #5a6268;
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(108, 117, 125, 0.3);
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

        /* Responsive Design */
        @media (max-width: 768px) {
            .sidebar-blur {
                width: 0;
            }
            
            .top-navbar-blur {
                left: 0;
            }
            
            .modal {
                max-width: 95%;
                margin: 10px;
            }
            
            .form-grid {
                grid-template-columns: 1fr;
            }
            
            .modal-body {
                padding: 20px;
            }
            
            .form-actions {
                flex-direction: column;
            }
        }

        /* Scrollbar personnalisée pour la modal */
        .modal::-webkit-scrollbar {
            width: 6px;
        }

        .modal::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }

        .modal::-webkit-scrollbar-thumb {
            background: #8b0000;
            border-radius: 10px;
        }

        .modal::-webkit-scrollbar-thumb:hover {
            background: #5a0000;
        }

        .required {
            color: #dc3545;
        }

        .info-text {
            font-size: 12px;
            color: #6c757d;
            margin-top: 4px;
        }
    </style>
</head>
<body>
    <!-- Arrière-plan flou simulant productlist.php -->
    <div class="background-overlay"></div>
    
    <!-- Simulation de la sidebar -->
    <div class="sidebar-blur">
        <div class="sidebar-header-blur"></div>
    </div>
    
    <!-- Simulation de la top navbar -->
    <div class="top-navbar-blur"></div>
    
    <!-- Modal Container -->
    <div class="modal-container">
        <div class="modal">
            <div class="modal-header">
                <h2 class="modal-title">
                    <i class="fas fa-edit"></i>
                    Modifier le Produit
                </h2>
                <button class="close-btn" onclick="window.location.href='productlist.php'">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            
            <div class="modal-body">
                <form method="POST">
                    <div class="form-grid">
                        <div class="form-group">
                            <label class="form-label">
                                Nom du Produit <span class="required">*</span>
                            </label>
                            <input type="text" name="nom" class="form-input" 
                                   value="<?php echo htmlspecialchars($product['nom'] ?? ''); ?>" 
                                   required placeholder="Entrez le nom du produit">
                        </div>

                        <div class="form-group">
                            <label class="form-label">
                                Marque
                            </label>
                            <input type="text" name="marque" class="form-input" 
                                   value="<?php echo htmlspecialchars($product['marque'] ?? ''); ?>" 
                                   placeholder="Entrez la marque">
                        </div>
                    </div>

                    <div class="form-group full-width">
                        <label class="form-label">
                            Description
                        </label>
                        <textarea name="description" class="form-textarea" 
                                  placeholder="Décrivez le produit..."><?php echo htmlspecialchars($product['description'] ?? ''); ?></textarea>
                    </div>

                    <div class="form-grid">
                        <div class="form-group">
                            <label class="form-label">
                                Catégorie <span class="required">*</span>
                            </label>
                            <select name="categorie" class="form-select" required>
                                <option value="">Sélectionner une catégorie</option>
                                <option value="Office Supplies" <?php echo ($product['categorie'] ?? '') === 'Office Supplies' ? 'selected' : ''; ?>>Office Supplies</option>
                                <option value="Electronics" <?php echo ($product['categorie'] ?? '') === 'Electronics' ? 'selected' : ''; ?>>Electronics</option>
                                <option value="Furniture" <?php echo ($product['categorie'] ?? '') === 'Furniture' ? 'selected' : ''; ?>>Furniture</option>
                                <option value="Stationery" <?php echo ($product['categorie'] ?? '') === 'Stationery' ? 'selected' : ''; ?>>Stationery</option>
                                <option value="Supplies" <?php echo ($product['categorie'] ?? '') === 'Supplies' ? 'selected' : ''; ?>>Supplies</option>
                                <option value="Technology" <?php echo ($product['categorie'] ?? '') === 'Technology' ? 'selected' : ''; ?>>Technology</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label class="form-label">
                                Fournisseur
                            </label>
                            <input type="text" name="fournisseur" class="form-input" 
                                   value="<?php echo htmlspecialchars($product['fournisseur'] ?? ''); ?>" 
                                   placeholder="Nom du fournisseur">
                        </div>
                    </div>

                    <div class="form-group full-width">
                        <label class="form-label">
                            Informations Fournisseur
                        </label>
                        <textarea name="info_fournisseur" class="form-textarea" 
                                  placeholder="Informations sur le fournisseur (contact, adresse, etc.)"><?php echo htmlspecialchars($product['info_fournisseur'] ?? ''); ?></textarea>
                        <div class="info-text">Contact, adresse, conditions de livraison, etc.</div>
                    </div>

                    <div class="form-grid">
                        <div class="form-group">
                            <label class="form-label">
                                Prix Unitaire <span class="required">*</span>
                            </label>
                            <div class="currency-group">
                                <input type="number" step="0.01" name="prix_achat" class="form-input" 
                                       value="<?php echo htmlspecialchars($product['prix_achat'] ?? ''); ?>" 
                                       required placeholder="0.00">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label">
                                Total Achat <span class="required">*</span>
                            </label>
                            <div class="currency-group">
                                <input type="number" step="0.01" name="totale_achat" class="form-input" 
                                       value="<?php echo htmlspecialchars($product['totale_achat'] ?? ''); ?>" 
                                       required placeholder="0.00">
                            </div>
                        </div>
                    </div>

                    <div class="form-actions">
                        <button type="button" class="btn btn-secondary" onclick="window.location.href='productlist.php'">
                            <i class="fas fa-times"></i>
                            Annuler
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i>
                            Enregistrer les Modifications
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Animation d'entrée de la modal
        document.addEventListener('DOMContentLoaded', function() {
            const modal = document.querySelector('.modal');
            modal.style.animation = 'modalSlideIn 0.3s ease-out';
        });

        // Fermer avec Escape
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                window.location.href = 'productlist.php';
            }
        });

        // Fermer en cliquant sur l'overlay
        document.querySelector('.background-overlay').addEventListener('click', function() {
            window.location.href = 'productlist.php';
        });

        // Calcul automatique du total (optionnel)
        document.querySelector('input[name="prix_achat"]').addEventListener('input', function() {
            const prixUnitaire = parseFloat(this.value) || 0;
            const quantite = 1; // Vous pouvez ajouter un champ quantité si nécessaire
            const total = prixUnitaire * quantite;
            document.querySelector('input[name="totale_achat"]').value = total.toFixed(2);
        });
    </script>
</body>
</html>