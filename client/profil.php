<?php
session_start();

// 1. Protection
if (!isset($_SESSION['client_logged_in']) || $_SESSION['client_logged_in'] !== true || !isset($_SESSION['client_id'])) {
    session_unset();
    session_destroy();
    header('Location: connexion_client.php?erreur=session');
    exit();
}

require_once __DIR__ . '/../config/db.php';
$pdo = Database::getConnexion();

// 2. Récupérer l'ID du client depuis la session
$client_id = $_SESSION['client_id'];

// 3. Traitement de la mise à jour du mot de passe
$message = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['new_password'])) {
    $new_password = password_hash($_POST['new_password'], PASSWORD_DEFAULT);

    $stmt = $pdo->prepare("UPDATE utilisateurs SET password = ? WHERE id_utilisateur = ?");
    $stmt->execute([$new_password, $client_id]);
    $message = "Mot de passe mis à jour avec succès !";
}

// 4. Récupérer les infos actuelles
$stmt = $pdo->prepare("SELECT nom, prenom, email FROM utilisateurs WHERE id_utilisateur = ?");
$stmt->execute([$client_id]);
$client = $stmt->fetch(PDO::FETCH_ASSOC);

$nomComplet = trim(($client['nom'] ?? '') . ' ' . ($client['prenom'] ?? ''));
$initiales = strtoupper(mb_substr($client['nom'] ?? '?', 0, 1) . mb_substr($client['prenom'] ?? '', 0, 1));
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon Profil - Green Galsen</title>
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

    <div class="gg-profile-wrap">
        <div class="gg-profile-card">

            <div class="gg-profile-banner">
                <div class="gg-avatar"><?= htmlspecialchars($initiales ?: '?') ?></div>
                <h2>Mon profil</h2>
                <p>Gérez vos informations personnelles</p>
            </div>

            <div class="gg-profile-body">

                <?php if ($message): ?>
                    <div class="gg-alert-success"><i class="fa-solid fa-circle-check"></i> <?= htmlspecialchars($message) ?></div>
                <?php endif; ?>

                <div class="gg-info-row">
                    <i class="fa-solid fa-user"></i>
                    <span class="label">Nom</span>
                    <span class="value"><?= htmlspecialchars($nomComplet ?: '—') ?></span>
                </div>
                <div class="gg-info-row">
                    <i class="fa-solid fa-envelope"></i>
                    <span class="label">Email</span>
                    <span class="value"><?= htmlspecialchars($client['email'] ?? '') ?></span>
                </div>

                <h4><i class="fa-solid fa-lock"></i> Changer le mot de passe</h4>
                <form method="POST">
                    <div class="gg-form-group">
                        <i class="fa-solid fa-key"></i>
                        <input type="password" name="new_password" placeholder="Nouveau mot de passe" required>
                    </div>
                    <button type="submit" class="gg-btn">
                        Mettre à jour <i class="fa-solid fa-arrow-right"></i>
                    </button>
                </form>

                <a href="acceuil_client.php" class="gg-back-link"><i class="fa-solid fa-arrow-left"></i> Retour au tableau de bord</a>
            </div>
        </div>
    </div>

</body>
</html>
