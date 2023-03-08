<h1>Mes favoris</h1>
<div class="menu-list">
    <?php foreach ($favoriteMenus as $menu) : ?>
        <div class="menu-item">
            <h2><?= $menu->getNom() ?></h2>
            <p><?= $menu->getDescription() ?></p>
            <p><span>Prix:</span><?= $menu->getprix() ?></p>
        </div>
    <?php endforeach; ?>
</div>
