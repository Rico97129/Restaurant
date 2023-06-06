<?php
require_once('Model/pdo.php');
require_once('./manager/MenuManager.php');

/**
 * Classe d'accès aux données pour la gestion des menus
 */
class MenuPdo {

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
    public static function ajouterMenu($nom, $description, $prix, $image) {
        // Connexion à la base de données
        $pdo = PdoMusic::getPdoMusic()->getMonPdo();
    
        // Préparation de la requête SQL avec les paramètres nommés
        $stmt = $pdo->prepare("INSERT INTO menus (nom, description, prix, image) VALUES (:nom, :description, :prix, :image)");
    
        // Association des valeurs aux paramètres nommés
        $stmt->bindValue(':nom', $nom);
        $stmt->bindValue(':description', $description);
        $stmt->bindValue(':prix', $prix);
        $stmt->bindValue(':image', $image);
    
        // Exécution de la requête préparée
        $stmt->execute();
    }
    

    /**
     * Retourne tous les menus disponibles dans la base de données
     * @return array Un tableau d'objets Menu représentant les menus
     */
    public static function getAllMenus() {
        try {
            $menus = array();
            
    
            $req ="SELECT * FROM menus WHERE is_available = 1 ORDER BY id DESC";
            $pdo = PdoMusic::getPdoMusic();
            $stmt = $pdo::getMonPdo()->prepare($req) ;
            $stmt->setFetchMode(PDO::FETCH_OBJ);
            $stmt->execute();
          
    
           
            
            $stmt->execute() ;
            
            $menus=$stmt->fetchAll();
        return $menus;
        } catch (PDOException $e) {
            echo "Erreur lors de la récupération des menus : " . $e->getMessage();
            return array();
        } finally {
            // Log a message to the console
            error_log("getAllMenus() called");
        }
    }
    

    /**
     * Retourne un menu à partir de son identifiant
     * @param int $id L'identifiant du menu
     * @return Menu|null L'objet Menu correspondant à l'identifiant, ou null si le menu n'existe pas
     */
    public static function getMenuById($id) {
        require_once('manager/MenuManager.php');
        try {
            $pdo = PdoMusic::getPdoMusic()->getMonPdo();

            $stmt = $pdo->prepare("SELECT nom, description, prix,image FROM menus WHERE id = ?");
            $stmt->execute(array($id));

            if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $menu = new MenuPdo( $row['nom'], $row['description'], $row['prix'],$row['image']);
                return $menu;
            } else {
                return null;
            }
        } catch (PDOException $e) {
            echo "Erreur lors de la récupération du menu : " . $e->getMessage();
            return null;
        }
    }
                public static function findMenyByNom($nom){
                    // Check if the menu with the given name already exists in the database
                    $pdo = PdoMusic::getPdoMusic()->getMonPdo();
                    $stmt = $pdo->prepare("SELECT COUNT(*) FROM menus WHERE nom = :nom");
                    $stmt->bindValue(':nom', $nom);
                    $stmt->execute();
                    $count = $stmt->fetchColumn();
                return $count;
                }
    /**
     * Met à jour les informations d'un menu dans la base de données
     * @param Menu $menu L'objet Menu à mettre à jour
     * @return bool True si la mise à jour a réussi, false sinon
     */
    public static function deleteMenu($id) {
        try {
            $pdo = PdoMusic::getMonPdo();
    
            $stmt = $pdo->prepare("delete from menus WHERE id = :id");
            $stmt->bindValue(':id', $id);
            $stmt->execute(); // execute the query
            $rowCount = $stmt->rowCount(); // get the number of affected rows
            return $rowCount > 0; // return true if any rows were affected, false otherwise
        } catch (PDOException $e) {
            echo "Erreur lors de la mise à jour du menu : " . $e->getMessage();
            return false;
        }
    }
    

}
?>
