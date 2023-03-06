
		// Fonction pour ajouter un objet en favori
		function ajouterEnFavori(objet) {
		  // Récupérer les objets en favori déjà stockés dans le Local Storage
		  var objetsEnFavori = JSON.parse(localStorage.getItem("objetsEnFavori")) || [];
		
		  // Vérifier si l'objet est déjà en favori
		  var index = objetsEnFavori.findIndex(function (o) {
		    return o.id === objet.id;
		  });
		
		  // Si l'objet n'est pas déjà en favori, l'ajouter
		  if (index === -1) {
		    objetsEnFavori.push(objet);
		    localStorage.setItem("objetsEnFavori", JSON.stringify(objetsEnFavori));
		  }
		}
		
		// Fonction pour supprimer un objet des favoris
		function supprimerDesFavoris(objet) {
		  // Récupérer les objets en favori déjà stockés dans le Local Storage
		  var objetsEnFavori = JSON.parse(localStorage.getItem("objetsEnFavori")) || [];
		
		  // Trouver l'index de l'objet à supprimer
		  var index = objetsEnFavori.findIndex(function (o) {
		    return o.id === objet.id;
		  });
		
		  // Si l'objet est en favori, le supprimer
		  if (index !== -1) {
		    objetsEnFavori.splice(index, 1);
		    localStorage.setItem("objetsEnFavori", JSON.stringify(objetsEnFavori));
		  }
		}
		
		// Récupérer les objets en favori stockés dans le Local Storage
		var objetsEnFavori = JSON.parse(localStorage.getItem("objetsEnFavori")) || [];
		
		// Envoyer les objets en favori au serveur PHP à l'aide d'une requête HTTP POST
		var xhr = new XMLHttpRequest();
		xhr.open("POST", "enregistrerFavoris.php");
		xhr.setRequestHeader("Content-Type", "application/json;charset=UTF-8");
		xhr.send(JSON.stringify(objetsEnFavori));
        
        function clearLocalStorage() {
            localStorage.clear();
            alert("Local Storage effacé !");
          }
        