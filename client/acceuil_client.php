<?php
// 1. Démarrer la session
session_start();

// 2. Sécurité : Vérifier si le client est bien connecté
if (!isset($_SESSION['client_logged_in']) || $_SESSION['client_logged_in'] !== true) {
    header('Location: connexion_client.php');
    exit();
}

// (Optionnel) Si vous voulez récupérer le nom de l'utilisateur depuis la BDD ici
$client_email = $_SESSION['client_email'] ?? '';
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon Espace Client - Green Galsen</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <link rel="stylesheet" href="../CSS/dashboard.css">
</head>
<body class="gg-body">

    <nav class="gg-nav">
        <a href="acceuil_client.php" class="gg-logo">
            <i class="fa-solid fa-seedling"></i>
            Green <span>Galsen</span>
        </a>
        <button class="gg-burger" onclick="document.getElementById('gg-menu').classList.toggle('open')">
            <i class="fa-solid fa-bars"></i>
        </button>
        <ul id="gg-menu">
            <li><a href="catalogue.php"><i class="fa-solid fa-basket-shopping"></i> Nos produits</a></li>
            <li><a href="panier.php"><i class="fa-solid fa-cart-shopping"></i> Mon panier</a></li>
            <li><a href="profil.php"><i class="fa-solid fa-user"></i> Mon profil</a></li>
            <li><a href="deconnexion_client.php" class="gg-logout"><i class="fa-solid fa-right-from-bracket"></i> Se déconnecter</a></li>
        </ul>
    </nav>

    <main class="gg-main">

        <section class="gg-hero">
            <span class="blob blob-a"></span>
            <span class="blob blob-b"></span>
            <span class="eyebrow"><i class="fa-solid fa-leaf"></i>&nbsp; Espace client</span>
            <h1>Bienvenue sur Green Galsen<?= $client_email ? ' 👋' : '' ?></h1>
            <p>Vous êtes bien connecté à votre espace sécurisé. Retrouvez ici vos produits favoris, votre panier et vos informations personnelles.</p>
        </section>

        <div class="gg-grid">
            <a href="catalogue.php" class="gg-card">
                <div class="gg-card-icon"><i class="fa-solid fa-basket-shopping"></i></div>
                <h3>Nos produits</h3>
                <p>Découvrez les fruits, légumes, plantes et greffons de nos producteurs locaux.</p>
                <span class="gg-card-cta">Voir le catalogue <i class="fa-solid fa-arrow-right"></i></span>
            </a>

            <a href="panier.php" class="gg-card">
                <div class="gg-card-icon"><i class="fa-solid fa-cart-shopping"></i></div>
                <h3>Mon panier</h3>
                <p>Retrouvez les articles que vous avez ajoutés et finalisez votre commande.</p>
                <span class="gg-card-cta">Voir mon panier <i class="fa-solid fa-arrow-right"></i></span>
            </a>

            <a href="profil.php" class="gg-card">
                <div class="gg-card-icon"><i class="fa-solid fa-user"></i></div>
                <h3>Mon profil</h3>
                <p>Consultez vos informations personnelles et modifiez votre mot de passe.</p>
                <span class="gg-card-cta">Gérer mon profil <i class="fa-solid fa-arrow-right"></i></span>
            </a>
        </div>

        <section class="gg-section">
            <h3><i class="fa-solid fa-circle-info"></i> Mes informations</h3>
            <p>Ici, vous pourrez bientôt suivre l'historique de vos commandes directement depuis votre tableau de bord.</p>
        </section>

    </main>

</body>
</html>
