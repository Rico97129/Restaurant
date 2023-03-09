<?php

session_start();
if (!isset($_SESSION['panier'])) {
    $_SESSION['panier'] = array();
}

if(!isset($_REQUEST['action']))
{
$action = 'accueil';
}
else {
$action = $_REQUEST['action'];
}
// vue qui crée l’en-tête de la page

    include("includes/Entete.php");

  
switch($action)
{ 
    case 'menu':
    // vue qui crée le contenu de la page d’accueil
    require("Model/MenuPdo.php");
   
    $menus = MenuPdo::getAllMenus();
   
  
    include("Vues/menus.php");
  
    break;
    case 'register':
        // vue qui crée le contenu de la page d’accueil
        // require("Model/ClientPdo.php");
       
        // $menus = MenuPdo::getAllMenus();
       
      
        include("Vues/register.php");
      
        break;
    case 'boissons':
        // vue qui crée le contenu de la page d’accueil
        
        require("Model/BoissonsPdo.php");
       
        $boissons = BoissonsPdo::getAllBoissons();
      
        include("Vues/boissons.php");
      
        break;
        
        case 'ajouterAuPanier':
            // check if the 'panier' session variable exists, if not create it as an empty array
            if (!isset($_SESSION['panier'])) {
                $_SESSION['panier'] = array();
            }
        
            // check if the action is to add an item to the panier
            if (isset($_GET['action']) && $_GET['action'] == 'ajouterAuPanier') {
                // check if a menu ID or drink ID is provided
                if (isset($_GET['menuid'])) {
                    // get the menu ID from the GET parameter
                    $id = $_GET['menuid'];
                    $type = 'menu';
                } elseif (isset($_GET['boissonid'])) {
                    // get the drink ID from the GET parameter
                    $id = $_GET['boissonid'];
                    $type = 'boisson';
                } else {
                    // no valid item ID is provided, do nothing and exit
                    break;
                }
        
                // check if the item is already in the panier
                $found = false;
                foreach ($_SESSION['panier'] as &$item) {
                    if ($item['type'] == $type && $item['id'] == $id) {
                        // increase the quantity of the existing item in the panier
                        $item['quantite'] += 1;
                        $found = true;
                        break;
                    }
                }
                unset($item); // unset the reference to the last element
        
                // if the item is not already in the panier, add it as a new entry
                if (!$found) {
                    $_SESSION['panier'][] = array(
                        'type' => $type,
                        'id' => $id,
                        'quantite' => 1
                    );
                }
            }   
            break;
        
        
        
        
        
            case 'Panier':
                require("Model/MenuPdo.php");
                require("Model/BoissonsPdo.php");
                
                $panier = $_SESSION['panier'];
                
                foreach ($panier as $item) {
                    if ($item['type'] == 'menu') {
                        $menu = MenuPdo::getMenuById($item['id']);
                    } elseif ($item['type'] == 'boisson') {
                        $boisson = BoissonsPdo::getBoissonById($item['id']);
                    }
                }
                
                include("Vues/panier.php");
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

                    case 'supprimerDuPanier':
                        session_start();
                        $key = $_POST['key'];
                        unset($_SESSION['panier'][$key]);
                        header('Location: index.php?action=Panier');
                        break;
                    
                        case 'nouveauClient':
                            require("Model/ClientPdo.php");
                        
                            // Récupération des données du formulaire
                            $nom = $_POST['nom'];
                            $prenom = $_POST['prenom'];
                            $email = $_POST['email'];
                            $telephone = $_POST['telephone'];
                            $adresse = $_POST['numVoie'];
                            $adresse = $_POST['libelleVoie'];
                            $adresse = $_POST['codePostal'];
                            $adresse = $_POST['ville'];
                            $motDePasse = $_POST['motDePasse'];
                        
                            // Vérification des entrées utilisateur
                            $errors = array(
                                'nom' => '',
                                'prenom' => '',
                                'email' => '',
                                'telephone' => '',
                                'adresse' => '',
                                'motDePasse' => '',
                                'confirmMotDePasse' => ''
                              );
                        
                            // Vérification du nom
                            if (empty($nom)) {
                                $errors[] = "Le nom est obligatoire.";
                            }
                        
                            // Vérification du prénom
                            if (empty($prenom)) {
                                $errors[] = "Le prénom est obligatoire.";
                            }
                        
                            // Vérification de l'adresse e-mail
                            if (empty($email)) {
                                $errors[] = "L'adresse e-mail est obligatoire.";
                            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                                $errors[] = "L'adresse e-mail n'est pas valide.";
                            }
                        
                            // Vérification du numéro de téléphone
                            if (empty($telephone)) {
                                $errors[] = "Le numéro de téléphone est obligatoire.";
                            } elseif (!preg_match("/^[0-9]{10}$/", $telephone)) {
                                $errors[] = "Le numéro de téléphone n'est pas valide.";
                            }
                        
                            // Vérification de l'adresse
                            if (empty($adresse)) {
                                $errors[] = "L'adresse est obligatoire.";
                            }
                        
                            // Vérification du mot de passe
                            if (empty($motDePasse)) {
                                $errors[] = "Le mot de passe est obligatoire.";
                            } elseif (!preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,}$/", $motDePasse)) {
                                $errors[] = "Le mot de passe doit contenir au moins 8 caractères, avec une combinaison de lettres minuscules, majuscules et chiffres.";
                            }
                            if (empty($confirmMotDePasse)) {
                                $errors[] = "La confirmation du mot de passe est obligatoire.";
                            } elseif ($motDePasse !== $confirmMotDePasse) {
                                $errors[] = "Les mots de passe ne correspondent pas.";
                            }
                        
                            if (empty($errors)) {
                                // Hachage du mot de passe
                                $motDePasseHash = password_hash($motDePasse, PASSWORD_DEFAULT);
                        
                                // Ajout du client dans la base de données
                                ClientPdo::ajouterClient($nom, $prenom, $email, $telephone, $numVoie,$libelleVoie,$codePostal,$ville, $motDePasse);
                        
                                // Redirection vers la page d'accueil
                                header('Location: index.php');
                                exit();
                            } else {
                        
                                // Afficher le formulaire avec les erreurs
                                require('Vues/register.php');
                            }
                            break;
                        
                        
        }        

   
        include("Includes/Pied.php");
?>