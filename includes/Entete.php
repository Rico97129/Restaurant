<?php
if ($utilisateurConnecte) {
    // Afficher la navigation pour l'utilisateur connecté
    include("NavBarConnecte.php");
} else {
    // Afficher la navigation par défaut pour les utilisateurs non connectés
    include("NavBar.php");
}
?>
