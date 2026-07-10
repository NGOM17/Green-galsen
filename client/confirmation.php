<?php
session_start();

// Sécurité : seul un client connecté (avec un id valide en session) peut finaliser une commande
if (!isset($_SESSION['client_logged_in']) || $_SESSION['client_logged_in'] !== true || !isset($_SESSION['client_id'])) {
    session_unset();
    session_destroy();
    header('Location: connexion_client.php?erreur=session');
    exit();
}

require_once __DIR__ . '/../config/db.php';
$pdo = Database::getConnexion();

// Si pas de panier, retour au catalogue (rien à confirmer)
if (empty($_SESSION['panier'])) {
    header('Location: catalogue.php');
    exit();
}

$methode = $_POST['methode'] ?? 'wave';
$erreur = null;
$commande_id = null;
$total_final = 0;

try {
    $pdo->beginTransaction();

    // 1. Enregistrer la commande principale (rattachée au client réellement connecté)
    $user_id = $_SESSION['client_id'];
    $sql = "INSERT INTO commandes (utilisateur_id, total_prix, statut, date_commande) VALUES (?, 0, 'En attente', NOW())";
    $pdo->prepare($sql)->execute([$user_id]);
    $commande_id = $pdo->lastInsertId();

    // 2. Enregistrer le détail de chaque produit du panier
    $sql_detail = "INSERT INTO details_commande (id_commande, id_produit, quantite, prix_unitaire) VALUES (?, ?, ?, ?)";
    $stmt_detail = $pdo->prepare($sql_detail);

    foreach ($_SESSION['panier'] as $id_produit => $quantite) {
        $req_prod = $pdo->prepare("SELECT prix FROM produits WHERE id_produit = ?");
        $req_prod->execute([$id_produit]);
        $produit = $req_prod->fetch(PDO::FETCH_ASSOC);

        if ($produit) {
            $stmt_detail->execute([$commande_id, $id_produit, $quantite, $produit['prix']]);
            $total_final += $produit['prix'] * $quantite;
        }
    }

    // 3. Mettre à jour le total réel de la commande
    $pdo->prepare("UPDATE commandes SET total_prix = ? WHERE id = ?")->execute([$total_final, $commande_id]);

    $pdo->commit();

    // 4. Vider le panier une fois la commande enregistrée
    unset($_SESSION['panier']);
} catch (Exception $e) {
    $pdo->rollBack();
    $erreur = $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Confirmation de commande - Green Galsen</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5" style="max-width: 500px;">
        <div class="card p-4 shadow-sm text-center">
            <?php if ($erreur): ?>
                <h3 class="text-danger">Une erreur est survenue</h3>
                <p><?= htmlspecialchars($erreur) ?></p>
                <a href="panier.php" class="btn btn-outline-secondary">Retour au panier</a>
            <?php else: ?>
                <h3 class="text-success">Merci pour votre commande !</h3>
                <p>Votre commande n°<strong><?= htmlspecialchars($commande_id) ?></strong> a bien été enregistrée.</p>
                <p>Montant payé (<?= htmlspecialchars($methode) ?>) : <strong><?= number_format($total_final, 0, ',', ' ') ?> FCFA</strong></p>
                <a href="catalogue.php" class="btn btn-success mt-3">Continuer mes achats</a>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
