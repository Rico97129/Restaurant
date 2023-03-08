<style>form {
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
</style>
<form action="register.php" method="post">
  <label for="nom">Nom:</label>
  <input type="text" id="nom" name="nom" required>

  <label for="prenom">Prenom:</label>
  <input type="text" id="prenom" name="prenom" required>

  <label for="email">Email:</label>
  <input type="email" id="email" name="email" required>

  <label for="telephone">Telephone:</label>
  <input type="text" id="telephone" name="telephone" required>

  <label for="adresse">Adresse:</label>
  <input type="text" id="adresse" name="adresse" required>

  <label for="motDePasse">Mot de passe:</label>
  <input type="password" id="motDePasse" name="motDePasse" required>

  <label for="confirmMotDePasse">Confirmer le mot de passe:</label>
  <input type="password" id="confirmMotDePasse" name="confirmMotDePasse" required>

  <input type="submit" value="S'inscrire">
</form>
