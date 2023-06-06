<?php
session_start();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Formulaire d'inscription</title>
    <style>
        form {
            max-width: 500px;
            margin: 0 auto;
        }

        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        input[type="text"],
        input[type="email"],
        input[type="password"] {
            display: block;
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        input[type="submit"] {
            display: block;
            width: 100%;
            padding: 10px;
            font-size: 16px;
            font-weight: bold;
            color: #fff;
            background-color: #007bff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #0069d9;
        }

        .errors {
            color: red;
            margin-bottom: 10px;
        }

        .errors li {
            margin-bottom: 5px;
        }
    </style>
</head>
<body>
    <h1>Formulaire d'inscription</h1>
    
    <?php if (isset($_SESSION['errors'])): ?>
        <div class="errors">
            <ul>
                <?php foreach ($_SESSION['errors'] as $error): ?>
                    <li><?php echo $error; ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
        <?php unset($_SESSION['errors']); ?>
    <?php endif; ?>
    
    <form action="index.php?action=nouveauClient" method="post">
        <label for="nom">Nom:</label>
        <input type="text" id="nom" name="nom" required>
        
        <label for="prenom">Prénom:</label>
        <input type="text" id="prenom" name="prenom" required>
        
        <label for="email">E-mail:</label>
        <input type="email" id="email" name="email" required>
        
        <label for="telephone">Téléphone:</label>
        <input type="text" id="telephone" name="telephone" required>
        
        <label for="adresse">Adresse:</label>
        <input type="text" id="adresse" name="adresse" placeholder="Rechercher une adresse" autocomplete="off">
        <div id="search-results"></div> <!-- Search results will be displayed here -->
        
        <label for="numVoie">Numéro de voie:</label>
        <input type="text" id="numVoie" name="numVoie" required>

        <label for="libelleVoie">Libellé de voie:</label>
        <input type="text" id="libelleVoie" name="libelleVoie" required>

        <label for="codePostal">Code postal:</label>
        <input type="text" id="codePostal" name="codePostal" required>

        <label for="ville">Ville:</label>
        <input type="text" id="ville" name="ville" required>

        <label for="motDePasse">Mot de passe:</label>
        <input type="password" id="motDePasse" name="motDePasse" required>
        <button id="togglePassword">Afficher le mot de passe</button>

        <label for="confirmMotDePasse">Confirmer le mot de passe:</label>
        <input type="password" id="confirmMotDePasse" name="confirmMotDePasse" required>
        <button id="toggleConfirmPassword">Afficher le mot de passe</button>
        
        <input type="submit" value="S'inscrire">

        <script>
            const searchInput = document.getElementById('adresse');
            const searchResults = document.getElementById('search-results');

            searchInput.addEventListener('input', () => {
                const searchQuery = searchInput.value.trim();
                if (searchQuery.length < 3) {
                    // If search query is less than 3 characters, don't make API request
                    searchResults.innerHTML = '';
                    return;
                }
                fetch(`https://api-adresse.data.gouv.fr/search/?q=${searchQuery}`)
                    .then(response => response.json())
                    .then(data => {
                        // Build HTML for search results
                        let html = '';
                        data.features.forEach(feature => {
                            const { name, postcode, city } = feature.properties;
                            html += `<div>${name}, ${postcode} ${city}</div>`;
                        });
                        searchResults.innerHTML = html;
                        searchResults.addEventListener('click', event => {
                            // Check if clicked element is a search result
                            if (event.target.matches('div')) {
                                // Get the selected feature from the API response data
                                const selectedFeature = data.features.find(feature => {
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

            const togglePasswordButton = document.getElementById('togglePassword');
            const toggleConfirmPasswordButton = document.getElementById('toggleConfirmPassword');
            const passwordInput = document.getElementById('motDePasse');
            const confirmPasswordInput = document.getElementById('confirmMotDePasse');

            togglePasswordButton.addEventListener('click', function() {
                if (passwordInput.type === 'password') {
                    passwordInput.type = 'text';
                    togglePasswordButton.textContent = 'Masquer le mot de passe';
                } else {
                    passwordInput.type = 'password';
                    togglePasswordButton.textContent = 'Afficher le mot de passe';
                }
            });

            toggleConfirmPasswordButton.addEventListener('click', function() {
                if (confirmPasswordInput.type === 'password') {
                    confirmPasswordInput.type = 'text';
                    toggleConfirmPasswordButton.textContent = 'Masquer le mot de passe';
                } else {
                    confirmPasswordInput.type = 'password';
                    toggleConfirmPasswordButton.textContent = 'Afficher le mot de passe';
                }
            });
        </script>
    </form>
</body>
</html>
