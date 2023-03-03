<h1>Panier</h1>

<?php if (empty($menuItems)) : ?>
    <p>Votre panier est vide.</p>
<?php else : ?>
    <table>
        <thead>
            <tr>
                <th>Produit</th>
                <th>Quantité</th>
                <th>Prix</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($menuItems as $menuItem) : ?>
                <tr>
                    <td><?= $menuItem->getNom() ?></td>
                    <td><?= $menuItem->quantity ?></td>
                    <td><?= $menuItem->getPrix() ?> €</td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    
<?php endif; ?>
