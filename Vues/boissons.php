<h1>Nos boissons</h1>
	<div class="boisson-list">
		<?php foreach ($boissons as $boisson) : ?>
			<div class="boisson-item">
				<h2><?= $boisson->nom ?></h2>
				<p><?= $boisson->description ?></p>
				<img src="<?= $boisson->image ?>" alt="" srcset="">

				<p><span>Prix:</span><?= $boisson->prix ?></p>
                <a href='./index.php?action=ajouterAuPanier&boissonid=<?= $boisson->id ?>'class="btn" >Ajouter au panier</a>
				<a href='./index.php?action=ajouterAuxFavoris&boissonid=<?= $boisson->id ?>' class="btn">Ajouter aux favoris</a>
			</div>
		<?php endforeach; ?>
	</div>