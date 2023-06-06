<title>Formulaire de Paiement Fictif</title>
    <style>
        /* Styles CSS pour le formulaire */
        .payment-form {
            max-width: 400px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-family: Arial, sans-serif;
        }
        
        .payment-form label {
            display: block;
            margin-bottom: 10px;
        }
        
        .payment-form input[type="text"] {
            width: 100%;
            padding: 5px;
            border: 1px solid #ccc;
            border-radius: 3px;
        }
        
        .payment-form input[type="submit"] {
            width: 100%;
            padding: 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <h1>Formulaire de Paiement Fictif</h1>

    <form class="payment-form" method="post" action="index.php?action=creerCommande">
        <label for="nom">Nom:</label>
        <input type="text" name="nom" id="nom" required>
        
        <label for="numero-carte">Numéro de Carte:</label>
        <input type="text" name="numero-carte" id="numero-carte" required>
        
        <label for="expiration">Date d'Expiration:</label>
        <input type="text" name="expiration" id="expiration" required>
        
        <label for="cvv">Code de Sécurité (CVV):</label>
        <input type="text" name="cvv" id="cvv" required>
        
        <input type="submit" value="Payer">
    </form>