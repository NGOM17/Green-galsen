<?php
session_start();

// Sécurité : seul un client connecté (avec un id valide en session) peut passer au paiement
if (!isset($_SESSION['client_logged_in']) || $_SESSION['client_logged_in'] !== true || !isset($_SESSION['client_id'])) {
    session_unset();
    session_destroy();
    header('Location: connexion_client.php?erreur=session');
    exit();
}

require_once __DIR__ . '/../config/db.php';
$pdo = Database::getConnexion();

// Si pas de panier, retour au catalogue
if (empty($_SESSION['panier'])) {
    header('Location: catalogue.php');
    exit();
}

// Calcul du total réel à partir des produits en base
$ids = array_keys($_SESSION['panier']);
$placeholders = implode(',', array_fill(0, count($ids), '?'));
$query = $pdo->prepare("SELECT * FROM produits WHERE id_produit IN ($placeholders)");
$query->execute($ids);
$produits_panier = $query->fetchAll(PDO::FETCH_ASSOC);

$total = 0;
foreach ($produits_panier as $prod) {
    $qty = $_SESSION['panier'][$prod['id_produit']];
    $total += $prod['prix'] * $qty;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Paiement - Green Galsen</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5" style="max-width: 500px;">
        <div class="card p-4 shadow-sm">
            <h3 class="text-center text-success">Finaliser le paiement</h3>
            <p class="text-center">Montant : <strong><?= number_format($total, 0, ',', ' ') ?> FCFA</strong></p>
            
            <form action="confirmation.php" method="POST">
                <div class="mb-3">
                    <label>Méthode de paiement</label>
                    <select name="methode" class="form-control">
                        <option value="wave">Wave</option>
                        <option value="om">Orange Money</option>
                        <option value="visa">Carte Bancaire</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-success w-100">Payer maintenant</button>
            </form>
        </div>
    </div>
</body>
</html>