<?php 
require_once('./Model/pdo.php');
require_once('./Model/MenuPdo.php');
class BoissonManager {
    private $id;
    private $nom;
    private $description;
    private $prix;
    private $image;
    private $isAvailable;
    private $createdAt;
    private $updatedAt;
    
    public function __construct($id, $nom, $description, $prix, $image, $isAvailable, $createdAt, $updatedAt) {
        $this->id = $id;
        $this->nom = $nom;
        $this->description = $description;
        $this->prix = $prix;
        $this->image = $image;
        $this->isAvailable = $isAvailable;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
    }
    
    // Getters
    public function getId() {
        return $this->id;
    }
    
    public function getNom() {
        return $this->nom;
    }
    
    public function getDescription() {
        return $this->description;
    }
    
    public function getPrix() {
        return $this->prix;
    }
    
    public function getImage() {
        return $this->image;
    }
    
    public function getIsAvailable() {
        return $this->isAvailable;
    }
    
    public function getCreatedAt() {
        return $this->createdAt;
    }
    
    public function getUpdatedAt() {
        return $this->updatedAt;
    }
    
    // Setters
    public function setNom($nom) {
        $this->nom = $nom;
    }
    
    public function setDescription($description) {
        $this->description = $description;
    }
    
    public function setPrix($prix) {
        $this->prix = $prix;
    }
    
    public function setImage($image) {
        $this->image = $image;
    }
    
    public function setIsAvailable($isAvailable) {
        $this->isAvailable = $isAvailable;
    }
}
?>