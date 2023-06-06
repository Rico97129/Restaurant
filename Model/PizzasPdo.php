<?php
require_once('Model/pdo.php');
require_once('./manager/boissonManager.php');

/**
 * Classe d'accès aux données pour la gestion des boissons
 */
class PizzasPdo {
   
    // Fonction pour créer une nouvelle commande de pizza
    public static function createCommandePizza($pizzaId, $tailleId, $quantite) {
        $pdo = PdoMusic::getPdoMusic()->getMonPdo();

        // Récupérer le prix de base de la pizza
        $sql = "SELECT prix FROM Pizzas WHERE id = $pizzaId";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($row) {
            $prixPizza = $row["prix"];
        } else {
            echo "Pizza non trouvée";
            return;
        }

        // Récupérer le prix supplémentaire de la taille
        $sql = "SELECT prix_supplementaire FROM Tailles WHERE id = $tailleId";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            $prixSupplementaire = $row["prix_supplementaire"];
        } else {
            echo "Taille non trouvée";
            return;
        }

        // Calculer le prix total
        $prixTotal = ($prixPizza + $prixSupplementaire) * $quantite;

        // Insérer la commande dans la table "Commande_pizzas"
        $sql = "INSERT INTO Commande_pizzas (pizza_id, taille_id, quantite, prix) VALUES (:pizzaId, :tailleId, :quantite, :prixTotal)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':pizzaId', $pizzaId, PDO::PARAM_INT);
        $stmt->bindValue(':tailleId', $tailleId, PDO::PARAM_INT);
        $stmt->bindValue(':quantite', $quantite, PDO::PARAM_INT);
        $stmt->bindValue(':prixTotal', $prixTotal, PDO::PARAM_STR);

        if ($stmt->execute()) {
            echo "Commande créée avec succès";
        } else {
            echo "Erreur lors de la création de la commande : " . $stmt->errorInfo();
        }
    }

    // Fonction pour récupérer toutes les commandes de pizzas
    public static function getAllCommandesPizza() {
        $pdo = PdoMusic::getPdoMusic()->getMonPdo();

        $sql = "SELECT * FROM Commande_pizzas";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();

        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if ($rows) {
            foreach ($rows as $row) {
                echo "ID: " . $row["id"] . "<br>";
                echo "Pizza ID: " . $row["pizza_id"] . "<br>";
                echo "Taille ID: " . $row["taille_id"] . "<br>";
                echo "Quantité: " . $row["quantite"] . "<br>";
                echo "Prix: " . $row["prix"] . "<br>";
                echo "Créé le: " . $row["created_at"] . "<br>";
                echo "<br>";
            }
        } else {
            echo "Aucune commande de pizza trouvée";
        }
    }

    // Fonction pour mettre à jour une commande de pizza
    public static function updateCommandePizza($commandeId, $quantite) {
        $pdo = PdoMusic::getPdoMusic()->getMonPdo();

        // Vérifier si la commande existe
        $sql = "SELECT * FROM Commande_pizzas WHERE id = :commandeId";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':commandeId', $commandeId, PDO::PARAM_INT);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$row) {
            echo "Commande non trouvée";
            return;
        }

        // Mettre à jour la quantité de la commande
        $sql = "UPDATE Commande_pizzas SET quantite = :quantite WHERE id = :commandeId";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':quantite', $quantite, PDO::PARAM_INT);
        $stmt->bindValue(':commandeId', $commandeId, PDO::PARAM_INT);

        if ($stmt->execute()) {
            echo "Commande mise à jour avec succès";
        } else {
            echo "Erreur lors de la mise à jour de la commande : " . $stmt->errorInfo();
        }
    }

    // Fonction pour supprimer une commande de pizza
    public static function deleteCommandePizza($commandeId) {
        $pdo = PdoMusic::getPdoMusic()->getMonPdo();

        // Vérifier si la commande existe
        $sql = "SELECT * FROM Commande_pizzas WHERE id = :commandeId";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':commandeId', $commandeId, PDO::PARAM_INT);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$row) {
            echo "Commande non trouvée";
            return;
        }

        // Supprimer la commande
        $sql = "DELETE FROM Commande_pizzas WHERE id = :commandeId";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':commandeId', $commandeId, PDO::PARAM_INT);

        if ($stmt->execute()) {
            echo "Commande supprimée avec succès";
        } else {
            echo "Erreur lors de la suppression de la commande : " . $stmt->errorInfo();
        }
    }

    // Fonction pour insérer une nouvelle pizza
    public static function createPizza($nom, $prix) {
        $pdo = PdoMusic::getPdoMusic()->getMonPdo();

        // Insérer la pizza dans la table "Pizzas"
        $sql = "INSERT INTO Pizzas (nom, prix) VALUES (:nom, :prix)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':nom', $nom, PDO::PARAM_STR);
        $stmt->bindValue(':prix', $prix, PDO::PARAM_STR);

        if ($stmt->execute()) {
            echo "Pizza créée avec succès";
        } else {
            echo "Erreur lors de la création de la pizza : " . $stmt->errorInfo();
        }
    }
     // Fonction pour récupérer toutes les pizzas
     public static function getAllPizzas() {
        $pdo = PdoMusic::getPdoMusic()->getMonPdo();

        $sql = "SELECT * FROM Pizzas";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();

        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if ($rows) {
            foreach ($rows as $row) {
                echo "ID: " . $row["id"] . "<br>";
                echo "Nom: " . $row["nom"] . "<br>";
                echo "Prix: " . $row["prix"] . "<br>";
                echo "<br>";
            }
        } else {
            echo "Aucune pizza trouvée";
        }
    }

    // Fonction pour récupérer une pizza par son ID
    public static function getPizzaById($pizzaId) {
        $pdo = PdoMusic::getPdoMusic()->getMonPdo();

        $sql = "SELECT * FROM Pizzas WHERE id = :pizzaId";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':pizzaId', $pizzaId, PDO::PARAM_INT);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            echo "ID: " . $row["id"] . "<br>";
            echo "Nom: " . $row["nom"] . "<br>";
            echo "Prix: " . $row["prix"] . "<br>";
        } else {
            echo "Pizza non trouvée";
        }
    }

    // Fonction pour récupérer une pizza par son nom
    public static function getPizzaByName($pizzaName) {
        $pdo = PdoMusic::getPdoMusic()->getMonPdo();

        $sql = "SELECT * FROM Pizzas WHERE nom = :pizzaName";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':pizzaName', $pizzaName, PDO::PARAM_STR);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            echo "ID: " . $row["id"] . "<br>";
            echo "Nom: " . $row["nom"] . "<br>";
            echo "Prix: " . $row["prix"] . "<br>";
        } else {
            echo "Pizza non trouvée";
        }
    }

    // Autres méthodes de gestion des pizzas...
}



// Utilisation de la classe BoissonsPdo pour créer une nouvelle pizza
$boissonsPdo = new PizzasPdo();
?>

