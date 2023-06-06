
<h1>Nos menus</h1>
<div class="menu-list">
	<?php foreach ($menus as $menu) : ?>
		<div class="menu-item">
			<h2><?= $menu->nom ?></h2>
			<p><?= $menu->description ?></p>
			<img src="<?= $menu->image ?>" alt="" srcset="">
			<p><span>Prix:</span><?= $menu->prix ?></p>
			<a href='./index.php?action=ajouterAuPanier&menuid=<?= $menu->id ?>' class="btn">Ajouter au panier</a>
			<a href='./index.php?action=ajouterAuxFavoris&menuid=<?= $menu->id ?>' class="btn">Ajouter aux favoris</a>
		</div>
	<?php endforeach; ?>
</div>
