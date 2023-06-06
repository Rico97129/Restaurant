<?php
require_once('Model/pdo.php');

/**
 * Classe d'accès aux données pour la gestion des boissons
 */
class BoissonsPdo {
    private $nom;
    private $description;
    private $prix;
    private $image;

    public function __construct($nom, $description, $prix, $image) {
        $this->nom = $nom;
        $this->description = $description;
        $this->prix = $prix;
        $this->image = $image;
    }

    public function getNom() {
        return $this->nom;
    }

    public function setNom($nom) {
        $this->nom = $nom;
    }

    public function getDescription() {
        return $this->description;
    }

    public function setDescription($description) {
        $this->description = $description;
    }

    public function getPrix() {
        return $this->prix;
    }

    public function setPrix($prix) {
        $this->prix = $prix;
    }

    public function getImage() {
        return $this->image;
    }

    public function setImage($image) {
        $this->image = $image;
    }

    public static function ajouterBoisson($nom, $description, $prix, $image) {
        try {
            $pdo = PdoMusic::getPdoMusic()->getMonPdo();

            $stmt = $pdo->prepare("INSERT INTO boissons (nom, description, prix, image) VALUES (:nom, :description, :prix, :image)");
            $stmt->bindValue(':nom', $nom);
            $stmt->bindValue(':description', $description);
            $stmt->bindValue(':prix', $prix);
            $stmt->bindValue(':image', $image);
            $stmt->execute();
        } catch (PDOException $e) {
            echo "Erreur lors de l'ajout de la boisson : " . $e->getMessage();
        }
    }

    public static function getAllBoissons() {
        try {
            $boissons = array();
            $pdo = PdoMusic::getPdoMusic()->getMonPdo();
            $stmt = $pdo->prepare("SELECT * FROM boissons WHERE is_available = 1 ORDER BY id DESC");
            $stmt->setFetchMode(PDO::FETCH_OBJ);
            $stmt->execute();
            $boissons = $stmt->fetchAll();
            return $boissons;
        } catch (PDOException $e) {
            echo "Erreur lors de la récupération des boissons : " . $e->getMessage();
            return array();
        } finally {
            error_log("getAllBoissons() called");
        }
    }

    public static function getBoissonById($id) {
        try {
            $pdo = PdoMusic::getPdoMusic()->getMonPdo();
            $stmt = $pdo->prepare("SELECT nom, description, prix, image FROM boissons WHERE id = ?");
            $stmt->execute(array($id));

            if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $boisson = new BoissonsPdo($row['nom'], $row['description'], $row['prix'], $row['image']);
                return $boisson;
            } else {
                return null;
            }
        } catch (PDOException $e) {
            echo "Erreur lors de la récupération de la boisson : " . $e->getMessage();
            return null;
        }
    }

    public static function findBoissonByNom($nom) {
        try {
            $pdo = PdoMusic::getPdoMusic()->getMonPdo();
            $stmt = $pdo->prepare("SELECT COUNT(*) FROM boissons WHERE nom = :nom");
            $stmt->bindValue(':nom', $nom);
            $stmt->execute();
            $count = $stmt->fetchColumn();
            return $count;
        } catch (PDOException $e) {
            echo "Erreur lors de la recherche de la boisson par nom : " . $e->getMessage();
            return false;
        }
    }

    public static function deleteBoisson($id) {
        try {
            $pdo = PdoMusic::getPdoMusic()->getMonPdo();
            $stmt = $pdo->prepare("DELETE FROM boissons WHERE id = :id");
            $stmt->bindValue(':id', $id);
            $stmt->execute();
            $rowCount = $stmt->rowCount();
            return $rowCount > 0;
        } catch (PDOException $e) {
            echo "Erreur lors de la suppression de la boisson : " . $e->getMessage();
            return false;
        }
    }
}
?>
