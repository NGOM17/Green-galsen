<?php
session_start();

// Sécurité : seul un admin connecté peut accéder à cette page
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: connexion.php');
    exit();
}
require_once __DIR__ . '/../config/db.php';
$pdo = Database::getConnexion();

$resultats = [];
// 2. Traitement de la recherche par nom de produit
if (isset($_GET['q']) && !empty($_GET['q'])) {
    $q = $_GET['q'];
    // On cherche les produits dont le nom contient le mot clé (utilisation de LIKE)
    $stmt = $pdo->prepare("SELECT * FROM produits WHERE nom_produit LIKE ?");
    $stmt->execute(['%' . $_GET['q'] . '%']);
    $resultats = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Recherche de Produits</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <a href="produits.php" class="btn btn-secondary mb-3">Retour à la liste des produits</a>
        <div class="card p-4">
            <h3>Rechercher un produit</h3>
            <form method="GET" class="d-flex mb-4">
                <input type="text" name="q" class="form-control me-2" placeholder="Nom du produit (ex: Mangue)" required>
                <button type="submit" class="btn btn-success">Rechercher</button>
            </form>

            <?php if (isset($_GET['q'])): ?>
                <h5>Résultats pour : "<?= htmlspecialchars($_GET['q']) ?>"</h5>
                <?php if ($resultats): ?>
                    <table class="table table-striped">
                        <thead><tr><th>ID</th><th>Nom</th><th>Prix</th><th>Action</th></tr></thead>
                        <tbody>
                            <?php foreach ($resultats as $p): ?>
                            <tr>
                                <td><?= $p['id_produit'] ?></td>
                                <td><?= htmlspecialchars($p['nom_produit']) ?></td>
                                <td><?= $p['prix'] ?> FCFA</td>
                                <td><a href="modifier_produit.php?id_produit=<?= $p['id_produit'] ?>" class="btn btn-sm btn-warning">Modifier</a></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <p>Aucun produit trouvé.</p>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>