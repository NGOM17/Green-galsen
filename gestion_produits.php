<?php
session_start();
require_once 'config/db.php';
$pdo = Database::getConnexion();

// TODO équipe : dès que la connexion agriculteur (session) sera prête,
// remplacer cette ligne par : $id_agriculteur = $_SESSION['id_agriculteur'];
// Pour l'instant on reste cohérent avec traitement_produit.php qui force id_agriculteur = 1
$id_agriculteur = $_SESSION['id_agriculteur'] ?? 1;

// Recherche par nom (optionnelle)
$recherche = isset($_GET['q']) ? trim($_GET['q']) : '';

if ($recherche !== '') {
    $sql = "SELECT * FROM produits WHERE id_agriculteur = ? AND nom_produit LIKE ? ORDER BY id_produit DESC";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id_agriculteur, "%$recherche%"]);
} else {
    $sql = "SELECT * FROM produits WHERE id_agriculteur = ? ORDER BY id_produit DESC";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id_agriculteur]);
}

$produits = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Message de confirmation après suppression ou modification (transmis en GET)
$message = '';
if (isset($_GET['succes']) && $_GET['succes'] === 'suppression') {
    $message = "Produit supprimé avec succès.";
} elseif (isset($_GET['succes']) && $_GET['succes'] === 'modification') {
    $message = "Produit modifié avec succès.";
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Gestion des Produits - Green Galsén</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="text-success fw-bold">Gestion de mes produits</h2>
            <a href="ajouter_produit.php" class="btn btn-success">+ Ajouter un produit</a>
        </div>

        <?php if ($message): ?>
            <div class="alert alert-success shadow-sm"><?php echo htmlspecialchars($message); ?></div>
        <?php endif; ?>

        <form action="gestion_produits.php" method="GET" class="mb-4">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="Rechercher un produit par nom..."
                       value="<?php echo htmlspecialchars($recherche); ?>">
                <button type="submit" class="btn btn-outline-success">Rechercher</button>
                <?php if ($recherche !== ''): ?>
                    <a href="gestion_produits.php" class="btn btn-outline-secondary">Réinitialiser</a>
                <?php endif; ?>
            </div>
        </form>

        <?php if (empty($produits)): ?>
            <div class="alert alert-warning text-center shadow-sm">
                Aucun produit trouvé. Commencez par en ajouter un.
            </div>
        <?php else: ?>
            <div class="table-responsive bg-white rounded shadow-sm">
                <table class="table align-middle mb-0">
                    <thead class="table-success">
                        <tr>
                            <th>Photo</th>
                            <th>Nom</th>
                            <th>Prix</th>
                            <th>Stock</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($produits as $prod): ?>
                            <tr>
                                <td>
                                    <img src="<?php echo htmlspecialchars($prod['image_url']); ?>"
                                         style="width: 60px; height: 60px; object-fit: cover;" class="rounded">
                                </td>
                                <td class="fw-bold"><?php echo htmlspecialchars($prod['nom_produit']); ?></td>
                                <td><?php echo number_format($prod['prix'], 0, ',', ' '); ?> FCFA</td>
                                <td>
                                    <?php if ($prod['quantite_stock'] < 5): ?>
                                        <span class="badge bg-danger">Stock faible : <?php echo htmlspecialchars($prod['quantite_stock']); ?> kg</span>
                                    <?php else: ?>
                                        <span class="badge bg-light text-success border border-success"><?php echo htmlspecialchars($prod['quantite_stock']); ?> kg</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-end">
                                    <a href="modifier_produit.php?id=<?php echo $prod['id_produit']; ?>"
                                       class="btn btn-sm btn-outline-primary">Modifier</a>
                                    <a href="supprimer_produit.php?id=<?php echo $prod['id_produit']; ?>"
                                       class="btn btn-sm btn-outline-danger"
                                       onclick="return confirm('Supprimer ce produit définitivement ?');">Supprimer</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>
        