<?php
// PHP processing at the top of the file
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $product = isset($_POST['product_name']) ? htmlspecialchars($_POST['product_name']) : '';
    $category = isset($_POST['category']) ? htmlspecialchars($_POST['category']) : '';
    $quantity = isset($_POST['quantity']) ? intval($_POST['quantity']) : 0;
    $urgent = isset($_POST['urgent']) ? htmlspecialchars($_POST['urgent']) : '';
    $reason = isset($_POST['reason']) ? htmlspecialchars($_POST['reason']) : '';
    $comment = isset($_POST['comment']) ? htmlspecialchars($_POST['comment']) : '';
    $uploadStatus = '';

    // Gestion du fichier uploadé
    if (isset($_FILES['file']) && $_FILES['file']['error'] == UPLOAD_ERR_OK) {
        $uploadDir = "uploads/";
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }
        
        $fileTmp = $_FILES['file']['tmp_name'];
        $fileName = basename($_FILES['file']['name']);
        $filePath = $uploadDir . $fileName;
        $allowedTypes = ['image/jpeg', 'image/png', 'application/pdf'];
        $fileType = mime_content_type($fileTmp);

        if (in_array($fileType, $allowedTypes)) {
            if (move_uploaded_file($fileTmp, $filePath)) {
                $uploadStatus = "<p>File uploaded successfully: $fileName</p>";
            } else {
                $uploadStatus = "<p>Error uploading the file.</p>";
            }
        } else {
            $uploadStatus = "<p>Invalid file type. Only JPEG, PNG, and PDF are allowed.</p>";
        }
    }

    // Display the results
    echo "<div style='max-width: 600px; margin: 20px auto; padding: 20px; background: rgba(255,255,255,0.9); border-radius: 8px;'>";
    echo "<h2 style='color: #4a2c20;'>Demand Received:</h2>";
    echo $uploadStatus;
    echo "<ul style='list-style: none; padding: 0;'>";
    echo "<li style='margin-bottom: 10px;'><strong>Product:</strong> $product</li>";
    echo "<li style='margin-bottom: 10px;'><strong>Category:</strong> $category</li>";
    echo "<li style='margin-bottom: 10px;'><strong>Quantity:</strong> $quantity</li>";
    echo "<li style='margin-bottom: 10px;'><strong>Urgent:</strong> $urgent</li>";
    echo "<li style='margin-bottom: 10px;'><strong>Reason:</strong> $reason</li>";
    echo "<li style='margin-bottom: 10px;'><strong>Comment:</strong> $comment</li>";
    echo "</ul>";
    echo "</div>";
    
    // Stop execution after displaying results
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Formulaire de Demande</title>
   <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background: linear-gradient(135deg, #2c1810 0%, #4a2c20 100%);
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 20px;
    }

    form {
      background: rgba(255, 255, 255, 0.08);
      padding: 40px;
      width: 100%;
      max-width: 500px;
      border: 1px solid rgba(255, 255, 255, 0.1);
      border-radius: 16px;
      backdrop-filter: blur(10px);
      box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
    }

    h2 {
      text-align: center;
      color: #e8b4a0;
      font-size: 2.2em;
      margin-bottom: 30px;
      font-weight: 300;
      letter-spacing: 2px;
      text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
    }

    label {
      display: block;
      margin-bottom: 8px;
      color: #e8b4a0;
      font-weight: 600;
      font-size: 1.1em;
    }

    input[type="text"],
    input[type="number"],
    input[type="file"],
    select,
    textarea {
      width: 100%;
      margin-bottom: 20px;
      padding: 12px 16px;
      border: 2px solid rgba(232, 180, 160, 0.3);
      border-radius: 8px;
      background: rgba(255, 255, 255, 0.1);
      color: #f5f5f5;
      font-size: 16px;
      transition: all 0.3s ease;
      backdrop-filter: blur(5px);
    }

    input[type="text"]:focus,
    input[type="number"]:focus,
    select:focus,
    textarea:focus {
      outline: none;
      border-color: #e8b4a0;
      background: rgba(255, 255, 255, 0.15);
      box-shadow: 0 0 20px rgba(232, 180, 160, 0.3);
    }

    input::placeholder,
    textarea::placeholder {
      color: rgba(245, 245, 245, 0.6);
    }

    select {
      cursor: pointer;
    }

    select option {
      background: #4a2c20;
      color: #f5f5f5;
    }

    /* Style pour le file input */
    input[type="file"] {
      border: 2px dashed rgba(232, 180, 160, 0.5);
      padding: 20px;
      text-align: center;
      cursor: pointer;
      transition: all 0.3s ease;
    }

    input[type="file"]:hover {
      border-color: #e8b4a0;
      background: rgba(255, 255, 255, 0.15);
    }

    .radio-group {
      display: flex;
      gap: 20px;
      margin-bottom: 20px;
      background: rgba(211, 47, 47, 0.1);
      padding: 15px;
      border-radius: 8px;
      border-left: 4px solid #d32f2f;
    }

    .radio-group label {
      display: flex;
      align-items: center;
      gap: 8px;
      cursor: pointer;
      color: #f5f5f5;
      font-weight: normal;
      margin-bottom: 0;
    }

    input[type="radio"] {
      width: 20px;
      height: 20px;
      accent-color: #e8b4a0;
    }

    textarea {
      resize: vertical;
      min-height: 120px;
    }

    .btn {
      background: linear-gradient(135deg, #d32f2f 0%, #b71c1c 100%);
      color: white;
      padding: 15px 40px;
      border: none;
      border-radius: 8px;
      cursor: pointer;
      font-size: 18px;
      font-weight: 600;
      text-transform: uppercase;
      letter-spacing: 1px;
      transition: all 0.3s ease;
      width: 100%;
      box-shadow: 0 4px 15px rgba(211, 47, 47, 0.3);
    }

    .btn:hover {
      background: linear-gradient(135deg, #f44336 0%, #d32f2f 100%);
      transform: translateY(-2px);
      box-shadow: 0 6px 20px rgba(211, 47, 47, 0.4);
    }

    .btn:active {
      transform: translateY(0);
    }

    /* Animation au chargement */
    form {
      opacity: 0;
      transform: translateY(20px);
      animation: fadeInUp 0.6s ease forwards;
    }

    @keyframes fadeInUp {
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    /* Responsive */
    @media (max-width: 768px) {
      form {
        padding: 20px;
        margin: 10px;
      }
      
      h2 {
        font-size: 1.8em;
      }
      
      .radio-group {
        flex-direction: column;
        gap: 10px;
      }
    }

    /* Styles pour les champs requis */
    input[required]:invalid {
      border-color: rgba(244, 67, 54, 0.5);
    }

    input[required]:valid {
      border-color: rgba(76, 175, 80, 0.5);
    }

    /* Ajout d'un indicateur pour les champs requis */
    label[for] {
      position: relative;
    }

    input[required] + label::after,
    select[required] + label::after {
      content: " *";
      color: #ff6b6b;
      font-weight: bold;
    }
  </style>
</head>
<body>
<form action="process_demande.php" method="post" enctype="multipart/form-data">
<h2>DEMANDE</h2>
    
    <label for="product_name">Nom du Produit</label>
    <input type="text" id="product_name" name="product_name" placeholder="Nom" required>
    
    <label for="category">Catégorie</label>
    <select id="category" name="category" required>
      <option value="">Sélectionner une catégorie</option>
      <option value="IT">Informatique</option>
      <option value="Office">Bureau</option>
      <option value="Furniture">Mobilier</option>
    </select>
    
    <label for="quantity">Quantité</label>
    <input type="number" id="quantity" name="quantity" min="1" value="1" required>
    
    <label for="file">Joindre un Fichier</label>
    <input type="file" id="file" name="file">
    
    <label>Demande Urgente</label>
    <div class="radio-group">
      <label><input type="radio" name="urgent" value="yes" required> Oui</label>
      <label><input type="radio" name="urgent" value="no"> Non</label>
    </div>
    
    <label for="reason">Raison</label>
    <input type="text" id="reason" name="reason" placeholder="Pourquoi ...">
    
    <label for="comment">Commentaire</label>
    <textarea id="comment" name="comment" placeholder="Comment puis-je vous aider ..." rows="4"></textarea>
    
    <button type="submit" class="btn">Envoyer</button>
  </form>

  <script>
    // Validation en temps réel
    document.querySelectorAll('input[required], select[required]').forEach(field => {
      field.addEventListener('blur', function() {
        if (this.value.trim() === '') {
          this.style.borderColor = 'rgba(244, 67, 54, 0.7)';
        } else {
          this.style.borderColor = 'rgba(76, 175, 80, 0.7)';
        }
      });
    });

    // Animation du bouton lors de la soumission
    document.querySelector('form').addEventListener('submit', function(e) {
      const btn = document.querySelector('.btn');
      btn.textContent = 'Envoi en cours...';
      btn.disabled = true;
    });

    // Amélioration du file input
    document.getElementById('file').addEventListener('change', function(e) {
      if (e.target.files.length > 0) {
        this.style.borderColor = 'rgba(76, 175, 80, 0.7)';
      }
    });
  </script>
</body>
</html>