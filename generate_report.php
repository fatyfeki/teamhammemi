<?php
require_once 'tcpdf/tcpdf.php'; // Adjust path as needed

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ch office track";

try {
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    $reportType = $_POST['report_type'] ?? 'all';
    
    // Create PDF first to catch any TCPDF errors
    $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
    
    // Set document information
    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetAuthor('CH OfficeTrack');
    $pdf->SetTitle('Stock Alert Report');
    $pdf->SetSubject('Stock Alerts');
    
    // Set default header data
    $pdf->SetHeaderData('', 0, 'Stock Alert Report', 'Generated on: '.date('Y-m-d H:i:s'));
    
    // Set header and footer fonts
    $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
    $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
    
    // Set default monospaced font
    $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
    
    // Set margins
    $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
    $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
    $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
    
    // Set auto page breaks
    $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
    
    // Add a page
    $pdf->AddPage();
    
    // Set font
    $pdf->SetFont('helvetica', '', 10);
    
    // Add content
    $pdf->writeHTML('<h1>Stock Alert Report</h1>', true, false, true, false, '');
    
    // Query data
    $query = "SELECT a.*, c.nom_categorie 
              FROM article a
              LEFT JOIN categories c ON a.id_categorie = c.id_categorie";
    
    switch($reportType) {
        case 'critical':
            $query .= " WHERE a.current_stock = 0";
            break;
        case 'warning':
            $query .= " WHERE a.current_stock > 0 AND a.current_stock <= a.seuil_min";
            break;
        case 'info':
            $query .= " WHERE a.current_stock <= (a.seuil_min * 0.5)";
            break;
        default:
            $query .= " WHERE a.current_stock = 0 OR a.current_stock <= a.seuil_min";
    }
    
    $stmt = $pdo->query($query);
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Create HTML table
    $html = '<table border="1" cellpadding="4">
        <tr style="background-color:#f2f2f2;">
            <th>Product</th>
            <th>Category</th>
            <th>Current Stock</th>
            <th>Min Stock</th>
            <th>Status</th>
        </tr>';
    
    foreach($products as $product) {
        $status = ($product['current_stock'] == 0) ? 'Out of Stock' : 
                 (($product['current_stock'] <= $product['seuil_min'] * 0.5) ? 'Critical' : 'Low Stock');
        
        $html .= '<tr>
            <td>'.htmlspecialchars($product['nom']).'</td>
            <td>'.htmlspecialchars($product['nom_categorie']).'</td>
            <td>'.$product['current_stock'].' '.htmlspecialchars($product['unit']).'</td>
            <td>'.$product['seuil_min'].' '.htmlspecialchars($product['unit']).'</td>
            <td>'.$status.'</td>
        </tr>';
    }
    
    $html .= '</table>';
    
    // Output the HTML content
    $pdf->writeHTML($html, true, false, true, false, '');
    
    // Close and output PDF document
    $pdf->Output('stock_report.pdf', 'D');
    
} catch(PDOException $e) {
    header('Content-Type: application/json');
    die(json_encode(['success' => false, 'message' => 'Database error: '.$e->getMessage()]));
} catch(Exception $e) {
    header('Content-Type: application/json');
    die(json_encode(['success' => false, 'message' => 'PDF generation error: '.$e->getMessage()]));
}
?>