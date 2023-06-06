<?php
require_once('Model/pdo.php');
// require_once('./manager/burgerManager.php');

/**
 * Classe d'accès aux données pour la gestion des burgers
 */
class BurgersPdo {

    private $id;
    private $nom; // Define the nom property
    private $description;
    private $prix;
    private $image;

    public function __construct($nom, $description, $prix,$image ) {
        $this->nom = $nom; // Assign the nom parameter to the nom property
        $this->description = $description;
        $this->prix = $prix;
        $this->image = $image;
    }

    // Getter method for nom property
    public function getNom() {
        return $this->nom;
    }

    // Setter method for nom property
    public function setNom($nom) {
        $this->nom = $nom;
    }
    
    // Getter method for nom property
    public function getPrix() {
        return $this->prix;
    }

    // Setter method for nom property
    public function setImage($image) {
        $this->nom = $image;
    }
     // Getter method for nom property
     public function getImage() {
        return $this->image;
    }

    // Setter method for nom property
    public function setPrix($prix) {
        $this->nom = $prix;
    }
 // Getter method for nom property
 public function getDescription() {
    return $this->description;
}

// Setter method for nom property
public function setDescription($description) {
    $this->nom = $description;
}
    // Other methods...
    public static function ajouterBurger($nom, $description, $prix, $image) {
        // Connexion à la base de données
        $pdo = PdoMusic::getPdoMusic()->getMonPdo();
    
        // Préparation de la requête SQL avec les paramètres nommés
        $stmt = $pdo->prepare("INSERT INTO burgers (nom, description, prix, image) VALUES (:nom, :description, :prix, :image)");
    
        // Association des valeurs aux paramètres nommés
        $stmt->bindValue(':nom', $nom);
        $stmt->bindValue(':description', $description);
        $stmt->bindValue(':prix', $prix);
        $stmt->bindValue(':image', $image);
    
        // Exécution de la requête préparée
        $stmt->execute();
    }
    

    /**
     * Retourne tous les burgers disponibles dans la base de données
     * @return array Un tableau d'objets burger représentant les burgers
     */
    public static function getAllBurgers() {
        try {
            $burgers = array();
            
    
            $req ="SELECT * FROM burgers WHERE is_available = 1 ORDER BY id DESC";
            $pdo = PdoMusic::getPdoMusic();
            $stmt = $pdo::getMonPdo()->prepare($req) ;
            $stmt->setFetchMode(PDO::FETCH_OBJ);
            $stmt->execute();
          
    
           
            
            $stmt->execute() ;
            
            $burgers=$stmt->fetchAll();
        return $burgers;
        } catch (PDOException $e) {
            echo "Erreur lors de la récupération des burgers : " . $e->getMessage();
            return array();
        } finally {
            // Log a message to the console
            error_log("getAllburgers() called");
        }
    }
    

    /**
     * Retourne un burger à partir de son identifiant
     * @param int $id L'identifiant du burger
     * @return burger|null L'objet burger correspondant à l'identifiant, ou null si le burger n'existe pas
     */
    public static function getBurgerById($id) {
        require_once('manager/burgerManager.php');
        try {
            $pdo = PdoMusic::getPdoMusic()->getMonPdo();

            $stmt = $pdo->prepare("SELECT nom, description, prix,image FROM burgers WHERE id = ?");
            $stmt->execute(array($id));

            if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $burger = new burgersPdo( $row['nom'], $row['description'], $row['prix'],$row['image']);
                return $burger;
            } else {
                return null;
            }
        } catch (PDOException $e) {
            echo "Erreur lors de la récupération du burger : " . $e->getMessage();
            return null;
        }
    }
                public static function findBurgerByNom($nom){
                    // Check if the burger with the given name already exists in the database
                    $pdo = PdoMusic::getPdoMusic()->getMonPdo();
                    $stmt = $pdo->prepare("SELECT COUNT(*) FROM burgers WHERE nom = :nom");
                    $stmt->bindValue(':nom', $nom);
                    $stmt->execute();
                    $count = $stmt->fetchColumn();
                return $count;
                }
    /**
     * Met à jour les informations d'un burger dans la base de données
     * @param burger $burger L'objet burger à mettre à jour
     * @return bool True si la mise à jour a réussi, false sinon
     */
    public static function deleteBurger($id) {
        try {
            $pdo = PdoMusic::getMonPdo();
    
            $stmt = $pdo->prepare("delete from burgers WHERE id = :id");
            $stmt->bindValue(':id', $id);
            $stmt->execute(); // execute the query
            $rowCount = $stmt->rowCount(); // get the number of affected rows
            return $rowCount > 0; // return true if any rows were affected, false otherwise
        } catch (PDOException $e) {
            echo "Erreur lors de la mise à jour du burger : " . $e->getMessage();
            return false;
        }
    }
    

}
?>
