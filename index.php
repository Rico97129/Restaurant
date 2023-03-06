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
    case 'boissons':
        // vue qui crée le contenu de la page d’accueil
        
        require("Model/BoissonsPdo.php");
       
        $boissons = BoissonsPdo::getAllBoissons();
      
        include("Vues/boissons.php");
      
        break;
        case 'ajouterAuPanier':
            // Vue qui crée le contenu de la page d’accueil
            require("Model/panier.php");
        
            // Vérifier si la variable de session 'panier' existe, sinon la créer
            if (!isset($_SESSION['panier'])) {
                $_SESSION['panier'] = array();
            }
        
            $id_produit = null;
            if (isset($_GET['menuid'])) {
                $id_produit = $_GET['menuid'];
            } else if (isset($_GET['boissonid'])) {
                $id_produit = $_GET['boissonid'];
            }
        
            if (!is_null($id_produit)) {
                $quantite = 1; // Quantité du produit à ajouter
                if (isset($_SESSION['panier'][$id_produit])) {
                    // Si le produit est déjà dans le panier, on ajoute la quantité
                    $_SESSION['panier'][$id_produit] += $quantite;
                } else {
                    // Sinon, on ajoute le produit avec sa quantité
                    $_SESSION['panier'][$id_produit] = $quantite;
                }
            }
            header('Location: index.php?action=Panier');
            break;
        
        
        
        case 'Panier':
            require("Model/MenuPdo.php");
            $cart = $_SESSION['panier'];
            $menuItems = array(); // An array to hold the menu item objects
            foreach ($cart as $id => $quantity) {
                $menuItem = MenuPdo::getMenuById($id); // Retrieve the menu item object from the database
                var_dump($menuItem);
                $menuItem->quantity = $quantity; // Add the quantity to the menu item object
                $menuItems[] = $menuItem; // Add the menu item object to the array
              
            }
            include("Vues/panier.php");
            break;
            case 'Favoris':
               
                include("Vues/favoris.php");
                break;
        }        

   
        include("Includes/Pied.php");
