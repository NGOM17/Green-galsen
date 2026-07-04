<?php
require_once 'config/db.php';
$pdo = Database::getConnexion();

// Récupération de tous les produits mis en ligne
$query = $pdo->query("SELECT * FROM produits ORDER BY id_produit DESC");
$produits = $query->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Marché Green Galsén</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="text-success fw-bold">Le Marché Green Galsén</h2>
    <a href="ajouter_produit.php" class="btn btn-outline-success">Mettre un produit en vente</a>
</div>

        <?php if (empty($produits)): ?>
            <div class="alert alert-warning text-center shadow-sm">
                Aucun produit n'est disponible pour le moment.
            </div>
        <?php else: ?>
            <div class="row row-cols-1 row-cols-md-3 g-4">
                <?php foreach ($produits as $prod): ?>
                    <div class="col">
                        <div class="card h-100 shadow-sm border-0">
                            <!-- Affichage de la photo uploadée -->
                            <img src="<?php echo htmlspecialchars($prod['image_url']); ?>" 
                                 class="card-img-top" 
                                 alt="<?php echo htmlspecialchars($prod['nom_produit']); ?>" 
                                 style="height: 220px; object-fit: cover;">
                            
                            <div class="card-body">
                                <h5 class="card-title fw-bold text-dark"><?php echo htmlspecialchars($prod['nom_produit']); ?></h5>
                                <p class="card-text text-muted small"><?php echo htmlspecialchars($prod['description']); ?></p>
                                
                                <div class="d-flex justify-content-between align-items-center mt-3">
                                    <span class="fs-5 fw-bold text-success"><?php echo number_format($prod['prix'], 0, ',', ' '); ?> FCFA</span>
                                    <span class="badge bg-light text-success border border-success">Stock : <?php echo htmlspecialchars($prod['quantite_stock']); ?> kg</span>
                                </div>
                            </div>
                            
                            <!-- Le footer avec le NOUVEAU formulaire de panier corrigé -->
                            <div class="card-footer bg-white border-0 p-3">
                                <form action="ajouter_panier.php" method="POST">
                                    <input type="hidden" name="id_produit" value="<?php echo $prod['id_produit']; ?>">
                                    <button type="submit" class="btn btn-success w-100 py-2 fw-bold">Ajouter au panier</button>
                                </form>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?> <!-- C'est souvent cette balise qui saute par erreur ! -->
            </div>
        <?php endif; ?>
    </div>
</body>
</html>