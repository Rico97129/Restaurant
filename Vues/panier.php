<h1>Votre panier</h1>
<div class="cart-items">
    <?php
    // Variable pour stocker le prix total
    $prixTotal = 0;
    ?>
    <?php foreach ($_SESSION['panier'] as $key => $item) : ?>
        <?php if ($item['type'] == 'menu') : ?>
            <?php 
            // get the menu object by id
            $menu = MenuPdo::getMenuById($item['id']);
            if ($menu) :
                // Calculer le prix total de l'article
                $prixArticle = $menu->getPrix() * $item['quantite'];
                // Ajouter le prix de l'article au prix total
                $prixTotal += $prixArticle;
            ?>
            <div class="cart-item">
                <h2><?= $menu->getNom() ?></h2>
                <p><span>Prix unitaire:</span> <?= $menu->getPrix() ?></p>
                <form action="index.php?action=modifierQuantité" method="post">
                    <input type="hidden" name="key" value="<?= $key ?>">
                    <label for="quantite">Quantité:</label>
                    <input type="number" name="quantite" value="<?= $item['quantite'] ?>" min="1" max="10" class="quantite-input">
                </form>
                <form action="index.php?action=supprimerDuPanier" method="post">
                    <input type="hidden" name="key" value="<?= $key ?>">
                    <button type="submit">Supprimer</button>
                </form>
                <p><span>Prix total:</span> <?= $prixArticle ?></p>
            </div>
            <?php endif; ?>
        <?php elseif ($item['type'] == 'boisson') : ?>
            <?php 
            // get the boisson object by id
            $boisson = BoissonsPdo::getBoissonById($item['id']);
            if ($boisson) :
                // Calculer le prix total de l'article
                $prixArticle = $boisson->getPrix() * $item['quantite'];
                // Ajouter le prix de l'article au prix total
                $prixTotal += $prixArticle;
            ?>
            <div class="cart-item">
                <h2><?= $boisson->getNom() ?></h2>
                <p><span>Prix unitaire:</span> <?= $boisson->getPrix() ?></p>
                <form action="index.php?action=modifierQuantité" method="post">
                    <input type="hidden" name="key" value="<?= $key ?>">
                    <label for="quantite">Quantité:</label>
                    <input type="number" name="quantite" value="<?= $item['quantite'] ?>" min="1" max="10" class="quantite-input">
                </form>
                <form action="index.php?action=supprimerDuPanier" method="post">
                    <input type="hidden" name="key" value="<?= $key ?>">
                    <button type="submit">Supprimer</button>
                </form>
                <p><span>Prix total:</span> <?= $prixArticle ?></p>
            </div>
            <?php endif; ?>
        <?php endif; ?>
    <?php endforeach; ?>
</div>

<p><span>Prix total:</span> <?= $prixTotal ?></p>

<form action="index.php?action=adresseLivraison" method="post">
    <button type="submit">Passer la commande</button>
</form>

<script>
    // Sélectionnez tous les champs de saisie de quantité
    const quantiteInputs = document.querySelectorAll('.quantite-input');

    // Parcourez tous les champs de saisie de quantité
    quantiteInputs.forEach((input) => {
        // Ajoutez un gestionnaire d'événement pour l'événement "change"
        input.addEventListener('change', (event) => {
            // Sélectionnez le formulaire parent du champ de saisie de quantité
            const form = event.target.closest('form');
            // Soumettez automatiquement le formulaire
            form.submit();
        });
    });
</script>
