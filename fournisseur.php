<?php
// fournisseur.php
class Fournisseur {
    // Propriétés
    private $id;
    private $name;
    private $phone;
    private $email;
    private $adresse;
    private $id_article;

    // Constructeur
    public function __construct($id, $name, $phone, $email, $adresse, $id_article) {
        $this->id = $id;
        $this->name = $name;
        $this->phone = $phone;
        $this->email = $email;
        $this->adresse = $adresse;
        $this->id_article = $id_article;
    }

    // Getters
    public function getId() {
        return $this->id;
    }

    public function getName() {
        return $this->name;
    }

    public function getPhone() {
        return $this->phone;
    }

    public function getEmail() {
        return $this->email;
    }

    public function getAdresse() {
        return $this->adresse;
    }

    public function getIdArticle() {
        return $this->id_article;
    }

    // Setters
    public function setId($id) {
        $this->id = $id;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function setPhone($phone) {
        $this->phone = $phone;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    public function setAdresse($adresse) {
        $this->adresse = $adresse;
    }

    public function setIdArticle($id_article) {
        $this->id_article = $id_article;
    }

    // Méthode pour enregistrer le fournisseur dans la base de données
    public function save() {
        $db = Database::getInstance()->getConnection();
        
        try {
            $stmt = $db->prepare("INSERT INTO fournisseur (id, name, phone, email, adresse, id_article) 
                                VALUES (:id, :name, :phone, :email, :adresse, :id_article)");
            
            $stmt->execute([
                ':id' => $this->id,
                ':name' => $this->name,
                ':phone' => $this->phone,
                ':email' => $this->email,
                ':adresse' => $this->adresse,
                ':id_article' => $this->id_article
            ]);
            
            return true;
        } catch (PDOException $e) {
            error_log("Erreur lors de l'ajout du fournisseur: " . $e->getMessage());
            return false;
        }
    }

    // Méthode statique pour récupérer tous les fournisseurs
    public static function getAll() {
        $db = Database::getInstance()->getConnection();
        
        try {
            $stmt = $db->query("SELECT * FROM fournisseur ORDER BY name");
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Erreur lors de la récupération des fournisseurs: " . $e->getMessage());
            return [];
        }
    }
}

// database.php (nouveau fichier à créer)
class Database {
    private static $instance = null;
    private $connection;
    
    private function __construct() {
        try {
            $this->connection = new PDO(
                "mysql:host=localhost;dbname=CH_OfficeTrack", 
                "root", 
                ""
            );
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Erreur de connexion à la base de données: " . $e->getMessage());
        }
    }
    
    public static function getInstance() {
        if (!self::$instance) {
            self::$instance = new Database();
        }
        return self::$instance;
    }
    
    public function getConnection() {
        return $this->connection;
    }
}
?>