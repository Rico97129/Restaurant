<form action="adminBoisson.php?action=AjouterBoisson" method="post" enctype="multipart/form-data">
    <label for="nom">Nom:</label>
    <input type="text" name="nom" id="nom">
    <br>
    <label for="description">Description:</label>
    <textarea name="description" id="description"></textarea>
    <br>
    <label for="prix">Prix:</label>
    <input type="number" name="prix" id="prix" step="0.01">
    <br>
    <label for="image">Image:</label>
    <input type="file" name="image" id="image">
    <br>
    <input type="submit" value="Ajouter">
</form>
