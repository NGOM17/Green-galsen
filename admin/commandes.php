<?php
session_start();

// Sécurité : seul un admin connecté peut accéder à cette page
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: connexion.php');
    exit();
}
// 2. Connexion sécurisée
require_once __DIR__ . '/../config/db.php';
$pdo = Database::getConnexion();

// 3. Récupération des commandes
// On trie par date pour avoir les plus récentes en haut
$sql = "SELECT * FROM commandes ORDER BY date_commande DESC";
$commandes = $pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Commandes - Green Galsen</title>
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

    <main class="au-main">
        <div class="au-page-header">
            <div>
                <h1>Gestion des commandes</h1>
                <p>Suivez, validez ou supprimez les commandes passées par les clients.</p>
            </div>
            <div class="au-actions">
                <a href="rechercher_commande.php" class="au-btn au-btn-outline"><i class="fa-solid fa-magnifying-glass"></i> Rechercher</a>
                <a href="dashboard.php" class="au-btn au-btn-primary"><i class="fa-solid fa-arrow-left"></i> Tableau de bord</a>
            </div>
        </div>

        <div class="au-table-wrap">
            <?php if (empty($commandes)): ?>
                <div class="au-empty">
                    <i class="fa-solid fa-receipt"></i>
                    Aucune commande enregistrée pour le moment.
                </div>
            <?php else: ?>
            <table class="au-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Client (ID)</th>
                        <th>Total</th>
                        <th>Statut</th>
                        <th>Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($commandes as $c): ?>
                    <?php $estLivree = strtolower($c['statut']) === 'livrée' || strtolower($c['statut']) === 'livree'; ?>
                    <tr>
                        <td>#<?= htmlspecialchars($c['id']); ?></td>
                        <td><?= htmlspecialchars($c['utilisateur_id']); ?></td>
                        <td><?= number_format($c['total_prix'], 0, ',', ' '); ?> FCFA</td>
                        <td>
                            <span class="au-badge <?= $estLivree ? 'au-badge-delivered' : 'au-badge-pending' ?>">
                                <i class="fa-solid <?= $estLivree ? 'fa-circle-check' : 'fa-clock' ?>"></i>
                                <?= htmlspecialchars($c['statut']); ?>
                            </span>
                        </td>
                        <td><?= htmlspecialchars($c['date_commande']); ?></td>
                        <td class="au-actions-cell">
                            <a href="details_commande.php?id=<?= $c['id']; ?>" class="au-btn au-btn-sm au-btn-info"><i class="fa-solid fa-eye"></i> Voir</a>
                            <a href="action_commande.php?id=<?= $c['id']; ?>&action=supprimer" class="au-btn au-btn-sm au-btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette commande ?')"><i class="fa-solid fa-trash"></i> Supprimer</a>
                            <a href="action_commande.php?id=<?= $c['id']; ?>&action=valider" class="au-btn au-btn-sm au-btn-success"><i class="fa-solid fa-check"></i> Valider</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <?php endif; ?>
        </div>
    </main>

</body>
</html>
