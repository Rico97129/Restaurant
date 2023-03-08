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
    
    public static function ajouterClient($nom, $prenom, $email, $telephone, $adresse, $motDePasse) {
        // Connexion à la base de données
        $pdo = PdoMusic::getPdoMusic()->getMonPdo();
        
        // Hachage du mot de passe
        $motDePasseHash = password_hash($motDePasse, PASSWORD_DEFAULT);
        
        // Préparation de la requête SQL avec les paramètres nommés
        $stmt = $pdo->prepare("INSERT INTO clients (nom, prenom, email, telephone, adresse, motDePasse) VALUES (:nom, :prenom, :email, :telephone, :adresse, :motDePasse)");
        
        // Association des valeurs aux paramètres nommés
        $stmt->bindValue(':nom', $nom);
        $stmt->bindValue(':prenom', $prenom);
        $stmt->bindValue(':email', $email);
        $stmt->bindValue(':telephone', $telephone);
        $stmt->bindValue(':adresse', $adresse);
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
}
?>
