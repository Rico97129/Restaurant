<style>
        /* Styles généraux */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
        }

        h1 {
            text-align: center;
        }

        .commande {
            margin-bottom: 20px;
            border: 1px solid #ccc;
            padding: 10px;
        }

        h2 {
            margin: 0;
            font-size: 1.2em;
        }

        h3 {
            margin-top: 10px;
        }

        ul {
            margin: 0;
            padding: 0;
            list-style-type: none;
        }

        li {
            margin-bottom: 5px;
        }

        /* Styles responsives */
        @media screen and (max-width: 600px) {
            /* Réduire la taille de la police */
            h1 {
                font-size: 1.5em;
            }
            h2 {
                font-size: 1em;
            }
            h3 {
                font-size: 0.9em;
            }
            li {
                font-size: 0.8em;
            }
        }
    </style>
<?php
echo "<!DOCTYPE html>";
echo "<html>";
echo "<head>";
echo "<meta charset='UTF-8'>";
echo "<title>Historique des commandes</title>";
echo "</head>";
echo "<body>";
echo "<h1>Historique des commandes</h1>";

if (!empty($historique)) {
    foreach ($historique as $commande) {
        echo "<div class='commande'>";
        echo "<h2>Commande n°" . $commande['commande_id'] . "</h2>";
        echo "<p>Date de commande : " . $commande['date_commande'] . "</p>";

        if (!empty($commande['boisson'])) {
            echo "<h3>Boissons</h3>";
            echo "<ul>";
            echo "<li>" . $commande['boisson'] . " (Quantité : " . $commande['quantite_boisson'] . ")</li>";
            echo "</ul>";
        }

        if (!empty($commande['dessert'])) {
            echo "<h3>Desserts</h3>";
            echo "<ul>";
            echo "<li>" . $commande['dessert'] . " (Quantité : " . $commande['quantite_dessert'] . ")</li>";
            echo "</ul>";
        }

        if (!empty($commande['menu'])) {
            echo "<h3>Menus</h3>";
            echo "<ul>";
            echo "<li>" . $commande['menu'] . " (Quantité : " . $commande['quantite_menu'] . ")</li>";
            echo "</ul>";
        }

        if (!empty($commande['burger'])) {
            echo "<h3>Burgers</h3>";
            echo "<ul>";
            echo "<li>" . $commande['burger'] . " (Quantité : " . $commande['quantite_burger'] . ")</li>";
            echo "</ul>";
        }

        echo "</div>";
    }
} else {
    echo "<p>Aucune commande trouvée.</p>";
}

echo "</body>";
echo "</html>";
?>
