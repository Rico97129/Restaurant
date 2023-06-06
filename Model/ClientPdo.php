<?php
require_once('Model/pdo.php');


/**
 * Classe d'accès aux données pour la gestion des clients
 */
class ClientPdo {

    private $id;
    private $nom; // Define the nom property
   

    public function __construct($nom, $description, $prix) {
        $this->nom = $nom; // Assign the nom parameter to the nom property
      
    }

    // Getter method for nom property
    public function getNom() {
        return $this->nom;
    }

    // Setter method for nom property
    public function setNom($nom) {
        $this->nom = $nom;
    }
    
   
    // Other methods...


    /**
     * Retourne tous les clients disponibles dans la base de données
     * @return array Un tableau d'objets client représentant les clients
     */
    public static function getAllClients() {
        try {
            $clients = array();
            
    
            $req ="SELECT * FROM clients ";
            $pdo = PdoMusic::getPdoMusic();
            $stmt = $pdo::getMonPdo()->prepare($req) ;
            $stmt->setFetchMode(PDO::FETCH_OBJ);
            $stmt->execute();
          
    
           
            
            $stmt->execute() ;
            
            $clients=$stmt->fetchAll();
        return $clients;
        } catch (PDOException $e) {
            echo "Erreur lors de la récupération des clients : " . $e->getMessage();
            return array();
        } finally {
            // Log a message to the console
            error_log("getAllclients() called");
            
        }
    }
    

    /**
     * Retourne un client à partir de son identifiant
     * @param int $id L'identifiant du client
     * @return client|null L'objet client correspondant à l'identifiant, ou null si le client n'existe pas
     */
    public static function verifierConnexion($email, $motDePasse) {
        try {
            $pdo = PdoMusic::getPdoMusic()->getMonPdo();
    
            $stmt = $pdo->prepare("SELECT id, email, motDePasse, nom, prenom FROM clients WHERE email = ?");
            $stmt->execute(array($email));
    
            if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $id = $row['id'];
                $emailBdd = $row['email'];
                $motDePasseBdd = $row['motDePasse'];
                $nom = $row['nom'];
                $prenom = $row['prenom'];
    
                // Vérifiez le mot de passe
                if (password_verify($motDePasse, $motDePasseBdd)) {
                    // Informations d'identification valides, vous pouvez effectuer des actions supplémentaires ici
                    return array('id' => $id, 'email' => $emailBdd, 'nom' => $nom, 'prenom' => $prenom);
                }
            }
        } catch (PDOException $e) {
            echo "Erreur lors de la vérification de la connexion : " . $e->getMessage();
            return false;
        }
    }
    
    
    public static function getclientById($id) {
        require_once('manager/clientManager.php');
        try {
            $pdo = PdoMusic::getPdoMusic()->getMonPdo();

            $stmt = $pdo->prepare("SELECT nom, description, prix FROM clients WHERE id = ?");
            $stmt->execute(array($id));

            if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $client = new clientPdo( $row['nom'], $row['description'], $row['prix']);
                return $client;
            } else {
                return null;
            }
        } catch (PDOException $e) {
            echo "Erreur lors de la récupération du client : " . $e->getMessage();
            return null;
        }
    }
   public static function getAdresseLivraison($clientID) {
        // Initialisez votre connexion à la base de données
        $pdo = PdoMusic::getPdoMusic()->getMonPdo();
        // Préparez la requête SQL pour récupérer les informations d'adresse de livraison
        $query = "SELECT numVoie, libelleVoie, codePostal, ville FROM clients WHERE id = :clientID";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":clientID", $clientID);
        
        // Exécutez la requête
        $stmt->execute();
    
        // Récupérez le résultat de la requête
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
        // Fermez la connexion à la base de données
        $pdo = null;
    
        // Retournez les informations d'adresse de livraison
        return $result;
    }
    
    
    public static function ajouterClient($nom, $prenom, $email, $telephone, $numVoie,$libelleVoie,$codePostal,$ville, $motDePasse) {
        // Connexion à la base de données
        $pdo = PdoMusic::getPdoMusic()->getMonPdo();
        
        // Hachage du mot de passe
        $motDePasseHash = password_hash($motDePasse, PASSWORD_DEFAULT);
        
        // Préparation de la requête SQL avec les paramètres nommés
        $stmt = $pdo->prepare("INSERT INTO clients (nom, prenom, email, telephone, numVoie,libelleVoie,codePostal,ville, motDePasse) VALUES (:nom, :prenom, :email, :telephone, :numVoie,:libelleVoie,:codePostal,:ville, :motDePasse)");
        
        // Association des valeurs aux paramètres nommés
        $stmt->bindValue(':nom', $nom);
        $stmt->bindValue(':prenom', $prenom);
        $stmt->bindValue(':email', $email);
        $stmt->bindValue(':telephone', $telephone);
        $stmt->bindValue(':numVoie',$numVoie);
        $stmt->bindValue(':libelleVoie',$libelleVoie);
        $stmt->bindValue(':codePostal',$codePostal);
        $stmt->bindValue(':ville',$ville);
        $stmt->bindValue(':motDePasse', $motDePasseHash);
        
        // Exécution de la requête préparée
        $stmt->execute();
    }
    
    
    

    /**
     * Met à jour les informations d'un client dans la base de données
     * @param client $client L'objet client à mettre à jour
     * @return bool True si la mise à jour a réussi, false sinon
     */
    public static function updateclient($client) {
        try {
            $pdo = PdoMusic::getMonPdo();

            $stmt = $pdo->prepare("UPDATE clients SET nom = ?, description = ?, prix = ?, image = ?, is_available = ?, updated_at = NOW() WHERE id = ?");
            $stmt->execute(array($client->getNom(), $client->getDescription(), $client->getPrix(), $client->getImage(), $client->isAvailable(), $client->getId()));

            return $stmt->rowCount() > 0;
        } catch (PDOException $e) {
            echo "Erreur lors de la mise à jour du client : " . $e->getMessage();
            return false;
        }
    } 
    public static function HistoriqueDeCommande($client_id) {
        try {
            $pdo = PdoMusic::getPdoMusic()->getMonPdo();
            $query = "
            SELECT c.id AS commande_id, c.date_commande, 
            b.nom AS boisson, cb.quantite AS quantite_boisson, 
            d.nom AS dessert, cd.quantite AS quantite_dessert, 
            m.nom AS menu, cm.quantite AS quantite_menu, 
            bg.nom AS burger, cbg.quantite AS quantite_burger
            FROM commandes AS c
            LEFT JOIN commande_boissons AS cb ON c.id = cb.commande_id
            LEFT JOIN commande_desserts AS cd ON c.id = cd.commande_id
            LEFT JOIN commande_menus AS cm ON c.id = cm.commande_id
            LEFT JOIN commande_burgers AS cbg ON c.id = cbg.commande_id
            LEFT JOIN boissons AS b ON cb.boisson_id = b.id
            LEFT JOIN desserts AS d ON cd.dessert_id = d.id
            LEFT JOIN menus AS m ON cm.menu_id = m.id
            LEFT JOIN burgers AS bg ON cbg.burger_id = bg.id
            WHERE c.client_id = :client_id
            ";
    
            $stmt = $pdo->prepare($query);
            $stmt->execute(array(':client_id' => $client_id));
    
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Erreur lors de la récupération de l'historique des commandes : " . $e->getMessage();
            return false;
        }
    }
    
}
?>
