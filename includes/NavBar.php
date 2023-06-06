<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/style.css">
    <link rel="stylesheet" href="./css/navbar.css">
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="./css/script.js"></script>
  
    <title>Restaurant </title>
</head>
  <header>
        <div class="navbar">
            <div class="navbar-toggle">
                <span></span>
                <span></span>
                <span></span>
            </div>
            <nav>
                <ul>
                    <li><a href="index.php">Home</a></li>
                    <li><a href="index.php?action=menu">Les Menus</a></li>
                    <li><a href="index.php?action=boissons">Les boissons</a></li>
                    <li><a href="index.php?action=burgers">Les burgers</a></li>
                    <li><a href="index.php?action=panier&menuid=' . $id_produit"> Panier</a></li>                    <li><a href="index.php?action=Favoris">Les Favoris</a></li>
                    <li><a href="index.php?action=register">Créer un compte</a></li>
                    <li><a href="index.php?action=login">Se connecter</a></li>
                </ul>
            </nav>
        </div>
    </header>
<body>
  

