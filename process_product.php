<?php
// Include database connection and Article class
include 'db.php';
include 'article.php';

// Function to handle file upload
function uploadProductImage($file) {
    $target_dir = "uploads/products/";
    
    // Create directory if it doesn't exist
    if (!file_exists($target_dir)) {
        mkdir($target_dir, 0777, true);
    }
    
    // Generate unique filename
    $file_extension = pathinfo($file["name"], PATHINFO_EXTENSION);
    $unique_filename = uniqid() . '_' . time() . '.' . $file_extension;
    $target_file = $target_dir . $unique_filename;
    
    // Check if image file is a actual image
    $check = getimagesize($file["tmp_name"]);
    if ($check === false) {
        return ['success' => false, 'error' => 'File is not an image.'];
    }
    
    // Check file size (5MB max)
    if ($file["size"] > 5000000) {
        return ['success' => false, 'error' => 'File is too large. Max size is 5MB.'];
    }
    
    // Allow certain file formats
    $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif'];
    if (!in_array(strtolower($file_extension), $allowed_extensions)) {
        return ['success' => false, 'error' => 'Only JPG, JPEG, PNG & GIF files are allowed.'];
    }
    
    // Try to upload file
    if (move_uploaded_file($file["tmp_name"], $target_file)) {
        return ['success' => true, 'filename' => $unique_filename];
    } else {
        return ['success' => false, 'error' => 'There was an error uploading your file.'];
    }
}

// Process form when submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Validate required fields
        $required_fields = ['nom', 'id_categorie', 'date_importation', 'fournisseur', 'unit', 'seuil_min', 'prix_unitaire', 'stock_actuel'];
        $missing_fields = [];
        
        foreach ($required_fields as $field) {
            if (empty($_POST[$field])) {
                $missing_fields[] = $field;
            }
        }
        
        if (!empty($missing_fields)) {
            $error_message = 'Missing required fields: ' . implode(', ', $missing_fields);
            header("Location: addproduct.php?error=" . urlencode($error_message));
            exit();
        }
        
        // Handle image upload if provided
        $image_filename = null;
        if (!empty($_FILES['product_image']['name'])) {
            $upload_result = uploadProductImage($_FILES['product_image']);
            
            if (!$upload_result['success']) {
                header("Location: addproduct.php?error=" . urlencode($upload_result['error']));
                exit();
            }
            
            $image_filename = $upload_result['filename'];
        }
        
        // Calculate total purchase amount
        $total_achat = $_POST['prix_unitaire'] * $_POST['stock_actuel'];
        
        // Prepare SQL statement
        $sql = "INSERT INTO article (
            nom, 
            description, 
            marque, 
            id_categorie, 
            date_importation, 
            fournisseur, 
            unit, 
            seuil_min, 
            current_stock, 
            prix_unitaire, 
            totale_achat, 
            image
        ) VALUES (
            :nom, 
            :description, 
            :marque, 
            :id_categorie, 
            :date_importation, 
            :fournisseur, 
            :unit, 
            :seuil_min, 
            :current_stock, 
            :prix_unitaire, 
            :totale_achat, 
            :image
        )";
        
        $stmt = $pdo->prepare($sql);
      $stmt->bindValue(':nom', $_POST['nom']);
        $stmt->bindValue(':description', $_POST['description'] ?? '');
        $stmt->bindValue(':marque', $_POST['marque']);
        $stmt->bindValue(':id_categorie', $_POST['id_categorie'], PDO::PARAM_INT);
        $stmt->bindValue(':date_importation', $_POST['date_importation']);
        $stmt->bindValue(':fournisseur', $_POST['fournisseur']);
        $stmt->bindValue(':unit', $_POST['unit']);
        $stmt->bindValue(':seuil_min', $_POST['seuil_min'], PDO::PARAM_INT);
        $stmt->bindValue(':current_stock', $_POST['stock_actuel'], PDO::PARAM_INT);
        $stmt->bindValue(':prix_unitaire', $_POST['prix_unitaire']);
        $stmt->bindValue(':totale_achat', $total_achat);
        $stmt->bindValue(':image', $image_filename);

        
        // Execute the statement
        $stmt->execute();
        
        // Redirect with success message
        header("Location: addproduct.php?success=1");
        exit();
        
    } catch (PDOException $e) {
        // Handle database errors
        $error_message = "Database error: " . $e->getMessage();
        header("Location: addproduct.php?error=" . urlencode($error_message));
        exit();
    } catch (Exception $e) {
        // Handle other errors
        $error_message = "Error: " . $e->getMessage();
        header("Location: addproduct.php?error=" . urlencode($error_message));
        exit();
    }
} else {
    // Redirect if not POST request
    header("Location: addproduct.php");
    exit();
}
?>