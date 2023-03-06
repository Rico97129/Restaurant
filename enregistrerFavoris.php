<?php
// Récupérer les données de favoris envoyées via la requête AJAX
$id = $_POST['id'];
$nom = $_POST['nom'];
$prix = $_POST['prix'];

// Créer un objet avec les données de favoris
$favori = new stdClass();
$favori->id = $id;
$favori->nom = $nom;
$favori->prix = $prix;

// Récupérer les favoris existants depuis le Local Storage
$favoris = json_decode($_COOKIE['favoris']);

// Ajouter le nouveau favori à la liste des favoris existants
$favoris[] = $favori;

// Enregistrer les favoris dans le Local Storage
setcookie('favoris', json_encode($favoris), time() + (86400 * 30), "/");

// Renvoyer une réponse JSON indiquant que l'enregistrement a réussi
header('Content-Type: application/json');
echo json_encode(['success' => true]);
?>
