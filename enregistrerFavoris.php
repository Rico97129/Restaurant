<?php
// Récupérer les données de favori envoyées via la requête AJAX
$data = json_decode(file_get_contents("php://input"));

// Créer un objet avec les données de favori
$favori = new stdClass();
$favori->id = $data->id;
$favori->nom = $data->nom;
$favori->prix = $data->prix;

// Récupérer les favoris existants depuis le Local Storage
$favoris = json_decode($_POST['favoris']) ?? [];

// Ajouter le nouveau favori à la liste des favoris existants
$favoris[] = $favori;

// Enregistrer les favoris dans le Local Storage
$_POST['favoris'] = json_encode($favoris);

// Renvoyer une réponse JSON indiquant que l'enregistrement a réussi
header('Content-Type: application/json');
echo json_encode(['success' => true]);
?>
