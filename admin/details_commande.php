<?php
session_start();

// Sécurité : seul un admin connecté peut accéder à cette page
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: connexion.php');
    exit();
}

// 2. Connexion
require_once __DIR__ . '/../config/db.php';
$pdo = Database::getConnexion();

// 3. Récupération et vérification de l'ID
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header('Location: commandes.php');
    exit();
}

$id = $_GET['id'];

// 4. Requête pour les détails de la commande
$stmt = $pdo->prepare("SELECT * FROM commandes WHERE id = ?");
$stmt->execute([$id]);
$commande = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$commande) {
    die("Commande introuvable.");
}

$estLivree = strtolower($commande['statut']) === 'livrée' || strtolower($commande['statut']) === 'livree';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Détails Commande #<?= htmlspecialchars($commande['id']) ?> - Green Galsen</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <link rel="stylesheet" href="../CSS/admin-ui.css">
</head>
<body class="au-body">

    <nav class="au-nav">
        <a href="dashboard.php" class="au-logo"><i class="fa-solid fa-seedling"></i> Admin <span>Green Galsen</span></a>
        <button class="au-burger" onclick="document.getElementById('au-menu').classList.toggle('open')"><i class="fa-solid fa-bars"></i></button>
        <ul id="au-menu">
            <li><a href="dashboard.php"><i class="fa-solid fa-gauge"></i> Tableau de bord</a></li>
            <li><a href="commandes.php" class="active"><i class="fa-solid fa-receipt"></i> Commandes</a></li>
            <li><a href="produits.php"><i class="fa-solid fa-basket-shopping"></i> Produits</a></li>
            <li><a href="utilsateurs.php"><i class="fa-solid fa-users"></i> Utilisateurs</a></li>
            <li><a href="deconnexion.php" class="au-logout"><i class="fa-solid fa-right-from-bracket"></i> Déconnexion</a></li>
        </ul>
    </nav>

    <main class="au-main" style="max-width:640px;">
        <a href="commandes.php" class="au-btn au-btn-outline" style="margin-bottom:1.4rem;"><i class="fa-solid fa-arrow-left"></i> Retour aux commandes</a>

        <div class="au-card">
            <div class="au-page-header" style="margin-bottom:1rem;">
                <div>
                    <h1 style="font-size:1.3rem;">Commande #<?= htmlspecialchars($commande['id']) ?></h1>
                </div>
                <span class="au-badge <?= $estLivree ? 'au-badge-delivered' : 'au-badge-pending' ?>">
                    <i class="fa-solid <?= $estLivree ? 'fa-circle-check' : 'fa-clock' ?>"></i>
                    <?= htmlspecialchars($commande['statut']) ?>
                </span>
            </div>

            <ul class="au-detail-list">
                <li><i class="fa-solid fa-user"></i> <span class="label">Client (ID)</span> <span class="value"><?= htmlspecialchars($commande['utilisateur_id']) ?></span></li>
                <li><i class="fa-solid fa-sack-dollar"></i> <span class="label">Total</span> <span class="value"><?= number_format($commande['total_prix'], 0, ',', ' ') ?> FCFA</span></li>
                <li><i class="fa-solid fa-calendar"></i> <span class="label">Date</span> <span class="value"><?= htmlspecialchars($commande['date_commande']) ?></span></li>
            </ul>

            <div style="margin-top:1.6rem;">
                <a href="modifier_commande.php?id=<?= $commande['id'] ?>" class="au-btn au-btn-warning"><i class="fa-solid fa-pen"></i> Modifier le statut</a>
            </div>
        </div>
    </main>

</body>
</html>
