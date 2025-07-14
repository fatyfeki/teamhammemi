<?php
require_once 'db.php';

class Demande {
    private $id;
    private $product_name;
    private $category;
    private $quantity;
    private $urgent;
    private $reason;
    private $comment;
    private $file_name;
    private $date_demande;

    // Constructeur
    public function __construct($product_name, $category, $quantity, $urgent, $reason, $comment, $file_name = null) {
        $this->product_name = $product_name;
        $this->category = $category;
        $this->quantity = $quantity;
        $this->urgent = $urgent;
        $this->reason = $reason;
        $this->comment = $comment;
        $this->file_name = $file_name;
    }

    // === Méthode pour insérer la demande dans la base ===
    public function enregistrer(PDO $pdo) {
        $sql = "INSERT INTO demandes (product_name, category, quantity, urgent, reason, comment, file_name)
                VALUES (:product_name, :category, :quantity, :urgent, :reason, :comment, :file_name)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            'product_name' => $this->product_name,
            'category'     => $this->category,
            'quantity'     => $this->quantity,
            'urgent'       => $this->urgent,
            'reason'       => $this->reason,
            'comment'      => $this->comment,
            'file_name'    => $this->file_name
        ]);
        $this->id = $pdo->lastInsertId();
    }

    // === Méthode statique pour récupérer toutes les demandes ===
    public static function getAll(PDO $pdo) {
        $stmt = $pdo->query("SELECT * FROM demandes ORDER BY date_demande DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // === Getters ===
    public function getId() { return $this->id; }
    public function getProductName() { return $this->product_name; }
    public function getCategory() { return $this->category; }
    public function getQuantity() { return $this->quantity; }
    public function getUrgent() { return $this->urgent; }
    public function getReason() { return $this->reason; }
    public function getComment() { return $this->comment; }
    public function getFileName() { return $this->file_name; }
    public function getDateDemande() { return $this->date_demande; }

    // === Setters (si besoin) ===
    public function setProductName($name) { $this->product_name = $name; }
    public function setCategory($cat) { $this->category = $cat; }
    public function setQuantity($q) { $this->quantity = $q; }
    public function setUrgent($u) { $this->urgent = $u; }
    public function setReason($r) { $this->reason = $r; }
    public function setComment($c) { $this->comment = $c; }
    public function setFileName($f) { $this->file_name = $f; }
}
?>
