 <?php
        error_reporting(E_ALL);
        ini_set('display_errors', 1);

        session_start();

        // Vérification de l'état de connexion de l'utilisateur
        $utilisateurConnecte = isset($_SESSION['connexion']) && $_SESSION['connexion'] === true;

        // Initialisation du panier s'il n'existe pas
        if (!isset($_SESSION['panier'])) {
            $_SESSION['panier'] = array();
        }

        // Inclusion de l'en-tête de la page
        include("includes/Entete.php");

        // Traitement des actions
        if (!isset($_REQUEST['action'])) {
            $action = 'accueil';
            include("Vues/accueil.php");
        } else {
            $action = $_REQUEST['action'];

            switch ($action) {
                case 'nouveauClient':
                    // Vérifier si le formulaire a été soumis
                    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                        // Valider les données du formulaire et vérifier les erreurs
                        $errors = array();

                        // Vérification des champs requis
                        $requiredFields = array('nom', 'prenom', 'email', 'telephone', 'numVoie', 'libelleVoie', 'codePostal', 'ville', 'motDePasse', 'confirmMotDePasse');
                        foreach ($requiredFields as $field) {
                            if (empty($_POST[$field])) {
                                $errors[] = "Le champ $field est requis.";
                            }
                        }

                        // Vérification du nom
                        if (empty($_POST['nom'])) {
                            $errors['nom'] = "Le nom est obligatoire.";
                        }

                        // Vérification du prénom
                        if (empty($_POST['prenom'])) {
                            $errors['prenom'] = "Le prénom est obligatoire.";
                        }

                        // Vérification de l'adresse e-mail
                        if (empty($_POST['email'])) {
                            $errors['email'] = "L'adresse e-mail est obligatoire.";
                        } elseif (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
                            $errors['email'] = "L'adresse e-mail n'est pas valide.";
                        }

                        // Vérification du numéro de téléphone
                        if (empty($_POST['telephone'])) {
                            $errors['telephone'] = "Le numéro de téléphone est obligatoire.";
                        } elseif (!preg_match("/^[0-9]{10}$/", $_POST['telephone'])) {
                            $errors['telephone'] = "Le numéro de téléphone n'est pas valide.";
                        }

                        // Vérification du mot de passe
                        if (empty($_POST['motDePasse'])) {
                            $errors['motDePasse'] = "Le mot de passe est obligatoire.";
                        } elseif (!preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,}$/", $_POST['motDePasse'])) {
                            $errors['motDePasse'] = "Le mot de passe doit contenir au moins 8 caractères, avec une combinaison de lettres minuscules, majuscules et chiffres.";
                        }
                        if (empty($_POST['confirmMotDePasse'])) {
                            $errors['confirmMotDePasse'] = "La confirmation du mot de passe est obligatoire.";
                        } elseif ($_POST['motDePasse'] !== $_POST['confirmMotDePasse']) {
                            $errors['confirmMotDePasse'] = "Les mots de passe ne correspondent pas.";
                        }

                        // Si des erreurs sont présentes, les stocker dans la session
                        if (!empty($errors)) {
                            $_SESSION['errors'] = $errors;
                            header('Location:index.php?action=register');
                            exit;
                        }

                        // Sinon, le formulaire est valide, continuer avec le traitement
                        require("Model/ClientPdo.php");

                        // Récupération des données du formulaire
                        $nom = $_POST['nom'];
                        $prenom = $_POST['prenom'];
                        $email = $_POST['email'];
                        $telephone = $_POST['telephone'];
                        $numVoie = $_POST['numVoie'];
                        $libelleVoie = $_POST['libelleVoie'];
                        $codePostal = $_POST['codePostal'];
                        $ville = $_POST['ville'];
                        $motDePasse = $_POST['motDePasse'];
                        $confirmMotDePasse = $_POST['confirmMotDePasse'];

                        // Hachage du mot de passe
                        $motDePasseHash = password_hash($motDePasse, PASSWORD_DEFAULT);

                        // Ajout du client dans la base de données
                        ClientPdo::ajouterClient($nom, $prenom, $email, $telephone, $numVoie, $libelleVoie, $codePostal, $ville, $motDePasse);

                        // Redirection vers la page d'accueil
                        header('Location: index.php');
                        exit();
                    }
                case 'menu':
                    require("Model/MenuPdo.php");
                    $menus = MenuPdo::getAllMenus();
                    include("Vues/menus.php");
                    break;

                case 'register':
                    include("Vues/register.php");
                    break;

                case 'boissons':
                    require("Model/BoissonsPdo.php");
                    $boissons = BoissonsPdo::getAllBoissons();
                    include("Vues/boissons.php");
                    break;
                case 'burgers':
                        require("Model/BurgersPdo.php");
                        $burgers = BurgersPdo::getAllBurgers();
                        include("Vues/burgers.php");
                        break;

                case 'login':
                    include("Vues/login.php");
                    break;

                case 'connexion':
                    // Vérification des informations de connexion
                    if ($_SERVER["REQUEST_METHOD"] == "POST") {
                        $email = $_POST["email"];
                        $motDePasse = $_POST["password"];
                        require("Model/ClientPdo.php");
                        $utilisateur = ClientPdo::verifierConnexion($email, $motDePasse);

                        if ($utilisateur) {
                            // Informations d'identification valides, vous pouvez effectuer des actions supplémentaires ici (par exemple, créer une session)
                            // Informations d'identification valides, vous pouvez effectuer des actions supplémentaires ici (par exemple, créer une session)
                            $_SESSION['connexion'] = true;
                            $_SESSION['clientID'] = $utilisateur['id']; // Supposons que l'ID du client est stocké dans la colonne 'id' de la table 'clients'

                            echo "Connexion réussie !";
                            // Rediriger vers une autre page après la connexion réussie
                            header("Location: index.php?action=menu");
                            exit;
                        } else {
                            // Informations d'identification invalides
                            echo "Identifiants de connexion invalides. Veuillez réessayer.";
                        }
                    }
                    // Inclure la vue de connexion
                    include("Vues/login.php");
                    break;

                case 'ajouterAuPanier':
                    require('Model/CommandePdo.php');
                    // Vérifier si l'action est d'ajouter un item au panier
                    if (isset($_GET['action']) && $_GET['action'] == 'ajouterAuPanier') {
                        // Vérifier si un ID de menu, boisson, dessert ou burger est fourni
                        if (isset($_GET['menuid'])) {
                            $id = $_GET['menuid'];
                            $type = 'menu';
                        } elseif (isset($_GET['boissonid'])) {
                            $id = $_GET['boissonid'];
                            $type = 'boisson';
                        } elseif (isset($_GET['dessertid'])) {
                            $id = $_GET['dessertid'];
                            $type = 'dessert';
                        } elseif (isset($_GET['burgerid'])) {
                            $id = $_GET['burgerid'];
                            $type = 'burger';
                        } else {
                            // Aucun ID d'item valide n'est fourni, ne rien faire et sortir
                            break;
                        }

                        // Vérifier si l'item est déjà dans le panier
                        $existingItemKey = null;
                        foreach ($_SESSION['panier'] as $key => $item) {
                            if ($item['type'] == $type && $item['id'] == $id) {
                                // Stocker la clé de l'élément existant pour la mise à jour ultérieure
                                $existingItemKey = $key;
                                break;
                            }
                        }

                        // Si l'item existe déjà dans le panier, augmenter sa quantité
                        if ($existingItemKey !== null) {
                            $_SESSION['panier'][$existingItemKey]['quantite']++;
                        } else {
                            // Si l'item n'est pas déjà dans le panier, l'ajouter avec une quantité de 1
                            $item = array('type' => $type, 'id' => $id, 'quantite' => 1);
                            array_push($_SESSION['panier'], $item);
                        }

                        // // Calculer le prix total de l'item ajouté
                        // $prix_unitaire = getPrix($id); // Supposons que l'ID corresponde à l'ID de l'élément dans la base de données
                        // $prix_total = $prix_unitaire * $_SESSION['panier'][$existingItemKey]['quantite'];

                        // // Mise à jour du prix total dans le panier
                        // $_SESSION['panier'][$existingItemKey]['prix_total'] = $prix_total;
                    }

                    // Rediriger vers la page appropriée après l'ajout au panier
                    header("Location: index.php?action=panier");
                    exit;
                    break;



                case 'panier':
                    // Afficher le contenu du panier
                    require("Model/MenuPdo.php");
                    require('Model/BoissonsPdo.php');
                    var_dump($_SESSION['panier']);
                    require("Vues/panier.php");
                    break;
                case 'modifierQuantité':

                    // Récupérer la clé et la nouvelle quantité envoyées via le formulaire
                    $key = $_POST['key'];
                    $nouvelleQuantite = $_POST['quantite'];

                    // Vérifier si la clé existe dans la session panier
                    if (array_key_exists($key, $_SESSION['panier'])) {
                        // Mettre à jour la quantité pour l'élément correspondant
                        $_SESSION['panier'][$key]['quantite'] = $nouvelleQuantite;
                        // Rediriger vers la page du panier
                        header("Location: index.php?action=panier");
                        exit;
                    }
                    break;
                case 'supprimerDuPanier':
                    session_start();
                    $key = $_POST['key'];
                    unset($_SESSION['panier'][$key]);
                    header('Location: index.php?action=panier');
                    break;

                case 'deconnexion':
                    // Détruire la session et rediriger vers la page de déconnexion réussie
                    session_destroy();
                    header("Location: index.php");
                    exit;
                    break;

                case 'deconnexionReussie':
                    // Afficher la page de déconnexion réussie
                    include("Vues/deconnexionReussie.php");
                    break;

                case 'Favoris':
                    require("Model/MenuPdo.php");
                    $favorites = json_decode($_COOKIE['favorites'] ?? '[]', true);
                    $favoriteMenus = array();
                    foreach ($favorites as $id) {
                        $menu = MenuPdo::getMenuById($id);
                        if ($menu) {
                            $favoriteMenus[] = $menu;
                        }
                    }
                    include("Vues/favoris.php");
                    break;

                case 'ajouterAuxFavoris':
                    $favorites = json_decode($_COOKIE['favorites'] ?? '[]', true);
                    $menuId = $_GET['menuid'] ?? null;
                    if ($menuId && !in_array($menuId, $favorites)) {
                        $favorites[] = $menuId;
                        setcookie('favorites', json_encode($favorites), time() + (86400 * 30), '/');
                    }
                    header('Location: index.php');
                    break;
                case 'modifierQuantité':

                    // Récupérer la clé et la nouvelle quantité envoyées via le formulaire
                    $key = $_POST['key'];
                    $nouvelleQuantite = $_POST['quantite'];

                    // Vérifier si la clé existe dans la session panier
                    if (array_key_exists($key, $_SESSION['panier'])) {
                        // Mettre à jour la quantité pour l'élément correspondant
                        $_SESSION['panier'][$key]['quantite'] = $nouvelleQuantite;
                        // Rediriger vers la page du panier
                        header("Location: index.php?action=Panier");
                        exit;
                    }
                    break;


                    case 'creerCommande':
                        require("Model/CommandePdo.php");
                        require("Model/BoissonsPdo.php");
                        require("Model/BurgersPdo.php");
                        // require("Model/MenuPdo.php");
                    
                        // Vérifier si l'utilisateur est connecté
                        if (!isset($_SESSION['connexion']) || !$_SESSION['connexion']) {
                            // Utilisateur non connecté, rediriger vers la page de connexion
                            header("Location: index.php?action=login");
                            exit;
                        }
                    
                        // Vérifier si le panier n'est pas vide
                        if (empty($_SESSION['panier'])) {
                            echo "Le panier est vide. Ajoutez des articles avant de passer une commande.";
                            break;
                        }
                    
                        // Récupérer l'ID du client connecté
                        $client_id = $_SESSION['clientID'];
                    
                        // Récupérer l'adresse de livraison depuis la session
                        $adresseLivraison = $_SESSION['adresseLivraison'];
                    
                        // Extraire les informations de l'adresse de livraison
                        $numVoie = $adresseLivraison['numVoie'];
                        $libelleVoie = $adresseLivraison['libelleVoie'];
                        $codePostal = $adresseLivraison['codePostal'];
                        $ville = $adresseLivraison['ville'];
                    
                        // Calculer le total de la commande
                        $total = 0;
                        foreach ($_SESSION['panier'] as $item) {
                            $quantite = $item['quantite'];
                            $type = $item['type'];
                            $id = $item['id'];
                    
                            // Récupérer le prix unitaire de l'article à partir de la base de données
                            if ($type == 'menu') {
                                $prixUnitaire = MenuPdo::getMenuById($id)->getPrix();
                            } elseif ($type == 'boisson') {
                                $prixUnitaire = BoissonsPdo::getBoissonById($id)->getPrix();
                            } elseif ($type == 'burger') {
                                $prixUnitaire = BurgersPdo::getBurgerById($id)->getPrix();
                            }
                    
                            $sousTotal = $prixUnitaire * $quantite;
                            $total += $sousTotal;
                        }
                    
                        // Créer une nouvelle commande dans la base de données
                        $panier = $_SESSION['panier'];
                        try {
                            $commande_id = CommandePdo::passerCommande($client_id, $total, $numVoie, $libelleVoie, $codePostal, $ville);
                    
                            // Vérifier si la commande a été créée avec succès
                            if ($commande_id) {
                                foreach ($_SESSION['panier'] as $item) {
                                    $type = $item['type'];
                                    $quantite = $item['quantite'];
                    
                                    // Récupérer le prix unitaire de l'article à partir de la base de données
                                    if ($type == 'menu') {
                                        $id = $item['id'];
                                        $prix = MenuPdo::getMenuById($id)->getPrix();
                                        $menu_id = $id;
                                        echo "Valeurs avant l'appel à insererLigneCommande : <br>";
                                        echo "commande_id : " . $commande_id . "<br>";
                    
                                        echo "menu_id : " . $menu_id . "<br>";
                                        echo "quantite :" . $quantite . "<br>";
                                        echo "prix :" . $prix . "<br>";
                    
                                        CommandePdo::insererLigneMenu($commande_id, $menu_id, $quantite, $prix);
                                    } elseif ($type == 'boisson') {
                                        $id = $item['id'];
                                        $prix = BoissonsPdo::getBoissonById($id)->getPrix();
                                        $commande_id;
                                        $boisson_id = $id;
                                        CommandePdo::insererLigneBoisson($commande_id, $boisson_id, $quantite, $prix);
                                    } elseif ($type == 'burger') {
                                        $id = $item['id'];
                                        $prix = BurgersPdo::getBurgerById($id)->getPrix();
                                        $commande_id;
                                        $burger_id = $id;
                                        CommandePdo::insererLigneBurger($commande_id, $burger_id, $quantite, $prix);
                                    }
                                }
                    
                                // Effacer le panier après la création de la commande
                                $_SESSION['panier'] = [];
                                var_dump($commande_id, $menu_id, $prix, $quantite);
                                echo "La commande a été créée avec succès !";
                            } else {
                                echo "Une erreur s'est produite lors de la création de la commande.";
                            }
                        } catch (PDOException $e) {
                            // Afficher les erreurs et les requêtes SQL
                            echo "Erreur : " . $e->getMessage();
                            echo "<br>";
                            echo "Requête SQL : " . $e->getPrevious()->queryString;
                        }
                    
                        break;
                    

                case 'afficherHistoriqueCommandes':
                    require('Model/ClientPdo.php');
                    $clientId = $_SESSION['clientID'];
                    // Vérifier si le client est connecté (par exemple, vérifier la session ID)


                    $clientId = $_SESSION['clientID'];
                    // Appeler la fonction HistoriqueDeCommande pour récupérer l'historique des commandes
                    $historique = ClientPdo::HistoriqueDeCommande($clientId);
                    include('Vues/historiqueCommande.php');

                    break;
                case 'adresseLivraison':
                    require('Model/ClientPdo.php');
                    // Vérifier si le panier n'est pas vide
                    if (empty($_SESSION['panier'])) {
                        echo "Le panier est vide. Ajoutez des articles avant de passer une commande.";
                        break;
                    }
                    if (empty($_SESSION['clientID'])) {
                        header('Location: index.php?action=login');;
                        break;
                    }

                    $clientId = $_SESSION['clientID'];
                    // Démarrez la session


                    // Récupérez les informations d'adresse de livraison depuis la base de données
                    $adresseLivraison = ClientPdo::getAdresseLivraison($clientId);

                    // Stockez les informations d'adresse de livraison dans une variable de session
                    $_SESSION['adresseLivraison'] = $adresseLivraison;

                    // Vous pouvez accéder aux informations d'adresse de livraison à partir de la session dans d'autres parties de votre application
                    $adresse = $_SESSION['adresseLivraison']['libelleVoie'];
                    $codePostal = $_SESSION['adresseLivraison']['codePostal'];
                    $ville = $_SESSION['adresseLivraison']['ville'];
                    $numVoie = $_SESSION['adresseLivraison']['numVoie'];
                    


                    include('Vues/adresseLivraison.php');
                    break ;

                case 'paiement':
                        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                            // Récupérer l'option sélectionnée
                            $adresseOption = $_POST['adresseOption'];
                    
                            if ($adresseOption === 'adresse_client') {
                                // L'option sélectionnée est l'adresse du client
                                // Récupérer l'adresse de livraison depuis la session
                                $adresseLivraison = $_SESSION['adresseLivraison'];
                            } else {
                                // L'option sélectionnée est une autre adresse
                                // Récupérer les données du formulaire
                                $numVoie = $_POST['numVoie'];
                                $libelleVoie = $_POST['libelleVoie'];
                                $codePostal = $_POST['codePostal'];
                                $ville = $_POST['ville'];
                    
                                $adresseLivraison = [
                                    'numVoie' => $numVoie,
                                    'libelleVoie' => $libelleVoie,
                                    'codePostal' => $codePostal,
                                    'ville' => $ville
                                ];
                            }
                    
                            // Stocker les informations de l'adresse de livraison dans la session
                            $_SESSION['adresseLivraison'] = $adresseLivraison;
                    
                            // Redirection vers la page de paiement
                            header('Location: index.php?action=pagePaiement');
                            exit;
                        }
                        Case 'pagePaiement':
                        include('Vues/page_paiement.php');
                        break;
                    
                    default:
                    // Action non reconnue, afficher une page d'erreur
                    include("Vues/erreur.php");
                    break;
            }


            // Inclusion du pied de page
            include("includes/Pied.php");
        }
        ?>
