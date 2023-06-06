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
    case 'AddMenuForm':
        // vue qui crée le contenu de la page d’accueil
        // require("Model/ClientPdo.php");
       
        // $menus = MenuPdo::getAllMenus();
       
      
        include("Vues/addMenu.php");
  
    break;
    case 'allMenu':
    // vue qui crée le contenu de la page d’accueil
    require("Model/MenuPdo.php");
   
    $menus = MenuPdo::getAllMenus();
   
  
// Set the correct MIME type for the image

    // include("Vues/menus.php");
    
  
    break;
   
    case 'formMenu':
        require("Model/MenuPdo.php");
     
           
        
        include("Vues/addMenu.php");
        break;                    



case 'AjouterMenu':
  require("Model/MenuPdo.php");
 

  $nom = $_POST['nom'] ?? '';
  $description = $_POST['description'] ?? '';
  $prix = $_POST['prix'] ?? '';
  $image = $_FILES['image']['name'] ?? '';
  
  // Check if any of the required fields are empty
  if (empty($nom) || empty($description) || empty($prix) || empty($image)) {
      echo 'Erreur: Veuillez remplir tous les champs du formulaire.';
      exit();
  }
  
  // Move the uploaded image to a permanent location on the server
  $imagePath = 'images/' . $image;
  if (!move_uploaded_file($_FILES['image']['tmp_name'], $imagePath)) {
      echo 'Erreur: Une erreur est survenue lors du téléchargement de l\'image.';
      exit();
  }
  
  $count = MenuPdo::findMenyByNom($nom);
  
  if ($count > 0) {
      // Display an error message if the menu already exists
      echo "Erreur: Le menu '$nom' existe déjà dans la base de données.";
  } else {
      // Call the ajouterMenu function with the form data
      MenuPdo::ajouterMenu($nom, $description, $prix, $imagePath);
      echo "Le menu '$nom' a été ajouté avec succès.";
  }
  
  break;

                    
                        
        }        

   
        include("Includes/Pied.php");
?>