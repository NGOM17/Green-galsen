<?php
session_start();
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: connexion.php');
    exit();
}
require_once __DIR__ . '/../config/db.php';

// On récupère la connexion
$pdo = Database::getConnexion();

// On récupère tous les utilisateurs
$query = $pdo->query("SELECT * FROM utilisateurs ORDER BY id_utilisateur DESC");
$utilisateurs = $query->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des utilisateurs - Green Galsen</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <link rel="stylesheet" href="../CSS/admin-ui.css">
</head>
<body class="au-body">

    <nav class="au-nav">
        <a href="dashboard.php" class="au-logo"><i class="fa-solid fa-seedling"></i> Admin <span>Green Galsen</span></a>
        <button class="au-burger" onclick="document.getElementById('au-menu').classList.toggle('open')"><i class="fa-solid fa-bars"></i></button>
        <ul id="au-menu">
            <li><a href="dashboard.php"><i class="fa-solid fa-gauge"></i> Tableau de bord</a></li>
            <li><a href="commandes.php"><i class="fa-solid fa-receipt"></i> Commandes</a></li>
            <li><a href="produits.php"><i class="fa-solid fa-basket-shopping"></i> Produits</a></li>
            <li><a href="utilsateurs.php" class="active"><i class="fa-solid fa-users"></i> Utilisateurs</a></li>
            <li><a href="deconnexion.php" class="au-logout"><i class="fa-solid fa-right-from-bracket"></i> Déconnexion</a></li>
        </ul>
    </nav>

    <main class="au-main">
        <div class="au-page-header">
            <div>
                <h1>Utilisateurs inscrits</h1>
                <p>Retrouvez ici l'ensemble des clients inscrits sur Green Galsen.</p>
            </div>
            <div class="au-actions">
                <a href="inscription.php" class="au-btn au-btn-primary"><i class="fa-solid fa-user-plus"></i> Ajouter un utilisateur</a>
            </div>
        </div>

        <div class="au-table-wrap">
            <?php if (empty($utilisateurs)): ?>
                <div class="au-empty">
                    <i class="fa-solid fa-users"></i>
                    Aucun utilisateur inscrit pour le moment.
                </div>
            <?php else: ?>
            <table class="au-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nom</th>
                        <th>Prénom</th>
                        <th>Email</th>
                        <th>Rôle</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($utilisateurs as $user): ?>
                    <tr>
                        <td>#<?php echo htmlspecialchars($user['id_utilisateur']); ?></td>
                        <td><?php echo htmlspecialchars($user['nom']); ?></td>
                        <td><?php echo htmlspecialchars($user['prenom']); ?></td>
                        <td><?php echo htmlspecialchars($user['email']); ?></td>
                        <td><span class="au-badge au-badge-role"><?php echo htmlspecialchars($user['role']); ?></span></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <?php endif; ?>
        </div>
    </main>

</body>
</html>
