<?php
header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);
$id = $data['id'] ?? null;

if (!$id) {
    echo json_encode(['success' => false, 'message' => 'ID manquant']);
    exit;
}

try {
    $pdo = new PDO("mysql:host=localhost;dbname=ch office track", "root", "");
    $stmt = $pdo->prepare("DELETE FROM article WHERE id_article = ?");
    $stmt->execute([$id]);
    
    echo json_encode(['success' => true]);
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
?>