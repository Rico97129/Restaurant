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
            require("Model/panier.php");
            
        
            // check if the 'panier' session variable exists, if not create it as an empty array
            if (!isset($_SESSION['panier'])) {
                $_SESSION['panier'] = array();
            }
        
            // check if the action is to add a menu to the panier
            if (isset($_GET['action']) && $_GET['action'] == 'ajouterAuPanier' && isset($_GET['menuid'])) {
                // get the menu ID from the GET parameter
                $menuid = $_GET['menuid'];
        
                // check if the menu is already in the panier
                $found = false;
                foreach ($_SESSION['panier'] as &$item) {
                    if ($item['type'] == 'menu' && $item['id'] == $menuid) {
                        // increase the quantity of the existing menu in the panier
                        $item['quantite'] += 1;
                        $found = true;
                        break;
                    }
                }
                unset($item); // unset the reference to the last element
        
                // if the menu is not already in the panier, add it as a new entry
                if (!$found) {
                    $_SESSION['panier'][] = array(
                        'type' => 'menu',
                        'id' => $menuid,
                        'quantite' => 1
                    );
                }
            }
        
            // check if the action is to add a drink to the panier
            if (isset($_GET['action']) && $_GET['action'] == 'ajouterAuPanier' && isset($_GET['boissonid'])) {
                // get the drink ID from the GET parameter
                $boissonid = $_GET['boissonid'];
        
                // check if the drink is already in the panier
                $found = false;
                foreach ($_SESSION['panier'] as &$item) {
                    if ($item['type'] == 'boisson' && $item['id'] == $boissonid) {
                        // increase the quantity of the existing drink in the panier
                        $item['quantite'] += 1;
                        $found = true;
                        break;
                    }
                }
                unset($item); // unset the reference to the last element
        
                // if the drink is not already in the panier, add it as a new entry
                if (!$found) {
                    $_SESSION['panier'][] = array(
                        'type' => 'boisson',
                        'id' => $boissonid,
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
                    
                
        }        

   
        include("Includes/Pied.php");
?>