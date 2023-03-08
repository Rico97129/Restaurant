<?php
require_once('Model/pdo.php');
require_once('./manager/boissonManager.php');

/**
 * Classe d'accès aux données pour la gestion des boissons
 */
class BoissonsPdo {
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
    /**
     * Retourne tous les boissons disponibles dans la base de données
     * @return array Un tableau d'objets boisson représentant les boissons
     */
    public static function getAllBoissons() {
        try {
            $boissons = array();
            
    
            $req ="SELECT * FROM boissons WHERE is_available = 1 ORDER BY id DESC";
            $pdo = PdoMusic::getPdoMusic();
            $stmt = $pdo::getMonPdo()->prepare($req) ;
            $stmt->setFetchMode(PDO::FETCH_OBJ);
            $stmt->execute();
          
    
           
            
            $stmt->execute() ;
            
            $boissons=$stmt->fetchAll();
        return  $boissons;
        } catch (PDOException $e) {
            echo "Erreur lors de la récupération des boissons : " . $e->getMessage();
            return array();
        } finally {
            // Log a message to the console
            error_log("getAllBoissons() called");
        }
    }
    

    /**
     * Retourne un boisson à partir de son identifiant
     * @param int $id L'identifiant du boisson
     * @return boisson|null L'objet boisson correspondant à l'identifiant, ou null si le boisson n'existe pas
     */
    public static function getBoissonById($id) {
        try {
            $pdo = PdoMusic::getPdoMusic()->getMonPdo();

            $stmt = $pdo->prepare("SELECT * FROM boissons WHERE id = ?");
            $stmt->execute(array($id));

            if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $boisson = new BoissonsPdo($row['id'], $row['nom'], $row['description'], $row['prix'], $row['image'], $row['is_available'], $row['created_at'], $row['updated_at']);
                return $boisson;
            } else {
                return null;
            }
        } catch (PDOException $e) {
            echo "Erreur lors de la récupération du boisson : " . $e->getMessage();
            return null;
        }
    }

    /**
     * Met à jour les informations d'un boisson dans la base de données
     * @param boisson $boisson L'objet boisson à mettre à jour
     * @return bool True si la mise à jour a réussi, false sinon
     */
    public static function updateboisson(boisson $boisson) {
        try {
            $pdo = PdoMusic::getMonPdo();

            $stmt = $pdo->prepare("UPDATE boissons SET nom = ?, description = ?, prix = ?, image = ?, is_available = ?, updated_at = NOW() WHERE id = ?");
            $stmt->execute(array($boisson->getNom(), $boisson->getDescription(), $boisson->getPrix(), $boisson->getImage(), $boisson->isAvailable(), $boisson->getId()));

            return $stmt->rowCount() > 0;
        } catch (PDOException $e) {
            echo "Erreur lors de la mise à jour du boisson : " . $e->getMessage();
            return false;
        }
    }
}
?>