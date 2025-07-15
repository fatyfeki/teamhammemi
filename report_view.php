<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ch office track";

try {
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    $reportType = $_GET['type'] ?? 'all';
    
    // Query data
    $query = "SELECT a.*, c.nom_categorie 
              FROM article a
              LEFT JOIN categories c ON a.id_categorie = c.id_categorie
              WHERE ";
    
    switch($reportType) {
        case 'critical':
            $query .= "a.current_stock = 0";
            break;
        case 'warning':
            $query .= "a.current_stock > 0 AND a.current_stock <= a.seuil_min";
            break;
        case 'info':
            $query .= "a.current_stock <= (a.seuil_min * 0.5)";
            break;
        default:
            $query .= "(a.current_stock = 0 OR a.current_stock <= a.seuil_min)";
    }
    
    $stmt = $pdo->query($query);
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
} catch(PDOException $e) {
    die("Database error: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stock Alert Report - CH OfficeTrack</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f5f5f5;
        }
        .report-container {
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            padding: 20px;
            max-width: 1200px;
            margin: 0 auto;
        }
        .report-header {
            text-align: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 1px solid #eee;
        }
        .report-title {
            color: #dc3545;
            margin: 0;
        }
        .report-date {
            color: #666;
            font-size: 14px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #dc3545;
            color: white;
            font-weight: bold;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        tr:hover {
            background-color: #f1f1f1;
        }
        .status-critical {
            color: #dc3545;
            font-weight: bold;
        }
        .status-warning {
            color: #ffc107;
            font-weight: bold;
        }
        .status-normal {
            color: #28a745;
        }
        .print-btn {
            background: #dc3545;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 4px;
            cursor: pointer;
            margin-bottom: 20px;
            font-size: 16px;
        }
        .print-btn:hover {
            background: #c82333;
        }
    </style>
</head>
<body>
    <div class="report-container">
        <div class="report-header">
            <h1 class="report-title">Stock Alert Report</h1>
            <div class="report-date">Generated on: <?php echo date('Y-m-d H:i:s'); ?></div>
            <div class="report-subtitle">Report Type: <?php echo ucfirst($reportType); ?></div>
        </div>
        
        <button class="print-btn" onclick="window.print()">
            <i class="fas fa-print"></i> Print Report
        </button>
        
        <table>
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Category</th>
                    <th>Current Stock</th>
                    <th>Min Stock</th>
                    <th>Status</th>
                    <th>Unit Price</th>
                    <th>Supplier</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($products as $product): ?>
                <?php
                    $status = '';
                    $statusClass = '';
                    if ($product['current_stock'] == 0) {
                        $status = 'Out of Stock';
                        $statusClass = 'status-critical';
                    } elseif ($product['current_stock'] <= $product['seuil_min'] * 0.5) {
                        $status = 'Critical';
                        $statusClass = 'status-critical';
                    } elseif ($product['current_stock'] <= $product['seuil_min']) {
                        $status = 'Low Stock';
                        $statusClass = 'status-warning';
                    } else {
                        $status = 'Normal';
                        $statusClass = 'status-normal';
                    }
                ?>
                <tr>
                    <td><?php echo htmlspecialchars($product['nom']); ?></td>
                    <td><?php echo htmlspecialchars($product['nom_categorie']); ?></td>
                    <td><?php echo $product['current_stock'] . ' ' . htmlspecialchars($product['unit']); ?></td>
                    <td><?php echo $product['seuil_min'] . ' ' . htmlspecialchars($product['unit']); ?></td>
                    <td class="<?php echo $statusClass; ?>"><?php echo $status; ?></td>
                    <td><?php echo number_format($product['prix_unitaire'], 2); ?> TND</td>
                    <td><?php echo htmlspecialchars($product['fournisseur']); ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>