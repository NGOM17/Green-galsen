<?php
session_start();
require_once __DIR__ . '/../config/db.php';
$pdo = Database::getConnexion();

// Récupération de tous les produits mis en ligne
$query = $pdo->query("SELECT * FROM produits ORDER BY id_produit DESC");
$produits = $query->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Marché Green Galsén</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <link rel="stylesheet" href="../CSS/dashboard.css">
</head>
<body class="gg-body">

    <nav class="gg-nav">
        <a href="<?= isset($_SESSION['client_logged_in']) ? 'acceuil_client.php' : '../index.php' ?>" class="gg-logo">
            <i class="fa-solid fa-seedling"></i>
            Green <span>Galsen</span>
        </a>
        <button class="gg-burger" onclick="document.getElementById('gg-menu').classList.toggle('open')">
            <i class="fa-solid fa-bars"></i>
        </button>
        <ul id="gg-menu">
            <li><a href="catalogue.php"><i class="fa-solid fa-basket-shopping"></i> Nos produits</a></li>
            <li><a href="panier.php"><i class="fa-solid fa-cart-shopping"></i> Mon panier</a></li>
            <li><a href="connexion_client.php"><i class="fa-solid fa-user"></i> Mon compte</a></li>
        </ul>
    </nav>

    <div class="gg-market-wrap">

        <div class="gg-market-header">
            <div>
                <h1><i class="fa-solid fa-basket-shopping"></i>Le Marché Green Galsén</h1>
                <p>Fruits, légumes, plantes et greffons vendus directement par nos producteurs locaux.</p>
            </div>
            <a href="../admin/ajouter_produit.php" class="gg-card-cta" style="background:var(--gg-white); padding:.7rem 1.2rem; border-radius:10px; box-shadow:var(--gg-shadow); text-decoration:none;">
                <i class="fa-solid fa-plus"></i> Mettre un produit en vente
            </a>
        </div>

        <?php if (empty($produits)): ?>
            <div class="gg-market-empty">
                <i class="fa-solid fa-basket-shopping"></i>
                Aucun produit n'est disponible pour le moment.
            </div>
        <?php else: ?>
            <div class="gg-product-grid">
                <?php foreach ($produits as $prod): ?>
                    <?php
                        $hasImage = !empty($prod['image_url']);
                        $image_src = $hasImage ? '../' . ltrim($prod['image_url'], '/') : '';
                        $description = $prod['description'] ?? '';
                        $stock = (int) ($prod['stock'] ?? 0);
                    ?>
                    <div class="gg-product-card">
                        <div class="gg-product-media">
                            <?php if ($hasImage): ?>
                                <img src="<?= htmlspecialchars($image_src) ?>" alt="<?= htmlspecialchars($prod['nom_produit']) ?>">
                            <?php else: ?>
                                <div class="gg-placeholder"><i class="fa-solid fa-leaf"></i></div>
                            <?php endif; ?>
                        </div>

                        <div class="gg-product-body">
                            <h3><?= htmlspecialchars($prod['nom_produit']) ?></h3>
                            <p class="gg-product-desc"><?= htmlspecialchars(substr($description, 0, 80)) . (strlen($description) > 80 ? '...' : '') ?></p>

                            <div class="gg-product-meta">
                                <span class="gg-price"><?= number_format($prod['prix'], 0, ',', ' ') ?> FCFA</span>
                                <span class="gg-stock-badge <?= $stock <= 0 ? 'out' : '' ?>">
                                    <?= $stock > 0 ? 'Stock : ' . $stock . ' kg' : 'Rupture de stock' ?>
                                </span>
                            </div>

                            <form action="ajouter_panier.php" method="POST" class="gg-add-form">
                                <input type="hidden" name="id_produit" value="<?= $prod['id_produit'] ?>">
                                <button type="submit" class="gg-add-btn"><i class="fa-solid fa-cart-plus"></i> Ajouter au panier</button>
                            </form>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>

</body>
</html>
