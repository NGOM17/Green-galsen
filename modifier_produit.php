<?php
require_once 'config/db.php';
$pdo = Database::getConnexion();

if (!isset($_GET['id'])) {
    header("Location: gestion_produits.php");
    exit;
}

$id_produit = $_GET['id'];

$stmt = $pdo->prepare("SELECT * FROM produits WHERE id_produit = ?");
$stmt->execute([$id_produit]);
$produit = $stmt->fetch(PDO::FETCH_ASSOC);

// Si le produit n'existe pas, on retourne à la liste
if (!$produit) {
    header("Location: gestion_produits.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier un Produit - Green Galsén</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5" style="max-width: 600px;">
        <div class="card shadow-sm p-4 bg-white">
            <h2 class="text-success mb-4 text-center">Modifier le produit</h2>

            <div class="text-center mb-3">
                <img src="<?php echo htmlspecialchars($produit['image_url']); ?>"
                     style="width: 120px; height: 120px; object-fit: cover;" class="rounded">
            </div>

            <!-- enctype requis même en modification, au cas où on change la photo -->
            <form action="traitement_modif_produit.php" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="id_produit" value="<?php echo $produit['id_produit']; ?>">
                <!-- On garde en mémoire l'ancienne image pour pouvoir la supprimer si elle est remplacée -->
                <input type="hidden" name="ancienne_image" value="<?php echo htmlspecialchars($produit['image_url']); ?>">

                <div class="mb-3">
                    <label class="form-label">Nom du produit</label>
                    <input type="text" name="nom_produit" class="form-control"
                           value="<?php echo htmlspecialchars($produit['nom_produit']); ?>" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Description courte</label>
                    <textarea name="description" class="form-control" rows="3" required><?php echo htmlspecialchars($produit['description']); ?></textarea>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Prix unitaire (FCFA)</label>
                        <input type="number" step="0.01" name="prix" class="form-control"
                               value="<?php echo htmlspecialchars($produit['prix']); ?>" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Quantité en stock (Kg)</label>
                        <input type="number" name="quantite_stock" class="form-control"
                               value="<?php echo htmlspecialchars($produit['quantite_stock']); ?>" required>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label">Nouvelle photo (laisser vide pour garder l'actuelle)</label>
                    <input type="file" name="image" class="form-control" accept="image/*">
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-success w-100">Enregistrer les modifications</button>
                    <a href="gestion_produits.php" class="btn btn-outline-secondary w-100 text-center d-flex align-items-center justify-content-center">Annuler</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>