// // Fonction pour ajouter un objet en favori
// function ajouterEnFavori(id, nom, prix) {
// 	// Créer un objet avec les données de l'objet en favori
// 	var objet = { id: id, nom: nom, prix: prix };
  
// 	// Récupérer les objets en favori déjà stockés dans le Local Storage
// 	var objetsEnFavori = JSON.parse(localStorage.getItem("objetsEnFavori")) || [];
  
// 	// Vérifier si l'objet est déjà en favori
// 	var index = objetsEnFavori.findIndex(function (o) {
// 	  return o.id === id;
// 	});
  
// 	// Si l'objet n'est pas déjà en favori, l'ajouter
// 	if (index === -1) {
// 	  objetsEnFavori.push(objet);
// 	  localStorage.setItem("objetsEnFavori", JSON.stringify(objetsEnFavori));
  
// 	  // Envoyer l'objet ajouté au serveur PHP
// 	  var xhr = new XMLHttpRequest();
// 	  xhr.open("POST", "enregistrerFavoris.php");
// 	  xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded;charset=UTF-8");
// 	  xhr.send("favoris=" + encodeURIComponent(JSON.stringify(objetsEnFavori)));
// 	}
//   }
  
//   // Fonction pour supprimer un objet des favoris
//   function supprimerDesFavoris(objet) {
// 	// Récupérer les objets en favori déjà stockés dans le Local Storage
// 	var objetsEnFavori = JSON.parse(localStorage.getItem("objetsEnFavori")) || [];
  
// 	// Trouver l'index de l'objet à supprimer
// 	var index = objetsEnFavori.findIndex(function (o) {
// 	  return o.id === objet.id;
// 	});
  
// 	// Si l'objet est en favori, le supprimer
// 	if (index !== -1) {
// 	  objetsEnFavori.splice(index, 1);
// 	  localStorage.setItem("objetsEnFavori", JSON.stringify(objetsEnFavori));
// 	}
//   }
  
//   // Récupérer les objets en favori stockés dans le Local Storage
//   var objetsEnFavori = JSON.parse(localStorage.getItem("objetsEnFavori")) || [];
  
//   // Afficher les objets en favori dans la console
//   console.log(objetsEnFavori);
  
//   // Supprimer tous les favoris
//   function supprimerTousLesFavoris() {
// 	localStorage.removeItem
//   }  