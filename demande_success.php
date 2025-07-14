<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Liste des Demandes</title>
  <style>
    body {
      margin: 0;
      font-family: Arial, sans-serif;
      background-color: #2c1109;
      color: #fff;
    }

    .container {
      max-width: 1000px;
      margin: 50px auto;
      background: #3b1c13;
      padding: 20px;
      border-radius: 15px;
      box-shadow: 0 0 10px rgba(0,0,0,0.5);
    }

    h2 {
      text-align: center;
      color: #f5b392;
      font-size: 28px;
      margin-bottom: 20px;
    }

    .success-message {
      background-color: #e9ffe8;
      color: #145c16;
      padding: 10px 20px;
      border-radius: 8px;
      margin: 20px auto;
      max-width: 1000px;
      font-weight: bold;
      text-align: center;
    }

    table {
      width: 100%;
      border-collapse: collapse;
    }

    th, td {
      padding: 12px 15px;
      border-bottom: 1px solid #6e3a2d;
      text-align: left;
    }

    th {
      background-color: #5c2b20;
      color: black;
    }

    td {
      background-color: #402018;
      color: #f0e4d7;
    }

    a {
      color: #add8e6;
      text-decoration: underline;
    }

    a:hover {
      color: #fff;
    }
  </style>
</head>
<body>

</body>
</html>

<?php
require_once 'db.php';
require_once 'demande.php';

// Get all demands to display
$demandes = Demande::getAll($pdo);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Demande Enregistrée</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            line-height: 1.6;
        }
        .success-message {
            background-color: #dff0d8;
            color: #3c763d;
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 4px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
    </style>
</head>
<body>
    <div class="success-message">
        Votre demande a été enregistrée avec succès!
    </div>

    <h2>Liste des Demandes</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Produit</th>
                <th>Catégorie</th>
                <th>Quantité</th>
                <th>Urgent</th>
                <th>Date</th>
                <th>Fichier</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($demandes as $demande): ?>
            <tr>
                <td><?= htmlspecialchars($demande['id']) ?></td>
                <td><?= htmlspecialchars($demande['product_name']) ?></td>
                <td><?= htmlspecialchars($demande['category']) ?></td>
                <td><?= htmlspecialchars($demande['quantity']) ?></td>
                <td><?= htmlspecialchars($demande['urgent']) ?></td>
                <td><?= htmlspecialchars($demande['date_demande']) ?></td>
                <td>
                    <?php if ($demande['file_name']): ?>
                        <a href="uploads/<?= htmlspecialchars($demande['file_name']) ?>" target="_blank">Voir fichier</a>
                    <?php else: ?>
                        Aucun fichier
                    <?php endif; ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>