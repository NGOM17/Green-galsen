<?php
session_start();
require_once 'config/db.php';
$pdo = Database::getConnexion();

$total = 0;
$produits_panier = [];

// Si le panier contient des produits, on récupère leurs infos en BDD
if (!empty($_SESSION['panier'])) {
    $ids = array_keys($_SESSION['panier']);
    $placeholders = implode(',', array_fill(0, count($ids), '?'));
    
    $query = $pdo->prepare("SELECT * FROM produits WHERE id_produit IN ($placeholders)");
    $query->execute($ids);
    $produits_panier = $query->fetchAll(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Mon Panier - Green Galsén</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <h2 class="mb-4 text-success fw-bold">Votre Panier</h2>
        
        <?php if (empty($produits_panier)): ?>
            <div class="alert alert-info">Votre panier est vide. <a href="catalogue.php">Retourner au catalogue</a></div>
        <?php else: ?>
            <table class="table align-middle bg-white rounded shadow-sm">
                <thead class="table-success">
                    <tr>
                        <th>Produit</th>
                        <th>Prix</th>
                        <th>Quantité</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($produits_panier as $prod): 
                        $qty = $_SESSION['panier'][$prod['id_produit']];
                        $subtotal = $prod['prix'] * $qty;
                        $total += $subtotal;
                    ?>
                    <tr>
                        <td>
                            <img src="<?php echo $prod['image_url']; ?>" style="width: 50px; height: 50px; object-fit: cover;" class="rounded me-2">
                            <?php echo htmlspecialchars($prod['nom_produit']); ?>
                        </td>
                        <td><?php echo number_format($prod['prix'], 0, ',', ' '); ?> FCFA</td>
                        <td><?php echo $qty; ?> kg</td>
                        <td class="fw-bold"><?php echo number_format($subtotal, 0, ',', ' '); ?> FCFA</td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <div class="text-end mt-4">
                <h4>Total de la commande : <span class="text-success fw-bold"><?php echo number_format($total, 0, ',', ' '); ?> FCFA</span></h4>
                <a href="catalogue.php" class="btn btn-outline-secondary">Continuer mes achats</a>
                <button class="btn btn-success px-4">Valider la commande</button>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>