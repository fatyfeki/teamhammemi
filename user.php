<?php 
class Utilisateur {
    private $id_utilisateur;
    private $nom;
    private $prenom;
    private $email;
    private $PhoneNumber; // ✅ Ajout du numéro de téléphone
    private $mot_de_passe;
    private $fonction;

    // --- Constructeur ---
   public function __construct($id_utilisateur = null, $nom = '', $prenom = '', $email = '', $PhoneNumber = '', $mot_de_passe = '', $fonction = '') {
    $this->id_utilisateur = $id_utilisateur;
    $this->nom = $nom;
    $this->prenom = $prenom;
    $this->email = $email;
    $this->PhoneNumber = $PhoneNumber;
    $this->mot_de_passe = $mot_de_passe;
    $this->fonction = $fonction;
}

    // --- Getters ---
    public function getIdUtilisateur() {
        return $this->id_utilisateur;
    }

    public function getNom() {
        return $this->nom;
    }

    public function getPrenom() {
        return $this->prenom;
    }

    public function getEmail() {
        return $this->email;
    }

    public function getPhoneNumber() { // ✅ Getter téléphone
        return $this->PhoneNumber;
    }

    public function getMotDePasse() {
        return $this->mot_de_passe;
    }

    public function getFonction() {
        return $this->fonction;
    }

    // --- Setters ---
    public function setIdUtilisateur($id_utilisateur) {
        $this->id_utilisateur = $id_utilisateur;
    }

    public function setNom($nom) {
        $this->nom = $nom;
    }

    public function setPrenom($prenom) {
        $this->prenom = $prenom;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    public function setPhoneNumber($PhoneNumber) {
    $this->PhoneNumber = $PhoneNumber;
}
    public function setMotDePasse($mot_de_passe) {
        $this->mot_de_passe = $mot_de_passe;
    }

    public function setFonction($fonction) {
        $this->fonction = $fonction;
    }
}
?>
