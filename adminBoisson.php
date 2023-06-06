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
    case 'AddBoissonForm':
        // vue qui crée le contenu de la page d’accueil
        // require("Model/ClientPdo.php");
       
        // $Boissons = BoissonPdo::getAllBoissons();
       
      
        include("Vues/addBoisson.php");
  
    break;
    case 'allBoisson':
    // vue qui crée le contenu de la page d’accueil
    require("Model/BoissonPdo.php");
   
    $Boissons = BoissonsPdo::getAllBoissons();
   
  
// Set the correct MIME type for the image

    // include("Vues/Boissons.php");
    
  
    break;
   
                        
                            case 'AjouterBoisson':
                                require("Model/BoissonsPdo.php");
                             
                                    $nom = $_POST['nom'];
                                    $description = $_POST['description'];
                                    $prix = $_POST['prix'];
                                    $image = $_FILES['image']['name'];
                                    
                                    // Move the uploaded image to a permanent location on the server
                                    $imagePath = 'includes/images/' . $image;
                                    move_uploaded_file($_FILES['image']['tmp_name'], $imagePath);
                                    
                                    $count = BoissonsPdo::findBoissonByNom($nom);
                                    
                                    if ($count > 0) {
                                        // Display an error message if the Boisson already exists
                                        echo "Le Boisson '$nom' existe déjà dans la base de données.";
                                    } else {
                                        // Call the ajouterBoisson function with the form data
                                        BoissonsPdo::ajouterBoisson($nom, $description, $prix, $imagePath);
                                        echo "Le Boisson '$nom' a été ajouté avec succès.";
                                    }
                                
                                
                                
                                include("Vues/addBoisson.php");
                                break;
                        
        }        

   
        include("Includes/Pied.php");
