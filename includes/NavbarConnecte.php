<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/style.css">
    <script src="https://kit.fontawesome.com/90a78da149.js" crossorigin="anonymous"></script>
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="./css/script.js"></script>
    <link rel="stylesheet" href="./css/navbar.css">
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
                    <li><a href="index.php?action=login">Mon compte</a></li>
                    <li><a href="index.php?action=deconnexion"><i class="fas fa-sign-out-alt"></i></a></li>
                    <li><a href="index.php?action=afficherHistoriqueCommandes">historique de commande</a></li>



                </ul>
            </nav>
        </div>
    </header>
<body>
<!--   

    <script>document.addEventListener('DOMContentLoaded', function() {
  const navbarToggle = document.querySelector('.navbar-toggle');
  const nav = document.querySelector('nav');

  navbarToggle.addEventListener('click', function() {
    nav.classList.toggle('active');
  });
});

</script> -->
