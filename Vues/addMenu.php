<!-- Example HTML code (addMenu.php) -->
<form id="formAjouterMenu" action="adminMenu.php?action=AjouterMenu" method="post">
<input type="text" name="nom">
  <textarea name="description"></textarea>
  <input type="number" name="prix">
  <input type="file" name="image">
  <button type="submit">Ajouter</button>
</form>

<div id="error"></div>