<?php
class Article {
    private $id_article;
    private $nom;
    private $description;
    private $categorie;
    private $stock_actuel;
    private $seuil_min;
    private $fournisseur;
    private $prix_unitaire;

    // --- Constructeur ---
    public function __construct($id_article = null, $nom = '', $description = '', $categorie = '', $stock_actuel = 0, $seuil_min = 0, $fournisseur = '', $prix_unitaire = 0.0) {
        $this->id_article = $id_article;
        $this->nom = $nom;
        $this->description = $description;
        $this->categorie = $categorie;
        $this->stock_actuel = $stock_actuel;
        $this->seuil_min = $seuil_min;
        $this->fournisseur = $fournisseur;
        $this->prix_unitaire = $prix_unitaire;
    }

    // --- Getters ---
    public function getIdArticle() {
        return $this->id_article;
    }

    public function getNom() {
        return $this->nom;
    }

    public function getDescription() {
        return $this->description;
    }

    public function getCategorie() {
        return $this->categorie;
    }

    public function getStockActuel() {
        return $this->stock_actuel;
    }

    public function getSeuilMin() {
        return $this->seuil_min;
    }

    public function getFournisseur() {
        return $this->fournisseur;
    }

    public function getPrixUnitaire() {
        return $this->prix_unitaire;
    }

    // --- Setters ---
    public function setIdArticle($id_article) {
        $this->id_article = $id_article;
    }

    public function setNom($nom) {
        $this->nom = $nom;
    }

    public function setDescription($description) {
        $this->description = $description;
    }

    public function setCategorie($categorie) {
        $this->categorie = $categorie;
    }

    public function setStockActuel($stock_actuel) {
        $this->stock_actuel = $stock_actuel;
    }

    public function setSeuilMin($seuil_min) {
        $this->seuil_min = $seuil_min;
    }

    public function setFournisseur($fournisseur) {
        $this->fournisseur = $fournisseur;
    }

    public function setPrixUnitaire($prix_unitaire) {
        $this->prix_unitaire = $prix_unitaire;
    }
}
?>
