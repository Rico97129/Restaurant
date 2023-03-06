<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/style.css">
    <script src="./css/script.js"></script>
    <title>Document</title>

</head>
<body>

 
    <nav>
    <ul>
        <li><a href="index.php">Home</a></li>
        <li><a href="index.php?action=menu"> Les Menus</a></li>
       
        <li><a href="index.php?action=boissons"> Les boissons</a></li>
        <li><a href="index.php?action=Panier&menuid=' . $id_produit"> Panier</a></li>
        <li><a href="index.php?action=Favoris"> Les Favoris</a></li>
        <button onclick="clearLocalStorage()">Effacer le Local Storage</button>
    </ul>
</nav>
</div>
