<?php

require_once('Model/pdo.php');

/**
 * Classe d'accès aux données pour la gestion des commandes
 */
class CommandePdo {
   // Dans le fichier CommandePdo.php

   public static function passerCommande($client_id, $total, $numVoie, $libelleVoie, $codePostal, $ville)
   {
       try {
           $pdo = PdoMusic::getPdoMusic()->getMonPdo();
           $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
           
           // Début de la transaction
           $pdo->beginTransaction();
   
           // Insertion de la commande dans la table "commandes"
           $stmt = $pdo->prepare("INSERT INTO commandes (date_commande, client_id, total, numVoie, libelleVoie, codePostal, ville) VALUES (NOW(), :client_id, :total, :numVoie, :libelleVoie, :codePostal, :ville)");
           $stmt->bindValue(':client_id', $client_id);
           $stmt->bindValue(':total', $total);
           $stmt->bindValue(':numVoie', $numVoie);
           $stmt->bindValue(':libelleVoie', $libelleVoie);
           $stmt->bindValue(':codePostal', $codePostal);
           $stmt->bindValue(':ville', $ville);
           $stmt->execute();
   
           // Récupération de l'identifiant de la commande insérée
           $commande_id = $pdo->lastInsertId();
   
           // Validation de la transaction
           $pdo->commit();
   
           // Retourner l'identifiant de la commande
           return $commande_id;
       } catch (PDOException $e) {
           // En cas d'erreur, effectuer un rollback pour annuler les modifications
           $pdo->rollBack();
   
           // Retourner un message d'erreur ou effectuer d'autres actions nécessaires
           return "Une erreur s'est produite lors de la passation de la commande : " . $e->getMessage();
       }
   }
   

public static function insererLigneBoisson($commande_id, $boisson_id, $quantite, $prix)
{
    try {
        $pdo = PdoMusic::getPdoMusic()->getMonPdo();
        $stmt = $pdo->prepare("INSERT INTO commande_boissons (commande_id, boisson_id, quantite, prix) VALUES (:commande_id, :boisson_id, :quantite, :prix)");
        $stmt->bindValue(':commande_id', $commande_id);
        $stmt->bindValue(':boisson_id', $boisson_id);
        $stmt->bindValue(':quantite', $quantite);
        $stmt->bindValue(':prix', $prix);
        $stmt->execute();
        return true;
    } catch (PDOException $e) {
        // Gérer l'erreur
        return false;
    }
}
public static function insererLigneBurger($commande_id, $burger_id, $quantite, $prix)
{
    try {
        $pdo = PdoMusic::getPdoMusic()->getMonPdo();
        $stmt = $pdo->prepare("INSERT INTO commande_burgers (commande_id, burger_id, quantite, prix) VALUES (:commande_id, :burger_id, :quantite, :prix)");
        $stmt->bindValue(':commande_id', $commande_id);
        $stmt->bindValue(':burger_id', $burger_id);
        $stmt->bindValue(':quantite', $quantite);
        $stmt->bindValue(':prix', $prix);
        $stmt->execute();
        return true;
    } catch (PDOException $e) {
        // Gérer l'erreur
        return false;
    }
}
public static function insererLigneDessert($commande_id, $dessert_id, $quantite, $prix)
{
    try {
        $pdo = PdoMusic::getPdoMusic()->getMonPdo();
        $stmt = $pdo->prepare("INSERT INTO commande_desserts (commande_id, dessert_id, quantite, prix) VALUES (:commande_id, :dessert_id, :quantite, :prix)");
        $stmt->bindValue(':commande_id', $commande_id);
        $stmt->bindValue(':dessert_id', $dessert_id);
        $stmt->bindValue(':quantite', $quantite);
        $stmt->bindValue(':prix', $prix);
        $stmt->execute();
        return true;
    } catch (PDOException $e) {
        // Gérer l'erreur
        return false;
    }
}
public static function insererLigneMenu($commande_id, $menu_id, $quantite, $prix)
{
    try {
        $pdo = PdoMusic::getPdoMusic()->getMonPdo();
        $stmt = $pdo->prepare("INSERT INTO commande_menus (commande_id, menu_id, quantite, prix) VALUES (:commande_id, :menu_id, :quantite, :prix)");
        $stmt->bindValue(':commande_id', $commande_id);
        $stmt->bindValue(':menu_id', $menu_id);
        $stmt->bindValue(':quantite', $quantite);
        $stmt->bindValue(':prix', $prix);
        $stmt->execute();
        return true;
    } catch (PDOException $e) {
        // Gérer l'erreur
        return false;
    }
}

         
    // Méthode pour récupérer le prix d'une boisson à partir de la base de données
    private static function getPrixBoisson($boisson_id) {
        // Code pour récupérer le prix de la boisson avec l'ID donné depuis la base de données
        // Remplacez cette partie avec votre logique de récupération du prix
        
        // Exemple de récupération du prix à partir d'une table "boissons"
        $pdo = PdoMusic::getPdoMusic()->getMonPdo();
        $stmt = $pdo->prepare("SELECT prix FROM boissons WHERE id = :boisson_id");
        $stmt->bindValue(':boisson_id', $boisson_id);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
        return $row['prix']; // Retourne le prix de la boisson
    }
    
    // Méthode pour récupérer le prix d'un burger à partir de la base de données
    private static function getPrixBurger($burger_id) {
        // Code pour récupérer le prix du burger avec l'ID donné depuis la base de données
        // Remplacez cette partie avec votre logique de récupération du prix
        
        // Exemple de récupération du prix à partir d'une table "burgers"
        $pdo = PdoMusic::getPdoMusic()->getMonPdo();
        $stmt = $pdo->prepare("SELECT prix FROM burgers WHERE id = :burger_id");
        $stmt->bindValue(':burger_id', $burger_id);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
        return $row['prix']; // Retourne le prix du burger
    }
    
    // Méthode pour récupérer le prix d'un dessert à partir de la base de données
    private static function getPrixDessert($dessert_id) {
        // Code pour récupérer le prix du dessert avec l'ID donné depuis la base de données
        // Remplacez cette partie avec votre logique de récupération du prix
        
        // Exemple de récupération du prix à partir d'une table "desserts"
        $pdo = PdoMusic::getPdoMusic()->getMonPdo();
        $stmt = $pdo->prepare("SELECT prix FROM desserts WHERE id = :dessert_id");
        $stmt->bindValue(':dessert_id', $dessert_id);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
        return $row['prix']; // Retourne le prix du dessert
    }
    
    // Méthode pour récupérer le prix d'un menu à partir de la base de données
    private static function getPrixMenu($menu_id) {
        // Code pour récupérer le prix du menu avec l'ID donné depuis la base de données
        // Remplacez cette partie avec votre logique de récupération du prix
        
        // Exemple de récupération du prix à partir d'une table "menus"
        $pdo = PdoMusic::getPdoMusic()->getMonPdo();
        $stmt = $pdo->prepare("SELECT prix FROM menus WHERE id = :menu_id");
        $stmt->bindValue(':menu_id', $menu_id);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
        return $row['prix']; // Retourne le prix du menu
    }
}

?>
