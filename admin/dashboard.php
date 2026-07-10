<?php
session_start();

// 1. Protection : seul un admin connecté peut voir cette page
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: connexion.php');
    exit();
}

// 2. Connexion sécurisée
require_once __DIR__ . '/../config/db.php';
$pdo = Database::getConnexion();

// 3. Calcul des statistiques
// On compte les commandes et on additionne les prix
$stats_cmd = $pdo->query("SELECT COUNT(*) as nb_cmd, SUM(total_prix) as revenu FROM commandes")->fetch(PDO::FETCH_ASSOC);
// On compte les produits
$stats_prod = $pdo->query("SELECT COUNT(*) as nb_prod FROM produits")->fetch(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de bord - Green Galsen</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <link rel="stylesheet" href="../CSS/admin-ui.css">
</head>
<body class="au-body">

    <nav class="au-nav">
        <a href="dashboard.php" class="au-logo"><i class="fa-solid fa-seedling"></i> Admin <span>Green Galsen</span></a>
        <button class="au-burger" onclick="document.getElementById('au-menu').classList.toggle('open')"><i class="fa-solid fa-bars"></i></button>
        <ul id="au-menu">
            <li><a href="dashboard.php" class="active"><i class="fa-solid fa-gauge"></i> Tableau de bord</a></li>
            <li><a href="commandes.php"><i class="fa-solid fa-receipt"></i> Commandes</a></li>
            <li><a href="produits.php"><i class="fa-solid fa-basket-shopping"></i> Produits</a></li>
            <li><a href="utilsateurs.php"><i class="fa-solid fa-users"></i> Utilisateurs</a></li>
            <li><a href="deconnexion.php" class="au-logout"><i class="fa-solid fa-right-from-bracket"></i> Déconnexion</a></li>
        </ul>
    </nav>

    <main class="au-main">
        <div class="au-page-header">
            <div>
                <h1>Tableau de bord</h1>
                <p>Vue d'ensemble de l'activité de la plateforme Green Galsen.</p>
            </div>
        </div>

        <div class="au-stats-grid">
            <div class="au-stat-card">
                <div class="au-stat-icon"><i class="fa-solid fa-receipt"></i></div>
                <div>
                    <h3>Commandes</h3>
                    <div class="au-stat-value"><?= htmlspecialchars($stats_cmd['nb_cmd']); ?></div>
                </div>
            </div>

            <div class="au-stat-card stat-revenue">
                <div class="au-stat-icon"><i class="fa-solid fa-sack-dollar"></i></div>
                <div>
                    <h3>Revenu total</h3>
                    <div class="au-stat-value"><?= number_format($stats_cmd['revenu'] ?? 0, 0, ',', ' '); ?> FCFA</div>
                </div>
            </div>

            <div class="au-stat-card stat-products">
                <div class="au-stat-icon"><i class="fa-solid fa-basket-shopping"></i></div>
                <div>
                    <h3>Produits</h3>
                    <div class="au-stat-value"><?= htmlspecialchars($stats_prod['nb_prod']); ?></div>
                </div>
            </div>
        </div>

        <div class="au-card">
            <h3 style="font-size:1rem; font-weight:600; margin-bottom:.5rem;"><i class="fa-solid fa-circle-info" style="color:var(--au-primary); margin-right:.4rem;"></i> Bienvenue</h3>
            <p style="font-size:.9rem; color:var(--au-gray); line-height:1.6;">
                Utilisez le menu ci-dessus pour gérer les commandes, les produits et les utilisateurs de la plateforme.
            </p>
        </div>
    </main>

</body>
</html>
