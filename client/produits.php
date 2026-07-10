<?php
session_start();

// Protection : seul un client connecté peut voir cette page
if (!isset($_SESSION['client_logged_in']) || $_SESSION['client_logged_in'] !== true) {
    header('Location: connexion_client.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Nos Produits - Green Galsen</title>
    <link rel="stylesheet" href="../CSS/style.css">
</head>
<body>
    <header>
        <nav>
            <h1>Green Galsen</h1>
            <ul>
                <li><a href="acceuil_client.php">Accueil</a></li>
                <li><a href="produits.php">Produits</a></li>
                <li><a href="deconnexion_client.php">Se déconnecter</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <h2>Nos Produits disponibles</h2>
        
        <div class="grille-produits">
            <!-- Exemple d'un produit (à répéter ou générer via une boucle PHP) -->
            <div class="produit">
                <h3>Nom du produit</h3>
                <p>Description courte du produit.</p>
                <p><strong>Prix : 1500 FCFA</strong></p>
                <button>Ajouter au panier</button>
            </div>
            
            <div class="produit">
                <h3>Nom du produit 2</h3>
                <p>Description courte du produit 2.</p>
                <p><strong>Prix : 2000 FCFA</strong></p>
                <button>Ajouter au panier</button>
            </div>
        </div>
    </main>
</body>
</html>