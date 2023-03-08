<h1>Votre panier</h1>
<div class="cart-items">
    <?php foreach ($_SESSION['panier'] as $key => $item) : ?>
        <?php if ($item['type'] == 'menu') : ?>
            <?php 
            // get the menu object by id
           
            if ($menu) :
            ?>
            <div class="cart-item">
                <h2><?= $menu->getNom() ?></h2>
                <p><span>Prix:</span> <?= $menu->getPrix() ?></p>
                <form action="modifier_quantite.php" method="post">
                    <input type="hidden" name="key" value="<?= $key ?>">
                    <label for="quantite">Quantité:</label>
                    <input type="number" name="quantite" value="<?= $item['quantite'] ?>" min="1" max="10">
                    <input type="submit" value="Modifier">
                   
                </form>
                <form action="index.php?action=supprimerDuPanier" method="post">
        <input type="hidden" name="key" value="<?= $key ?>">
        <button type="submit">Supprimer</button>
            </div>
            <?php endif; ?>
        <?php elseif ($item['type'] == 'boisson') : ?>
            <?php 
            // get the boisson object by id
            
            if ($boisson) :
            ?>
            <div class="cart-item">
                <h2><?= $boisson->getNom() ?></h2>
                <p><span>Prix:</span> <?= $boisson->getPrix() ?></p>
                <form action="modifier_quantite.php" method="post">
                    <input type="hidden" name="key" value="<?= $key ?>">
                    <label for="quantite">Quantité:</label>
                    <input type="number" name="quantite" value="<?= $item['quantite'] ?>" min="1" max="10">
                    <input type="submit" value="Modifier">
                    <form action="index.php?action=supprimerDuPanier" method="post">
        
                </form>
                <input type="hidden" name="key" value="<?= $key ?>">
        <button type="submit">Supprimer</button>
            </div>
            <?php endif; ?>
        <?php endif; ?>
    <?php endforeach; ?>
</div>
