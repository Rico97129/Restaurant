<h1>Nos menus</h1>
<div class="menu-list">
	<?php foreach ($menus as $menu) : ?>
		<div class="menu-item">
			<h2><?= $menu->nom ?></h2>
			<p><?= $menu->description ?></p>
			<p><span>Prix:</span><?= $menu->prix ?></p>
			<a href='./index.php?action=ajouterAuPanier&menuid=<?= $menu->id ?>'class="btn">Ajouter au panier</a>
			<button onclick="ajouterEnFavori({id: <?= $menu->id ?>, nom: '<?= $menu->nom ?>', prix: <?= $menu->prix ?>})">Ajouter aux favoris</button>
		</div>
	<?php endforeach; ?>
</div>
