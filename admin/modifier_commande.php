<?php
session_start();

// Sécurité : seul un admin connecté peut accéder à cette page
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: connexion.php');
    exit();
}
require_once __DIR__ . '/../config/db.php';
$pdo = Database::getConnexion();

if (!isset($_GET['id'])) {
    header('Location: commandes.php');
    exit();
}
$id = $_GET['id'];

// 1. D'ABORD : Traitement de la mise à jour si POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $statut = $_POST['statut'];
    $total_prix = $_POST['total_prix'];

    $stmt = $pdo->prepare("UPDATE commandes SET statut = ?, total_prix = ? WHERE id = ?");
    $stmt->execute([$statut, $total_prix, $id]);

    header('Location: commandes.php?message=modifie');
    exit();
}

// 2. ENSUITE : Récupération des données pour l'affichage
$stmt = $pdo->prepare("SELECT * FROM commandes WHERE id = ?");
$stmt->execute([$id]);
$c = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$c) { die("Commande introuvable."); }
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier Commande #<?= $c['id'] ?> - Green Galsen</title>
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

    <main class="au-main" style="max-width:520px;">
        <div class="au-card">
            <h1 style="font-size:1.3rem; margin-bottom:1.4rem;"><i class="fa-solid fa-pen" style="color:var(--au-primary); margin-right:.4rem;"></i> Modifier la commande #<?= $c['id'] ?></h1>

            <form action="modifier_commande.php?id=<?= $c['id']?>" method="POST">
                <div class="au-form-group">
                    <label>Total Prix (FCFA)</label>
                    <input type="number" name="total_prix" value="<?= $c['total_prix'] ?>" required>
                </div>
                <div class="au-form-group">
                    <label>Statut</label>
                    <select name="statut">
                        <option value="En attente" <?= $c['statut'] == 'En attente' ? 'selected' : '' ?>>En attente</option>
                        <option value="Livrée" <?= $c['statut'] == 'Livrée' ? 'selected' : '' ?>>Livrée</option>
                    </select>
                </div>

                <div class="au-form-actions">
                    <button type="submit" class="au-btn au-btn-warning"><i class="fa-solid fa-floppy-disk"></i> Enregistrer les modifications</button>
                    <a href="commandes.php" class="au-btn au-btn-link">Annuler</a>
                </div>
            </form>
        </div>
    </main>

</body>
</html>
