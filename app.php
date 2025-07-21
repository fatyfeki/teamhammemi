<?php
// Inclure les fichiers nécessaires
require_once 'db.php';
require_once 'fournisseur.php';

// Traitement de l'import de fichier CSV
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'import_suppliers') {
    try {
        if (isset($_FILES['import_file']) && $_FILES['import_file']['error'] === UPLOAD_ERR_OK) {
            $tmpName = $_FILES['import_file']['tmp_name'];
            $fileName = $_FILES['import_file']['name'];
            $fileType = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
            
            if ($fileType === 'csv') {
                $handle = fopen($tmpName, 'r');
                if ($handle !== FALSE) {
                    $importCount = 0;
                    $stmt = $pdo->prepare("INSERT INTO fournisseur (name, phone, email, adresse) VALUES (?, ?, ?, ?)");
                    
                    // Skip header row
                    fgetcsv($handle);
                    
                    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                        if (count($data) >= 4) {
                            $name = trim($data[0]);
                            $phone = trim($data[1]);
                            $email = trim($data[2]);
                            $address = trim($data[3]);
                            
                            if (!empty($name) && !empty($phone) && !empty($email)) {
                                $stmt->execute([$name, $phone, $email, $address]);
                                $importCount++;
                            }
                        }
                    }
                    fclose($handle);
                    $success_message = "$importCount fournisseurs importés avec succès !";
                } else {
                    $error_message = "Erreur lors de la lecture du fichier CSV.";
                }
            } else {
                $error_message = "Seuls les fichiers CSV sont acceptés.";
            }
        } else {
            $error_message = "Erreur lors de l'upload du fichier.";
        }
    } catch (Exception $e) {
        $error_message = "Erreur lors de l'import : " . $e->getMessage();
    }
}

// Traitement du formulaire d'ajout de fournisseur
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'add_supplier') {
    try {
        // Récupérer les données du formulaire
        $name = $_POST['supplierName'] ?? '';
        $phone = $_POST['phoneNumber'] ?? '';
        $email = $_POST['email'] ?? '';
        $address = $_POST['address'] ?? '';
        
        // Préparer la requête d'insertion
        $stmt = $pdo->prepare("INSERT INTO fournisseur (name, phone, email, adresse) VALUES (?, ?, ?, ?)");
        $result = $stmt->execute([$name, $phone, $email, $address]);
        
        if ($result) {
            $success_message = "Fournisseur ajouté avec succès !";
        } else {
            $error_message = "Erreur lors de l'ajout du fournisseur.";
        }
    } catch (PDOException $e) {
        $error_message = "Erreur de base de données : " . $e->getMessage();
    }
}

// Traitement de la modification d'un fournisseur
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'edit_supplier') {
    try {
        $id = $_POST['supplierId'] ?? '';
        $name = $_POST['supplierName'] ?? '';
        $phone = $_POST['phoneNumber'] ?? '';
        $email = $_POST['email'] ?? '';
        $address = $_POST['address'] ?? '';
        
        // Préparer la requête de mise à jour
        $stmt = $pdo->prepare("UPDATE fournisseur SET name = ?, phone = ?, email = ?, adresse = ? WHERE id = ?");
        $result = $stmt->execute([$name, $phone, $email, $address, $id]);
        
        if ($result) {
            $success_message = "Fournisseur modifié avec succès !";
        } else {
            $error_message = "Erreur lors de la modification du fournisseur.";
        }
    } catch (PDOException $e) {
        $error_message = "Erreur de base de données : " . $e->getMessage();
    }
}

// Traitement de la suppression d'un fournisseur
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'delete_supplier') {
    try {
        $id = $_POST['supplierId'] ?? '';
        
        // Préparer la requête de suppression
        $stmt = $pdo->prepare("DELETE FROM fournisseur WHERE id = ?");
        $result = $stmt->execute([$id]);
        
        if ($result) {
            $success_message = "Fournisseur supprimé avec succès !";
        } else {
            $error_message = "Erreur lors de la suppression du fournisseur.";
        }
    } catch (PDOException $e) {
        $error_message = "Erreur de base de données : " . $e->getMessage();
    }
}

// Récupérer tous les fournisseurs
try {
    $stmt = $pdo->query("SELECT * FROM fournisseur ORDER BY name");
    $suppliers = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $suppliers = [];
    $error_message = "Erreur lors de la récupération des fournisseurs : " . $e->getMessage();
}

// Générer le prochain ID
$next_id = 1001;
if (!empty($suppliers)) {
    $last_id = max(array_column($suppliers, 'id'));
    $next_id = $last_id + 1;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Suppliers - CH OfficeTrack</title>
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

        /* Navigation Sidebar */
        .sidebar {
            position: fixed;
            left: 0;
            top: 0;
            width: 280px;
            height: 100vh;
            background: linear-gradient(180deg, #000000 0%, #1a0000 50%, #2b2b2b 100%);
            backdrop-filter: blur(20px);
            box-shadow: 
                0 10px 30px rgba(0,0,0,0.3),
                inset 1px 0 0 rgba(255,255,255,0.1);
            z-index: 1000;
            overflow-y: auto;
        }

        /* Header */
        .sidebar-header {
            background: linear-gradient(135deg, #8b0000 0%, #5a0000 100%);
            color: white;
            padding: 24px 20px;
            position: relative;
            overflow: hidden;
        }

        .sidebar-header::before {
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

        .header-content {
            position: relative;
            z-index: 2;
        }

        .company-name {
            font-size: 16px;
            font-weight: 700;
            letter-spacing: 0.5px;
            margin-bottom: 4px;
        }

        .system-label {
            font-size: 12px;
            font-weight: 400;
            opacity: 0.9;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        /* Navigation Menu */
        .nav-menu {
            list-style: none;
            padding: 12px 0;
            margin: 0;
        }

        .nav-section {
            margin-bottom: 20px;
        }

        .nav-section-title {
            color: rgba(255,255,255,0.5);
            font-size: 11px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin: 0 20px 10px 20px;
            padding-bottom: 8px;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }

        .nav-item {
            margin: 2px 12px;
            border-radius: 12px;
            overflow: hidden;
        }

        .nav-link {
            display: flex;
            align-items: center;
            padding: 16px 20px;
            color: rgba(255,255,255,0.8);
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            border-radius: 12px;
            margin-bottom: 2px;
        }

        .nav-link::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            width: 0;
            height: 100%;
            background: linear-gradient(135deg, #8b0000 0%, #5a0000 100%);
            transition: width 0.3s ease;
            border-radius: 12px;
        }

        .nav-link:hover::before {
            width: 100%;
        }

        .nav-link:hover {
            color: #ffffff;
            transform: translateX(4px);
            box-shadow: 0 4px 20px rgba(139,0,0,0.3);
        }

        .nav-link.active {
            background: linear-gradient(135deg, #8b0000 0%, #5a0000 100%);
            color: #ffffff;
            box-shadow: 
                0 4px 20px rgba(139,0,0,0.4),
                inset 0 1px 0 rgba(255,255,255,0.2);
        }

        .nav-icon {
            width: 20px;
            height: 20px;
            margin-right: 16px;
            font-size: 16px;
            text-align: center;
            position: relative;
            z-index: 2;
        }

        .nav-text {
            position: relative;
            z-index: 2;
        }

        /* Top Navigation Bar */
        .top-navbar {
            position: fixed;
            top: 0;
            left: 280px;
            right: 0;
            height: 70px;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-bottom: 1px solid rgba(0, 0, 0, 0.1);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 30px;
            z-index: 999;
            box-shadow: 0 2px 20px rgba(0, 0, 0, 0.1);
        }

        .navbar-left {
            flex: 1;
            max-width: 600px;
        }

        .navbar-right {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .search-container {
            position: relative;
            width: 100%;
        }

        .search-input {
            width: 100%;
            padding: 12px 20px 12px 50px;
            border: 2px solid #e9ecef;
            border-radius: 25px;
            font-size: 14px;
            background: #f8f9fa;
            transition: all 0.3s ease;
            outline: none;
        }

        .search-input:focus {
            border-color: #8b0000;
            background: white;
            box-shadow: 0 0 0 4px rgba(139, 0, 0, 0.1);
        }

        .search-icon {
            position: absolute;
            left: 18px;
            top: 50%;
            transform: translateY(-50%);
            color: #6c757d;
            font-size: 14px;
        }

        .notifications {
            position: relative;
            cursor: pointer;
        }

        .notifications .fas {
            font-size: 20px;
            color: #6c757d;
            transition: color 0.2s ease;
        }

        .notifications:hover .fas {
            color: #8b0000;
        }

        .notification-badge {
            position: absolute;
            top: -8px;
            right: -8px;
            background: #8b0000;
            color: white;
            border-radius: 50%;
            width: 20px;
            height: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 11px;
            font-weight: bold;
        }

        .profile-menu {
            position: relative;
            display: flex;
            align-items: center;
            gap: 12px;
            cursor: pointer;
            padding: 8px 12px;
            border-radius: 12px;
            transition: background 0.2s ease;
        }

        .profile-menu:hover {
            background: #f8f9fa;
        }

        .profile-avatar {
            position: relative;
        }

        .profile-avatar img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid #e9ecef;
        }

        .status-indicator {
            position: absolute;
            bottom: 2px;
            right: 2px;
            width: 12px;
            height: 12px;
            background: #28a745;
            border-radius: 50%;
            border: 2px solid white;
        }

        .profile-info {
            display: flex;
            flex-direction: column;
            gap: 2px;
        }

        .profile-name {
            font-weight: 600;
            color: #333;
            font-size: 14px;
        }

        .profile-role {
            color: #6c757d;
            font-size: 12px;
        }

        /* Main Content */
        .main-content {
            margin-left: 280px;
            margin-top: 70px;
            padding: 30px;
            min-height: calc(100vh - 70px);
        }

        /* Page Header */
        .page-header {
            background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);
            border-radius: 20px;
            padding: 30px;
            margin-bottom: 30px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            border: 1px solid #e9ecef;
            position: relative;
            overflow: hidden;
        }

        .page-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(135deg, #8b0000 0%, #5a0000 100%);
        }

        .page-title {
            font-size: 32px;
            font-weight: 700;
            color: #333;
            margin-bottom: 8px;
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .page-title i {
            background: linear-gradient(135deg, #8b0000 0%, #5a0000 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .page-subtitle {
            color: #6c757d;
            font-size: 16px;
            margin-bottom: 20px;
        }

        .page-actions {
            display: flex;
            gap: 15px;
            flex-wrap: wrap;
        }

        .btn {
            padding: 12px 24px;
            border: none;
            border-radius: 12px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            position: relative;
            overflow: hidden;
        }

        .btn-primary {
            background: linear-gradient(135deg, #8b0000 0%, #5a0000 100%);
            color: white;
            box-shadow: 0 4px 15px rgba(139, 0, 0, 0.3);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(139, 0, 0, 0.4);
        }

        .btn-secondary {
            background: #f8f9fa;
            color: #6c757d;
            border: 2px solid #e9ecef;
        }

        .btn-secondary:hover {
            background: #e9ecef;
            color: #495057;
            transform: translateY(-2px);
        }

        /* Supplier Table Container */
        .table-container {
            background: white;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            border: 1px solid #e9ecef;
            overflow: hidden;
            position: relative;
        }

        .table-header {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            padding: 20px 30px;
            border-bottom: 2px solid #e9ecef;
            display: flex;
            justify-content: between;
            align-items: center;
        }

        .table-title {
            font-size: 20px;
            font-weight: 600;
            color: #333;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .table-title i {
            color: #f3f0f0ff;
        }

        .table-controls {
            display: flex;
            gap: 15px;
            align-items: center;
            margin-left: auto;
        }

        .filter-select {
            padding: 8px 15px;
            border: 2px solid #e9ecef;
            border-radius: 8px;
            font-size: 14px;
            background: white;
            outline: none;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .filter-select:focus {
            border-color: #131010ff;
            box-shadow: 0 0 0 3px rgba(139, 0, 0, 0.1);
        }

        .suppliers-table {
            width: 100%;
            border-collapse: collapse;
            background: white;
        }

         .suppliers-table th {
            background: linear-gradient(135deg, #6b2737 0%, #8b0000 100%);
            color: white;
            padding: 18px 20px;
            text-align: left;
            font-weight: 600;
            font-size: 14px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border-bottom: 3px solid #9e4444ff;
            position: sticky;
            top: 0;
            z-index: 10;
        }
        .suppliers-table th:first-child {
            border-top-left-radius: 0;
        }

        .suppliers-table th:last-child {
            border-top-right-radius: 0;
        }

        .suppliers-table td {
            padding: 18px 20px;
            border-bottom: 1px solid #f1f3f4;
            font-size: 14px;
            color: #333;
            transition: all 0.3s ease;
        }

        .suppliers-table tr {
            transition: all 0.3s ease;
            position: relative;
        }
         .suppliers-table tr:nth-child(even) {
            background-color: #f9f9f9;
        }

         .suppliers-table tr:hover {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(139, 0, 0, 0.1);
        }

        .suppliers-table tr:hover td {
            color: #333;
        }

       .supplier-id {
            font-weight: 600;
            color: #8b0000;
            font-size: 16px;
        }

        .supplier-name {
            font-weight: 600;
            color: #333;
        }

        .supplier-email {
            color: #0066cc;
            text-decoration: none;
            transition: color 0.2s ease;
        }

        .supplier-email:hover {
            color: #8b0000;
            text-decoration: underline;
        }

        .supplier-orders {
            background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
            color: white;
            padding: 6px 12px;
            border-radius: 20px;
            font-weight: 600;
            font-size: 12px;
            text-align: center;
            min-width: 50px;
            display: inline-block;
        }

        .actions-cell {
            display: flex;
            gap: 8px;
            justify-content: center;
        }

        .action-btn {
            width: 36px;
            height: 36px;
            border: none;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s ease;
            font-size: 14px;
            position: relative;
            overflow: hidden;
        }

        .action-btn::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            background: rgba(255,255,255,0.3);
            border-radius: 50%;
            transition: all 0.3s ease;
            transform: translate(-50%, -50%);
        }

        .action-btn:hover::before {
            width: 100%;
            height: 100%;
        }

        .edit-btn {
            background: linear-gradient(135deg, #ffc107 0%, #ff8f00 100%);
            color: white;
            box-shadow: 0 2px 10px rgba(255, 193, 7, 0.3);
        }

        .edit-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(255, 193, 7, 0.4);
        }

        .delete-btn {
            background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
            color: white;
            box-shadow: 0 2px 10px rgba(220, 53, 69, 0.3);
        }

        .delete-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(220, 53, 69, 0.4);
        }

        .info-btn {
            background: linear-gradient(135deg, #17a2b8 0%, #138496 100%);
            color: white;
            box-shadow: 0 2px 10px rgba(23, 162, 184, 0.3);
        }

        .info-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(23, 162, 184, 0.4);
        }

        /* Stats Cards */
        .stats-cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: white;
            border-radius: 15px;
            padding: 25px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            border: 1px solid #e9ecef;
            position: relative;
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(135deg, #8b0000 0%, #5a0000 100%);
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(0,0,0,0.15);
        }

        .stat-icon {
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, #8b0000 0%, #5a0000 100%);
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            color: white;
            margin-bottom: 15px;
        }

        .stat-value {
            font-size: 32px;
            font-weight: 700;
            color: #333;
            margin-bottom: 5px;
        }

        .stat-label {
            color: #6c757d;
            font-size: 14px;
            font-weight: 500;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
                transition: transform 0.3s ease;
            }
            
            .sidebar.active {
                transform: translateX(0);
            }
            
            .top-navbar {
                left: 0;
                padding: 0 20px;
            }
            
            .main-content {
                margin-left: 0;
                padding: 20px;
            }
            
            .page-actions {
                flex-direction: column;
            }
            
            .table-container {
                overflow-x: auto;
            }
            
            .suppliers-table {
                min-width: 800px;
            }
        }

        /* Loading Animation */
        .loading {
            display: inline-block;
            width: 20px;
            height: 20px;
            border: 3px solid #f3f3f3;
            border-top: 3px solid #8b0000;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        /* Tooltip */
        .tooltip {
            position: relative;
            cursor: pointer;
        }

        .tooltip::after {
            content: attr(data-tooltip);
            position: absolute;
            bottom: 100%;
            left: 50%;
            transform: translateX(-50%);
            background: #333;
            color: white;
            padding: 5px 10px;
            border-radius: 4px;
            font-size: 12px;
            white-space: nowrap;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
            z-index: 1000;
        }

        .tooltip:hover::after {
            opacity: 1;
            visibility: visible;
            transform: translateX(-50%) translateY(-5px);
        }

        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0,0,0,0.5);
            z-index: 2000;
            justify-content: center;
            align-items: center;
        }

        .modal-content {
            background: white;
            border-radius: 20px;
            width: 90%;
            max-width: 600px;
            box-shadow: 0 10px 50px rgba(0,0,0,0.3);
            animation: modalFadeIn 0.3s ease-out;
            overflow: hidden;
        }

        /* Modal spécial pour l'export */
        .export-modal-content {
            background: white;
            border-radius: 20px;
            width: 95%;
            max-width: 1200px;
            box-shadow: 0 10px 50px rgba(0,0,0,0.3);
            animation: modalFadeIn 0.3s ease-out;
            overflow: hidden;
        }

        @keyframes modalFadeIn {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .modal-header {
            background: linear-gradient(135deg, #8b0000 0%, #5a0000 100%);
            color: white;
            padding: 20px;
            position: relative;
        }

        .modal-header h2 {
            margin: 0;
            font-size: 22px;
        }

        .close-modal {
            position: absolute;
            top: 20px;
            right: 20px;
            background: none;
            border: none;
            color: white;
            font-size: 24px;
            cursor: pointer;
        }

        .modal-body {
            padding: 30px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #555;
        }

        .form-control {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid #e9ecef;
            border-radius: 8px;
            font-size: 14px;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            border-color: #8b0000;
            box-shadow: 0 0 0 3px rgba(139, 0, 0, 0.1);
            outline: none;
        }

        .form-row {
            display: flex;
            gap: 15px;
        }

        .form-row .form-group {
            flex: 1;
        }

        .modal-footer {
            padding: 20px 30px;
            background: #f8f9fa;
            border-top: 1px solid #e9ecef;
            display: flex;
            justify-content: flex-end;
            gap: 15px;
        }

        /* Status badge styles */
        .supplier-status {
            padding: 6px 12px;
            border-radius: 20px;
            font-weight: 600;
            font-size: 12px;
            text-align: center;
            min-width: 70px;
            display: inline-block;
        }

        .status-active {
            background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
            color: white;
        }

        .status-pending {
            background: linear-gradient(135deg, #ffc107 0%, #ff8f00 100%);
            color: white;
        }

        .status-inactive {
            background: linear-gradient(135deg, #6c757d 0%, #495057 100%);
            color: white;
        }

        /* Messages */
        .alert {
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-weight: 600;
        }

        .alert-success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .alert-error {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        .file-upload-area {
            border: 2px dashed #e9ecef;
            border-radius: 8px;
            padding: 30px;
            text-align: center;
            margin-bottom: 20px;
            transition: all 0.3s ease;
        }

        .file-upload-area:hover {
            border-color: #8b0000;
            background: #f8f9fa;
        }

        .file-upload-area.dragover {
            border-color: #8b0000;
            background: #f8f9fa;
        }

        .file-upload-icon {
            font-size: 48px;
            color: #6c757d;
            margin-bottom: 15px;
        }

        .file-upload-text {
            color: #6c757d;
            font-size: 16px;
            margin-bottom: 10px;
        }

        .file-upload-hint {
            color: #6c757d;
            font-size: 14px;
        }

        .file-input {
            display: none;
        }

        /* Styles spécifiques pour l'export */
        .export-info {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 20px;
            border-left: 4px solid #8b0000;
        }

        .export-info h3 {
            color: #8b0000;
            margin-bottom: 10px;
        }

        .export-info p {
            color: #6c757d;
            margin-bottom: 5px;
        }

        .print-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .print-table th,
        .print-table td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
        }

        .print-table th {
            background: linear-gradient(135deg, #8b0000 0%, #5a0000 100%);
            color: white;
            font-weight: 600;
        }

        .print-table tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        /* Styles d'impression */
        @media print {
            .sidebar,
            .top-navbar,
            .modal-header,
            .modal-footer,
            .btn,
            .close-modal {
                display: none !important;
            }

            .modal {
                position: static !important;
                background: none !important;
                z-index: auto !important;
            }

            .export-modal-content {
                width: 100% !important;
                max-width: none !important;
                border-radius: 0 !important;
                box-shadow: none !important;
            }

            .modal-body {
                padding: 0 !important;
            }

            .export-info {
                border: 1px solid #333 !important;
                background: #f0f0f0 !important;
            }

            .print-table {
                page-break-inside: avoid;
            }

            .print-table th {
                background: #333 !important;
                color: white !important;
            }

            body {
                background: white !important;
            }
        }
    </style>
</head>
<body>
<?php include 'sys.php'; ?>
    <!-- Main Content -->
    <main class="main-content">
        <!-- Page Header -->
        <div class="page-header">
            <h1 class="page-title">
                <i class="fas fa-truck"></i>
                Suppliers Management
            </h1>
            <p class="page-subtitle">Manage your suppliers and their information</p>
            <div class="page-actions">
                <button id="openSupplierModal" class="btn btn-primary">
                    <i class="fas fa-plus"></i>
                    Add New Supplier
                </button>
                <button id="openImportModal" class="btn btn-secondary">
                    <i class="fas fa-upload"></i>
                    Import Suppliers
                </button>
                <button id="openExportModal" class="btn btn-secondary">
                    <i class="fas fa-download"></i>
                    Export Data
                </button>
            </div>
        </div>

        <!-- Messages -->
        <?php if (isset($success_message)): ?>
            <div class="alert alert-success">
                <?php echo htmlspecialchars($success_message); ?>
            </div>
        <?php endif; ?>

        <?php if (isset($error_message)): ?>
            <div class="alert alert-error">
                <?php echo htmlspecialchars($error_message); ?>
            </div>
        <?php endif; ?>

        <!-- Export Modal -->
        <div id="exportModal" class="modal">
            <div class="export-modal-content">
                <div class="modal-header">
                    <h2><i class="fas fa-download"></i> Export Suppliers List</h2>
                    <button class="close-modal" type="button">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="export-info">
                        <h3>Liste des Fournisseurs - CH OfficeTrack</h3>
                        <p><strong>Date de génération:</strong> <?php echo date('d/m/Y à H:i'); ?></p>
                        <p><strong>Nombre total de fournisseurs:</strong> <?php echo count($suppliers); ?></p>
                        <p><strong>Statut:</strong> Export généré avec succès</p>
                    </div>
                    
                    <table class="print-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nom du Fournisseur</th>
                                <th>Téléphone</th>
                                <th>Email</th>
                                <th>Adresse</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($suppliers as $supplier): ?>
                            <tr>
                                <td>SPL<?php echo sprintf('%04d', $supplier['id']); ?></td>
                                <td><?php echo htmlspecialchars($supplier['name']); ?></td>
                                <td><?php echo htmlspecialchars($supplier['phone']); ?></td>
                                <td><?php echo htmlspecialchars($supplier['email']); ?></td>
                                <td><?php echo htmlspecialchars($supplier['adresse']); ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary close-modal">Fermer</button>
                    <button type="button" id="printTable" class="btn btn-primary">
                        <i class="fas fa-print"></i>
                        Imprimer
                    </button>
                </div>
            </div>
        </div>

        <!-- Import Suppliers Modal -->
        <div id="importModal" class="modal">
            <div class="modal-content">
                <div class="modal-header">
                    <h2><i class="fas fa-upload"></i> Import Suppliers</h2>
                    <button class="close-modal" type="button">&times;</button>
                </div>
                <div class="modal-body">
                    <form id="importForm" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="action" value="import_suppliers">
                        
                        <div class="file-upload-area" id="fileUploadArea">
                            <div class="file-upload-icon">
                                <i class="fas fa-cloud-upload-alt"></i>
                            </div>
                            <div class="file-upload-text">
                                Glissez-déposez votre fichier CSV ici ou cliquez pour parcourir
                            </div>
                            <div class="file-upload-hint">
                                Format accepté: CSV avec colonnes (Nom, Téléphone, Email, Adresse)
                            </div>
                            <input type="file" id="importFile" name="import_file" class="file-input" accept=".csv" required>
                        </div>
                        
                        <div class="form-group">
                            <label>Instructions:</label>
                            <ul style="margin-top: 10px; padding-left: 20px; color: #6c757d;">
                                <li>Le fichier doit être au format CSV</li>
                                <li>Première ligne doit contenir les en-têtes</li>
                                <li>Colonnes requises: Nom, Téléphone, Email, Adresse</li>
                                <li>Assurez-vous que tous les champs obligatoires sont remplis</li>
                            </ul>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary close-modal">Cancel</button>
                    <button type="submit" form="importForm" class="btn btn-primary">Import Suppliers</button>
                </div>
            </div>
        </div>

        <!-- Add New Supplier Modal -->
        <div id="supplierModal" class="modal">
            <div class="modal-content">
                <div class="modal-header">
                    <h2><i class="fas fa-truck"></i> Add New Supplier</h2>
                    <button class="close-modal" type="button">&times;</button>
                </div>
                <div class="modal-body">
                    <form id="supplierForm" method="POST" action="">
                        <input type="hidden" name="action" value="add_supplier">
                        
                        <div class="form-row">
                            <div class="form-group">
                                <label for="supplierName">Supplier Name</label>
                                <input type="text" id="supplierName" name="supplierName" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="supplierId">Supplier ID</label>
                                <input type="text" id="supplierId" class="form-control" value="SPL<?php echo sprintf('%04d', $next_id); ?>" readonly>
                            </div>
                        </div>
                        
                        <div class="form-row">
                            <div class="form-group">
                                <label for="phoneNumber">Phone Number</label>
                                <input type="tel" id="phoneNumber" name="phoneNumber" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="email">Email Address</label>
                                <input type="email" id="email" name="email" class="form-control" required>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="address">Address</label>
                            <textarea id="address" name="address" class="form-control" rows="3"></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary close-modal">Cancel</button>
                    <button type="submit" form="supplierForm" class="btn btn-primary">Save Supplier</button>
                </div>
            </div>
        </div>

        <!-- Edit Supplier Modal -->
        <div id="editSupplierModal" class="modal">
            <div class="modal-content">
                <div class="modal-header">
                    <h2><i class="fas fa-edit"></i> Edit Supplier</h2>
                    <button class="close-modal" type="button">&times;</button>
                </div>
                <div class="modal-body">
                    <form id="editSupplierForm" method="POST" action="">
                        <input type="hidden" name="action" value="edit_supplier">
                        <input type="hidden" id="editSupplierId" name="supplierId">
                        
                        <div class="form-row">
                            <div class="form-group">
                                <label for="editSupplierName">Supplier Name</label>
                                <input type="text" id="editSupplierName" name="supplierName" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="editSupplierIdDisplay">Supplier ID</label>
                                <input type="text" id="editSupplierIdDisplay" class="form-control" readonly>
                            </div>
                        </div>
                        
                        <div class="form-row">
                            <div class="form-group">
                                <label for="editPhoneNumber">Phone Number</label>
                                <input type="tel" id="editPhoneNumber" name="phoneNumber" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="editEmail">Email Address</label>
                                <input type="email" id="editEmail" name="email" class="form-control" required>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="editAddress">Address</label>
                            <textarea id="editAddress" name="address" class="form-control" rows="3"></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary close-modal">Cancel</button>
                    <button type="submit" form="editSupplierForm" class="btn btn-primary">Update Supplier</button>
                </div>
            </div>
        </div>

        <!-- Delete Confirmation Modal -->
        <div id="deleteSupplierModal" class="modal">
            <div class="modal-content">
                <div class="modal-header">
                    <h2><i class="fas fa-trash"></i> Delete Supplier</h2>
                    <button class="close-modal" type="button">&times;</button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete this supplier? This action cannot be undone.</p>
                    <form id="deleteSupplierForm" method="POST" action="">
                        <input type="hidden" name="action" value="delete_supplier">
                        <input type="hidden" id="deleteSupplierId" name="supplierId">
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary close-modal">Cancel</button>
                    <button type="submit" form="deleteSupplierForm" class="btn btn-primary" style="background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);">Delete</button>
                </div>
            </div>
        </div>

        <br><br><br>

        <!-- Stats Cards -->
        <div class="stats-cards">
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-truck"></i>
                </div>
                <div class="stat-value"><?php echo count($suppliers); ?></div>
                <div class="stat-label">Total Suppliers</div>
            </div>
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div class="stat-value"><?php echo count($suppliers); ?></div>
                <div class="stat-label">Active Suppliers</div>
            </div>
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-clipboard-list"></i>
                </div>
                <div class="stat-value">0</div>
                <div class="stat-label">Total Orders</div>
            </div>
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-star"></i>
                </div>
                <div class="stat-value">5.0</div>
                <div class="stat-label">Average Rating</div>
            </div>
        </div>

        <div class="table-container">
            <table class="suppliers-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Supplier Name</th>
                        <th>Phone</th>
                        <th>E-mail</th>
                        <th>Address</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($suppliers as $supplier): ?>
                    <tr>
                        <td class="supplier-id">SPL<?php echo sprintf('%04d', $supplier['id']); ?></td>
                        <td class="supplier-name"><?php echo htmlspecialchars($supplier['name']); ?></td>
                        <td><?php echo htmlspecialchars($supplier['phone']); ?></td>
                        <td><a href="mailto:<?php echo htmlspecialchars($supplier['email']); ?>" class="supplier-email"><?php echo htmlspecialchars($supplier['email']); ?></a></td>
                        <td><?php echo htmlspecialchars($supplier['adresse']); ?></td>
                        <td>
                            <div class="actions-cell">
                                <button class="action-btn edit-btn tooltip" data-tooltip="Edit" 
                                        data-id="<?php echo $supplier['id']; ?>"
                                        data-name="<?php echo htmlspecialchars($supplier['name']); ?>"
                                        data-phone="<?php echo htmlspecialchars($supplier['phone']); ?>"
                                        data-email="<?php echo htmlspecialchars($supplier['email']); ?>"
                                        data-address="<?php echo htmlspecialchars($supplier['adresse']); ?>">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="action-btn delete-btn tooltip" data-tooltip="Delete"
                                        data-id="<?php echo $supplier['id']; ?>">
                                    <i class="fas fa-trash"></i>
                                </button>
                                <button class="action-btn info-btn tooltip" data-tooltip="Details">
                                    <i class="fas fa-info-circle"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Modal functionality
            const supplierModal = document.getElementById('supplierModal');
            const editSupplierModal = document.getElementById('editSupplierModal');
            const deleteSupplierModal = document.getElementById('deleteSupplierModal');
            const importModal = document.getElementById('importModal');
            const exportModal = document.getElementById('exportModal');
            const openModalBtn = document.getElementById('openSupplierModal');
            const openImportModalBtn = document.getElementById('openImportModal');
            const openExportModalBtn = document.getElementById('openExportModal');
            const closeModalBtns = document.querySelectorAll('.close-modal');
            const supplierForm = document.getElementById('supplierForm');
            const editSupplierForm = document.getElementById('editSupplierForm');
            const importForm = document.getElementById('importForm');
            const printTableBtn = document.getElementById('printTable');
            
            // Open add supplier modal
            openModalBtn.addEventListener('click', function() {
                supplierModal.style.display = 'flex';
                document.body.style.overflow = 'hidden';
            });

            // Open import modal
            openImportModalBtn.addEventListener('click', function() {
                importModal.style.display = 'flex';
                document.body.style.overflow = 'hidden';
            });

            // Open export modal
            openExportModalBtn.addEventListener('click', function() {
                exportModal.style.display = 'flex';
                document.body.style.overflow = 'hidden';
            });

            // Print table function
            printTableBtn.addEventListener('click', function() {
                window.print();
            });
            
            // Close modal
            closeModalBtns.forEach(btn => {
                btn.addEventListener('click', function() {
                    supplierModal.style.display = 'none';
                    editSupplierModal.style.display = 'none';
                    deleteSupplierModal.style.display = 'none';
                    importModal.style.display = 'none';
                    exportModal.style.display = 'none';
                    document.body.style.overflow = 'auto';
                    supplierForm.reset();
                    editSupplierForm.reset();
                    importForm.reset();
                });
            });
            
            // Close modal when clicking outside
            [supplierModal, editSupplierModal, deleteSupplierModal, importModal, exportModal].forEach(modal => {
                modal.addEventListener('click', function(e) {
                    if (e.target === modal) {
                        modal.style.display = 'none';
                        document.body.style.overflow = 'auto';
                        supplierForm.reset();
                        editSupplierForm.reset();
                        importForm.reset();
                    }
                });
            });

            // File upload functionality
            const fileUploadArea = document.getElementById('fileUploadArea');
            const fileInput = document.getElementById('importFile');

            fileUploadArea.addEventListener('click', function() {
                fileInput.click();
            });

            fileUploadArea.addEventListener('dragover', function(e) {
                e.preventDefault();
                this.classList.add('dragover');
            });

            fileUploadArea.addEventListener('dragleave', function(e) {
                e.preventDefault();
                this.classList.remove('dragover');
            });

            fileUploadArea.addEventListener('drop', function(e) {
                e.preventDefault();
                this.classList.remove('dragover');
                const files = e.dataTransfer.files;
                if (files.length > 0) {
                    fileInput.files = files;
                    updateFileUploadText(files[0].name);
                }
            });

            fileInput.addEventListener('change', function() {
                if (this.files.length > 0) {
                    updateFileUploadText(this.files[0].name);
                }
            });

            function updateFileUploadText(filename) {
                const textElement = fileUploadArea.querySelector('.file-upload-text');
                textElement.textContent = `Fichier sélectionné: ${filename}`;
            }
            
            // Edit button functionality
            const editButtons = document.querySelectorAll('.edit-btn');
            editButtons.forEach(btn => {
                btn.addEventListener('click', function() {
                    const id = this.getAttribute('data-id');
                    const name = this.getAttribute('data-name');
                    const phone = this.getAttribute('data-phone');
                    const email = this.getAttribute('data-email');
                    const address = this.getAttribute('data-address');
                    
                    document.getElementById('editSupplierId').value = id;
                    document.getElementById('editSupplierIdDisplay').value = 'SPL' + String(id).padStart(4, '0');
                    document.getElementById('editSupplierName').value = name;
                    document.getElementById('editPhoneNumber').value = phone;
                    document.getElementById('editEmail').value = email;
                    document.getElementById('editAddress').value = address;
                    
                    editSupplierModal.style.display = 'flex';
                    document.body.style.overflow = 'hidden';
                });
            });
            
            // Delete button functionality
            const deleteButtons = document.querySelectorAll('.delete-btn');
            deleteButtons.forEach(btn => {
                btn.addEventListener('click', function() {
                    const id = this.getAttribute('data-id');
                    document.getElementById('deleteSupplierId').value = id;
                    
                    deleteSupplierModal.style.display = 'flex';
                    document.body.style.overflow = 'hidden';
                });
            });
            
            // Tooltip initialization
            const tooltips = document.querySelectorAll('.tooltip');
            
            tooltips.forEach(tooltip => {
                tooltip.addEventListener('mouseenter', function() {
                    const tooltipText = this.getAttribute('data-tooltip');
                    const tooltipElement = document.createElement('div');
                    tooltipElement.className = 'tooltip-text';
                    tooltipElement.textContent = tooltipText;
                    this.appendChild(tooltipElement);
                    
                    setTimeout(() => {
                        tooltipElement.style.opacity = '1';
                        tooltipElement.style.visibility = 'visible';
                        tooltipElement.style.transform = 'translateY(-5px)';
                    }, 10);
                });
                
                tooltip.addEventListener('mouseleave', function() {
                    const tooltipElement = this.querySelector('.tooltip-text');
                    if (tooltipElement) {
                        tooltipElement.remove();
                    }
                });
            });
            
            // Search functionality
            const searchInput = document.querySelector('.search-input');
            
            searchInput.addEventListener('input', function() {
                const searchTerm = this.value.toLowerCase();
                const rows = document.querySelectorAll('.suppliers-table tbody tr');
                
                rows.forEach(row => {
                    const rowText = row.textContent.toLowerCase();
                    if (rowText.includes(searchTerm)) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                });
            });

            // Hide alerts after 5 seconds
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(alert => {
                setTimeout(() => {
                    alert.style.display = 'none';
                }, 5000);
            });
        });
    </script>
</body>
</html>