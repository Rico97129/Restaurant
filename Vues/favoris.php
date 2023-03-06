<?php
// Vérifier si des favoris sont enregistrés
if(isset($_COOKIE['favoris'])) {
  // Récupérer les favoris depuis le Local Storage
  $favoris = json_decode($_COOKIE['favoris']);
  var_dump($favoris);
  // Afficher les favoris dans une liste HTML
  echo "<h1>Mes favoris</h1>";
  echo "<ul>";
  foreach ($favoris as $favori) {
    echo "<li>{$favori->nom} - Prix : {$favori->prix}€</li>";
    var_dump($favori);
   
  }
  echo "</ul>";
} else {
  // Si aucun favori n'est enregistré, afficher un message à l'utilisateur
  echo "<p>Aucun favori enregistré pour le moment.</p>";
}
?>
