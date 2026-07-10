<?php
session_start();

// Sécurité : seul un admin connecté peut accéder à cette page
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: connexion.php');
    exit();
}
require_once __DIR__ . '/../config/db.php';
$pdo = Database::getConnexion();

// 2. Vérifier si un ID est bien passé dans l'URL
if (!isset($_GET['id_produit'])) {
    header('Location: produits.php');
    exit();
}

$id = $_GET['id_produit'];

// 3. Traitement de la mise à jour (Formulaire envoyé)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = $_POST['nom_produit'];
    $prix = $_POST['prix'];

    $stmt = $pdo->prepare("UPDATE produits SET nom_produit = ?, prix = ? WHERE id_produit = ?");
    $stmt->execute([$nom, $prix, $id]);
    
    header('Location: produits.php?succes=modifie');
    exit();
}

// 4. Récupérer les données actuelles du produit pour pré-remplir le formulaire
$stmt = $pdo->prepare("SELECT id_produit, nom_produit, prix FROM produits WHERE id_produit = ?");
$stmt->execute([$id]);
$p = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$p) { die("Produit introuvable."); }
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier Produit</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="card p-4 col-md-6 mx-auto">
            <h3>Modifier le produit : <?= htmlspecialchars($p['nom_produit']) ?></h3>
            <form action="enregistrer_produits.php" method="POST">
                <input type="hidden" name="action" value="modifier">
                <input type="hidden" name="id_produit" value="<?= htmlspecialchars($p['id_produit']) ?>">
                <label>Nom :</label>
                <input type="text" name="nom_produit" value="<?= htmlspecialchars($p['nom_produit']) ?>" required>
                <label>Prix :</label>
                <input type="number" name="prix" value="<?= htmlspecialchars($p['prix']) ?>" required>
                <button type="submit">Enregistrer les modifications</button>
            </form>
        </div>
    </div>
</body>
</html>