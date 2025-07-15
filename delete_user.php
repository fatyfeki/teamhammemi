<?php
include 'db.php';

if (isset($_GET['id'])) {
    $userId = $_GET['id'];
    
    try {
        // Delete the user from the database
        $stmt = $pdo->prepare("DELETE FROM Utilisateur WHERE id_utilisateur = ?");
        $stmt->execute([$userId]);
        
        // Return success response
        http_response_code(200);
        exit();
    } catch (PDOException $e) {
        // Return error response
        http_response_code(500);
        echo json_encode(['error' => $e->getMessage()]);
        exit();
    }
} else {
    http_response_code(400);
    echo json_encode(['error' => 'User ID not provided']);
    exit();
}
?>