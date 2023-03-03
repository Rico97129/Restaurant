
<h1>Nos menus</h1>
	<div class="menu-list">
		<?php foreach ($menus as $menu) : ?>
			<div class="menu-item">
				<h2><?= $menu->nom ?></h2>
				<p><?= $menu->description ?></p>
				<p><span>Prix:</span><?= $menu->prix ?></p>
				<a href='./index.php?action=ajouterAuPanier&menuid=<?= $menu->id ?>'class="btn" >Ajouter au panier</a>
		
			</div>
		<?php endforeach; ?>
	</div>
	