<h1>Choix de l'adresse de livraison</h1>

<form method="POST" action="index.php?action=paiement">
    <input type="radio" name="adresseOption" id="adresseClient" value="adresse_client" checked>
    <label for="adresseClient">Adresse de livraison : <?php echo $numVoie ." ". $adresse . ", " . $codePostal . " " . $ville; ?></label>
    
    <br>
    
    <input type="radio" name="adresseOption" id="autreAdresse" value="autre_adresse">
    <label for="autreAdresse">Autre adresse</label>
    
    <br>
    <label for="adresse">Adresse:</label>
        <input type="text" id="adresse" name="adresse" placeholder="Rechercher une adresse" autocomplete="off">
        <div id="search-results"></div> <!-- Search results will be displayed here -->
    
    <label for="numVoie">Numéro de voie:</label>
    <input type="text" name="numVoie" id="numVoie" >
    <br>
    <label for="libelleVoie">Libellé de voie:</label>
    <input type="text" name="libelleVoie" id="libelleVoie" >
    <br>
    <label for="codePostal">Code postal:</label>
    <input type="text" name="codePostal" id="codePostal" >
    <br>
    <label for="ville">Ville:</label>
    <input type="text" name="ville" id="ville" >
    <br>
    <input type="submit" value="Valider">
</form>
<Script>
  const searchInput = document.getElementById('adresse');
const searchResults = document.getElementById('search-results');
const postCodes = ['95200', '95400', '93380'];

// Obtenez la valeur du code postal depuis PHP
const codePostal = '<?php echo $codePostal; ?>';

// Vérifiez si le code postal est inclus dans la liste des codes postaux des villes desservies
const isCodePostalAllowed = postCodes.includes(codePostal);

// Désactivez la première option si le code postal n'est pas inclus
if (!isCodePostalAllowed) {
  document.getElementById('adresseClient').disabled = true;

adresseClientOption.addEventListener('click', () => {
    alert("Nous ne livrons pas dans cette ville.");
  });
}


searchInput.addEventListener('input', () => {
  const searchQuery = searchInput.value.trim();
  if (searchQuery.length < 3) {
    // If search query is less than 3 characters, don't make API request
    searchResults.innerHTML = '';
    return;
  }
  
  const promises = postCodes.map(postCode => {
    const apiUrl = `https://api-adresse.data.gouv.fr/search/?q=${searchQuery}&postcode=${postCode}`;
    return fetch(apiUrl)
      .then(response => response.json());
  });

  Promise.all(promises)
    .then(dataArray => {
      // Combine and flatten the results from multiple API requests
      const combinedFeatures = dataArray.flatMap(data => data.features);

      // Build HTML for search results
      let html = '';
      combinedFeatures.forEach(feature => {
        const { name, postcode, city } = feature.properties;
        html += `<div>${name}, ${postcode} ${city}</div>`;
      });
      searchResults.innerHTML = html;

      searchResults.addEventListener('click', event => {
        // Check if clicked element is a search result
        if (event.target.matches('div')) {
          // Get the selected feature from the API response data
          const selectedFeature = combinedFeatures.find(feature => {
            const { name, postcode, city } = feature.properties;
            const searchResultText = `${name}, ${postcode} ${city}`;
            return searchResultText === event.target.textContent;
          });
          // Extract and insert address values into form fields
          const { housenumber, street, postcode, city } = selectedFeature.properties;
          document.getElementById('numVoie').value = housenumber;
          document.getElementById('libelleVoie').value = street;
          document.getElementById('codePostal').value = postcode;
          document.getElementById('ville').value = city;
        }
      });
    })
    .catch(error => console.error(error));
});


</Script>