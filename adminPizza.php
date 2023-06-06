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

    // include("includes/Entete.php");

  
switch($action)
{ 
    case 'AddPizzaForm':
        // vue qui crée le contenu de la page d’accueil
        // require("Model/ClientPdo.php");
       
        // $Pizzas = PizzaPdo::getAllPizzas();
       
      
        include("Vues/addPizza.php");
  
    break;
    case 'allPizza':
    // vue qui crée le contenu de la page d’accueil
    require("Model/PizzaPdo.php");
   
    $Pizzas = PizzasPdo::getAllPizzas();
   
  
// Set the correct MIME type for the image

    // include("Vues/Pizzas.php");
    
  
    break;
   
    case 'formPizza':
        require("Model/PizzaPdo.php");
     
           
        
        include("Vues/addPizza.php");
        break;                    



case 'AjouterPizza':
  require("Model/PizzaPdo.php");
 

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
  
  $count = PizzasPdo::getPizzaByName($nom);
  
  if ($count > 0) {
      // Display an error message if the Pizza already exists
      echo "Erreur: Le Pizza '$nom' existe déjà dans la base de données.";
  } else {
      // Call the ajouterPizza function with the form data
      PizzasPdo::createPizza($nom, $description, $prix, $imagePath);
      echo "La Pizza '$nom' a été ajouté avec succès.";
  }
  
  break;

                    
                        
        }        

   
        include("Includes/Pied.php");
?>