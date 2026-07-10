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

// 3. Récupération de l'ID du produit
if (!isset($_GET['id_produit']) || empty($_GET['id_produit'])) {
    header('Location: produits.php');
    exit();
}

$id = $_GET['id_produit'];

// 4. Requête sécurisée pour les détails du produit
$stmt = $pdo->prepare("SELECT * FROM produits WHERE id_produit = ?");
$stmt->execute([$id]);
$produit = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$produit) {
    die("Produit introuvable.");
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Détails du produit : <?= htmlspecialchars($produit['nom_produit']) ?></title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <a href="produits.php" class="btn btn-secondary mb-3">Retour à la liste</a>
        <div class="card p-4 shadow-sm">
            <h3 class="mb-4">Détails : <?= htmlspecialchars($produit['nom_produit']) ?></h3>
            <ul class="list-group">
                <li class="list-group-item"><strong>ID :</strong> <?= htmlspecialchars($produit['id_produit']) ?></li>
                <li class="list-group-item"><strong>Nom :</strong> <?= htmlspecialchars($produit['nom_produit']) ?></li>
                <li class="list-group-item"><strong>Prix :</strong> <?= number_format($produit['prix'], 0, ',', ' ') ?> FCFA</li>
            </ul>
            <div class="mt-4">
                <a href="modifier_produit.php?id_produit=<?= $produit['id_produit'] ?>" class="btn btn-warning">Modifier ce produit</a>
            </div>
        </div>
    </div>
</body>
</html>