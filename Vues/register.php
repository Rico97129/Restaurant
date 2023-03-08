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
<form action="index.php?action=nouveauClient" method="post">
  <label for="nom">Nom:</label>
  <input type="text" id="nom" name="nom" required>
  <?php if (isset($errors['nom'])): ?>
    <p class="error"><?= $errors['nom'] ?></p>
  <?php endif; ?>

  <label for="prenom">Prenom:</label>
  <input type="text" id="prenom" name="prenom" required>
  <?php if (isset($errors['prenom'])): ?>
    <p class="error"><?= $errors['prenom'] ?></p>
  <?php endif; ?>

  <label for="email">Email:</label>
  <input type="email" id="email" name="email" required>
  <?php if (isset($errors['email'])): ?>
    <p class="error"><?= $errors['email'] ?></p>
  <?php endif; ?>

  <label for="telephone">Telephone:</label>
  <input type="text" id="telephone" name="telephone" required>
  <?php if (isset($errors['telephone'])): ?>
    <p class="error"><?= $errors['telephone'] ?></p>
  <?php endif; ?>

  <label for="adresse">Adresse:</label>
  <input type="text" id="adresse" name="adresse" required>
  <?php if (isset($errors['adresse'])): ?>
    <p class="error"><?= $errors['adresse'] ?></p>
  <?php endif; ?>

  <label for="motDePasse">Mot de passe:</label>
  <input type="password" id="motDePasse" name="motDePasse" required>
  <?php if (isset($errors['motDePasse'])): ?>
    <p class="error"><?= $errors['motDePasse'] ?></p>
  <?php endif; ?>

  <label for="confirmMotDePasse">Confirmer le mot de passe:</label>
  <input type="password" id="confirmMotDePasse" name="confirmMotDePasse" required>
  <?php if (isset($errors['confirmMotDePasse'])): ?>
    <p class="error"><?= $errors['confirmMotDePasse'] ?></p>
  <?php endif; ?>

  <input type="submit" value="S'inscrire">
</form>
