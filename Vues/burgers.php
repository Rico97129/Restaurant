
<h1>Nos burgers</h1>
<div class="burger-list">
	<?php foreach ($burgers as $burger) : ?>
		<div class="burger-item">
			<h2><?= $burger->nom ?></h2>
			<p><?= $burger->description ?></p>
			<img src="<?= $burger->image ?>" alt="" srcset="">
			<p><span>Prix:</span><?= $burger->prix ?></p>
			<a href='./index.php?action=ajouterAuPanier&burgerid=<?= $burger->id ?>' class="btn">Ajouter au panier</a>
			<a href='./index.php?action=ajouterAuxFavoris&burgerid=<?= $burger->id ?>' class="btn">Ajouter aux favoris</a>
		</div>
	<?php endforeach; ?>
</div>
