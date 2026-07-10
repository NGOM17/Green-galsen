<?php
session_start();
require_once __DIR__ . '/../config/db.php';
$pdo = Database::getConnexion();

if (!isset($_SESSION['panier'])) {
    $_SESSION['panier'] = [];
}

// Retirer un article du panier
if (isset($_GET['retirer']) && ctype_digit((string) $_GET['retirer'])) {
    unset($_SESSION['panier'][(int) $_GET['retirer']]);
    header('Location: panier.php');
    exit;
}

// Vider entièrement le panier
if (isset($_GET['vider'])) {
    $_SESSION['panier'] = [];
    header('Location: panier.php');
    exit;
}

// Modifier la quantité d'un article
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['quantites']) && is_array($_POST['quantites'])) {
    foreach ($_POST['quantites'] as $id => $qty) {
        $id = (int) $id;
        $qty = (int) $qty;
        if (isset($_SESSION['panier'][$id])) {
            if ($qty <= 0) {
                unset($_SESSION['panier'][$id]);
            } else {
                $_SESSION['panier'][$id] = $qty;
            }
        }
    }
    header('Location: panier.php');
    exit;
}

$total = 0;
$nb_articles = 0;
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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon Panier - Green Galsén</title>
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
            <li><a href="panier.php" class="gg-active"><i class="fa-solid fa-cart-shopping"></i> Mon panier</a></li>
            <li><a href="connexion_client.php"><i class="fa-solid fa-user"></i> Mon compte</a></li>
        </ul>
    </nav>

    <div class="gg-market-wrap">

        <div class="gg-market-header">
            <div>
                <h1><i class="fa-solid fa-cart-shopping"></i>Votre Panier</h1>
                <p>Retrouvez ici les produits frais sélectionnés avant de passer commande.</p>
            </div>
            <?php if (!empty($produits_panier)): ?>
                <a href="?vider" class="gg-clear-cart" onclick="return confirm('Vider entièrement le panier ?');">
                    <i class="fa-solid fa-trash-can"></i> Vider le panier
                </a>
            <?php endif; ?>
        </div>

        <?php if (empty($produits_panier)): ?>

            <div class="gg-cart-empty">
                <div class="gg-cart-empty-icon">
                    <i class="fa-solid fa-basket-shopping"></i>
                </div>
                <h3>Votre panier est vide</h3>
                <p>Vous n'avez pas encore ajouté de produit. Direction le marché pour découvrir les fruits, légumes et plantes de nos producteurs locaux !</p>
                <a href="catalogue.php" class="gg-btn">
                    <i class="fa-solid fa-basket-shopping"></i> Découvrir le catalogue
                </a>
            </div>

        <?php else: ?>

            <form action="panier.php" method="POST">
                <div class="gg-cart-list">
                    <?php foreach ($produits_panier as $prod):
                        $id = $prod['id_produit'];
                        $qty = $_SESSION['panier'][$id];
                        $subtotal = $prod['prix'] * $qty;
                        $total += $subtotal;
                        $nb_articles += $qty;
                        $hasImage = !empty($prod['image_url']);
                        $image_src = $hasImage ? '../' . ltrim($prod['image_url'], '/') : '';
                    ?>
                    <div class="gg-cart-item">
                        <div class="gg-cart-item-media">
                            <?php if ($hasImage): ?>
                                <img src="<?= htmlspecialchars($image_src) ?>" alt="<?= htmlspecialchars($prod['nom_produit']) ?>">
                            <?php else: ?>
                                <div class="gg-placeholder"><i class="fa-solid fa-leaf"></i></div>
                            <?php endif; ?>
                        </div>

                        <div class="gg-cart-item-body">
                            <h4><?= htmlspecialchars($prod['nom_produit']) ?></h4>
                            <span class="gg-price"><?= number_format($prod['prix'], 0, ',', ' ') ?> FCFA / kg</span>
                        </div>

                        <div class="gg-cart-item-qty">
                            <label>Quantité (kg)</label>
                            <input type="number" name="quantites[<?= $id ?>]" value="<?= $qty ?>" min="0" step="1">
                        </div>

                        <div class="gg-cart-item-subtotal">
                            <?= number_format($subtotal, 0, ',', ' ') ?> FCFA
                        </div>

                        <a href="?retirer=<?= $id ?>" class="gg-cart-item-remove" title="Retirer cet article" onclick="return confirm('Retirer ce produit du panier ?');">
                            <i class="fa-solid fa-xmark"></i>
                        </a>
                    </div>
                    <?php endforeach; ?>
                </div>

                <div class="gg-cart-summary">
                    <button type="submit" class="gg-btn gg-btn-outline">
                        <i class="fa-solid fa-rotate"></i> Mettre à jour les quantités
                    </button>

                    <div class="gg-cart-total">
                        <span><?= $nb_articles ?> article<?= $nb_articles > 1 ? 's' : '' ?></span>
                        <h3>Total : <span class="text-price"><?= number_format($total, 0, ',', ' ') ?> FCFA</span></h3>
                    </div>
                </div>
            </form>

            <div class="gg-cart-actions">
                <a href="catalogue.php" class="gg-btn gg-btn-outline">
                    <i class="fa-solid fa-arrow-left"></i> Continuer mes achats
                </a>
                <form action="paiement.php" method="POST">
                    <button type="submit" class="gg-btn">
                        Valider la commande <i class="fa-solid fa-arrow-right"></i>
                    </button>
                </form>
            </div>

        <?php endif; ?>
    </div>

</body>
</html>
