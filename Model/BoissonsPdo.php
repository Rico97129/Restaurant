<?php
require_once('Model/pdo.php');
require_once('./manager/MenuManager.php');

/**
 * Classe d'accès aux données pour la gestion des menus
 */
class BoissonsPdo {
    /**
     * Retourne tous les menus disponibles dans la base de données
     * @return array Un tableau d'objets Menu représentant les menus
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
            echo "Erreur lors de la récupération des menus : " . $e->getMessage();
            return array();
        } finally {
            // Log a message to the console
            error_log("getAllBoissons() called");
        }
    }
    

    /**
     * Retourne un menu à partir de son identifiant
     * @param int $id L'identifiant du menu
     * @return Menu|null L'objet Menu correspondant à l'identifiant, ou null si le menu n'existe pas
     */
    public static function getMenuById($id) {
        try {
            $pdo = PdoMusic::getPdoMusic()->getMonPdo();

            $stmt = $pdo->prepare("SELECT * FROM menus WHERE id = ?");
            $stmt->execute(array($id));

            if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $menu = new MenuPdo($row['id'], $row['nom'], $row['description'], $row['prix'], $row['image'], $row['is_available'], $row['created_at'], $row['updated_at']);
                return $menu;
            } else {
                return null;
            }
        } catch (PDOException $e) {
            echo "Erreur lors de la récupération du menu : " . $e->getMessage();
            return null;
        }
    }

    /**
     * Met à jour les informations d'un menu dans la base de données
     * @param Menu $menu L'objet Menu à mettre à jour
     * @return bool True si la mise à jour a réussi, false sinon
     */
    public static function updateMenu(Menu $menu) {
        try {
            $pdo = PdoMusic::getMonPdo();

            $stmt = $pdo->prepare("UPDATE menus SET nom = ?, description = ?, prix = ?, image = ?, is_available = ?, updated_at = NOW() WHERE id = ?");
            $stmt->execute(array($menu->getNom(), $menu->getDescription(), $menu->getPrix(), $menu->getImage(), $menu->isAvailable(), $menu->getId()));

            return $stmt->rowCount() > 0;
        } catch (PDOException $e) {
            echo "Erreur lors de la mise à jour du menu : " . $e->getMessage();
            return false;
        }
    }
}
