<?php
session_start();
require_once __DIR__ . '/../config/db.php';
$pdo = Database::getConnexion();

// Sécurité : Vérifier que l'admin est connecté
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
header('Location: connexion.php');
exit();
}

// Récupérer les produits
$produits = $pdo->query("SELECT * FROM produits")->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Gestion des Produits - Green Galsen</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
<link rel="stylesheet" href="../CSS/admin-ui.css">
</head>
<body class="au-body">

<nav class="au-nav">
    <a href="dashboard.php" class="au-logo"><i class="fa-solid fa-seedling"></i> Admin <span>Green Galsen</span></a>
    <button class="au-burger" onclick="document.getElementById('au-menu').classList.toggle('open')"><i class="fa-solid fa-bars"></i></button>
    <ul id="au-menu">
        <li><a href="dashboard.php"><i class="fa-solid fa-gauge"></i> Tableau de bord</a></li>
        <li><a href="produits.php" class="active"><i class="fa-solid fa-basket-shopping"></i> Produits</a></li>
        <li><a href="rechercher_produits.php"><i class="fa-solid fa-magnifying-glass"></i> Rechercher</a></li>
        <li><a href="utilsateurs.php"><i class="fa-solid fa-users"></i> Utilisateurs</a></li>
        <li><a href="deconnexion.php" class="au-logout"><i class="fa-solid fa-right-from-bracket"></i> Déconnexion</a></li>
    </ul>
</nav>

<main class="au-main">
    <div class="au-page-header">
        <div>
            <h1>Gestion des produits</h1>
            <p>Ajoutez, modifiez ou supprimez les produits mis en vente sur la plateforme.</p>
        </div>
        <div class="au-actions">
            <a href="ajouter_produit.php" class="au-btn au-btn-primary"><i class="fa-solid fa-plus"></i> Ajouter un nouveau produit</a>
        </div>
    </div>

    <div class="au-table-wrap">
        <?php if (empty($produits)): ?>
            <div class="au-empty">
                <i class="fa-solid fa-basket-shopping"></i>
                Aucun produit enregistré pour le moment.
            </div>
        <?php else: ?>
        <table class="au-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nom</th>
                    <th>Prix</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($produits as $p): ?>
                <tr>
                    <td>#<?= htmlspecialchars($p['id_produit']) ?></td>
                    <td><?= htmlspecialchars($p['nom_produit']) ?></td>
                    <td><?= number_format($p['prix'], 0, ',', ' ') ?> FCFA</td>
                    <td class="au-actions-cell">
                        <a href="modifier_produit.php?id_produit=<?= $p['id_produit'] ?>" class="au-btn au-btn-sm au-btn-warning"><i class="fa-solid fa-pen"></i> Modifier</a>
                        <a href="supprimer_produits.php?id_produit=<?= $p['id_produit'] ?>" class="au-btn au-btn-sm au-btn-danger" onclick="return confirm('Es-tu sûr de vouloir supprimer ce produit ?')"><i class="fa-solid fa-trash"></i> Supprimer</a>
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
